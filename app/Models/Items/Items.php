<?php

namespace App\Models\Items;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\References\Additional;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

/**
 * App\Models\Items\Items
 *
 *
 * @mixin IdeHelperItems
 */
class Items extends Model
{
    protected $table = 'items';
    public $timestamps = false;
    const STATUS_NOACTIVE = 1;
    const STATUS_PUBLICATION = 3;
    const STATUS_INPUBLICATION = 4; //Снятые с публикации
    const STATUS_BLOCKED = 5; //Заблокированные
    const STATUS_DELETED = 6;  //Удаленные
    const NEW_STATUS_PUBLICATIOM = 0;
    const NEW_STATUS_INPUBLICATION = 1;
    const NEW_STATUS_MODERATING = 2;
    const NEW_STATUS_INACTIVE = 3;
    const NEW_STATUS_BLOCKED = 4;
    const NEW_STATUS_DELETED = 5;
    const NEW_STATUS_DEL = 6;
    const STATUS_TYPE = [
        self::NEW_STATUS_PUBLICATIOM => [
            'name' => 'Опубликованные',
            'statuses' => [
                'status' => 3,
                'is_moderating' => 0,
                'is_publicated' => 1
            ]
        ],
        self::NEW_STATUS_INPUBLICATION => [
            'name' => 'Снятые с публикации',
            'statuses' => [
                'status' => 4,
                'is_moderating' => 0,
                'is_publicated' => 0
            ]
        ],
        self::NEW_STATUS_MODERATING => [
            'name' => 'На модерации',
            'statuses' => [
                'status' => 3,
                'is_moderating' => 1,
                'is_publicated' => 0
            ]
        ],
        self::NEW_STATUS_INACTIVE => [
            'name' => 'Неактивированные',
            'statuses' => [
                'status' => 1,
                'is_moderating' => 0,
                'is_publicated' => 0
            ]
        ],
        self::NEW_STATUS_BLOCKED => [
            'name' => 'Заблокированные',
            'statuses' => [
                'status' => 5,
                'is_moderating' => 0,
                'is_publicated' => 0
            ]
        ],
        self::NEW_STATUS_DELETED => [
            'name' => 'Удаленные',
            'statuses' => [
                'status' => 6,
                'is_moderating' => 0,
                'is_publicated' => 0
            ]
        ],
        -1 => [
            'name' => 'Все',
        ],
    ];
    protected $fillable = [
        'user_id',
        'user_ip',
        'shop_id',
        'is_publicated',
        'is_moderating',
        'status',
        'status_prev',
        'status_changed',
        'deleted',
        'cat_id',
        'owner_type',
        'district_id',
        'address',
        'svc_up_activate',
        'svc_up_date',
        'svc_up_free',
        'svc_upauto_on',
        'svc_upauto_sett',
        'svc_upauto_next',
        'svc_fixed',
        'svc_fixed_to',
        'svc_fixed_order',
        'svc_premium',
        'svc_premium_to',
        'svc_premium_order',
        'svc_marked_to',
        'svc_press_status',
        'svc_press_date',
        'svc_press_date_last',
        'svc_quick_to',
        'coordinate_x',
        'coordinate_y',
        'title',
        'keyword',
        'link',
        'description',
        'lang',
        'img_s',
        'img_m',
        'images',
        'date_cr',
        'date_up',
        'price',
        'price_ex',
        'price_search',
        'currency_id',
        'name',
        'phones',
        'publicated',
        'publicated_to',
        'publicated_order',
        'publicated_period',
        'from_device',
        'moderated_id',
        'moderated_id',
        'blocked_reason',
        'img_prefix',
        'f1',
        'f2',
        'f3',
        'f4',
        'f5',
        'f6',
        'f7',
        'f8',
        'f9',
        'f10',
        'f11',
        'f12',
        'f13',
        'f14',
        'f15',
        'f16',
        'f17',
        'f18',
        'f19',
        'f20',
        'f21',
        'f22',
        'f23',
        'f24',
        'f25',
        'old_price',
        'is_publicated_telegram',
        'price_end',
        'popular_degree',
        'old_title',
        'old_description',
    ];

    // price type
    // цена - 0
    // торг возможен - 1
    // обмен - 2
    // бесплатно - 4
    // договорная - 8
    /**
     * Foydalanuvchi elonlari
     *
     * @param $user_id
     * @param int $page
     * @param null $query
     * @return array
     */
    public static function getUserItems($user_id, $page = 1, $query = null)
    {
        $count = config('settings.shop_items_pagesize');
        $limit = $count * $page;
        $skip = $limit - $count;
        $items = Items::where(['user_id' => $user_id])->where(
            'status',
            '!=',
            self::STATUS_TYPE[self::NEW_STATUS_DELETED]['statuses']['status']
        )->where(
            function ($q) use ($query) {
                if (isset($query->title)) {
                    $q->where('title', 'ilike', "%{$query->title}%");
                }
                if (isset($query->category) && is_numeric($query->category)) {
                    $q->whereIn('cat_id', Categories::getChildren($query->category));
                }
            }
        )
            ->with(['currency', 'category', 'favorite', 'district', 'itemViews', 'itemMsgCount'])
            ->orderBy('id', 'desc')
            ->skip($skip)
            ->take($count)
            ->get();
        $result = [];
        $color = Additional::serviceMarkedColor();
        foreach ($items as $item) {
            $msgCount = 0;
            if ($item->itemMsgCount != null) {
                $msgCount = $item->chatMsgCount();
            }
            $result [] = $item->getItem($color, $msgCount);
        }
        return $result;
    }

    /**
     * Do'konlar elonlari
     *
     * @param $shop_id
     * @param int $page
     * @param null $query
     * @return array
     */
    public static function getShopItems($shop_id, $page = 1, $query = null)
    {
        $count = config('settings.shop_items_pagesize');
        $limit = $count * $page;
        $skip = $limit - $count;
        $items = Items::where(['shop_id' => $shop_id, 'is_moderating' => 0, 'status' => self::STATUS_PUBLICATION])
            ->where(
                function ($q) use ($query) {
                    if (isset($query->title)) {
                        $q->where('title', 'ilike', "%{$query->title}%");
                    }
                    if (isset($query->category) && is_numeric($query->category)) {
                        $q->whereIn('cat_id', Categories::getChildren($query->category));
                    }
                }
            )->with(['currency', 'district', 'itemViews', 'category', 'favorite'])->skip($skip)->take($count)->get();
        $result = [];
        $color = Additional::serviceMarkedColor();
        foreach ($items as $item) {
            $result [] = $item->getShopItemsList($color);
        }
        return $result;
    }

    /**
     * Foydalanuchining faol elonlari
     *
     * @param $user_id
     * @param int $page
     * @param null $query
     * @return array
     */
    public static function getUserActiveItems($user_id, $page = 1, $query = null)
    {
        $count = config('settings.shop_items_pagesize');
        $limit = $count * $page;
        $skip = $limit - $count;
        $items = Items::where(
            ['user_id' => $user_id, 'is_publicated' => 1, 'is_moderating' => 0, 'status' => self::STATUS_PUBLICATION]
        )
            ->where(
                function ($q) use ($query) {
                    if (isset($query->title)) {
                        $q->where('title', 'ilike', "%{$query->title}%");
                    }
                    if (isset($query->category) && is_numeric($query->category)) {
                        $q->whereIn('cat_id', Categories::getChildren($query->category));
                    }
                }
            )
            ->with(['currency', 'category', 'favorite', 'district', 'itemViews', 'itemMsgCount'])
            ->orderBy('id', 'desc')
            ->skip($skip)
            ->take($count)
            ->get();
        $result = [];
        $color = Additional::serviceMarkedColor();
        foreach ($items as $item) {
            $msgCount = 0;
            if ($item->itemMsgCount != null) {
                $msgCount = $item->chatMsgCount();
            }
            $result [] = $item->getItem($color, $msgCount);
        }
        return $result;
    }

    /**
     * Foydalanuvchining moderatsiyadagi elonlari
     *
     * @param $user_id
     * @param int $page
     * @param null $query
     * @return array
     */
    public static function getUserModeratingItems($user_id, $page = 1, $query = null)
    {
        $count = config('settings.shop_items_pagesize');
        $limit = $count * $page;
        $skip = $limit - $count;
        $items = Items::where(
            ['user_id' => $user_id, 'is_publicated' => 0, 'is_moderating' => 1, 'status' => self::STATUS_PUBLICATION]
        )->where(
            function ($q) use ($query) {
                if (isset($query->title)) {
                    $q->where('title', 'ilike', "%{$query->title}%");
                }
                if (isset($query->category) && is_numeric($query->category)) {
                    $q->whereIn('cat_id', Categories::getChildren($query->category));
                }
            }
        )
            ->with(['currency', 'category', 'favorite', 'district', 'itemViews', 'itemMsgCount'])
            ->orderBy('id', 'desc')
            ->skip($skip)
            ->take($count)
            ->get();

        $result = [];
        $color = Additional::serviceMarkedColor();
        foreach ($items as $item) {
            $msgCount = 0;
            if ($item->itemMsgCount != null) {
                $msgCount = $item->chatMsgCount();
            }
            $result [] = $item->getItem($color, $msgCount);
        }
        return $result;
    }

    /**
     * Foydalanuvchining faol bo'lmagan elonlar listi
     *
     * @param $user_id
     * @param int $page
     * @param null $query
     * @return array
     */
    public static function getUserNoActiveItems($user_id, $page = 1, $query = null)
    {
        $count = config('settings.shop_items_pagesize');
        $limit = $count * $page;
        $skip = $limit - $count;
        $items = Items::where(['user_id' => $user_id, 'status' => self::STATUS_INPUBLICATION])
            ->where(
                function ($q) use ($query) {
                    if (isset($query->title)) {
                        $q->where('title', 'ilike', "%{$query->title}%");
                    }
                    if (isset($query->category) && is_numeric($query->category)) {
                        $q->whereIn('cat_id', Categories::getChildren($query->category));
                    }
                }
            )
            ->with(['currency', 'category', 'favorite', 'district', 'itemViews', 'itemMsgCount'])
            ->orderBy('id', 'desc')
            ->skip($skip)
            ->take($count)
            ->get();
        $result = [];
        $color = Additional::serviceMarkedColor();
        foreach ($items as $item) {
            $msgCount = 0;
            if ($item->itemMsgCount != null) {
                $msgCount = $item->chatMsgCount();
            }
            $result [] = $item->getItem($color, $msgCount);
        }
        return $result;
    }

    /**
     * Foydalanuvchining bloklangan elonlari
     *
     * @param $user_id
     * @param int $page
     * @param null $query
     * @return array
     */
    public static function getUserBlockedItems($user_id, $page = 1, $query = null)
    {
        $count = config('settings.shop_items_pagesize');
        $limit = $count * $page;
        $skip = $limit - $count;
        $items = Items::where(['user_id' => $user_id, 'status' => self::STATUS_BLOCKED])
            ->where(
                function ($q) use ($query) {
                    if (isset($query->title)) {
                        $q->where('title', 'ilike', "%{$query->title}%");
                    }
                    if (isset($query->category) && is_numeric($query->category)) {
                        $q->whereIn('cat_id', Categories::getChildren($query->category));
                    }
                }
            )
            ->with(['currency', 'category', 'favorite', 'district', 'itemViews', 'itemMsgCount'])
            ->orderBy('id', 'desc')
            ->skip($skip)
            ->take($count)
            ->get();
        $result = [];
        $color = Additional::serviceMarkedColor();
        foreach ($items as $item) {
            $msgCount = 0;
            if ($item->itemMsgCount != null) {
                $msgCount = $item->chatMsgCount();
            }
            $result [] = $item->getItem($color, $msgCount);
        }
        return $result;
    }

    /**
     * Elonlarning likelarini aniqlash
     *
     * @param $item
     * @return array
     */
    public static function getLikeItems($item)
    {
        $result = [];
        $view_similar_limit = config('settings.view_similar_limit');
        $items = Items::where(['is_moderating' => 0, 'status' => self::STATUS_PUBLICATION,])
            ->where('id', '!=', $item->id)
            ->where(['cat_id' => $item->cat_id])
            ->with(['currency', 'category', 'favorite', 'district', 'itemViews'])
            ->orderBy('publicated', 'desc')->inRandomOrder()
            ->take($view_similar_limit)->get();
        $color = Additional::serviceMarkedColor();
        foreach ($items as $it) {
            if ($it->id !== $item->id) {
                $result [] = $it->getItem($color);
            }
        }
        return $result;
    }

    /**
     * E'lon ko'rilayotgnda shu e'longa biriktirilgan do'kon  bo'ladigan bo'lsa
     * shu do'konning qolgan elonlarinixam ko'rsatish funksiyasi
     *
     * @param $item
     * @return array
     */
    public static function getUserShopItems($item)
    {
        $result = [];
        $view_similar_limit = config('settings.view_similar_limit');
        if (!$item->shop_id) {
            return $result;
        }

        $items = Items::where(['is_moderating' => 0, 'status' => self::STATUS_PUBLICATION,])
            ->where('id', '!=', $item->id)
            ->where('shop_id', $item->shop_id)
            ->with(['currency', 'category', 'favorite', 'district', 'itemViews'])
            ->orderBy('publicated', 'desc')->inRandomOrder()
            ->take($view_similar_limit)->get();
        $color = Additional::serviceMarkedColor();
        foreach ($items as $it) {
            if ($it->id !== $item->id) {
                $result [] = $it->getItem($color);
            }
        }
        return $result;
    }

    /**
     * @param $mainCategories
     * @param $item
     * @return array
     */
    public static function getDynpropValues($mainCategories, $item)
    {
        $dynpropValues = [];
        for ($i = count($mainCategories) - 1; $i > -1; $i--) {
            foreach ($mainCategories[$i]['dynprop'] as $dynprop) {
                $value = $item->{'f' . $dynprop['data_field']};
                $dynpropMulti = CategoriesDynprops::getValueFromArray(
                    $dynprop['categoriesDynpropsMultiDatas'],
                    $value,
                    $dynprop['type']
                );
                if ($dynpropMulti != null) {
                    $dynpropValues [] = [
                        'title' => $dynprop['title'],
                        'dynpropMulti' => $dynpropMulti,
                        'description' => $dynprop['description'],
                        'type' => $dynprop['type'],
                        'typeName' => $dynprop['typeName'],
                        'extra' => unserialize($dynprop['extra']),
                        'default_value' => $dynprop['default_value'],
                        'num' => $dynprop['num'],
                        'value' => $value,
                        'categoriesDynpropsMultiDatas' => $dynprop['categoriesDynpropsMultiDatas'],
                    ];
                }
            }
        }
        return $dynpropValues;
    }

    /**
     * Premimum tarifidagi elonlarni qaytarish
     *
     * @param null $item_id
     * @return array
     */
    public static function getPremiumItems($item_id = null)
    {
        $distId = Additional::getRegionsDistrict();
        $items = Items::where(['is_publicated' => 1, 'status' => self::STATUS_PUBLICATION, /*'deleted' => 0*/])
            ->where('svc_premium_to', '>', date('Y-m-d H:i:s'))
            ->with(['currency', 'category', 'district', 'favorite', 'itemViews']);

        if (count($distId) > 0) {
            $items = $items->whereIn('district_id', $distId);
        }

        if (config('settings.general_premium_view_type') == 1) {
            $items = $items->inRandomOrder()->take(4)->get();
        } else {
            $items = $items->inRandomOrder()->take(10)->get();
        }

        $result = [];
        $color = Additional::serviceMarkedColor();
        foreach ($items as $item) {
            if ($item_id == null) {
                $result [] = $item->getItem($color);
            }
            if ($item_id != null && $item_id !== $item->id) {
                $result [] = $item->getItem($color);
            }
        }
        return $result;
    }

    /**
     * Yangi elonlarni qaytarish
     *
     * @param int $page
     * @return array
     */
    public static function getNewItems($page = 1)
    {
        $distId = Additional::getRegionsDistrict();
        $items = Items::where(['is_publicated' => 1, 'status' => self::STATUS_PUBLICATION, /*'deleted' => 0*/]);

        if (count($distId) > 0) {
            $items = $items->whereIn('district_id', $distId);
        }

        $count = 2 * config('settings.general_item_count_in_new_items');
        $limit = $count * $page;
        $skip = $limit - $count;

        $items = $items->orderBy('status_changed', 'desc')->orderBy('id', 'desc')
            ->with(['currency', 'category', 'district', 'favorite', 'itemViews'])
            ->skip($skip)
            ->take($count)
            ->get();

        $result = [];
        $color = Additional::serviceMarkedColor();
        foreach ($items as $item) {
            $result [] = $item->getItem($color);
        }
        return $result;
    }

    public static function getLastItemsByCount($besides)
    {
        $distId = Additional::getRegionsDistrict();
        $items = Items::where(['is_publicated' => 1, 'status' => self::STATUS_PUBLICATION])
            ->where('link', '!=', $besides);
        $count = config('settings.last_item_count_in_new_items');
        if (count($distId) > 0) {
            $items = $items->whereIn('district_id', $distId);
        }
        $items = $items->orderBy('status_changed', 'desc')->orderBy('id', 'desc')
            ->with(['currency', 'category', 'district', 'favorite', 'itemViews'])
            ->take($count)
            ->get();
        $result = [];
        $color = Additional::serviceMarkedColor();
        foreach ($items as $item) {
            $result [] = $item->getItem($color);
        }
        return $result;
    }

    /**
     * Popular elonlarni qaytarish
     *
     * @param int $page
     * @return array
     */
    public static function getPopularItems($page = 1)
    {
        $distId = Additional::getRegionsDistrict();
        $items = Items::where(['is_publicated' => 1, 'status' => self::STATUS_PUBLICATION, /*'deleted' => 0*/]);

        if (count($distId) > 0) {
            $items = $items->whereIn('district_id', $distId);
        }


        $count = 2 * config('settings.general_item_count_in_new_items');
        $limit = $count * $page;
        $skip = $limit - $count;

        $items = $items->orderBy('popular_degree', 'desc')
            ->inRandomOrder()
            /*->orderBy('status_changed', 'desc')
            ->orderBy('id', 'desc')*/
            ->with(['currency', 'category', 'district', 'favorite', 'itemViews'])
            ->skip($skip)
            ->take($count)
            ->get();

        $result = [];
        $color = Additional::serviceMarkedColor();
        foreach ($items as $item) {
            $result [] = $item->getItem($color);
        }
        return $result;
    }

    /**
     * Foydalanuvchiga qizigan e'lonlarini ko'rsatish
     *
     * @param $duplicated_id
     * @param $result
     */
    public static function getRecommendationItems($duplicated_id, &$result)
    {
        $recommendation_count = config('settings.recommendation_count');

        $cat_list = Categories::getUserCategories();
        $items = Items::where(['is_publicated' => 1, 'status' => self::STATUS_PUBLICATION, /*'deleted' => 0*/]);
        $color = Additional::serviceMarkedColor();
        if (!empty($cat_list)) {
            $items = $items->whereIn('cat_id', $cat_list)
                ->orderBy('popular_degree', 'desc')
                ->inRandomOrder()
                ->with(['currency', 'category', 'district', 'favorite', 'itemViews'])
                ->whereNotIn('id', $duplicated_id)
                ->take($recommendation_count)
                ->get();
            foreach ($items as $item) {
                $result [] = $item->getItem($color);
            }
        }
    }

    /**
     * Bo'limlardagi elonlar sonini aniqlash
     *
     * @param $categoryChildIdList
     * @return int
     */
    public static function categoryItemsCount($categoryChildIdList)
    {
        $distId = Additional::getRegionsDistrict();
        $itemsCount = Items::where(['is_publicated' => 1, 'status' => self::STATUS_PUBLICATION, /*'deleted' => 0*/]);
        if ($categoryChildIdList != null) {
            $itemsCount = $itemsCount->whereIn('cat_id', $categoryChildIdList);
        } else {
            return 0;
        }

        if (count($distId) > 0) {
            $itemsCount = $itemsCount->whereIn('district_id', $distId);
        }
        return $itemsCount->count();
    }

    /**
     * Bo'limlardagi elonlar sonini qaytarish map ko'rinish uchun
     *
     * @param $categoryChildIdList
     * @return int
     */
    public static function categoryItemsCountMap($categoryChildIdList)
    {
        $itemsCount = Items::where(['is_publicated' => 1, 'status' => self::STATUS_PUBLICATION, /*'deleted' => 0*/]);
        if ($categoryChildIdList != null) {
            $itemsCount = $itemsCount->whereIn('cat_id', $categoryChildIdList);
        } else {
            return 0;
        }

        return $itemsCount->count();
    }

    /**
     * Mintaqalar bo'yicha elonlar sonini qaytarish
     *
     * @param null $distId
     * @param null $categoryChildIdList
     * @return int
     */
    public static function regionItemsCount($distId = null, $categoryChildIdList = null)
    {
        $itemsCount = Items::where(['is_publicated' => 1, 'status' => self::STATUS_PUBLICATION, /*'deleted' => 0*/]);
        if ($distId != null) {
            $itemsCount = $itemsCount->whereIn('district_id', $distId);
        }
        if ($categoryChildIdList != null) {
            $itemsCount = $itemsCount->whereIn('cat_id', $categoryChildIdList);
        }

        return $itemsCount->count();
    }

    /**
     * Elonlar listini olish
     *
     * @param $keyword
     * @param int $page
     * @param null $post
     * @return array
     */
    public static function getItemList($keyword, $page = 1, $post = null)
    {
        $distId = Additional::getRegionsDistrict();
        $items = Items::where(['is_publicated' => 1, 'status' => self::STATUS_PUBLICATION]);

        $category = Categories::where(['keyword' => $keyword, 'enabled' => 1])->with(['children'])->first();
        if ($category != null) {
            $categoryChildIdList = $category->buildTree($category->children, $category->id);
            if ($categoryChildIdList != null) {
                $items->whereIn('cat_id', $categoryChildIdList);
            } else {
                $items->where('cat_id', $category->id);
            }
        }

        if (count($distId) > 0) {
            $items->whereIn('district_id', $distId);
        }

        $count = config('settings.general_item_count_in_new_items');
        $limit = $count * $page;
        $skip = $limit - $count;

        //bu kodni o'chirdim va filtrPostDatas ga qowdim
        /*$items->orderBy('svc_fixed_to', 'asc')
            ->orderBy('status_changed', 'desc')
            ->orderBy('svc_premium', 'desc');*/
        $items = Items::filtrPostDatas($post, $items);
        $items = $items->with(['currency', 'category', 'district', 'favorite', 'itemViews'])
            ->skip($skip)->take($count)->get();

        $result = [];
        $color = Additional::serviceMarkedColor();
        foreach ($items as $item) {
            $result [] = $item->getItem($color);
        }
        return $result;
    }

    /**
     * Rss uchun elonlar ro'yxatini olish
     *
     * @param $category
     * @param int $page
     * @param $region_id
     * @param $district_id
     * @return array
     */
    public static function getItemListForRss($category, $page = 1, $region_id, $district_id)
    {
        $distId = Additional::getRegionsDistrictForRss($region_id, $district_id);
        $items = Items::where(['is_publicated' => 1, 'status' => self::STATUS_PUBLICATION]);
        $categoryChildIdList = null;
        if($category != null){
            $categoryChildIdList = $category->buildTree($category->children, $category->id);
            if ($categoryChildIdList != null) {
                $items = $items->whereIn('cat_id', $categoryChildIdList);
            } else {
                $items = $items->where('cat_id', $category->id);
            }
        }

        if (count($distId) > 0) {
            $items = $items->whereIn('district_id', $distId);
        }

        $count = config('settings.general_item_count_in_new_items');
        $limit = $count * $page;
        $skip = $limit - $count;

        $items = $items->orderBy('svc_fixed_to', 'asc')
            ->orderBy('status_changed', 'desc')
            ->orderBy('svc_premium', 'desc');
        $items = $items->with(['currency', 'category', 'district', 'favorite', 'itemImages', 'itemViews'])
            ->skip($skip)->take($count)->get();

        $result = [];
        $color = Additional::serviceMarkedColor();
        foreach ($items as $item) {
            $array = $item->getItem($color);
            $array += $item->getItemImages();
            $result [] = $array;
        }
        return $result;
    }

    /**
     * Elonga tegishli rasmlarni olish
     *
     * @return array[]
     */
    public function getItemImages()
    {
        $result = [];
        foreach ($this->itemImages as $image) {
            $result [] = [
                'img_s' => config('app.itemsPath') . $image->extstor_img_s,
                'img_m' => config('app.itemsPath') . $image->extstor_img_m,
                'img_v' => config('app.itemsPath') . $image->extstor_img_v,
                'img_z' => config('app.itemsPath') . $image->extstor_img_z,
                'img_o' => config('app.itemsPath') . $image->extstor_img_o,
            ];
        }
        return ['itemImages' => $result];
    }

    /**
     * Aloxida e'lonni ko'rish
     *
     * @param null $markColor
     * @param int $msgCount
     * @return array
     */
    public function getItem($markColor = null, $msgCount = 0)
    {
        $favorite = '';
        $currencyName = null;
        if ($this->currency != null) {
            $currencyName = $this->currency->getName();
        }

        if (count($this->favorite) > 0) {
            $favorite = 'active';
        } elseif ($this->favoriteSession()) {
            $favorite = 'active';
        }

        if ($this->old_price) {
            $old_price = number_format($this->old_price) . ' ' . $currencyName;
        } else {
            $old_price = null;
        }

        if ((float)$this->coordinate_x > 0 && (float)$this->coordinate_y) {
            $map = true;
        } else {
            $map = false;
        }

        $phones = unserialize($this->phones);
        if (is_array($phones) && count($phones) > 0) {
            $showPhone = true;
        } else {
            $showPhone = false;
        }

        $price = null;
        if ($this->category->price) {
            $price = number_format($this->price, 2, '.', ' ');
            if ($this->price_ex === 0) {
                if ($this->category->price_diapazone && $this->price_end > 0) {
                    $price .= ' - ' . number_format($this->price_end, 2, '.', ' ');
                }
                $price .= ' ' . $currencyName;
                $price = str_replace('.00', '', $price);
            } elseif ($this->price_ex == 1) {
                if ($this->category->price_diapazone && $this->price_end > 0) {
                    $price .= ' - ' . number_format($this->price_end, 2, '.', ' ');
                }
                $price .= ' ' . $currencyName;
                $price = str_replace('.00', '', $price);
            } elseif ($this->price_ex == 2) {
                $price = trans('messages.Exchange');
            } elseif ($this->price_ex == 4) {
                $price = trans('messages.Free');
            } elseif ($this->price_ex == 8) {
                $price = trans('messages.Negotiated');
            }
        }

        $viewCount = 0;
        $contactView = 0;
        $today_view = 0;
        $today = date("Y-m-d");
        foreach ($this->itemViews as $view) {
            $viewCount += $view->item_views;
            $contactView += $view->contacts_views;
            if ($view->period === $today) {
                $today_view = $view->item_views;
            }
        }

        $shop = [];
        if ($this->shop_id != null) {
            $shop = $this->shop->getShop();
        }

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'shop_id' => $this->shop_id,
            'shop' => $shop,
            'title' => $this->title,
            'description' => str_replace("\n", '<br>', $this->description),
            'link' => $this->link != null ? $this->link : $this->id, // bu yerni tekshirib turish kerak
            'keyword' => $this->keyword,
            'image' => $this->getImageM(),
            'imageZ' => $this->getImageZ(),
            'price' => $price,
            'price_ex' => ($this->price_ex == 1 ? true : false), //$this->price_ex,
            'price_ex_title' => $this->category->getModTitle(),
            'oldPrice' => $old_price,
            'favorite' => $favorite,
            'date_cr' => date('d.m.Y', strtotime($this->date_cr)),
            'date_cr_h' => date('H:i d.m.Y', strtotime($this->date_cr)),
            'date_status_changed' => date('d.m.Y', strtotime($this->status_changed)),
            'date_status_changed_h' => date('H:i d.m.Y', strtotime($this->status_changed)),
            'categoryName' => $this->category->getName(),
            'district' => $this->district,
            //'districtName' => $this->district->region->name . ' ' . $this->district->name,
            'regionName' => ($this->district) ? $this->district->region->name : '',
            'address' => $this->getAddress(),
            'selfAddress' => $this->address,
            'serviceFixed' => $this->serviceFixed(),
            'serviceUp' => $this->serviceUp(),
            'serviceMarked' => $this->serviceMarked(),
            'serviceMarkedColor' => $markColor,
            'serviceQuick' => $this->serviceQuick(),
            'servicePremium' => $this->servicePremium(),
            'map' => $map,
            'showPhone' => $showPhone,
            'coordinate_x' => $this->coordinate_x,
            'coordinate_y' => $this->coordinate_y,
            'publicated' => date('d.m.Y', strtotime($this->publicated)),
            'publicated_to' => date('d.m.Y', strtotime($this->publicated_to)),
            'viewCount' => $viewCount,
            'contactView' => $contactView,
            'statusName' => $this->getStatusName(),
            'name' => $this->name,
            'itemServicesList' => $this->itemServicesList(),
            'msgCount' => $msgCount,
            'video' => $this->video,
            'today_view' => $today_view,
            'verified' => $this->verified,
            'blocked_reason' => $this->blocked_reason,
        ];
    }

    /**
     * Elon user uchun favorites qilib belgilanganmi yoki yo'q
     * Shuni aniqlovchi funksiya
     *
     * @return string
     */
    public function checkFavorite(){
        return !$this->favorite->isEmpty() || $this->favoriteSession() ? 'active' : '';
    }

    /** Elonning eski narhi mavjud bo'lsa o'sha narhni pull birligi bilan odam tushunadigan tilga o'tkazish
     * @param string $currencyName
     * @return string|null
     */
    public function getOldPrice($currencyName = ''){
        return $this->old_price ? number_format($this->old_price) . ' ' . $currencyName : null;
    }

    /**
     * Elon telefon raqam bo'sh yoki bo'sh emasligini aniqlash funksiyasi
     *
     * @return bool
     */
    public function notEmptyPhoneNumbers(){
        $phones = $this->getPhones();
        return (is_array($phones) && count($phones) > 0);
    }

    /**
     * E'longa belgilangan narhni qayta formatlab chiqaradi
     *
     * @param string $currencyName
     * @return  mixed
     */
    public function getItemPrice(string $currencyName){
        $price = number_format($this->price, 0, false, ' ');
        if ($this->price_ex === 0 || $this->price_ex == 1) {
            if ($this->category->price_diapazone && $this->price_end > 0) {
                $price .= ' - ' . number_format($this->price_end, 2, false, ' ');
            }
            $price .= ' ' . $currencyName;
        } elseif ($this->price_ex == 2) {
            $price = trans('messages.Exchange');
        } elseif ($this->price_ex == 4) {
            $price = trans('messages.Free');
        } elseif ($this->price_ex == 8) {
            $price = trans('messages.Negotiated');
        }
        return $price;
    }

    /**
     * Magazinga tegishli elonlarni chiqarish
     *
     * @param null $markColor
     * @param int $msgCount
     * @return array
     */
    public function getShopItemsList($markColor = null, $msgCount = 0)
    {
        $currencyName = $this->currency_id ? $this->currency->getName() : null;
        $old_price = $this->getOldPrice($currencyName);
        $map = ((float)$this->coordinate_x > 0 && (float)$this->coordinate_y);
        $showPhone = $this->notEmptyPhoneNumbers();
        $price = $this->category->price ? $this->getItemPrice($currencyName) : null;
        $viewCount = $this->itemViews->sum('item_views');
        $contactView = $this->itemViews->sum('contacts_views');
        $today_view = 0;
        $today = date("Y-m-d");
        $date_status_changed = Carbon::parse($this->status_changed)->format('d.m.Y');
        foreach ($this->itemViews as $view) {
            if ($view->period === $today) {
                $today_view = $view->item_views;
            }
        }
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'shop_id' => $this->shop_id,
            'title' => $this->title,
            'description' => str_replace("\n", '<br>', $this->description),
            'link' => $this->link != null ? $this->link : $this->id, // bu yerni tekshirib turish kerak
            'keyword' => $this->keyword,
            'image' => $this->getImageM(),
            'price' => $price,
            'price_ex' => $this->price_ex == 1, //$this->price_ex,
            'price_ex_title' => $this->category->getModTitle(),
            'oldPrice' => $old_price,
            'favorite' => $this->checkFavorite(),
            'date_cr' => date('d.m.Y', strtotime($this->date_cr)),
            'date_cr_h' => date('H:i d.m.Y', strtotime($this->date_cr)),
            'date_status_changed' => $date_status_changed,
            'date_status_changed_h' => $date_status_changed,
            'categoryName' => $this->category->getName(),
            'district' => $this->district,
            'regionName' => ($this->district) ? $this->district->region->name : '',
            'address' => $this->getAddress(),
            'selfAddress' => $this->address,
            'serviceFixed' => $this->serviceFixed(),
            'serviceUp' => $this->serviceUp(),
            'serviceMarked' => $this->serviceMarked(),
            'serviceMarkedColor' => $markColor,
            'serviceQuick' => $this->serviceQuick(),
            'servicePremium' => $this->servicePremium(),
            'map' => $map,
            'showPhone' => $showPhone,
            'coordinate_x' => $this->coordinate_x,
            'coordinate_y' => $this->coordinate_y,
            'publicated' => Carbon::parse($this->publicated)->format('d.m.Y'),
            'publicated_to' => Carbon::parse($this->publicated_to)->format('d.m.Y'),
            'viewCount' => $viewCount,
            'contactView' => $contactView,
            'statusName' => $this->getStatusName(),
            'name' => $this->name,
            'itemServicesList' => $this->itemServicesList(),
            'msgCount' => $msgCount,
            'video' => $this->video,
            'today_view' => $today_view,
            'verified' => $this->verified,
            'blocked_reason' => $this->blocked_reason,
        ];
    }

    /**
     * Elonlarni filtr qilish
     *
     * @param $post
     * @param $items
     * @return mixed
     */
    public static function filtrPostDatas($post, $items)
    {
        if (isset($post['d'])) {
            foreach ($post['d'] as $key => $value) {
                if (array_key_exists('f', $value)) {
                    if (isset($value['f']) && $value['f'] != null) {
                        $items->where('f' . $key, '>=', $value['f']);
                    }
                    if (isset($value['t']) && $value['t'] != null) {
                        $items->where('f' . $key, '<=', $value['t']);
                    }

                    if (isset($value['r']) && $value['f'] == null && $value['t'] == null) {
                        $dynpropSearch = Additional::getDynpropSearch();
                        if ($dynpropSearch != null) {
                            $from = '';
                            $to = '';
                            if ($value['f'] != null) {
                                $from = $value['f'];
                            }
                            if ($value['t'] != null) {
                                $to = $value['t'];
                            }
                            foreach ($value['r'] as $range) {
                                foreach ($dynpropSearch as $dynprop) {
                                    if ($dynprop['data_field'] == $key) {
                                        $extra = unserialize($dynprop['extra']);
                                        foreach ($extra['search_ranges'] as $search_range) {
                                            if ($search_range['id'] == $range) {
                                                if ($from == '' || $from > $search_range['from']) {
                                                    $from = $search_range['from'];
                                                }
                                                if ($to == '' || $to < $search_range['to']) {
                                                    $to = $search_range['to'];
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            if ($from != '') {
                                $items->where('f' . $key, '>=', $from);
                            }
                            if ($to != '') {
                                $items->where('f' . $key, '<=', $to);
                            }
                        }
                    }
                } else {
                    $items->whereIn('f' . $key, $value);
                }
            }
        }
        if (isset($post['owner_private_search']) && $post['owner_private_search'] == 1) {
            $items->where('owner_type', '!=', 2);
        }
        if (isset($post['only_photo']) && $post['only_photo'] == 1) {
            $items->whereNotIn('img_m', ['', config('app.def_m')]);
        }
        if (isset($post['sorting']) && $post['sorting'] == 'new') {
            $items->orderBy('svc_fixed_to', 'asc') // bu qo'shildi
                ->orderBy('status_changed', 'desc')
                ->orderBy('id', 'desc');
        } elseif (isset($post['sorting']) && $post['sorting'] == 'price_asc') {
            $items->orderBy('svc_fixed_to', 'asc') // bu qo'shildi
                ->orderBy('price_search', 'asc')
                ->orderBy('price_ex', 'asc');
        } elseif (isset($post['sorting']) && $post['sorting'] == 'price_desc') {
            $items->orderBy('svc_fixed_to', 'asc') // bu qo'shildi
                ->orderBy('price_search', 'desc')
                ->orderBy('publicated', 'asc');
        } else {
            $items->orderBy('svc_fixed_to', 'asc')
                ->orderBy('status_changed', 'desc')
                ->orderBy('svc_premium', 'desc');
        }
        $currency_id = isset($post['price_c']) ? $post['price_c'] : null;
        $price_f = isset($post['price_f']) ? $post['price_f'] : null;
        $price_t = isset($post['price_t']) ? $post['price_t'] : null;
        $price_search_f = isset($post['price_search_f']) ? $post['price_search_f'] : null;
        $price_search_t = isset($post['price_search_t']) ? $post['price_search_t'] : null;

        if (isset($post['price_f']) && $post['price_f'] != '') {
            $items->where(
                function ($query) use ($currency_id, $price_f, $price_search_f) {
                    $query->where(
                        function ($q) use ($currency_id, $price_f) {
                            $q->where('currency_id', '=', $currency_id)
                                ->where('price', '>=', $price_f);
                        }
                    )->orWhere(
                        function ($q) use ($currency_id, $price_search_f) {
                            $q->where('currency_id', '<>', $currency_id)
                                ->where('price_search', '>=', $price_search_f);
                        }
                    );
                }
            );
        }

        if (isset($post['price_t']) && $post['price_t'] != '') {
            $items->where(
                function ($query) use ($currency_id, $price_t, $price_search_t) {
                    $query->where(
                        function ($q) use ($currency_id, $price_t) {
                            $q->where('currency_id', $currency_id)
                                ->where('price', '<=', $price_t);
                        }
                    )->orWhere(
                        function ($q) use ($currency_id, $price_search_t) {
                            $q->where('currency_id', '!=', $currency_id)
                                ->where('price_search', '<=', $price_search_t);
                        }
                    );
                }
            );
        }
        return $items;
    }

    /**
     * Qidiruvdagi elonlarni filtrlash
     *
     * @param $post
     * @param $items
     * @return mixed
     */
    public static function filtrPostDatasForSearch($post, &$items)
    {
        $currency_id = $post['price_c'];
        $price_f = $post['price_f'];
        $price_t = $post['price_t'];
        $price_search_f = $post['price_search_f'];
        $price_search_t = $post['price_search_t'];

        if ($post['only_photo'] == 1) {
            $items->whereNotIn('img_m', ['', config('app.def_m')]);
        }

        if ($post['price_f'] != '') {
            $items->where(
                function ($query) use ($currency_id, $price_f, $price_search_f) {
                    $query->where(
                        function ($q) use ($currency_id, $price_f) {
                            $q->where('currency_id', '=', $currency_id)
                                ->where('price', '>=', $price_f);
                        }
                    )->orWhere(
                        function ($q) use ($currency_id, $price_search_f) {
                            $q->where('currency_id', '<>', $currency_id)
                                ->where('price_search', '>=', $price_search_f);
                        }
                    );
                }
            );
        }

        if ($post['price_t'] != '') {
            $items->where(
                function ($query) use ($currency_id, $price_t, $price_search_t) {
                    $query->where(
                        function ($q) use ($currency_id, $price_t) {
                            $q->where('currency_id', $currency_id)
                                ->where('price', '<=', $price_t);
                        }
                    )->orWhere(
                        function ($q) use ($currency_id, $price_search_t) {
                            $q->where('currency_id', '!=', $currency_id)
                                ->where('price_search', '<=', $price_search_t);
                        }
                    );
                }
            );
        }
    }

    /**
     * Elonlar ro'yxatini html ko'rinishda qaytarish
     *
     * @param $itemsList
     * @return string
     */
    public static function getHtmlItemList($itemsList)
    {
        $result = '';
        foreach ($itemsList as $item) {
            $servicePremium = null;
            $serviceQuick = null;
            $serviceFixed = null;
            if ($item['servicePremium']) {
                $servicePremium = '<div class="premium"><img src="/images/premium.png" alt="Image">' . trans(
                        'messages.Premium'
                    ) . '</div>';
            }
            if ($item['serviceQuick']) {
                $serviceQuick = '<div class="premium ups_pre"><img src="/images/premium.png" alt="premium">' . trans(
                        'messages.Quick'
                    ) . '</div>';
            }
            if ($item['serviceFixed']) {
                $serviceFixed = '<div class="fastening"><img src="/images/fastening.png" alt="Image">' .
                    trans(
                        'messages.Fix'
                    ) . '</div>';
            }
            if (Auth::check()) {
                $star = '<div class="favoruites_product ' . ($item['favorite'] ? 'active' : '') . '" data-url="' .
                    route(
                        'item-set-favorite',
                        ['id' => $item['id'], 'type' => 1]
                    ) . '" onclick="itemFavorite(this)"></div>';
            } else {
                $star = '<div class="favoruites_product ' . ($item['favorite'] ? 'active' : '') . '" data-url="' . route(
                        'item-set-favorite-noauth',
                        ['id' => $item['id'], 'type' => 1]
                    ) . '" onclick="itemFavorite(this)"></div>';
            }

            $result .= '<div class="col-lg-6"><div class="product_horizontal"><a href="' . route(
                    'view-item',
                    $item['link']
                ) . '" class="product_item"><img src="' . $item['image'] . '" alt="' . $item['title'] . '"><div class="product_text"><div class="elt_title"><span>' . $item['categoryName'] . '</span><div class="elt_date">' . $item['date_cr'] . '</div></div><h4>' . $item['title'] . '</h4><div class="price_product"><b>' . $item['price'] . '</b><i>' . $item['oldPrice'] . '</i></div><div class="address_product">' . $item['address'] . '</div></div></a>' . $star . $servicePremium . $serviceFixed . $serviceQuick . '</div></div>';
        }
        return $result;
    }

    /**
     * Elonlar ro'yxatini html fayl ko'rinishida qaytarish
     * Map (xarita) turidagi saxiga uchun
     *
     * @param $itemsList
     * @return string
     */
    public static function getHtmlItemMap($itemsList)
    {
        $result = '';
        foreach ($itemsList as $item) {
            $servicePremium = null;
            $serviceQuick = null;
            $serviceFixed = null;
            if ($item['servicePremium']) {
                $servicePremium = '<div class="premium"><img src="/images/premium.png" alt="Image">' . trans(
                        'messages.Premium'
                    ) . '</div>';
            }
            if ($item['serviceQuick']) {
                $serviceQuick = '<div class="premium ups_pre"><img src="/images/premium.png" alt="premium">' . trans(
                        'messages.Quick'
                    ) . '</div>';
            }
            if ($item['serviceFixed']) {
                $serviceFixed = '<div class="fastening"><img src="/images/fastening.png" alt="Image">' . trans(
                        'messages.Fix'
                    ) . '</div>';
            }
            if (Auth::check()) {
                $star = '<div class="favoruites_product ' . ($item['favorite'] ? 'active' : '') . '" data-url="' . route(
                        'item-set-favorite',
                        ['id' => $item['id'], 'type' => 1]
                    ) . '" onclick="itemFavorite(this)"></div>';
            } else {
                $star = '<div class="favoruites_product ' . ($item['favorite'] ? 'active' : '') . '" data-url="' . route(
                        'item-set-favorite-noauth',
                        ['id' => $item['id'], 'type' => 1]
                    ) . '" onclick="itemFavorite(this)"></div>';
            }

            $result .= '<div class="product_horizontal"><a href="' . route(
                    'view-item',
                    $item['link']
                ) . '" class="product_item"><img src="' . $item['image'] . '" alt="' . $item['title'] . '"><div class="product_text"><div class="elt_title"><span>' . $item['categoryName'] . '</span><div class="elt_date">' . $item['date_cr'] . '</div></div><h4>' . $item['title'] . '</h4><div class="price_product"><b>' . $item['price'] . '</b><i>' . $item['oldPrice'] . '</i></div><div class="address_product">' . $item['address'] . '</div></div></a>' . $star . $servicePremium . $serviceFixed . $serviceQuick . '<input type="hidden" name="coordinateX[]" value="' . $item['coordinate_x'] . '"><input type="hidden" name="coordinateY[]" value="' . $item['coordinate_y'] . '"><input type="hidden" name="itemTitles[]" value="' . $item['title'] . '"><input type="hidden" name="itemDates[]" value="' . $item['date_cr'] . '"><input type="hidden" name="itemCategories[]" value="' . $item['categoryName'] . '"><input type="hidden" name="itemPrices[]" value="' . $item['price'] . '"><input type="hidden" name="itemImages[]" value="' . $item['image'] . '"><input type="hidden" name="itemUrls[]" value="' . route(
                    'view-item',
                    $item['link']
                ) . '"></div>';
        }
        return $result;
    }

    /**
     * Yangi elonlar uchun html fayl tayorlash
     *
     * @param $itemsList
     * @return string
     */
    public static function getHtmlNewItemList($itemsList)
    {
        $result = '';
        foreach ($itemsList as $item) {
            $servicePremium = null;
            $serviceQuick = null;
            $serviceFixed = null;
            if ($item['servicePremium']) {
                $servicePremium = '<div class="premium"><img src="/images/premium.png" alt="Image">' . trans(
                        'messages.Premium'
                    ) . '</div>';
            }
            if ($item['serviceQuick']) {
                $serviceQuick = '<div class="premium ups_pre"><img src="/images/premium.png" alt="premium">' . trans(
                        'messages.Quick'
                    ) . '</div>';
            }
            if ($item['serviceFixed']) {
                $serviceFixed = '<div class="fastening"><img src="/images/fastening.png" alt="Image">' . trans(
                        'messages.Fix'
                    ) . '</div>';
            }
            if (Auth::check()) {
                $star = '<div class="favoruites_product ' . ($item['favorite'] ? 'active' : '') . '" data-url="' . route(
                        'item-set-favorite',
                        ['id' => $item['id'], 'type' => 1]
                    ) . '" onclick="itemFavorite(this)"></div>';
            } else {
                $star = '<div class="favoruites_product ' . ($item['favorite'] ? 'active' : '') . '" data-url="' . route(
                        'item-set-favorite-noauth',
                        ['id' => $item['id'], 'type' => 1]
                    ) . '" onclick="itemFavorite(this)"></div>';
            }

            $result .=
                '<div class="product_mains col-md-3 col-sm-4 col-6">
                    <a href="' . route('view-item', $item['link']) . '" class="product_item">
                        <img src="' . $item['image'] . '" alt="Image">
                        <div class="product_text">
                            <span>' . $item['categoryName'] . '</span>
                            <h4>' . $item['title'] . '</h4>
                            <div class="price_product">
                                <b>' . $item['price'] . '</b>
                                <i>' . $item['oldPrice'] . '</i>
                            </div>
                            <p class="negotiat"></p>
                            <div class="address_product">' . $item['address'] . '</div>
                        </div>
                    </a>
                    ' . $star . $servicePremium . $serviceFixed . $serviceQuick . '
				</div>';
        }
        return $result;
    }

    /**
     * M turidagi, e'lon rasmlarini qaytarish
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function getImageM()
    {
        $size_folder = '221x240';
        if ($this->img_m == null || $this->img_m == '') {
            return config('app.noImage');
        } else {
            if ($this->img_m == 'def-m.png') {
                return config('app.uploadPath') . 'noimg.jpg';
            } else {

                 //return 'https://img.bisyor.uz/files/220x240/'.$this->img_m;
                //$image = $this->getImageO();
                $image = $this->img_m;

                //return 'https://img.bisyor.uz/files/220x240/'.$image;

                if(!$image) {
                    return config('app.uploadPath') . 'noimg.jpg';
                }
                try{
                    $fileName = md5($image).'.jpg';
                    $path = storage_path().'/app/public/'.$size_folder;
                    if (file_exists($path.'/'.$fileName)) {
                        return  env('SITE_LINK'). '/storage/'.$size_folder.'/'.$fileName;
                    }

                    File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
                    $img = Image::make(config('app.itemsPath') . $image);
                    $img->resize(null, 240, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $img->save($path."/".$fileName, 95);
                    return  env('SITE_LINK'). '/storage/'.$size_folder.'/'.$fileName;
                }catch(\Exception $e){
                    return config('app.uploadPath') . 'noimg.jpg';
                }

            }
        }
    }
    
    
    public function compressImg($source, $destination, $quality)
    {
        $info = getimagesize($source);
    
        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);
    
        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);
    
        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);
    
        elseif ($info['mime'] == 'image/webp')
            $image = imagecreatefromwebp($source);
        imagejpeg($image, $destination, $quality);
        return $destination;
    }

    //   public function getImageM()
    // {
    //     if ($this->img_m == null || $this->img_m == '') {
    //         return config('app.noImage');
    //     } else {
    //         if ($this->img_m == 'def-m.png') {
    //             return config('app.uploadPath') . 'noimg.jpg';
    //         } else {
    //             return config('app.itemsPath') . $this->img_m;
    //         }
    //     }
    // }



    public function getImageO(){
        preg_match("/[1-9]{1}m+/", $this->img_m, $array);
        if(isset($array[0]) && strlen($array[0] == 2)){
            $number = $array[0][0];
            return str_replace($number.'m', $number.'o',$this->img_m);
        }
        return $this->img_m;
    }



    /**
     * Z turidagi, e'lon rasmlarini qaytarish
     *
     * @return string
     */
    public function getImageZ()
    {
        $image = $this->itemImages->first();
        if ($image == null) {
            return config('app.uploadPath') . 'noimg.jpg';
        } else {
            return config('app.itemsPath') . $image->extstor_img_z;
        }
    }

    /**
     * To'lov turi
     *
     * @return string
     */
    public function getPriceEx()
    {
        if ($this->price_ex == 8) {
            return 'Договорная';
        }
        if ($this->price_ex == 4) {
            return 'Бесплатно';
        }
        if ($this->price_ex == 2) {
            return 'Обмен';
        }
        if ($this->price_ex == 1) {
            return 'Торг возможен';
        }
        if ($this->price_ex == 0) {
            return 'Цена';
        }
    }

    /**
     * Elon qaysi xolatddagilini aniqlash
     *
     * @return string
     */
    public function getStatusName()
    {
        if ($this->is_publicated == 1 && $this->is_moderating == 0 && $this->status == 3) {
            return 'publicated';
        }
        if ($this->is_publicated == 0 && $this->is_moderating == 1 && $this->status == 3) {
            return 'moderation';
        }
        if ($this->status == 4) {
            return 'remove-public';
        }
        if ($this->status == 1) {
            return 'no-active';
        }
        if ($this->status == 5) {
            return 'blocked';
        }
        if ($this->status == 6) {
            return 'deleted';
        }
    }

    /**
     * E'longa biriktirilgan manzilni qaytarish
     *
     * @return string|null
     */
    public function getAddress()
    {
        if ($this->address != null) {
            return $this->address;
        } else {
            if ($this->district != null) {
                return $this->district->region->getName() . ', ' . $this->district->getName() . ' ' . $this->address;
            } else {
                return null;
            }
        }
    }

    // keraksiz funksiya uni olib tawlash kerak va hech qayerda ishlatilmasin
    // Kop joylarda ishlatilgan ekan endi kech :(((
    //Статус услуги  Поднятие
    public function serviceUp()
    {
        return false;
    }

    /**
     * Servis xolati (Biriktirilgan)
     *
     * @return bool
     */
    public function serviceFixed()
    {
        if ($this->svc_fixed && time() < strtotime($this->svc_fixed_to)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Servis xolati (Premimum elon)
     *
     * @return bool
     */
    public function servicePremium()
    {
        if ($this->svc_premium && time() < strtotime($this->svc_premium_to)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Servis statusi (Belgilangan)
     *
     * @return bool
     */
    public function serviceMarked()
    {
        if (time() < strtotime($this->svc_marked_to)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Servis xolati (Nashr etilish)
     *
     * @return bool
     */
    public function servicePress()
    {
        if ($this->svc_press_status && time() < strtotime($this->svc_press_date)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Servis xolati (Zudlik bilan - Срочно)
     *
     * @return bool
     */
    public function serviceQuick()
    {
        if (time() < strtotime($this->svc_quick_to)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * ELon hizmatlari ro'yxati
     *
     * @return array
     */
    public function itemServicesList()
    {
        $result = [];

        if ($this->serviceFixed()) {
            $result [] = [
                'img' => config('app.fixImage'),
                'name' => trans('messages.Fix'),
                'date' => date('d.m.Y', strtotime($this->svc_fixed_to)),
            ];
        }

        if ($this->serviceUp()) {
            $result [] = [
                'img' => config('app.upImage'),
                'name' => trans('messages.Up'),
                'date' => date('d.m.Y', strtotime('0000-00-00')),
            ];
        }

        if ($this->serviceMarked()) {
            $result [] = [
                'img' => config('app.markImage'),
                'name' => trans('messages.Mark'),
                'date' => date('d.m.Y', strtotime($this->svc_marked_to)),
            ];
        }

        if ($this->serviceQuick()) {
            $result [] = [
                'img' => config('app.quickImage'),
                'name' => trans('messages.Quick'),
                'date' => date('d.m.Y', strtotime($this->svc_quick_to)),
            ];
        }

        if ($this->servicePremium()) {
            $result [] = [
                'img' => config('app.premiumImage'),
                'name' => trans('messages.Premium'),
                'date' => date('d.m.Y', strtotime($this->svc_premium_to)),
            ];
        }
        return $result;
    }

    /**
     * Sessiadagi sevimlilarni qaytarish
     *
     * @return bool
     */
    public function favoriteSession()
    {
        if (Auth::check()) {
            return false;
        }

        $array = Session::get('noAuthUserFavorites');
        if ($array != null && in_array($this->id, $array)) {
            if (($key = array_search($this->id, $array)) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Sevimlilarni ko'rish
     *
     * @return HasMany
     */
    public function favoriteView()
    {
        $user_id = null;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }
        return $this->hasMany('App\Models\Items\Favorites', 'item_id', 'id')
            ->where(['user_id' => $user_id, 'type' => Favorites::TYPE_VIEW]);
    }

    /**
     * Sevimlilar
     *
     * @return HasMany
     */
    public function favorite()
    {
        $user_id = null;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }
        return $this->hasMany('App\Models\Items\Favorites', 'item_id', 'id')
            ->where(['user_id' => $user_id, 'type' => Favorites::TYPE_FAVORITE]);
    }

    /**
     * For return relation favorites in items
     *
     * @return HasMany
     */
    public function getItemFavorites()
    {
        return $this->hasMany('App\Models\Items\Favorites', 'item_id', 'id')
            ->select(['item_id'])
            ->where(['type' => Favorites::TYPE_FAVORITE]);
    }

    /**
     * Elon chatidagi xabarlar soni
     *
     * @return int
     */
    public function chatMsgCount()
    {
        $count = 0;
        foreach ($this->itemMsgCount as $value) {
            $count += count($value->chatMessagesCount);
        }
        return $count;
    }

    /**
     * Elon chatidagi xabarlar soni
     *
     * @return HasMany
     */
    public function itemMsgCount()
    {
        return $this->hasMany('App\Models\Chats\Chats', 'field_id', 'id')
            ->where(['type' => 6])->with(['chatMessagesCount']);
    }

    /**
     * ELonnig view  qismi
     *
     * @return HasMany
     */
    public function itemViews()
    {
        return $this->hasMany('App\Models\Items\ItemsViews', 'item_id', 'id');
    }

    /**
     * Elonga biriktirilgan eslatmalarni chiqarish
     *
     * @return mixed
     */
    public function itemNote()
    {
        return $this->hasOne('App\Models\Items\ItemNotes', 'item_id', 'id');
    }

    /**
     * Elonlarni rasmini ko'rish
     *
     * @return HasMany
     */
    public function itemImages()
    {
        return $this->hasMany('App\Models\Items\ItemsImages', 'item_id', 'id')
            ->orderBy('id', 'asc');
    }

    /**
     * Mintaqalar bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo('App\Models\References\Districts', 'district_id', 'id')
            ->with(['region', 'translate']);
    }

    /**
     * Foydalanuvchilar bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Do'konlar bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo('App\Models\Shops\Shops', 'shop_id', 'id');
    }

    /**
     * Pull birligi bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo('App\Models\References\Currencies', 'currency_id', 'id')
            ->with(['translate']);
    }

    /**
     * Bo'limlar bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Items\Categories', 'cat_id', 'id')
            ->with(['translates']);
    }

    public function videos(){
        return $this->hasMany('App\Models\Items\VideoGallery', 'item_id', 'id');
    }

    public function video(){
        return $this->hasOne('App\Models\Items\VideoGallery', 'item_id', 'id');
    }

    /**
     * Dynprop bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoryWithDynprop()
    {
        return $this->belongsTo('App\Models\Items\Categories', 'cat_id', 'id')
            ->with(['categoriesDynprops']);
    }


    /**
     * Elonning yillik narhlar statistikasini ko'rsatuvchi funksiya
     *
     * @param $category_id
     * @return arraypublic static function itemPriceStatisticsInYear(int $category_id): array
    {
    return self::select(
    DB::raw('min(price_search) as min_price, max(price_search) as max_price'), DB::raw("date_trunc('month', publicated) as group_date"))
    ->where('cat_id', $category_id)
    ->where(['is_publicated' => 1, 'status' => self::STATUS_PUBLICATION])
    ->whereBetween('publicated', [date('Y-m-d H:i:s', strtotime('-1 year')), date('Y-m-d H:i:s')])
    ->groupBy('group_date')
    ->get()->toArray();
    }
     */


    /**
     * Saqlashdan oldin kerakli sozlashlash qilinadi
     *
     * @param $request
     */
    public function beforeSave($request)
    {
        $user = Auth::user();
        //$this->moderated_id = $user->id;
        $this->date_cr = date('Y-m-d H:i:s');
        $this->date_up = date('Y-m-d H:i:s');
        $this->status_changed = date('Y-m-d H:i:s');
        $this->publicated = date('Y-m-d H:i:s');
        $this->publicated_order = date('Y-m-d H:i:s');
        // statuslarini belgilash
        $statuses = self::STATUS_TYPE[self::NEW_STATUS_MODERATING]['statuses'];
        $this->status_prev = self::NEW_STATUS_INACTIVE;
        $this->status = $statuses['status'];
        $this->is_moderating = $statuses['is_moderating'];
        $this->is_publicated = $statuses['is_publicated'];

        if (config('settings.general_announcement_period') == 1) {
            $this->publicated_period = 30 * $request->post('pub_date');
            $this->publicated_to = date("Y-m-d H:i:s", strtotime("+" . $request->post('pub_date') . " month"));
        } else {
            $this->publicated_period = config('settings.the_term_of_publication_of_the_announcement');
            $this->publicated_to = date(
                "Y-m-d H:i:s",
                strtotime(
                    "+" . config(
                        'settings.the_term_of_publication_of_the_announcement'
                    ) . " days"
                )
            );
        }

        if ($this->item_owner_type == 1) {
            $this->shop_id = null;
        }
    }

    /**
     * Modelni update qilishdan oldin update sanalarini o'zgartirish
     *
     * @param $request
     */
    public function beforeUpdate($request)
    {
        $user = Auth::user();
        $this->date_up = date('Y-m-d H:i:s');
        // statuslarini belgilash
        $statuses = self::STATUS_TYPE[self::NEW_STATUS_MODERATING]['statuses'];
        $this->status_prev = self::NEW_STATUS_INACTIVE;
        $this->status = $statuses['status'];
        $this->is_moderating = $statuses['is_moderating'];
        $this->is_publicated = $statuses['is_publicated'];
        if (config('settings.general_announcement_period') == 1) {
            $this->publicated_period = 30 * $request->post('pub_date');
            $this->publicated_to = date(
                "Y-m-d H:i:s",
                strtotime(
                    "+" . $request->post('pub_date') . " month"
                )
            );
        } else {
            $this->publicated_period = config('settings.the_term_of_publication_of_the_announcement');
            $this->publicated_to = date(
                "Y-m-d H:i:s",
                strtotime(
                    "+" . config(
                        'settings.the_term_of_publication_of_the_announcement'
                    ) . " days"
                )
            );
        }
    }

    /**
     * Formadan kelgan telefon raqamni kerakli ko'rinishga keltirib serializatsiya qilish
     *
     * @param $request
     */
    public function phonesSerialize($request)
    {
        $phones_array = $request->post('phones');
        $arr = [];
        if ($phones_array && is_array($phones_array)) {
            foreach ($phones_array as $value) {
                if ($value != '') {
                    $arr[] = ['v' => $value];
                }
            }
        }
        $this->phones = serialize($arr);
    }

    /**
     * Rasmni boshqa serverga yuborish
     *
     * @param $data
     * @return mixed
     */
    public static function sendStorageFile($data)
    {
        // curl connection
        $ch = curl_init();
        // set curl url connection
        $curl_url = config('app.imgSiteNameSelf') . '/api/image-change';
        // pass curl url
        curl_setopt($ch, CURLOPT_URL, $curl_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        // image upload Post Fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // set CURL ETURN TRANSFER type
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_result = curl_exec($ch);
        curl_close($ch);
        return json_decode($server_result);
        exit;
    }

    /**
     * Rasmni saqlab olish
     *
     * @param $result
     * @param $time
     * @return int
     */
    public function saveImage($result, $time)
    {
        $i = 0;
        $user_id = $this->user_id;
        foreach ($result as $value) {
            if ($value != null && is_numeric($value)) {
                $model = new ItemsImages();
                $model->item_id = $this->id;
                $model->user_id = $user_id;
                $model->extstor_img_o = $this->keyword . '-' . $this->id . '-' . ($value) . 'o-' . $time . '.jpg';
                $model->extstor_img_z = $this->keyword . '-' . $this->id . '-' . ($value) . 'z-' . $time . '.jpg';
                $model->extstor_img_v = $this->keyword . '-' . $this->id . '-' . ($value) . 'v-' . $time . '.jpg';
                $model->extstor_img_m = $this->keyword . '-' . $this->id . '-' . ($value) . 'm-' . $time . '.jpg';
                $model->extstor_img_s = $this->keyword . '-' . $this->id . '-' . ($value) . 's-' . $time . '.jpg';
                $model->num = $value;
                $model->created = date('Y-m-d H:i');
                $model->save();
                $i++;
                if ($i == 1) {
                    $this->img_s = $model->extstor_img_s;
                    $this->img_m = $model->extstor_img_m;
                }
            }
        }

        return $i;
    }

    /**
     * Rasmni saqlab olish
     *
     * @param $uploaded_files
     */
    public function uploadImage($uploaded_files)
    {
        $j = ItemsImages::where(['item_id' => $this->id])->count();
        $i = 0;
        if ($j == 0 || $j == null) {
            $j = 1;
        } else {
            $j++;
        }
        $result = null;
        $time = time();

        if ($uploaded_files != "") {
            $result = self::sendStorageFile(
                [
                    'image_name' => $uploaded_files,
                    'title' => $this->keyword,
                    'id' => $this->id,
                    'key' => $j,
                    'time' => $time,
                ]
            );
            if ($result != null) $i = $this->saveImage($result, $time);
        }
        if ($i == 0) {
            $this->img_s = config('app.def_s');
            $this->img_m = config('app.def_m');
        }
    }

    /**
     * User elonni qo'shgandan keyin trashdagi rasmlarni items papkaga tashlab uni bazaga yozadi
     *
     * @param $request
     */

    public function updateImage($request)
    {
        $uploaded_files = $request->post('photos');
        if ($uploaded_files != "") {
            $images = explode(",", $uploaded_files);
            $photos = ItemsImages::where(['item_id' => $this->id])->get()->toArray();
            if ($photos) {
                $images = $this->deleteImages($images, $photos);
            }
            if ($images) {
                $this->uploadImage(implode(',', $images));
            }
        } else {
            $photos = ItemsImages::where(['item_id' => $this->id])->get()->toArray();
            if ($photos) {
                $images = $this->deleteImages([], $photos);
            }
            $this->img_s = config('app.def_s');
            $this->img_m = config('app.def_m');
        }
    }

    /**
     * Rasmlarni o'chirish
     *
     * @param $images
     * @param $photos
     * @return array|mixed
     */
    public function deleteImages($images, $photos)
    {
        $uploadPath = config('app.itemsRoute');
        foreach ($photos as $key => $value) {
            if (!in_array($value['extstor_img_o'], $images) || empty($images)) {
                $delete = ItemsImages::find($value['id']);
                Storage::disk('ftp')->delete($uploadPath . $delete->extstor_img_o);
                Storage::disk('ftp')->delete($uploadPath . $delete->extstor_img_z);
                Storage::disk('ftp')->delete($uploadPath . $delete->extstor_img_v);
                Storage::disk('ftp')->delete($uploadPath . $delete->extstor_img_m);
                Storage::disk('ftp')->delete($uploadPath . $delete->extstor_img_s);
                $delete->delete();
            } else {
                $images = array_diff($images, [$value['extstor_img_o']]);
            }
        }
        return $images;
    }

    /**
     * Elon agar opublikovat qilinmagan bo'lsa uni shu user elon qilganmi yo'qmi
     * shuni tekshiradi
     *
     * @return bool
     */
    public function checkUser()
    {
        $user = Auth::user();
        if ($this->is_publicated == self::STATUS_TYPE[self::NEW_STATUS_PUBLICATIOM]['statuses']['is_publicated'] &&
            $this->is_moderating == self::STATUS_TYPE[self::NEW_STATUS_PUBLICATIOM]['statuses']['is_moderating'] &&
            $this->status == self::STATUS_TYPE[self::NEW_STATUS_PUBLICATIOM]['statuses']['status']) {
            return true;
        } else {
            if ($user) {
                if ($this->user_id == $user->id) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    /**
     * Elondagi xatolik  xabarlari
     *
     * @return string
     */
    public function itemErrosMsgText()
    {
        $user = Auth::user();
        if ($this->is_publicated == 0 && $this->is_moderating == 1 && $this->status == 3) {
            return 'moderating';
        }
        if ($user) {
            if ($this->user_id == $user->id) {
                return 'active';
            } else {
                return 'blocked';
            }
        } else {
            return 'blocked';
        }
    }

    /**
     * Saytda global region uchun search bo'lganda
     *
     * @param $data
     * @return array
     */
    public static function searchResult($data, $for_favorites = false)
    {
        if ($data != null && count($data) == 0) {
            if ($for_favorites) return [];
            return Items::getNewItems($page = 1);
            /*$result = [];
            $color = Additional::serviceMarkedColor();

            foreach ($data as $item) {
                $result [] = $item->getItem($color);
            }
            return $result;*/
        } else {
            $result = [];
            $color = Additional::serviceMarkedColor();

            foreach ($data as $item) {
                $result [] = $item->getItem($color);
            }
            return $result;
        }
    }

    /**
     * Returned  phones format array
     *
     * @return mixed
     */
    public function getPhones()
    {
        return unserialize($this->phones);
    }

    /**
     * Activ tabni olish
     *
     * @return array|string|null
     */
    public static function getActiveTab()
    {
        return Cookie::get('item_active_tab');
    }

    /**
     * Active tabni belgilash
     *
     * @param string $tab
     */
    public static function setActiveTab(string $tab)
    {
        Cookie::queue('item_active_tab', $tab, 3600 * 24 * 30);
    }

    public static function itemPriceStatisticsInYear(int $category_id): array
    {
        return self::select(
            DB::raw('min(price_search) as min_price, max(price_search) as max_price'), DB::raw("date_trunc('month', publicated) as group_date"))
            ->where('cat_id', $category_id)
            ->whereNotNull('price_search')
            ->where(['is_publicated' => 1, 'status' => self::STATUS_PUBLICATION])
            ->whereBetween('publicated', [date('Y-m-d H:i:s', strtotime('-1 year')), date('Y-m-d H:i:s')])
            ->groupBy('group_date')
            ->get()->toArray();
    }
}
