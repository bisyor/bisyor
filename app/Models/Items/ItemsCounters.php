<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Items\ItemsCounters
 *
 * @property int|null $cat_id
 * @property int|null $district_id
 * @property int|null $delivery
 * @property int|null $items
 * @property int|null $items_active Объявление публикатсии
 * @property-read \App\Models\Items\Categories|null $category
 * @property-read \App\Models\References\Districts|null $district
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsCounters newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsCounters newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsCounters query()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsCounters whereCatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsCounters whereDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsCounters whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsCounters whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemsCounters whereItemsActive($value)
 * @mixin \Eloquent
 * @mixin IdeHelperItemsCounters
 */
class ItemsCounters extends Model
{
    public $timestamps = false;
    protected $table = 'items_counters';
    protected $fillable = ['cat_id', 'district_id', 'delivery', 'items', 'items_active'];

    /**
     * Kategoriya bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Items\Categories', 'cat_id', 'id');
    }

    /**
     * Mintaqalar bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo('App\Models\References\Districts', 'district_id', 'id');
    }


}
