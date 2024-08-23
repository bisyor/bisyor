<?php

namespace App\Models\Shops;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shops\ShopsSubscribers
 *
 * @mixin \Illuminate\Database\Eloquent
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property integer|null $shop_id
 * @property integer|null $user_id
 * @property int $id
 * @property string|null $date_cr Дата создание
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsSubscribers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsSubscribers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsSubscribers query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsSubscribers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsSubscribers whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsSubscribers whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsSubscribers whereDateCr($value)
 * @mixin IdeHelperShopsSubscribers
 */
class ShopsSubscribers extends Model
{
    protected $table = 'shops_subscribers';
    public $timestamps = false;
    protected $fillable = ['shop_id', 'user_id', 'ball', 'date_cr'];
}
