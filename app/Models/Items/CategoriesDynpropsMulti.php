<?php

namespace App\Models\Items;

use Session;
use Illuminate\Database\Eloquent\Model;
use App\Models\References\Additional;
use App\Models\References\Translates;

/**
 * App\Models\Items\CategoriesDynpropsMulti
 *
 * @property int $id
 * @property int|null $dynprop_id Динамическое свойства
 * @property string|null $name Наименование
 * @property string|null $value Значение
 * @property int|null $num Номер
 * @property-read \App\Models\Items\CategoriesDynprops|null $categoriesDynprops
 * @property-read Translates $translate
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriesDynpropsMulti newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriesDynpropsMulti newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriesDynpropsMulti query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriesDynpropsMulti whereDynpropId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriesDynpropsMulti whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriesDynpropsMulti whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriesDynpropsMulti whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoriesDynpropsMulti whereValue($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCategoriesDynpropsMulti
 */
class CategoriesDynpropsMulti extends Model
{
    protected $table = 'categories_dynprops_multi';
    public $timestamps = false;
    protected $fillable = ['dynprop_id', 'name', 'value', 'num'];

    /**
     * Bo'glanish
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriesDynprops()
    {
        return $this->belongsTo(CategoriesDynprops::class, 'dynprop_id', 'id');
    }

    /**
     * Translate jadvali bilan bog'lanish
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translate()
    {
        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(['table_name' => $this->table, 'field_name' => 'name', 'language_code' => app()->getLocale()]);
    }

    /**
     * @return array|null
     */
    public function getDynpropsMulti()
    {
        $name = $this->name;
        if (app()->getLocale() != Additional::defaultLang()) {
            $translate = $this->translate;
            if ($translate != null && $translate->field_value != null) {
                $name = $translate->field_value;
            }
        }

        if ($this->value == 0) {
            return null;
        }

        return [
            'id' => $this->id,
            'dynprop_id' => $this->dynprop_id,
            'name' => $name,
            'value' => $this->value,
            'num' => $this->num,
        ];
    }

}
