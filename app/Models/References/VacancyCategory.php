<?php


namespace App\Models\References;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\References\VacancyCategory
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property int|null $parent_id Категория вакансии
 * @property bool|null $is_parent
 * @property int|null $status Статус
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyCategory whereIsParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VacancyCategory whereStatus($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|VacancyCategory[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\References\Translates|null $translate
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\References\Vacancy[] $vacancies
 * @property-read int|null $vacancies_count
 * @mixin IdeHelperVacancyCategory
 */
class VacancyCategory extends Model
{
    public $timestamps = false;
    protected $table = 'vacancy_category';

    public function translate()
    {
        return $this->hasOne(Translates::class, 'field_id', 'id')->where(
            ['table_name' => $this->table, 'language_code' => app()->getLocale()]
        );
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->withCount(
            ['vacancies AS vacancies_sum' => function ($query) {
            $query->select(DB::raw('SUM(vacancy_count)'));
        }]);
    }

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class, 'category_id', 'id');
    }

    public static function vacanciesCount(&$vacancies){
        foreach ($vacancies as $key => $value){
            $vacancies[$key]['children'] = array_sum(array_column($value['children'], 'vacancies_sum'));
        }
    }
}
