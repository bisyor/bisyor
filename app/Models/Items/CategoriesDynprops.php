<?php

namespace App\Models\Items;

use Session;
use Illuminate\Database\Eloquent\Model;
use App\Models\References\Additional;
use App\Models\References\Translates;

/**
 * App\Models\Items\CategoriesDynprops
 *
 * @mixin IdeHelperCategoriesDynprops
 */
class CategoriesDynprops extends Model
{
    protected $table = 'categories_dynprops';
    public $timestamps = false;
    const TYPE1 = 1;
    const TYPE2 = 2;
    const TYPE4 = 4;
    const TYPE5 = 5;
    const TYPE6 = 6;
    const TYPE8 = 8;
    const TYPE9 = 9;
    const TYPE10 = 10;
    const TYPE11 = 11;

    const TYPE_LIST = [
        self::TYPE1 => 'Однострочное текстовое поле',
        self::TYPE2 => 'Многострочное текстовое поле',
        self::TYPE4 => 'Выбор Да/Нет', // aniq emas searchi
        self::TYPE5 => 'Флаг', // aniq emas searchi
        self::TYPE6 => 'Выпадающий список',
        self::TYPE8 => 'Группа св-в с единичным выбором',
        self::TYPE9 => 'Группа св-в с множественным выбором',
        self::TYPE10 => 'Число',
        self::TYPE11 => 'Диапазон'
    ];

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'type',
        'default_value',
        'enabled',
        'cache_key',
        'req',
        'in_search',
        'in_seek',
        'num_first',
        'is_cache',
        'extra',
        'parent',
        'parent_value',
        'data_field',
        'num',
        'txt',
        'in_table',
        'search_hidden'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriesDynpropsMulti()
    {
        return $this->hasMany(CategoriesDynpropsMulti::class, 'dynprop_id', 'id')
            ->with(['translate'])->orderBy('num', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoryByNumlevel()
    {
        return $this->belongsTo('App\Models\Items\Categories', 'category_id', 'id')
            ->orderBy('numlevel', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translates()
    {

        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(['table_name' => $this->table, 'field_name' => 'title', 'language_code' => app()->getLocale()]);
    }

    /**
     * @return array
     */
    public function categoriesDynpropsMultiDatas()
    {
        $result = [];
        foreach ($this->categoriesDynpropsMulti as $value) {
            $datas = $value->getDynpropsMulti();
            if ($datas != null) {
                $result [] = $datas;
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getDynprop()
    {
        $title = $this->title;
        $description = $this->description;

        if (app()->getLocale() != Additional::defaultLang()) {
            $translate = $this->translates;
            if ($translate != null && $translate->field_value != null) {
                $title = $translate->field_value;
            }
        }

        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'title' => $title,
            'description' => $description,
            'type' => $this->type,
            'typeName' => $this::TYPE_LIST[$this->type],
            'extra' => $this->extra,
            'default_value' => $this->default_value,
            'enabled' => $this->enabled,
            'data_field' => $this->data_field,
            'req' => $this->req,
            'in_search' => $this->in_search,
            'num' => $this->num,
            'categoriesDynpropsMultiDatas' => $this->categoriesDynpropsMultiDatas(),
        ];
    }

    /**
     * @param $array
     * @param $value
     * @param $type
     * @return mixed|string|null
     */
    public static function getValueFromArray($array, $value, $type)
    {
        if ($type == self::TYPE11) { // Диапазон
            if ($value != 0) {
                return $value;
            } else {
                return null;
            }
        }

        if ($type == self::TYPE10) { // Число
            if ($value != 0) {
                return $value;
            } else {
                return null;
            }
        }
        if ($type == self::TYPE4) { // Выбор Да/Нет
            if ($value == 1) {
                return 'Да';
            } else {
                return 'Нет';
            }
        }
        if ($type == self::TYPE1) { // Однострочное текстовое поле
            if ($value != 0) {
                return $value;
            } else {
                return null;
            }
        }
        if ($type == self::TYPE2) { // Многострочное текстовое поле
            if ($value != 0) {
                return $value;
            } else {
                return null;
            }
        }

        if ($type == self::TYPE9) { // Группа св-в с множественным выбором
            $summa = $value;
            $result = '';
            foreach ($array as $arr) {
                if ($summa >= $arr['value']) {
                    if ($result == '') {
                        $result = $arr['name'];
                    } else {
                        $result = $arr['name'] . ', ' . $result;
                    }
                    $summa -= $arr['value'];
                }
            }
            return $result;
        }

        if ($type == self::TYPE6) { // Выпадающий список
            foreach ($array as $arr) {
                if ($arr['value'] == $value) {
                    if ($value != 0) {
                        return $arr['name'];
                    }
                }
            }
            return null;
        }

        if ($type == self::TYPE8) { // Группа св-в с единичным выбором
            foreach ($array as $arr) {
                if ($arr['value'] == $value) {
                    if ($value != 0) {
                        return $arr['name'];
                    }
                }
            }
            return null;
        }

        foreach ($array as $arr) {
            if ($arr['value'] == $value) {
                if ($type == self::TYPE5) { // Флаг nomalum nimada ishlatilishi ********************************
                    if ($value != 0) {
                        return $arr['name'];
                    }
                }
                return null;
            }
        }
    }

    /**
     * @param string $sort
     * @return mixed
     */
    public function getVariants($sort = "ASC")
    {
        $variants = CategoriesDynpropsMulti::where(['dynprop_id' => $this->id])->with('translate')
            ->orderBy('num', $sort)->get();

        foreach ($variants as  $variant){
            $variant->name = !empty($variant->translate->field_value) ? $variant->translate->field_value : $variant->name;
        }
        return $variants;
    }
}
