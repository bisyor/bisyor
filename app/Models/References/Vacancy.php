<?php


namespace App\Models\References;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\Vacancy
 *
 * @property int $id
 * @property string|null $title Наименование
 * @property int|null $vacancy_count количество вакансий
 * @property string|null $description
 * @property float|null $price
 * @property int|null $currency_id
 * @property int|null $category_id
 * @property-read \App\Models\References\VacancyCategory|null $category
 * @property-read \App\Models\References\Currencies|null $currency
 * @property-read \App\Models\References\Translates|null $translate
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vacancy whereVacancyCount($value)
 * @mixin \Eloquent
 * @mixin IdeHelperVacancy
 */
class Vacancy extends Model
{
    public $timestamps = false;
    protected $table = 'vacancies';

    /**
     * Tarjimalar bilan bog'lanish
     * @return mixed
     */
    public function translate()
    {
        return $this->hasOne(Translates::class, 'field_id', 'id')->where(
            ['table_name' => $this->table, 'language_code' => app()->getLocale()]
        );
    }

    /**
     * Tarjimasini to'girlab qulay ko'rinishga o'tkazib beradi
     * @param $translates
     */
    public static function getTranslates(&$translates)
    {
        foreach ($translates as $key => $value) {
            if (is_array($value['translate']) && array_key_exists('field_value', $value['translate']) && $value['translate']['field_value']) {
                $translates[$key]['name'] = $value['translate']['field_value'];
            }
            unset($translates[$key]['translate']);
        }
    }

    public function currency(){
        return $this->belongsTo(Currencies::class, 'currency_id', 'id');
    }

    public function category(){
        return $this->belongsTo(VacancyCategory::class, 'category_id', 'id');
    }
}
