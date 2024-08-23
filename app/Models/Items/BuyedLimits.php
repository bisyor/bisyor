<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Items\BuyedLimits
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property int $id
 * @property int|null $user_id Ползовател
 * @property bool|null $active Статус
 * @property bool|null $shop Для магазин
 * @property int|null $item_count Количество бесплатных объявлении
 * @property int|null $used_count Количество использованных
 * @property int|null $category_id Категория
 * @property string|null $regions Регионы
 * @property float|null $summa Стоимость
 * @property string|null $items Лист объявлении
 * @property string|null $date_cr Дата создание
 * @property string|null $date_to Дата окончание
 * @method static \Illuminate\Database\Eloquent\Builder|BuyedLimits newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuyedLimits newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuyedLimits query()
 * @method static \Illuminate\Database\Eloquent\Builder|BuyedLimits whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyedLimits whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyedLimits whereDateCr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyedLimits whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyedLimits whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyedLimits whereItemCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyedLimits whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyedLimits whereRegions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyedLimits whereShop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyedLimits whereSumma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyedLimits whereUsedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuyedLimits whereUserId($value)
 * @mixin IdeHelperBuyedLimits
 */
class BuyedLimits extends Model
{
    protected $table = 'user_buyed_limit';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'active',
        'shop',
        'item_count',
        'used_count',
        'category_id',
        'regions',
        'summa',
        'items',
        'date_cr',
        'date_to'
    ];

    /**
     * Sotib olingan limitlar qaytarish
     *
     * @param $categoryId
     * @param false $shop
     * @return BuyedLimits|false|Model|object
     */
    public static function buyedLimit($categoryId, $shop = false)
    {
        $userLimitPack = BuyedLimits::where(
            ['user_id' => Auth::user()->id, 'category_id' => $categoryId, 'active' => true, 'shop' => $shop]
        )->first();
        return $userLimitPack ? $userLimitPack : false;
    }
}
