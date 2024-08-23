<?php

namespace App\Models\References;

use App\Models\Items\Items;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\Districts
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property int|null $region_id Регион
 * @property int|null $last_id Old id
 * @property string|null $keyword Ключовая слова
 * @property string|null $declination Склонение (где)
 * @property string|null $coordinate_x Кордината х
 * @property string|null $coordinate_y Кордината у
 * @property bool|null $metro Есть метро
 * @property-read \Illuminate\Database\Eloquent\Collection|Items[] $items
 * @property-read int|null $items_count
 * @property-read \App\Models\References\Regions|null $region
 * @property-read \App\Models\References\Translates $translate
 * @property-read \App\Models\References\Translates $translateDec
 * @method static \Illuminate\Database\Eloquent\Builder|Districts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Districts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Districts query()
 * @method static \Illuminate\Database\Eloquent\Builder|Districts whereCoordinateX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Districts whereCoordinateY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Districts whereDeclination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Districts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Districts whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Districts whereLastId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Districts whereMetro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Districts whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Districts whereRegionId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperDistricts
 */
class Districts extends Model
{
    protected $table = 'districts';
    public $timestamps = false;
    protected $fillable = ['name', 'region_id', 'keyword', 'declination'];

    /**
     * Viloyatlar bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo('App\Models\References\Regions', 'region_id', 'id')
            ->with(['translate']);
    }

    /**
     * Elonlar bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Items::class, 'district_id')
            ->where(['is_publicated' => 1, 'status' => Items::STATUS_PUBLICATION]);
    }

    /**
     * Tarjimalar bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translate()
    {
        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(['table_name' => $this->table, 'field_name' => 'name', 'language_code' => app()->getLocale()]);
    }

    /**
     * Declination maydonini  tarjimasini olish
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
     * Nomini qaytarish
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
