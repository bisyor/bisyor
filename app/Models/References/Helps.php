<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\Helps
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property int|null $helps_categories_id Категория
 * @property int|null $sorting Сортировка
 * @property string|null $text Текст
 * @property int|null $usefull_count Полезно
 * @property int|null $nousefull_count Неполезно
 * @property-read \App\Models\References\Translates $translateName
 * @property-read \App\Models\References\Translates $translateText
 * @property-read \App\Models\References\Translates $translates
 * @method static \Illuminate\Database\Eloquent\Builder|Helps newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Helps newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Helps query()
 * @method static \Illuminate\Database\Eloquent\Builder|Helps whereHelpsCategoriesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Helps whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Helps whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Helps whereNousefullCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Helps whereSorting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Helps whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Helps whereUsefullCount($value)
 * @mixin \Eloquent
 * @mixin IdeHelperHelps
 */
class Helps extends Model
{
    protected $table = 'helps';
    public $timestamps = false;
    protected $fillable = ['name', 'helps_categories_id', 'sorting', 'text', 'usefull_count', 'nousefull_count'];

    /**
     * Tarjimalar bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translates()
    {
        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(['table_name' => $this->table, 'language_code' => app()->getLocale()]);
    }

    /**
     * declination maydonini tarjimsini olish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translateName()
    {
        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(['table_name' => $this->table, 'field_name' => 'name', 'language_code' => app()->getLocale()]);
    }

    /**
     * declination maydonini tarjimsini olish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translateText()
    {
        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(['table_name' => $this->table, 'field_name' => 'text', 'language_code' => app()->getLocale()]);
    }
}
