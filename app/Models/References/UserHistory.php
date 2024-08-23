<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\UserHistory
 *
 * @property int $id
 * @property int|null $user_id Пользователь
 * @property string|null $date_cr Дата создание
 * @property int|null $type Тип
 * @property string|null $title Заголовок
 * @property string|null $value Значение
 * @property int|null $from_device Устройства
 * @method static \Illuminate\Database\Eloquent\Builder|UserHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserHistory whereDateCr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserHistory whereFromDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserHistory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserHistory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserHistory whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserHistory whereValue($value)
 * @mixin \Eloquent
 * @mixin IdeHelperUserHistory
 */
class UserHistory extends Model
{
    public $timestamps = false;
    protected $table = 'user_history';
    protected $fillable = ['user_id', 'date_cr', 'type', 'title', 'value'];
    const DEVICE_WEB_SITE = 1;
    /**
     * Foydalanuvchi tarixini kiritish
     *
     * @param $type
     * @param $user_id
     */
    public static function setValue($type, $user_id)
    {
        $userHistory = new UserHistory();
        $userHistory->user_id = $user_id;
        $userHistory->date_cr = date('Y-m-d H:i:s');
        $userHistory->type = $type;
        $userHistory->from_device  = self::DEVICE_WEB_SITE;
        if ($type == 2) {
            $userHistory->value = 'Пользователь зарегистрирован';
            $userHistory->title = 'Регистрация';
        }
        if ($type == 3) {
            $userHistory->value = \Request::ip();
            $userHistory->title = 'Авторизация';
        }
        $userHistory->save();
    }
}
