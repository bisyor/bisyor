<?php

namespace App\Models\Shops;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shops\ShopsTariff
 *
 * @property int $id
 * @property int|null $abonement_id Абонемент
 * @property int|null $shop_id Магазин
 * @property string|null $date_cr Дата создание
 * @property int|null $status 1 - Активно, 2 - Не активно
 * @property string|null $data_access Cрок действия
 * @property float|null $price Общая стоимость
 * @property string|null $detail
 * @property int|null $preiod_id
 * @property-read \App\Models\Shops\ShopsAbonements|null $abonement
 * @property-read \App\Models\Shops\Shops|null $shop
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsTariff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsTariff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsTariff query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsTariff whereAbonementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsTariff whereDataAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsTariff whereDateCr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsTariff whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsTariff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsTariff wherePreiodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsTariff wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsTariff whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsTariff whereStatus($value)
 * @mixin \Eloquent
 * @mixin IdeHelperShopsTariff
 */
class ShopsTariff extends Model
{
    protected $table = 'shops_tariff';
    const CREATED_AT = 'date_cr';
    const UPDATED_AT = false;
    protected $fillable = ['abonement_id', 'shop_id', 'date_cr', 'status', 'data_access', 'price'];
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    public function shop()
    {
        return $this->belongsTo('App\Models\Shops\Shops', 'shop_id', 'id');
    }

    public function abonement()
    {
        return $this->belongsTo('App\Models\Shops\ShopsAbonements', 'abonement_id', 'id');
    }
}
