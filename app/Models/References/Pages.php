<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\Pages
 *
 * @property int $id
 * @property string|null $filename Наименование
 * @property int|null $changed_id Заголовок
 * @property string|null $date_cr Дата создание
 * @property string|null $date_up Дата изменение
 * @property bool|null $noindex ishlatmasligimiz ham mumkin
 * @property string|null $title Заголовок
 * @property string|null $description Описание
 * @property string|null $mtitle Заголовок (title)
 * @property string|null $mkeywords Ключевые слова (meta keywords)
 * @property string|null $mdescription Описание (meta desctiption)
 * @property-read \App\Models\References\Translates $translateDescription
 * @property-read \App\Models\References\Translates $translateTitle
 * @method static \Illuminate\Database\Eloquent\Builder|Pages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pages query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereChangedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereDateCr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereDateUp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereMdescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereMkeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereMtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereNoindex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereTitle($value)
 * @mixin \Eloquent
 * @mixin IdeHelperPages
 */
class Pages extends Model
{
    protected $table = 'pages';
    public $timestamps = false;
    protected $fillable = [
        'filename',
        'changed_id',
        'date_cr',
        'date_up',
        'noindex',
        'title',
        'description',
        'mtitle',
        'mkeywords',
        'mdescription	'
    ];

    /**
     * "title" maydonini tarjimasini olish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translateTitle()
    {
        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(['table_name' => $this->table, 'field_name' => 'title', 'language_code' => app()->getLocale()]);
    }

    /**
     * Description maydonini tarjimasini olish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translateDescription()
    {
        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(
                ['table_name' => $this->table, 'field_name' => 'description', 'language_code' => app()->getLocale()]
            );
    }

    /**
     * So'ralgan sagifani olish
     *
     * @param $id
     * @return array
     */
    public static function getPage($id)
    {
        $page = Pages::where(['id' => $id])->with(['translateTitle', 'translateDescription'])->first();

        $title = $page->title;
        $description = $page->description;

        if (app()->getLocale() != Additional::defaultLang()) {
            if ($page->translateTitle) {
                $title = $page->translateTitle->field_value;
            }
            if ($page->translateDescription) {
                $description = $page->translateDescription->field_value;
            }
        }

        return [
            'id' => $page->id,
            'title' => $title,
            'description' => $description,
            'date_up' => $page->date_up,
        ];
    }
}
