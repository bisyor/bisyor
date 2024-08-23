<?php

namespace App;

use App\Models\References\Bonuses;
use App\Models\References\Settings;
use Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\References\MessageSend;
use App\Models\Chats\Chats;

/**
 * App\User
 *
 * @mixin \Eloquent
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false, $remember_token;
    const EXPIRE_TIME = 3600 * 24 * 7;
    const ACTIVE_USER = 1; // Sms tasdiqdan o'tgan userlar

    public static function boot()
    {
        parent::boot();

        self::creating(
            function ($model) {
                $referral_id = session()->get('referral');
                if($referral_id){
                    $user_referral = User::find($referral_id);
                    $model->referal_id = $user_referral ? $user_referral->id : null;
                    session()->remove('referral');
                }
                $model->balance = 0;
                $model->access_token = Str::random(32);
                $model->login = $model->loginGenerate();
                $model->expiret_at = time() + $model::EXPIRE_TIME;
                $model->registry_date = date("Y-m-d H:i:s");
                $model->last_seen = date("Y-m-d H:i:s");
                if ($model->status == null) {
                    $model->status = 2;
                }
                if ($model->email_verified == null) {
                    $model->email_verified = 0;
                }
                if ($model->phone_verified == null) {
                    $model->phone_verified = 0;
                }
                $model->coordinate_x = config('app.coordinate_x');
                $model->coordinate_y = config('app.coordinate_y');
                if ($model->email_verified == null && $model->phone_verified == null && $model->status == 2) {
                    $model->sms_code = random_int(10000, 99999);
                    $model->sendVerifyCode();
                }
            }
        );

        self::created(
            function ($model) {
                $bonus = Settings::where('key', 'bonus_for_user')->first('value');
                if ($bonus->value) {
                    $model->bonus_balance = $bonus->value;
                    $model->save();
                    $text = '"Поздравляем! Вы успешно зарегистрировались на Bisyor.uz" За регистрацию на нашей платформе вам предоставлен бонус в размере ' . $bonus->value . ' сумов.';
                } else {
                    $text = '"Поздравляем! Вы успешно зарегистрировались на лучшей онлайн платформу. Это чат техподдержки. В случае технических неполадок Вы можете направлять сюда Ваши письма. Команда наших модераторов ответит на Ваше письмо в течении 2 рабочих дней. Так же в данный чат будут приходить рассылки и различные объявления от нашей администрации. Благодарим Вас то что выбрали нас. С уважением команда Bisyor.uz."';
                }
                if($model->referal_id != null){
                    Bonuses::setReferralBonusThenRegister($model->referal_id);
                }
                Chats::createAdminChat($model->id, 1, $text);
            }
        );

        self::updating(
            function ($model) {
                // ... code here
            }
        );

        self::updated(
            function ($model) {
                // ... code here
            }
        );

        self::deleting(
            function ($model) {
                // ... code here
            }
        );

        self::deleted(
            function ($model) {
                // ... code here
            }
        );
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'fio',
        'phone',
        'balance',
        'status',
        'access_token',
        'sms_code',
        'email_verified',
        'phone_verified',
        'login',
        'expiret_at',
        'registry_date',
        'last_seen',
        'avatar',
        'coordinate_x',
        'coordinate_y',
        'email_news_alert',
        'email_message_alert',
        'email_comment_alert',
        'email_fav_ads_price_alert',
        'sms_news_alert',
        'sms_comment_alert',
        'sms_fav_ads_price_alert',
        'referal_id',
        'sex'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Unikalniy login yaratish
     *
     * @return string
     * @throws \Exception
     */
    protected static function loginGenerate()
    {
        do {
            $rand = "u" . random_int(1000000000, 9999999999);
            $base = User::where('login', $rand)->first();
        } while ($base != false);
        return $rand;
    }

    /**
     * Tasdiqlash kodini yuborish
     */
    public function sendVerifyCode()
    {
        if ($this->phone != null) {
            $msg = new MessageSend();
            $token = $msg->getSmsAccessToken();
            // $msg->sendSms(str_replace('+', '', (string)$this->phone), 'Code: ' . $this->sms_code, $token);
            $msg->sendSms($this->phone, 'Code: ' . $this->sms_code, $token);
        } else {
            if ($this->email != null) {
                $msg = new MessageSend();
                $msg->sendMessageToEmail($this->email, 'Code: ' . $this->sms_code, "Код подтверждении");
            }
        }
    }

    /**
     * Foydalanuvchi ismi, sharifi
     *
     * @return mixed
     */
    public function getUserFio()
    {
        if ($this->fio != null) {
            return $this->fio;
        }
        return $this->login;
    }

    /**
     * Foydalanuvchining logini olish
     *
     * @return mixed
     */
    public function getUserLogin()
    {
        if ($this->login != null) {
            return $this->login;
        } else {
            if ($this->phone != null) {
                return $this->phone;
            } else {
                return $this->email;
            }
        }
    }

    /**
     * Foydalanuvchining xolatini qaytarish faol yoki no faol ekanligini
     *
     * @return int
     */
    public function getOnlineStatus()
    {
        if (time() < (strtotime($this->last_seen) + 60)) {
            return 1;
        }
        return 0;
    }

    /**
     * Balansni qaytarish
     *
     * @return string
     */
    public function getUserBalance()
    {
        return number_format($this->balance, 0, '.', ' ') . ' ' . trans('messages.Sum');
    }

    /**
     * Foydalanuchi bonus balanslarini olish
     *
     * @return string
     */
    public function getUserBonusBalance()
    {
        return number_format($this->bonus_balance, 0, '.', ' ') . ' ' . trans('messages.Sum');
    }

    /**
     * Foydalanuvchining referallardan olgan balansi
     *
     * @return string
     */
    public function getUserReferralBalance()
    {
        return number_format($this->referal_balance, 0, '.', ' ') . ' ' . trans('messages.Sum');
    }

    /**
     * Ro'yxatdan o'tgan sanani qaytarish
     *
     * @return false|string
     */
    public function getRegistryDate()
    {
        return date('d.m.Y', strtotime($this->registry_date));
    }

    /**
     * Foydalanuvchi uchun rasmni biriktirish
     *
     * @param $file
     */
    public function setAvatar($file)
    {
        $data = $file;

        $image_array_1 = explode(";", $data);

        $image_array_2 = explode(",", $image_array_1[1]);

        $data = base64_decode($image_array_2[1]);

        $image_name = $this->login . '_' . time() . '.jpg';
        $uploadPath = config('app.avatarsRoute');

        if ($this->avatar) {
            Storage::disk('ftp')->delete($uploadPath . $this->avatar);
        }
        Storage::disk('ftp')->put($uploadPath . $image_name, $data);

        $this->avatar = $image_name;
    }

    /**
     * Avatarni qaytarish
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function getAvatar()
    {
        if ($this->avatar == null || $this->avatar == '') {
            return config('app.noUserImage');
        }
        return config('app.avatarsPath') . $this->avatar;
    }

    /**
     * Telefon raqamni kiritish
     *
     * @param $phones
     * @return false|string|null
     */
    public function setPhones($phones)
    {
        $result = [];
        if (isset($phones)) {
            foreach ($phones as $value) {
                if ($value != '') {
                    $result [] = str_replace('-', '', $value);
                }
            }
            if (count($result) == 0) {
                return null;
            }
            return json_encode($result);
        }
        return null;
    }

    /**
     * So'ngi tashrifni kiritib qo'yish
     */
    public static function setLastSeen()
    {
        $user = Auth::user();
        if ($user != null) {
            $user->last_seen = date('Y-m-d H:i:s');
            $user->save();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shops()
    {
        return $this->hasMany('App\Models\Shops\Shops', 'user_id', 'id');
    }

    public function shop(){
        return $this->hasOne('App\Models\Shops\Shops', 'user_id');
    }

    public function subscribers()
    {
        return $this->hasMany('App\Models\References\UserSubscribers', 'to_user_id', 'id')
            ->with('subscribers');
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Models\References\UserSubscribers', 'from_user_id', 'id')
            ->with('subscriptions');
    }
    /**
     * @return mixed
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Blogs\BlogPosts', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo('App\Models\References\Districts', 'district_id', 'id')->with(['region', 'translate']);
    }

    public function item(){
        return $this->hasOne('App\Models\Items\Items', 'user_id', 'id');
    }
}
