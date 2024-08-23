<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\Contacts
 *
 * @property int $id
 * @property int|null $type Тип
 * @property int|null $user_id Пользователь
 * @property string|null $user_ip IP
 * @property string|null $name Наименование
 * @property string|null $email E-mail
 * @property string|null $message Сообщение
 * @property string|null $useragent Браузер пользователья
 * @property string|null $date_cr Дата создание
 * @property string|null $date_up Дата изменение
 * @property bool|null $viewed Статус
 * @property string|null $reason
 * @mixin IdeHelperContacts
 */
class Contacts extends Model
{
    protected $table = 'contacts';
    const CREATED_AT = 'date_cr';
    const UPDATED_AT = 'date_up';
    const CONTACT_TYPE_OFFER = 3;
    protected $fillable = [
        'name',
        'email',
        'type',
        'message',
        'date_cr',
        'date_up',
        'user_ip',
        'user_id',
        'useragent',
        'viewed'
    ];
}
