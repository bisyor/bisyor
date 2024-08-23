<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\Redirects
 *
 * @property int $id
 * @property string|null $from_uri Исходный URL
 * @property string|null $to_uri Итоговый URL
 * @property int|null $status Статус
 * @property bool|null $is_relative
 * @property bool|null $add_extra Использовать локализацию/регион и подобные настройки из исходного URL
 * @property bool|null $add_query Использовать параметры запроса из исходного URL
 * @property bool|null $enabled Включен
 * @property string|null $date_cr Дата создание
 * @property string|null $date_up Дата изменение
 * @property int|null $user_id Пользователь
 * @property string|null $user_ip IP пользователя
 * @property int|null $joined
 * @property string|null $joined_module
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects query()
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects whereAddExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects whereAddQuery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects whereDateCr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects whereDateUp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects whereFromUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects whereIsRelative($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects whereJoined($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects whereJoinedModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects whereToUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redirects whereUserIp($value)
 * @mixin \Eloquent
 * @mixin IdeHelperRedirects
 */
class Redirects extends Model
{
    protected $table = 'redirects';
    public $timestamps = false;
    protected $fillable = [
        'from_uri',
        'to_uri',
        'status',
        'is_relative',
        'add_extra',
        'add_query',
        'enabled',
        'date_cr',
        'date_up',
        'user_id',
        'user_ip',
        'joined',
        'joined_module'
    ];
}
