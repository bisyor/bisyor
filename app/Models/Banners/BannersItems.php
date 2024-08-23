<?php

namespace App\Models\Banners;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Banners\BannersItems
 *
 * @property int $id
 * @property int|null $banner_id Рекламный баннер
 * @property int|null $type Тип
 * @property string|null $type_data Код
 * @property string|null $img Картинка
 * @property string|null $sitemap_id URL размещения: (относительный UR
 * @property string|null $category_id Не учитывать вложенные страни
 * @property string|null $locale locale
 * @property string|null $url_match url_match
 * @property bool|null $url_match_exact url_match_exact
 * @property string|null $click_url click_url
 * @property string|null $url Ссылка
 * @property string|null $show_start Дата начала
 * @property string|null $show_finish Дата окончани
 * @property int|null $show_limit Количество пока
 * @property string|null $title Наименование реклам
 * @property string|null $description Текст
 * @property string|null $alt Алт
 * @property int|null $enabled Показать или н
 * @property string|null $date_cr Дата создани
 * @property int|null $list_pos list_pos
 * @property bool|null $target_blank Таргет или нет
 * @property int|null $sorting_number Порядковый номер
 * @property int|null $time Время
 * @property string|null $lang_code
 * @mixin \Eloquent
 * @property-read \App\Models\Banners\Banners|null $banner
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems query()
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereBannerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereClickUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereDateCr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereLangCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereListPos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereShowFinish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereShowLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereShowStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereSitemapId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereSortingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereTargetBlank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereTypeData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereUrlMatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannersItems whereUrlMatchExact($value)
 * @mixin IdeHelperBannersItems
 */
class BannersItems extends Model
{
    protected $table = 'banners_items';
    public $timestamps = false;
    protected $fillable = [
        'banner_id',
        'type',
        'type_data',
        'img',
        'sitemap_id',
        'category_id',
        'locale',
        'url_match',
        'url_match_exact',
        'click_url',
        'url',
        'show_start',
        'show_finish',
        'show_limit',
        'title',
        'description',
        'alt',
        'enabled',
        'date_cr',
        'list_pos',
        'target_blank',
        'sorting_number',
        'time'
    ];

    /**
     * Banner jadvali bilan bog'lanish
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function banner()
    {
        return $this->belongsTo('App\Models\Banners\Banners', 'banner_id', 'id');
    }

    /**
     * Bannerlarni rasmini olish
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function getImage()
    {
        if ($this->img == null || $this->img == '') {
            return config('app.noImage');
        } else {
            return config('app.bannersPath') . $this->img;
        }
    }

    /**
     * Ko'rishlar limitini o'zgartirish
     * Har bir banner ko'rilganda limit kamaytiriladi
     */
    public function setShowLimit()
    {
        $this->show_limit--;
        if ($this->show_limit <= 0) {
            $this->enabled = 0;
        }
        $this->save();

        $statistic = BannersStatistic::where(['banner_id' => $this->id, 'date' => date('Y-m-d')])->first();
        if ($statistic == null) {
            $statistic = new BannersStatistic();
            $statistic->banner_id = $this->id;
            $statistic->date = date('Y-m-d');
            $statistic->clicks = 0;
            $statistic->shows = 1;
            $statistic->save();
        } else {
            $statistic->shows++;
            $statistic->save();
        }
    }

    /**
     * Banner bo'yicha statistikani o'zgartirish
     */
    public function setStatistic()
    {
        $statistic = BannersStatistic::where(['banner_id' => $this->id, 'date' => date('Y-m-d')])->first();
        if ($statistic == null) {
            $statistic = new BannersStatistic();
            $statistic->banner_id = $this->id;
            $statistic->date = date('Y-m-d');
            $statistic->clicks = 1;
            $statistic->shows = 1;
            $statistic->save();
        } else {
            $statistic->clicks++;
            $statistic->save();
        }
    }
}
