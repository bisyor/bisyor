<?php

namespace App\Models\Shops;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shops\ShopsAbonementPeriod
 *
 * @property int $id
 * @property int|null $abonement_id Абонемент
 * @property int|null $month Кол-во Месяцов
 * @property float|null $price_for_month Цена в месяц
 * @property float|null $total_price Стоимость
 * @property-read \App\Models\Shops\ShopsAbonements $abonement
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonementPeriod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonementPeriod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonementPeriod query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonementPeriod whereAbonementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonementPeriod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonementPeriod whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonementPeriod wherePriceForMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonementPeriod whereTotalPrice($value)
 * @mixin \Eloquent
 * @mixin IdeHelperShopsAbonementPeriod
 */
class ShopsAbonementPeriod extends Model
{
    protected $table = 'shops_abonement_period';
    public $timestamps = false;
    protected $fillable = ['abonement_id', 'month', 'price_for_month', 'total_price'];

    public function abonement()
    {
        return $this->belongsTo('App\Models\Shops\ShopsAbonements', 'id', 'abonement_id');
    }

}
