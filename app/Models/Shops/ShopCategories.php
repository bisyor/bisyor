<?php

namespace App\Models\Shops;

use Illuminate\Database\Eloquent\Model;
use App\Models\References\Additional;
use App\Models\References\Translates;

/**
 * App\Models\Shops\ShopCategories
 *
 * @mixin \Eloquent
 * @mixin IdeHelperShopCategories
 */
class ShopCategories extends Model
{
    protected $table = 'shop_categories';
    public $timestamps = false;
    protected $fillable = ['sorting', 'title', 'keyword', 'icon_b', 'icon_s', 'enabled', 'parent_id', 'date_cr'];

    /**
     * Sections jadvali bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sections()
    {
        return $this->hasMany('App\Models\Shops\ShopsSections', 'section_id', 'id')
            ->with(['shop']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translate()
    {
        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(['table_name' => $this->table, 'field_name' => 'title', 'language_code' => app()->getLocale()]);
    }

    /**
     * @return array
     */
    public static function getList()
    {
        $result = [];
        $categories = ShopCategories::where(['enabled' => 1])->with(['sections', 'translate'])->get();
        $distId = Additional::getRegionsDistrict();

        foreach ($categories as $value) {
            $idList = [];
            $count = 0;
            foreach ($value->sections as $section) {
                $idList [] = $section->shop_id;
                if ($section->shop->status == 1 && (in_array($section->shop->district_id, $distId) || count(
                            $distId
                        ) == 0)) {
                    $count++;
                }
            }

            $title = $value->title;
            if (app()->getLocale() != Additional::defaultLang()) {
                $translate = $value->translate;
                if ($translate != null) {
                    $title = $translate->field_value;
                }
            }

            $result [] = [
                'id' => $value->id,
                'title' => $title,
                'keyword' => $value->keyword,
                'shopsCount' => $count,
            ];
        }

        return $result;
    }
}
