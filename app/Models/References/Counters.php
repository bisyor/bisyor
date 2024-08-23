<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\Counters
 *
 * @property int $id
 * @property string|null $title Заголовок
 * @property string|null $code
 * @property int|null $code_position
 * @property bool|null $enabled Статус
 * @property string|null $date_cr Дата создание
 * @property int|null $num Сортировка
 * @method static \Illuminate\Database\Eloquent\Builder|Counters newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Counters newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Counters query()
 * @method static \Illuminate\Database\Eloquent\Builder|Counters whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counters whereCodePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counters whereDateCr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counters whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counters whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counters whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counters whereTitle($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCounters
 */
class Counters extends Model
{
    protected $table = 'counters';
    public $timestamps = false;
    protected $fillable = ['title', 'code', 'code_position', 'enabled', 'date_cr', 'num'];

    // code_position type
    // "1" => в блоке head
    // "2" => после открывающего body
    // "3" => перед закрывающим body
    // "0" => в подвале сайта
    /**
     * Mintaqalarni qaytarish
     *
     * @return array
     */
    public static function getCounters()
    {
        $result = [];
        $counters = Counters::where(['enabled' => 1])->orderBy('num', 'asc')->get();

        foreach ($counters as $value) {
            $result [] = [
                'title' => $value->title,
                'code' => $value->code,
                'code_position' => (integer)$value->code_position,
            ];
        }
        return $result;
    }
}
