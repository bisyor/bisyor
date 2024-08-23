<?php

namespace App\Models\Banners;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Banners\BannersStatistic
 *
 * @property int $id
 * @property int|null $banner_id Рекламный баннер
 * @property string|null $date Дата
 * @property int|null $clicks Количество кликов
 * @property int|null $shows Количество просмотров
 * @property-read \App\Models\Banners\BannersItems|null $items
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|BannersStatistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BannersStatistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BannersStatistic query()
 * @method static \Illuminate\Database\Eloquent\Builder|BannersStatistic whereBannerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersStatistic whereClicks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersStatistic whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersStatistic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersStatistic whereShows($value)
 * @mixin IdeHelperBannersStatistic
 */
class BannersStatistic extends Model
{
    protected $table = 'banners_statistic';
    public $timestamps = false;
    protected $fillable = [
        'banner_id',
        'date', 'clicks',
        'shows'
    ];

    public function items()
    {
        return $this->belongsTo('App\Models\Banners\BannersItems', 'banner_id', 'id');
    }
}
