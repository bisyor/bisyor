<?php

namespace App\Models\References;

use App\Models\References\Translates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\Regions
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property int|null $last_id Old id
 * @property string|null $keyword Ключовая слова
 * @property string|null $declination
 * @property int|null $country_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\References\Districts[] $districts
 * @property-read int|null $districts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\References\Districts[] $districtsItem
 * @property-read int|null $districts_item_count
 * @property-read Translates $translate
 * @property-read Translates $translateDec
 * @method static \Illuminate\Database\Eloquent\Builder|Regions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Regions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Regions query()
 * @method static \Illuminate\Database\Eloquent\Builder|Regions whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regions whereDeclination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regions whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regions whereLastId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regions whereName($value)
 * @mixin \Eloquent
 * @mixin IdeHelperRegions
 */
class Regions extends Model
{
    protected $table = 'regions';
    public $timestamps = false;
    protected $fillable = ['name', 'keyword', 'declination'];

    /**
     * Viloyatga bog'langan tumanlarni chiqarish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function districts()
    {
        return $this->hasMany('App\Models\References\Districts', 'region_id', 'id')
            ->with(['translate', 'translateDec'])->orderBy('name', 'asc');
    }

    /**
     * Tumanlarni qaytarish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function districtsItem()
    {
        return $this->hasMany('App\Models\References\Districts', 'region_id', 'id')
            ->with(['translate', 'translateDec'])->withCount('items')->orderBy('name', 'asc');
    }

    /**
     * Tarjimalar bilan bog'lash
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translate()
    {
        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(['table_name' => $this->table, 'field_name' => 'name', 'language_code' => app()->getLocale()]);
    }

    /**
     * declination maydonini tarjimsini olish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translateDec()
    {
        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(
                ['table_name' => $this->table, 'field_name' => 'declination', 'language_code' => app()->getLocale()]
            );
    }

    /**
     * Viloyat nomini qaytarish
     *
     * @return mixed
     */
    public function getName()
    {
        $name = $this->name;
        if (app()->getLocale() != Additional::defaultLang()) {
            $translate = $this->translate;
            if ($translate != null) {
                $name = $translate->field_value;
            }
        }
        return $name;
    }
}
