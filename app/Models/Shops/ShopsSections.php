<?php

namespace App\Models\Shops;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shops\ShopsSections
 *
 * @property int $id
 * @property int|null $shop_id Магазин
 * @property int|null $section_id Раздел
 * @property-read \App\Models\Shops\ShopCategories|null $categories
 * @property-read \App\Models\Shops\ShopCategories|null $section
 * @property-read \App\Models\Shops\Shops|null $shop
 * @property-read \App\Models\Shops\Shops|null $shops
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsSections newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsSections newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsSections query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsSections whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsSections whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsSections whereShopId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperShopsSections
 */
class ShopsSections extends Model
{
    public $timestamps = false;
    protected $fillable = ['shop_id', 'section_id'];

    public function section()
    {
        return $this->hasOne('App\Models\Shops\ShopCategories', 'id', 'section_id');
    }

    public function shops()
    {
        return $this->belongsTo('App\Models\Shops\Shops', 'shop_id', 'id');
    }

    public function categories()
    {
        return $this->belongsTo('App\Models\Shops\ShopCategories', 'section_id', 'id');
    }

    public function shop()
    {
        return $this->hasOne('App\Models\Shops\Shops', 'id', 'shop_id')/*->where(['status' => 0])*/ ;
    }
}
