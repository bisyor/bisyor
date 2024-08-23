<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Hash;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\References\UserHistory;
use App\Models\References\Additional;
use App\Models\References\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use App\Models\References\Seo;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Login username to be used by the controller.
     *
     * @var string
     */
    protected string $username;

    protected array $providers = [
        'yandex', 'facebook', 'google', 'twitter'
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }

    /**
     * Saytdan chiqish
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect(Additional::getLoginUrl());
    }

    /**
     * Username bo'yicha qidirish
     *
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('login');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }

    /**
     * usernameni qaytarish
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    /**
     * Kiritilgan loginni tekshiruvdan o'tkazish
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorLogin(array $data)
    {
        $validator = Validator::make($data, ['login' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:12']]);
        $validator->setAttributeNames(['login' => trans('messages.Phone number')]);

        $validator->after(function ($validator) use ($data) {
            $login = str_replace(['-', ' '], '', $data['login']);
            if (!empty($login) && $login[0] != '+') $login = "+" . $login;
            $user = User::where('phone', $login)->first();
            if ($user != null) {
//                if ($user->status == 2) $validator->errors()->add('login', trans('messages.Account no activated'));
                if ($user->status == 3) $validator->errors()->add('login', trans('messages.Account blocked'));
                if ($user->status == 4) $validator->errors()->add('login', trans('messages.Account deleted'));
            }else{
                $validator->errors()->add('login', trans('messages.Username or password is incorrect'));
            }
        });
        return $validator;
    }

    /**
     * Saytga kirish
     *
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     * @throws \Exception
     */
    public function login(Request $request)
    {
        $this->validatorLogin($request->all())->validate();

        $phone = str_replace(['-', ' '], '', $request->login);
        $phone = "+" . ltrim($phone, '+');
        $model = User::where('phone', $phone)->first();
        $model->update(['sms_code' => random_int(10000, 99999)]);
        $model->sendVerifyCode();
        return redirect()->route('verify-code-get', ['login' => $model->phone ]);

    }

    /**
     * Login formasini qaytarish saytga kirishni bosganda
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        // Get URLs
        $urlPrevious = url()->previous();
        $urlBase = url()->to('/');

        // Set the previous url that we came from to redirect to after successful login but only if is internal
        if (($urlPrevious != $urlBase . '/login') && (substr($urlPrevious, 0, strlen($urlBase)) === $urlBase)) {
            session()->put('url.intended', $urlPrevious);
        }
        return view('auth.login', [
            'seo' => Seo::getMetaAuth(Seo::getSeoKey('users', app()->getLocale()), app()->getLocale())
        ]);
    }

    /**
     * @param $driver
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($driver)
    {
        if (!$this->isProviderAllowed($driver)) {
            return $this->sendFailedResponse("{$driver} is not currently supported");
        }

        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {
            // You should show something simple fail message
            return $this->sendFailedResponse($e->getMessage());
        }
    }


    public function handleProviderCallback($driver)
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        // check for email in returned user
        return empty($user->email)
            ? $this->sendFailedResponse("No email id returned from {$driver} provider.")
            : $this->loginOrCreateAccount($user, $driver);
    }

    /**
     * Muvaffaqiyatli xabarni yuborish
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendSuccessResponse()
    {
        Additional::setNoAuthUserFavoritesItems();
        Additional::setNoAuthUserFavoritesText();
        return redirect()->route('site-index');
    }

    /**
     * Xatolik xabarini yuborish
     *
     * @param null $msg
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('social.login')
            ->withErrors(['msg' => $msg ?: 'Unable to login, try with another provider to login.']);
    }

    /**
     * Login qilish yoki bo'lmasa yangisini yaratish
     *
     * @param $providerUser
     * @param $driver
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function loginOrCreateAccount($providerUser, $driver)
    {
        /*print_r("getName = " . $providerUser->getName());
        print_r("getEmail = " .$providerUser->getEmail());
        print_r("getAvatar = " . $providerUser->getAvatar());
        print_r("driver = " . $driver);
        print_r("getId = " . $providerUser->getId());
        print_r("token = " . $providerUser->token);*/

        $user = null;
        $fieldName = 'facebook_api_key';
        // check for already has account
        if ($driver == 'facebook') {
            $fieldName = 'facebook_api_key';
            $user = User::where('facebook_api_key', $providerUser->getId())->first();
        }
        if ($driver == 'google') {
            $fieldName = 'google_api_key';
            $user = User::where('google_api_key', $providerUser->getId())->first();
        }
        if ($driver == 'yandex') {
            $fieldName = 'yandex_api_key';
            $user = User::where('yandex_api_key', $providerUser->getId())->first();
        }

        $url = $providerUser->getAvatar();
        $info = pathinfo($url);
        $contents = file_get_contents($url);
        $file = '/tmp/' . $info['basename'];
        file_put_contents($file, $contents);
        $filename = $providerUser->getId() . '.jpeg';
        $uploaded_file = new \Symfony\Component\HttpFoundation\File\UploadedFile($file, $filename);

        // if user already found
        if ($user == null) {
            //Check email exists or not. If exists create a new user
            if ($providerUser->getEmail()) {
                $user = User::where('email', $providerUser->getEmail())->first();
                if ($user == null) $user = new User();

                $user->fio = $providerUser->getName();
                $user->email = $providerUser->getEmail();
                $user->status = 1;
                $user->email_verified = 1;
                $user->password = Hash::make($providerUser->getId());
                //$user->setAvatar($uploaded_file);
                $user->$fieldName = $providerUser->getId();
                $user->save();
                UserHistory::setValue(2, $user->id);
            } //Show message here what you want to show
            else {
                $user = new User();
                $user->fio = $providerUser->getName();
                $user->status = 1;
                $user->password = Hash::make($providerUser->getId());
                //$user->setAvatar($uploaded_file);
                $user->$fieldName = $providerUser->getId();
                $user->save();
                UserHistory::setValue(2, $user->id);
            }
        } else {
            //$user->setAvatar($uploaded_file);
            $user->save();
            UserHistory::setValue(3, $user->id);
        }

        // login the user
        Auth::login($user, true);
        return $this->sendSuccessResponse();
    }

    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }
}
