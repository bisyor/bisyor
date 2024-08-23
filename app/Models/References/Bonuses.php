<?php

namespace App\Models\References;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\Bonuses
 *
 * @property int $id
 * @property string|null $title Заголовок
 * @property string|null $description Описания
 * @property int|null $status Статус
 * @property string|null $image Картинка
 * @property float|null $bonus Бонус
 * @property string|null $keyword Кей
 * @method static \Illuminate\Database\Eloquent\Builder|Bonuses newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bonuses newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bonuses query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bonuses whereBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonuses whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonuses whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonuses whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonuses whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonuses whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonuses whereTitle($value)
 * @mixin \Eloquent
 * @mixin IdeHelperBonuses
 */
class Bonuses extends Model
{
    protected $table = "bonus_list";
    public $timestamps = false;

    const ACTIVE_BONUS = 1;
    const BONUS_REGISTRATION = "registration";
    // Referrallar uchun keyword
    const BONUS_REFERRAL = 'referal_for_service';
    const BONUS_DAY_LOGIN = 'day-login';


    /**
     * Bonus rasmlarini aniqlashtirib url bilan chiqarish uchun
     *
     * @return string
     */
    public function getImage(){
        return $this->image ? config('app.bonusImagePath') . $this->image : config('app.noImage');
    }

    /**
     * Userning bugun uchun olgan bonusi bormi?
     * Shu savolga javob beradi
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getUserBonusInDay(){
        return $this->hasOne(UserBonusHistories::class, 'bonus_id')
            ->where('date_cr', date('Y-m-d'))
            ->where('user_id', auth()->user()->id);
    }

    /**
     * Yangi foydalanuvchi referral orqali ro'yxatdan o'tganda
     * referral tarqatgan userga bonus berish funksiyasi
     *
     *
     * @param int $user_id
     * @return bool
     */
    public static function setReferralBonusThenRegister(int $user_id): bool
    {
        $referral_bonus = self::where('keyword', self::BONUS_REFERRAL)->where('status', self::ACTIVE_BONUS)->first();
        $response = false;
        if (!$referral_bonus) return $response;
        $referral_user = User::find($user_id);
        $referral_user->referal_balance = $referral_user->referal_balance + $referral_bonus->bonus;
        if ($referral_user->save()) {
            $response = true;
            UserBonusHistories::create(
                [
                    'bonus_id' => $referral_bonus->id,
                    'user_id' => $referral_user->id,
                    'summa' => $referral_bonus->bonus,
                    'date_cr' => date('Y-m-d')
                ]
            );
        }
        return $response;
    }
}
