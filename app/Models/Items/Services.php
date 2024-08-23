<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;
use App\Models\References\Translates;
use App\Models\References\Additional;

/**
 * App\Models\Items\Services
 *
 * @property int $id
 * @property int|null $type Тип
 * @property int|null $changed_id Кто изменил
 * @property string|null $keyword Уникальный Клю
 * @property string|null $module Модуль
 * @property string|null $module_title Заголовок Модула
 * @property string|null $title Заголовок
 * @property float|null $price Стоимость
 * @property string|null $short_description Короткое Описание
 * @property string|null $description Описание
 * @property int|null $day Количество дней
 * @property int|null $sorting Сортировка
 * @property string|null $icon_b Иконка (большая)
 * @property string|null $icon_s Иконка (малая)
 * @property bool|null $enabled Статус
 * @property string|null $color Цвет
 * @property string|null $date_cr Дата создания
 * @property string|null $date_up Дата изменение
 * @property bool|null $auto_enabled Автоподнятие
 * @property int|null $free_period Бесплатное поднятие
 * @property bool|null $add_form В форме добавления
 * @property int|null $period_type Стоимость услуги
 * @property-read \Illuminate\Database\Eloquent\Collection|Translates[] $translates
 * @property-read int|null $translates_count
 * @method static \Illuminate\Database\Eloquent\Builder|Services newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Services newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Services query()
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereAddForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereAutoEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereChangedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereDateCr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereDateUp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereFreePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereIconB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereIconS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereModuleTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services wherePeriodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereSorting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Services whereType($value)
 * @mixin \Eloquent
 * @mixin IdeHelperServices
 */
class Services extends Model
{
    protected $table = 'services';
    public $timestamps = false;
    protected $fillable = [
        'type',
        'changed_id',
        'keyword',
        'module',
        'module_title',
        'title',
        'price',
        'short_description',
        'description',
        'day',
        'sorting',
        'icon_b',
        'icon_s',
        'enabled',
        'color',
        'date_cr',
        'date_up',
        'auto_enabled',
        'free_period',
        'add_form',
        'period_type'
    ];

    /**
     * Tarjimalar bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translates()
    {
        return $this->hasMany(Translates::class, 'field_id', 'id')
            ->where(['table_name' => $this->table, 'language_code' => app()->getLocale()]);
    }

    /**
     * Servisni rasmlarini olish
     * Katta xajmdagilarini
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function bigImage()
    {
        if ($this->icon_b == null || $this->icon_b == '') {
            return config('app.noImage');
        }
        $img = config('app.uploadPath') . 'services/' . $this->icon_b;
        return $img;
        if (@file_get_contents($img)) {
            return $img;
        }
        return config('app.noImage');
    }

    /**
     * Servis rasmlarni olish
     * Kichik xajmdagilarini
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function smallImage()
    {
        if ($this->icon_s == null || $this->icon_s == '') {
            return config('app.noImage');
        }
        $img = config('app.uploadPath') . 'services/' . $this->icon_s;
        return $img;
        if (@file_get_contents($img)) {
            return $img;
        }
        return config('app.noImage');
    }

    /**
     * Xizmatlar listini qaytarish
     *
     * @return array
     */
    public static function servicesList()
    {
        $services = Services::where(['enabled' => 1])->with(['translates'])->orderBy('type', 'asc')->orderBy(
            'sorting',
            'asc'
        )->get();
        $result = [];
        foreach ($services as $service) {
            $title = $service->title;
            $short_description = $service->short_description;
            $description = $service->description;

            if (app()->getLocale() != Additional::defaultLang()) {
                $postTranslate = $service->translates;
                if (!empty($postTranslate)) {
                    foreach ($postTranslate as $value) {
                        if (isset($value->field_name) && $value->field_name == 'title' && $value->field_value != null) {
                            $title = $value->field_value;
                        }
                        if (isset($value->field_name) && $value->field_name == 'short_description' && $value->field_value != null) {
                            $short_description = $value->field_value;
                        }
                        if (isset($value->field_name) && $value->field_name == 'description' && $value->field_value != null) {
                            $description = $value->field_value;
                        }
                    }
                }
            }

            $result [] = [
                'id' => $service->id,
                'type' => $service->type,
                'keyword' => $service->keyword,
                'module' => $service->module,
                'module_title' => $service->module_title,
                'title' => $title,
                'price' => $service->price,
                'short_description' => $short_description,
                'description' => $description,
                'day' => $service->day,
                'icon_b' => $service->bigImage(),
                'icon_s' => $service->smallImage(),
                'auto_enabled' => $service->auto_enabled,
                'free_period' => $service->free_period,
                'add_form' => $service->add_form,
                'period_type' => $service->period_type,
            ];
        }
        return $result;
    }

}
