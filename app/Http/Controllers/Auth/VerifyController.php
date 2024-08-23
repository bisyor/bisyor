<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\References\Additional;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\References\UserHistory;
use Illuminate\Validation\ValidationException;

class VerifyController extends Controller
{
    public function getVerify(Request $request)
    {
        $text = filter_var($request->login, FILTER_VALIDATE_EMAIL)
            ? str_replace('{email}', '<b> ' . $request->login . '</b> ', trans('messages.Send message to email'))
            : str_replace(
                '{phone_number}',
                '<b> ' . $request->login . ' </b>',
                trans('messages.Send message to phone')
            );

        return view('auth.verify', ['login' => $request->login, 'text' => $text]);
    }

    public function postVerify(Request $request)
    {
        $this->validatorSmsCode($request->all())->validate();

        if ($user = User::where(['sms_code' => $request->sms_code])->first()) {
            $user->status = 1;
            $user->sms_code = null;
            $user->phone_verified = true;
            $user->save();
            Auth::login($user, true);
            UserHistory::setValue(3, $user->id);
            Additional::setNoAuthUserFavoritesItems();
            Additional::setNoAuthUserFavoritesText();
            return redirect()->route('success-registered');
        } else {
            return back()->with('sms_code', $request->sms_code)->withMessage(trans('messages.Wrong code'));
        }
    }

    public function postVerifyLogin(Request $request)
    {
        $this->validatorSmsCode($request->all())->validate();

        if ($user = User::where(['sms_code' => $request->sms_code])->first()) {
            Auth::login($user, true);
            $user->status = 1;
            $request->session()->regenerate();
            $user->sms_code = null;
            $user->phone_verified = true;
            $user->save();
            UserHistory::setValue(3, $user->id);
            Additional::setNoAuthUserFavoritesItems();
            Additional::setNoAuthUserFavoritesText();
            return redirect()->intended();
        } else {
            return back()->with('sms_code', $request->sms_code)->withMessage(trans('messages.Wrong code'));
        }
    }

    /**
     * Tasdiqlash ko'dini qayta yuborish
     *
     * @param Request $request
     * @return mixed
     */
    public function sendRetryVerifyCode(Request $request)
    {
        $additional = new Additional();
        $res = $additional->sendRetryVerifyCode($request->login);

        if ($res) {
            $text = filter_var($request->login, FILTER_VALIDATE_EMAIL)
                ? str_replace('{email}', $request->login, trans('messages.Send message to email'))
                : str_replace('{phone_number}', $request->login, trans('messages.Sended code to phone'));

            //return view('auth.verify', ['login' => $request->login, 'text' => $text]);
            return redirect()->route('verify-code-get', ['login' => $request->login])->withMessage($text);
        } else {
            return back()->with('sms_code', $request->sms_code)->withMessage(trans('messages.User not found'));
        }
    }

    /**
     * Saytga kirish muvaffaqiyatli amalga oshirilganda
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success(Request $request)
    {
        return view('auth.success', []);
    }

    /**
     * Parolni tiklash muvaffaqiyatli
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function successRecoveryPassword(Request $request)
    {
        return view('auth.success-recovery-password', []);
    }

    /**
     * Parolni unutdingizmi?
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getForgotPassword(Request $request)
    {
        $text = filter_var($request->login, FILTER_VALIDATE_EMAIL)
            ? str_replace('{email}', '<b> ' . $request->login . '</b> ', trans('messages.Send message to email'))
            : str_replace(
                '{phone_number}',
                '<b> ' . $request->login . ' </b>',
                trans('messages.Send message to phone')
            );

        return view('auth.forgot-password', ['login' => $request->login, 'text' => $text]);
    }

    /**
     * Parolni unutdingizmi
     * POST metod
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postForgotPassword(Request $request)
    {
        if (empty($request->email)) {
            $login = $request->phone;
        } else {
            $login = $request->email;
        }
        $this->validator($request->all())->validate();

        $additional = new Additional();
        $res = $additional->sendRetryVerifyCode($login);
        return redirect()->route('new-password-get', ['login' => $login]);
    }

    /**
     * Yangi parolni olish
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getNewPassword(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('site-index');
        }
        return view('auth.set-code', ['login' => $request->login, 'text' => $request->text]);
    }

    /**
     * Parolni yangilash
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postNewPassword(Request $request)
    {
        $this->validatorPassword($request->all())->validate();

        if ($user = User::where(['sms_code' => $request->sms_code])->first()) {
            $user->password = Hash::make($request->password);
            $user->sms_code = null;
            $user->save();
            Auth::login($user, true);
            UserHistory::setValue(3, $user->id);
            Additional::setNoAuthUserFavoritesItems();
            Additional::setNoAuthUserFavoritesText();
            return redirect()->route('success-recovery-password');
        } else {
            return back()->with('sms_code', $request->sms_code)->withMessage(trans('messages.Wrong code'));
        }
    }

    /**
     * Tekshiruv funksiyasi
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $phone = str_replace('-', '', $data['phone']);
        $data['phone'] = $phone;
        $validator = Validator::make(
            $data,
            [
                'email' => !empty($data['email']) ? ['string', 'max:255', 'email'] : [],
                'phone' => !empty($data['phone']) ? ['string', 'max:255'] : [],
            ]
        )->setAttributeNames(
            ['email' => trans('messages.Email'), 'phone' => trans('messages.Phone'),],
        );

        $validator->after(
            function ($validator) use ($data) {
                if (empty($data['email']) && empty($data['phone'])) {
                    $validator->errors()->add('phone_email', trans('messages.You must Enter phone number or email'));
                }

                if (!empty($data['email']) && User::whereEmail($data['email'])->first() == null) {
                    $validator->errors()->add('phone_email', trans('messages.User not found by email'));
                }

                if (!empty($data['phone']) && User::wherePhone($data['phone'])->first() == null) {
                    $validator->errors()->add('phone_email', trans('messages.User not found by phone'));
                }
            }
        );
        return $validator;
    }

    /**
     * Parol tekshiruvi
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorPassword(array $data)
    {
        $validator = Validator::make(
            $data,
            [
                'password' => ['required', 'string', 'min:6'],
                'sms_code' => ['required', 'string'],
            ]
        )->setAttributeNames(
            ['sms_code' => trans('messages.SMS code'), 'phone' => trans('messages.Password'),],
        );

        $validator->after(
            function ($validator) use ($data) {
                if (User::where(['sms_code' => $data['sms_code']])->first() == null) {
                    $validator->errors()->add('sms_code', trans('messages.Wrong code'));
                }
            }
        );
        return $validator;
    }

    /**
     * Sms kodni tekshirish
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorSmsCode(array $data)
    {
        $validator = Validator::make(
            $data,
            [
                'sms_code' => ['required', 'string'],
            ]
        )->setAttributeNames(
            ['sms_code' => trans('messages.SMS code')],
        );
        return $validator;
    }

    /**
     * Ajax so'rov orqali tasdiqlash sahifasini yuborish
     *
     * @return array
     * @throws \Throwable
     */
    public function getVerifyPage()
    {
        $user = Auth::user();
        $text = trans('messages.Enter phone number');
        if ($user->phone) {
            $text = str_replace(
                '{phone_number}',
                '<b> ' . $user->phone . ' </b>',
                trans('messages.Send message to phone')
            );
        }
        return [
            'form' => view('auth.verify-page-ajax')->with(['phone' => $user->phone, 'text' => $text])->render(),
        ];
    }

    /**
     * Raqamga kodni jo'natish AJAX uchun
     *
     * @param Request $request
     * @return array
     */
    public function sendCodeAjax(Request $request)
    {
        $this->validatorPhone($request->all())->validate();
        $additional = new Additional();
        $user = Auth::user();

        if ($request->phone === 'not_new_phone_number') {
            $res = $additional->sendRetryVerifyCode($user->phone);
        } else {
            $user->phone = str_replace('-', '', $request->phone);
            $user->save();
            $res = $additional->sendRetryVerifyCode($user->phone);
        }

        return $this->responseMessage($res, $user);
    }

    /**
     * Raqam validatori
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorPhone(array $data)
    {
        $phone = str_replace('-', '', $data['phone']);
        $data['phone'] = $phone;

        return Validator::make(
            $data,
            [
                'phone' => ['string', 'max:255', 'unique:users'],
            ]
        );
    }

    /**
     * Sms kodni qayta yuborish (AJAX)
     *
     * @param Request $request
     * @return array
     */
    public function reSendCodeAjax(Request $request)
    {
        $additional = new Additional();
        $user = Auth::user();
        $res = 0;
        if($user){
            $res = $additional->sendRetryVerifyCode($user->phone);
        }
        return $this->responseMessage($res, $user);
    }

    /**
     * Ajax tasdiqlash kodini olish
     *
     * @param Request $request
     * @return array|bool[]
     */
    public function postVerifyAjax(Request $request)
    {
        $auth_user = Auth::user();
        if ($user = User::where(['id' => $auth_user->id, 'sms_code' => $request->sms_code])->first()) {
            $user->status = 1;
            $user->sms_code = null;
            $user->phone_verified = true;
            $user->save();
            UserHistory::setValue(3, $user->id);
            Additional::setNoAuthUserFavoritesItems();
            Additional::setNoAuthUserFavoritesText();
            return ['success' => true];
        }
        return ['success' => false, 'message' => trans('messages.Wrong code')];
    }

    /**
     * Yakunlovchi xabarni yuborish (Ajax)
     *
     * @param $res
     * @param $user
     * @return array
     * @throws \Throwable
     */
    protected function responseMessage($res, $user)
    {
        if ($res) {
            $text = str_replace(
                '{phone_number}',
                '<b> ' . $user->phone . ' </b>',
                trans('messages.Sended code to phone')
            );
            return [
                'form' => view('auth.verify-form-ajax')->with(['text' => $text])->render(),
            ];
        }
        return ['error' => trans('messages.User not found')];
    }
}
