<?php

namespace App\Models\Banners;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Banners\Banners
 *
 * @property int $id
 * @property string|null $keyword Ключ
 * @property string|null $title  Наименование рекламы
 * @property bool|null $enabled Статус
 * @property float|null $width Ширина
 * @property float|null $height Высота
 * @property bool|null $filter_auth_users Скрывать для авторизованных пользов
 * @property string|null $lang_code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Banners\BannersItems[] $item
 * @property-read int|null $item_count
 * @method static \Illuminate\Database\Eloquent\Builder|Banners newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banners newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banners query()
 * @method static \Illuminate\Database\Eloquent\Builder|Banners whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banners whereFilterAuthUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banners whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banners whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banners whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banners whereLangCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banners whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banners whereWidth($value)
 * @mixin \Eloquent
 * @mixin IdeHelperBanners
 */
class Banners extends Model
{
	protected $table = 'banners';
	public $timestamps = false;
	protected $fillable = ['keyword', 'title', 'enabled', 'width', 'height', 'filter_auth_users'];

	const SORT_TYPE_BY_NUMBER = 2;
	const ITEMS_CARD_NEW_ITEMS = 'items_card_new_items';
	const ITEMS_CARD_OTHER_ITEMS = 'items_card_other_items';
	const MAIN_PAGE = 'main_page';
	const ITEMS_LIST = 'items_list';
	const ITEMS_MAP = 'items_map';
	const ITEMS_GALLERY = 'items_gallery';
	const SHOPS_LIST = 'shops_list';

    /**
     * Bannerlar itemi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function item()
    {
        $now = date('Y-m-d H:i:s');
        return $this->hasMany('App\Models\Banners\BannersItems', 'banner_id', 'id')
            ->where(['enabled' => 1])
            ->where('show_start', '<=', $now)
            ->where('show_finish', '>=', $now)
            ->where('show_limit', '>', 0)
            ->where('lang_code', app()->getLocale())
            ->inRandomOrder();
    }

    /**
     * Bannerlarni olish massiv ko'rinishida
     *
     * @param $array
     * @return array
     */
    public static function getBanners($array)
    {
        $banners = Banners::whereIn('keyword', $array)->where('enabled', 1)->with(['item'])->get();
        $result = [];
        foreach ($banners as $banner) {
            foreach ($banner->item->take(1) as $item) {
                $result [$banner->keyword] = [
                    'id' => $item->id,
                    'img' => $item->getImage(),
                    'url' => $item->url,
                    'title' => $item->title,
                    'description' => $item->description,
                    'alt' => $item->alt,
                    'type' => $item->type,
                    'type_data' => $item->type_data,
                ];
                $item->setShowLimit();
            }
        }
        return $result;
    }

    /**
     * Yandex and google ads
     *
     * @param array $items
     */
    public static function getGoogleAndYandexAds(array &$items = [], string $keyword = 'main_page'){
        $banner = self::whereKeyword('yandex_google_ads')->where('enabled',1)->first();
        $banner_items = [];
        if($banner){
            $banner_items = BannersItems::where('keyword', $keyword)->where('banner_id', $banner->id)
                ->where('enabled', true)->get();
        }
        $count_items = count($items);
        foreach ($banner_items as $banner_item) {
            $sorting_number = $banner_item->sorting_number;
            if($banner_item->sort_type != self::SORT_TYPE_BY_NUMBER || $banner_item->sorting_number > $count_items){
                $sorting_number = rand(1, 20);
            }
            if($sorting_number <= $count_items){
                $items = array_replace($items, [
                    $sorting_number - 1 => ['is_banner' => true, 'code' => $banner_item->type_data]
                ]);
            }
            $banner_item->setShowLimit();
        }
    }
}
