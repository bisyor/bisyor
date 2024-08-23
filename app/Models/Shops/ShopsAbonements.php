<?php

namespace App\Models\Shops;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shops\ShopsAbonements
 *
 * @property int $id
 * @property bool|null $enabled Статус
 * @property string|null $title Заголовок
 * @property bool|null $is_free Бесплатно
 * @property int|null $price_free_period
 * @property int|null $ads_count Количество объявлении
 * @property bool|null $import мпорт объявлении
 * @property bool|null $mark Выделение
 * @property bool|null $fix Закрепление
 * @property string|null $icon_b Иконка (большая)
 * @property string|null $icon_s Иконка (малая)
 * @property int|null $num Номер сортировки
 * @property bool|null $one_time Единоразовый
 * @property bool|null $is_default По умолчанию
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shops\ShopsAbonementPeriod[] $period
 * @property-read int|null $period_count
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements whereAdsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements whereFix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements whereIconB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements whereIconS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements whereImport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements whereIsFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements whereMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements whereOneTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements wherePriceFreePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsAbonements whereTitle($value)
 * @mixin \Eloquent
 * @mixin IdeHelperShopsAbonements
 */
class ShopsAbonements extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title',
        'icon_b',
        'icon_s',
        'enabled',
        'one_time',
        'is_default',
        'is_free',
        'import',
        'mark',
        'fix',
        'num_month',
        'num',
        'price_free_period',
        'ads_count'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function period()
    {
        return $this->hasMany('App\Models\Shops\ShopsAbonementPeriod', 'abonement_id', 'id');
    }

}
