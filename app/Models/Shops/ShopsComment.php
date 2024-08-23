<?php

namespace App\Models\Shops;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shops\ShopsComment
 *
 * @property int $id
 * @property bool|null $enabled Статус
 * @property string|null $text Текст
 * @property int|null $shop_id Магазин
 * @property string|null $user_ip IP пользователья
 * @property string|null $fio Фио пользователья
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsComment whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsComment whereFio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsComment whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsComment whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsComment whereUserIp($value)
 * @mixin \Eloquent
 * @mixin IdeHelperShopsComment
 */
class ShopsComment extends Model
{
    protected $table = 'shops_comment';
    public $timestamps = false;
    protected $fillable = ['shop_id', 'user_ip', 'fio', 'enabled', 'text'];
}
