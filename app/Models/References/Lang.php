<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\References\Lang
 *
 * @property int $id
 * @property string|null $url Код языка
 * @property string|null $local Местное название
 * @property string|null $name Наименование
 * @property string|null $image Фотография
 * @property int|null $default
 * @property int|null $status Статус
 * @property int|null $date_update Дата изменение
 * @property int|null $date_create Дата создание
 * @method static \Illuminate\Database\Eloquent\Builder|Lang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lang query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lang whereDateCreate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lang whereDateUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lang whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lang whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lang whereLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lang whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lang whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lang whereUrl($value)
 * @mixin \Eloquent
 * @mixin IdeHelperLang
 */
class Lang extends Model
{
    protected $table = 'lang';
    public $timestamps = false;

    /**
     * Taniqli ramzini qaytaradi
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function getImage()
    {
        if ($this->image == null || $this->image == '') {
            return config('app.noImage');
        }
        return config('app.uploadPath') . 'flags/' . $this->image;
    }

    /**
     * Tillarni qaytarish
     *
     * @return mixed
     */
    public static function getLanguages()
    {
        return Cache::get(
            'lang',
            function () {
                return Lang::where(['status' => 1])->get();
            }
        );
    }

}
