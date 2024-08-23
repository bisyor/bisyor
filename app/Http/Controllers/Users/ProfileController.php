<?php

namespace App\Http\Controllers\Users;

use App\Models\References\Bonuses;
use App\Models\References\MessageSend;
use App\Models\References\PromoCode;
use App\Models\References\UserBonusHistories;
use Auth;
use Hash;
use App\User;
use App\Http\Controllers\Controller;
use App\Models\References\Bills;
use App\Models\References\Additional;
use App\Models\Items\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Foydalanuvchi profil sozlamalari sahifasi
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings()
    {
        $user = Auth::user();
        $additional = new Additional();
        return view(
            'users.profile.settings',
            [
                'user' => $user,
                'additional' => $additional,
            ]
        );
    }

    /**
     * Profilni tahrirlashda yangi malumotlarni saqlab olish
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate(['birthday' => 'date_format:Y-m-d']);
        $user->fio = $request->fio;
        $user->telegram = $request->telegram;
        $user->district_id = $request->district_id;
        $user->address = $request->address;
        $user->birthday = $request->birthday;
        $user->coordinate_x = $request->coordinate_x;
        $user->coordinate_y = $request->coordinate_y;
        $user->phones = $user->setPhones($request->phones);
        $user->email_news_alert = $request->email_news_alert;
        $user->email_message_alert = $request->email_message_alert;
        $user->email_comment_alert = $request->email_comment_alert;
        $user->email_fav_ads_price_alert = $request->email_fav_ads_price_alert;
        $user->sms_news_alert = $request->sms_news_alert;
        $user->sms_comment_alert = $request->sms_comment_alert;
        $user->sms_fav_ads_price_alert = $request->sms_fav_ads_price_alert;
        $user->sex = $request->sex;

        if ($request->image_change) {
            $validator = Validator::make(['photo' => $request->file('image_change')], ['file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
            if($validator->fails()){
                return redirect()->back()->withErrors(['photo' => $validator->errors()->get('file')]);
            }
            $user->setAvatar($request->image_change);
        }
        $user->save();

        return redirect()->route('profile-settings')->with('success-changed', trans('messages.Successfully saved'));
    }

    /**
     * Parollni o'zgartirish
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $this->passwordValidator($request->all())->validate();
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->route('profile-settings')->with('success-changed', trans('messages.Successfully saved'));
    }

    /**
     * Sms kodni tasdiqlash
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function verifyCode(Request $request)
    {
        $this->validatorSmsCode($request->all())->validate();
        $user = Auth::user();
        if ($user = User::where(['sms_code' => $request->sms_code, 'id' => $user->id])->first()) {
            $user->sms_code = null;
            $user->phone_verified = true;
            $user->phone = str_replace('-', '', $request->new_phone);
            $user->save();
            return redirect()->route('profile-settings')->with('success-changed', trans('messages.Successfully saved'));
        } else {
            $user = Auth::user();
            $additional = new Additional();
            return view(
                'users.profile.settings',
                [
                    'user' => $user,
                    'additional' => $additional,
                    'verify_status' => true,
                    'new_phone' => $request->new_phone,
                    'error_message' => trans('messages.Wrong code')
                ]
            );
        }
    }

    /**
     * Sms kodni tekshiruvdan o'tkazish
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorSmsCode(array $data)
    {
        return Validator::make(
            $data,
            [
                'sms_code' => ['required', 'string'],
            ]
        )->setAttributeNames(
            ['sms_code' => trans('messages.SMS code')]
        );
    }

    /**
     * Telefon raqamini o'zgartirish
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function changePhone(Request $request)
    {
        $this->phoneValidator($request->all())->validate();
        $user = Auth::user();
        $additional = new Additional();
        $phone = str_replace('-', '', $request->new_phone);
        $user->sms_code = random_int(10000, 99999);
        $user->save();
        $msg = new MessageSend();
        $token = $msg->getSmsAccessToken();
        $msg->sendSms(str_replace('+', '', (string)$phone), 'Code: ' . $user->sms_code, $token);
        return view(
            'users.profile.settings',
            [
                'user' => $user,
                'additional' => $additional,
                'verify_status' => true,
                'new_phone' => $phone,
                'error_message' => null
            ]
        );
    }

    /**
     * Yangi emailni saqlab olish
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeEmail(Request $request)
    {
        $user = Auth::user();
        $user->update($this->emailValidator($request->all())->validate());
        return redirect()->route('profile-settings')->with('success-changed', trans('messages.Successfully saved'));
    }

    /**
     * Profilni o'chirish
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAccaunt(Request $request)
    {
        $this->deleteValidator($request->all())->validate();
        $user = Auth::user();
        $user->status = 4;
        $user->save();
        Auth::logout();
        return redirect()->route('site-index');
    }

    /**
     * To'lovlar statistikasini ko'rish
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function replenish()
    {
        $user = Auth::user();
        $bills = Bills::getHistory($user);
        return view(
            'users.profile.bills.replenish',
            [
                'user' => $user,
                'bills' => $bills,
            ]
        );
    }

    /**
     * To'lovlar ro'yxatini paginatsiyalari
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bills()
    {
        $user = Auth::user();
        $bills = Bills::getHistory($user);
        $pagination = $this->paginate($bills, 20);
        $pagination->setPath(route('profile.bonus-lists'));

        return view(
            'users.profile.bills.list',
            [
                'user' => $user,
                'bills' => $pagination,
            ]
        );
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function getUserPhone(Request $request)
    {
        $user = User::where(['login' => $request->login])->first();
        if ($user != null) {
            return $user->phone;
        } else {
            return trans('messages.User not found');
        }
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|mixed|string|null
     */
    public function getItemUserPhone(Request $request)
    {
        $item = Items::where(['id' => $request->id])->first();
        if ($item != null) {
            $phones = unserialize($item->phones);
            if (count($phones) > 0) {
                return $phones[0]['v'];
            } else {
                return trans('messages.Contacts');
            }
        } else {
            return trans('messages.User not found');
        }
    }

    /**
     * Foydalanuvchi o'zini profilidan to'lov qilish uchun
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function payment(Request $request)
    {
        $user = Auth::user();
        $amount = (int)str_replace(" ", "", $request->amount);
        $pay_method = $request->payment_method;
        $promo = $request->promo;
        $type = $request->type;
        $billCreateUrl = config('app.billCreateUrl');
        if ($type == 'pay') {
            if ($amount < 1000 || $amount > 10000000 || !$pay_method) {
                return redirect()->back()->withInput($request->all())->withErrors(
                    ['amount' => trans('messages.Maximal summa')]
                );
            }
            switch ($pay_method) {
                case "m2sev" :
                    $api = $billCreateUrl . "?user_id=" . $user->id . "&psystem=146&amount=" . $amount . "&type=1&lang=" . app(
                        )->getLocale();
                    break;
                case "m1er" :
                    $api = $billCreateUrl . "?user_id=" . $user->id . "&amount=" . $amount . "&type=1&lang=" . app(
                        )->getLocale();
                    break;
                default :
                    abort(404);
            }
            $json = file_get_contents_curl($api);
            $json = json_decode($json, true);
            if (!$json['status']) {
                return view(
                    'items.services.message',
                    [
                        'user' => $user,
                        'status' => 'error',
                        'message' => $json['message']
                    ]
                );
            }
            return redirect()->to($json['url']);
        } else {
            $promoCode = PromoCode::where(['code' => $promo])->first();
            if (!$promoCode) {
                return redirect()->back()->withInput($request->all())->withErrors(
                    ['promo' => trans('messages.Code not exsist')]
                );
            }
            $api = $billCreateUrl . "?user_id=" . $user->id . "&amount=" . $promoCode->amount . "&promocode_id=" . $promoCode->id . "&lang=" . app(
                )->getLocale();
            $json = file_get_contents_curl($api);
            $json = json_decode($json, true);
            if (!$json['status']) {
                return view(
                    'items.services.message',
                    [
                        'user' => $user,
                        'status' => 'error',
                        'message' => $json['message']
                    ]
                );
            } else {
                return view(
                    'items.services.message',
                    [
                        'user' => $user,
                        'status' => 'success',
                        'message' => $json['message']
                    ]
                );
            }
        }
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function passwordValidator(array $data)
    {
        $validator = Validator::make(
            $data,
            [
                'password' => ['required', 'string'],
                'new_password' => ['required', 'string', 'min:6', 'max:255'],
                'retry_password' => ['required', 'string', 'min:6', 'max:255'],
            ]
        );

        $validator->after(
            function ($validator) use ($data) {
                if ($data['new_password'] != $data['retry_password']) {
                    $validator->errors()->add('new_password', trans('messages.Retry error password'));
                }
                if (!Hash::check($data['password'], auth()->user()->password)) {
                    $validator->errors()->add('password', trans('messages.Entered wrong password'));
                }
            }
        );

        return $validator;
    }

    /**
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function phoneValidator(array $data)
    {
        $validator = Validator::make(
            $data,
            [
                'password' => ['required', 'string'],
                'phone' => ['required', 'string', 'max:255'],
                'new_phone' => ['required', 'string', 'max:255'],
            ]
        );

        $validator->after(
            function ($validator) use ($data) {
                if (auth()->user()->phone != str_replace('-', '', $data['phone'])) {
                    $validator->errors()->add('phone', trans('messages.Entered wrong phone'));
                }
                if (User::where('phone', str_replace('-', '', $data['new_phone']))->get()->toArray()) {
                    $validator->errors()->add('new_phone', trans('messages.This phone have in other user'));
                }
                if (!Hash::check($data['password'], auth()->user()->password)) {
                    $validator->errors()->add('password', trans('messages.Entered wrong password'));
                }
            }
        );
        return $validator;
    }

    /**
     * Emailni tasdiqdan otkazish
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function emailValidator(array $data)
    {
        $validator = Validator::make(
            $data,
            [
                'password' => ['required', 'string'],
                'email' => ['required', 'string', 'email', 'max:255'],
            ]
        );
        $validator->after(
            function ($validator) use ($data) {
                if (!Hash::check($data['password'], auth()->user()->password)) {
                    $validator->errors()->add('password', trans('messages.Entered wrong password'));
                }
            }
        );
        return $validator;
    }

    /**
     * Profilni o'chirish validatori
     * O'chirishdan oldin parol bilan tadiqlash kerak
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function deleteValidator(array $data)
    {
        $validator = Validator::make(
            $data,
            [
                'password' => ['required', 'string'],
            ]
        );

        $validator->after(
            function ($validator) use ($data) {
                if (!Hash::check($data['password'], auth()->user()->password)) {
                    $validator->errors()->add('password', trans('messages.Entered wrong password'));
                }
            }
        );

        return $validator;
    }

    /*public function uploadAvatar(Request $request){
        if(isset($request->image))
        {
            $data = $request->image;

            $image_array_1 = explode(";", $data);

            $image_array_2 = explode(",", $image_array_1[1]);

            $data = base64_decode($image_array_2[1]);

            $image_name = 'bisyor_avatar_' . time().'.jpg';

            $uploadPath = config('app.trashRoute');
            Storage::disk('ftp')->put($uploadPath . $image_name, $data);
            return $image_name;
        }
    }*/

    /**
     * Bonus listlar
     *
     * @return mixed
     */
    public function bonusList(){
        $bonuses = Bonuses::whereNotIn('keyword', [Bonuses::BONUS_REGISTRATION, Bonuses::BONUS_REFERRAL])
            ->where('status', Bonuses::ACTIVE_BONUS)
            ->with('getUserBonusInDay')->get();

        $user_bonus_histories = UserBonusHistories::where('user_id', auth()->id())->orderBy('date_cr', 'desc')
            ->with('getBonus')->get();

        $user_bonus_history_list_with_pagination = $this->paginate($user_bonus_histories, 20)
            ->setPath(route('profile.bonus-lists'));

        //$aactive_tab = cookie()->get('active_bonus_tab') ?? 'tab';

        return view('users.profile.bonuses.bonus_list', [
            'user' => auth()->user(),
            'bonuses' => $bonuses,
            'user_bonus_history_list_with_pagination' => $user_bonus_history_list_with_pagination]);
    }

    /**
     * Kunlik bonuslarini olish uchun action
     *
     * @param Bonuses $bonus
     * @return mixed
     */
    public function getBonusInDay(Bonuses $bonus){
        $user = Auth::user();
        $type_message = 'success-changed';
        $message  = trans('messages.Successfully saved');
        if(!UserBonusHistories::where(['bonus_id' => $bonus->id, 'user_id' => $user->id, 'date_cr' => date('Y-m-d')])->first()){
            UserBonusHistories::create(
                ['bonus_id' => $bonus->id, 'user_id' => $user->id, 'summa' => $bonus->bonus, 'date_cr' => date('Y-m-d')]
            );
            $user->bonus_balance = $user->bonus_balance + $bonus->bonus;
            $user->save();
        }else{
            $type_message = 'success-changed';
            $message = trans('messages.Model error text');
        }

        return back()->with($type_message, $message);
    }

    /**
     * Userning referallar ro'yxati
     *
     * @return mixed
     */
    public function referrals()
    {
        $user_referrals = User::where('referal_id', auth()->user()->getAuthIdentifier())->get();
        $user_referrals = $this->paginate($user_referrals, 20)
            ->setPath(route('profile.referrals'));

        return view('users.profile.bonuses.referrals_list', [
            'user' => auth()->user(),
            'user_referrals' => $user_referrals]);
    }

    /**
     *Bonus balansdan asosiy balansga pul o'tkazish
     *
     * @param Request $request
     * @return mixed
     */
    public function transferToMain(Request $request){
        $user = auth()->user();
        $balance_type = $request->transfer == 'bonus' ? 'bonus_balance': 'referal_balance';
        if($user->$balance_type < Bills::MIN_BALANCE){
            return view('items.services.message', [
                'user' => $user,
                'status' => 'failed', 'message' => trans('messages.There are no funds in your bonus account'),
            ]);
        }
        $bill_api = file_get_contents_curl('https://api.bisyor.uz/api/v1/additional/create-bill?user_id='.$user->id.'&type=2&amount='.$user->$balance_type.'&description=Перевод+средств+на+основной+баланс');
        $bill_api = json_decode($bill_api);

        if($bill_api->status){
            $user->$balance_type = 0;
            $user->save();
        }
        return redirect()->route('success-message');
    }
    

    public function successMessage(Request $request){
        return view('items.services.message', [
            'user' => auth()->user(),
            'status' => 'success',
            'message' => trans('messages.Transfer of funds to the main balance')
        ]);
    }
}
