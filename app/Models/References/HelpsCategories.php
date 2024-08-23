<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HelpsCategories
 *
 * @package App\Models\References
 * @property int $id
 * @property string|null $name Наименование
 * @property int|null $sorting Сортировка
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\References\Helps[] $helps
 * @property-read int|null $helps_count
 * @property-read \App\Models\References\Translates $translates
 * @method static \Illuminate\Database\Eloquent\Builder|HelpsCategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HelpsCategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HelpsCategories query()
 * @method static \Illuminate\Database\Eloquent\Builder|HelpsCategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HelpsCategories whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HelpsCategories whereSorting($value)
 * @mixin \Eloquent
 * @mixin IdeHelperHelpsCategories
 */
class HelpsCategories extends Model
{
    protected $table = 'helps_categories';
    public $timestamps = false;
    protected $fillable = ['name', 'sorting'];

    /**
     * Tarjimalarini bog'lash
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translates()
    {
        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(['table_name' => $this->table, 'field_name' => 'name', 'language_code' => app()->getLocale()]);
    }

    /**
     * Yordam jadvali bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function helps()
    {
        return $this->hasMany(Helps::class, 'helps_categories_id', 'id')
            ->orderBy('sorting', 'asc')->with(['translates']);
    }

    /**
     * Helpning qiymatlari uchun
     *
     * @return array
     */
    public function helpValues()
    {
        $result = [];
        foreach ($this->helps as $value) {
            $text = $value->text;
            $name = $value->name;
            if (app()->getLocale() != Additional::defaultLang()) {

                $nameTranslate = $value->translateName;
                $textTranslate = $value->translateText;

                if ($nameTranslate != null) {
                    $text = $nameTranslate->field_value;
                }

                if ($textTranslate != null) {
                    $text = $textTranslate->field_value;
                }
            }
            $result [] = [
                'id' => $value->id,
                'name' => $name,
                'text' => $text,
                'helps_categories_id' => $value->helps_categories_id,
                'usefull_count' => $value->usefull_count,
                'nousefull_count' => $value->nousefull_count,
            ];
        }
        return $result;
    }

    /**
     * Ro'yxatni olish
     *
     * @return array
     */
    public static function getList()
    {
        $categories = HelpsCategories::with(['translates', 'helps'])->orderBy('sorting', 'asc')->get();
        $result = [];
        foreach ($categories as $category) {
            $result [] = $category->getHelpCategory();
        }
        return $result;
    }

    /**
     * Yordam bo'limidagi kategoriyalarni olish
     *
     * @return array
     */
    public function getHelpCategory()
    {
        $name = $this->name;
        if (app()->getLocale() != Additional::defaultLang()) {
            $translate = $this->translates;
            if ($translate != null) {
                $name = $translate->field_value;
            }
        }

        return [
            'id' => $this->id,
            'name' => $name,
            'helps' => $this->helpValues(),
        ];
    }
}
