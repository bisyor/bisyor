<?php

namespace App\Models\References;

use Illuminate\Support\Facades\App;
use App\Models\Items\Categories;
use Illuminate\Support\Facades\Cache;
use App\Models\Items\Items;
use App\Models\Shops\Shops;
use App\Models\Shops\ShopCategories;
use App\Models\Blogs\BlogPosts;
use App\Models\Items\Services;


class Caching
{
    /**
     * Keshda qancha vaqt turishini bazadan o'qib olish
     *
     * @param string $key_local
     * @return int|mixed
     */
    public static function getCacheTime(string $key_local)
    {
        $defaultMinutes = 10;
        list($key) = explode('-', $key_local);

        if (Cache::has($key . '_minutes')) {
            return Cache::get($key . '_minutes');
        }

        $cache_data = CacheClear::where('key', $key)->first();
        if ($cache_data) {
            if ($cache_data->minutes > 0) {
                $defaultMinutes = $cache_data->minutes;
            }
            Cache::put($key . '_minutes', $defaultMinutes, 86400);
        }

        return $defaultMinutes;
    }

    /**
     * Servislarni keshdan olish
     *
     * @return array|mixed
     */
    public static function getServicesCache()
    {
        $cacheKey = Caching::getServicesCacheKey();
        if (Cache::has($cacheKey)) {
            $services = Cache::get($cacheKey);
        } else {
            $services = Services::servicesList();
            Cache::put($cacheKey, $services, self::getCacheTime($cacheKey) * 60);
        }

        return $services;
    }

    /**
     * Pull birlliklarini keshdan olish
     *
     * @return array
     */
    public static function getCurrencyCache()
    {
        $data = Cache::get(
            'currencies',
            function () {
                return Currencies::where(['enabled' => 1])->get();
            }
        );

        $arr = [];
        foreach ($data as $value) {
            $arr[$value->id] = $value->name;
        }

        return $arr;
    }

    /**
     * Mintaqalarni keshdan o'qib olish
     *
     * @return array|mixed
     */
    public static function getCountersCache()
    {
        $cacheKey = Caching::getCountersCacheKey();
        if (Cache::has($cacheKey)) {
            $counters = Cache::get($cacheKey);
        } else {
            $counters = Counters::getCounters();
            Cache::put($cacheKey, $counters, self::getCacheTime($cacheKey) * 60);
        }

        return $counters;
    }

    /**
     * Birliklar ro'yxatini keshdan olib berish
     *
     * @return array|mixed
     */
    public static function getCurrencyListCache()
    {
        $cacheKey = Caching::getCurrencyListCacheKey();
        if (Cache::has($cacheKey)) {
            $curList = Cache::get($cacheKey);
        } else {
            $curList = Currencies::getList();
            Cache::put($cacheKey, $curList, self::getCacheTime($cacheKey) * 60);
        }

        return $curList;
    }

    /**
     * Topdagi do'konlar ro'yxatini keshdan o'qib olish
     *
     * @return mixed
     */
    public static function getTopShopsListCache()
    {
        $cacheKey = Caching::getTopShopsCacheKey();
        if (Cache::has($cacheKey)) {
            $topShops = Cache::get($cacheKey);
        } else {
            $topShops = Shops::getTopShopsList();
            Cache::put($cacheKey, $topShops, self::getCacheTime($cacheKey) * 60);
        }

        return $topShops;
    }

    /**
     * Sozlamalar qiymatini kalit so'zlar bo'yicha keshdan o'qib olish
     *
     * @param $key
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public static function getSettingValueByKey($key)
    {
        return Settings::getValueByKey($key);
    }

    /**
     * Tillar ro'yxatini keshdan o'qib olish
     *
     * @return mixed
     */
    public static function getLangs()
    {
        $cacheKey = Caching::getLangsCacheKey();
        if (Cache::has($cacheKey)) {
            $langs = Cache::get($cacheKey);
        } else {
            $langs = Lang::where(['status' => 1])->get();
            Cache::put($cacheKey, $langs, self::getCacheTime($cacheKey) * 60);
        }

        return $langs;
    }

    /**
     * Yangi bloglarni keshdan o'qib olish
     *
     * @param $type
     * @return array|mixed
     */
    public static function newBlogs($type)
    {
        $cacheKey = Caching::getNewBlogsCacheKey();
        $newBlogs = BlogPosts::getNewBlogs($type);
        Cache::put($cacheKey, $newBlogs, self::getCacheTime($cacheKey) * 60);

        /*if (Cache::has($cacheKey)) {
            $newBlogs = Cache::get($cacheKey);
        } else {
            $newBlogs = BlogPosts::getNewBlogs($type);
            Cache::put($cacheKey, $newBlogs, self::getCacheTime($cacheKey) * 60);
        }*/

        return $newBlogs;
    }

    /**
     * Topdagi maqolalarni keshdan o'qib olish
     *
     * @param $type
     * @return mixed|null
     */
    public static function topPost($type)
    {
        $topPost = BlogPosts::getTopPost($type);
       /* $cacheKey = Caching::getTopPostCacheKey();
        if (Cache::has($cacheKey)) {
            $topPost = Cache::get($cacheKey);
        } else {
            $topPost = BlogPosts::getTopPost($type);
            Cache::put($cacheKey, $topPost, self::getCacheTime($cacheKey) * 60);
        }*/

        return $topPost;
    }

    /**
     * Ijtimoiy tarmoqlar ro'yxatini olish
     *
     * @return mixed
     */
    public static function getSocialList()
    {
        $cacheKey = self::getSocialListCacheKey();
        if (Cache::has($cacheKey)) {
            $socialList = Cache::get($cacheKey);
        } else {
            $socialList = SocialNetworks::where(['status' => 1])->get();
            Cache::put($cacheKey, $socialList, self::getCacheTime($cacheKey) * 60);
        }

        return $socialList;
    }

    /**
     * Bo'limlar uchun qurilgan avlod va ajdod ketma ketligini keshdan o'qib olish va keshlaash
     *
     * @param $currentCategory
     * @return mixed|null
     */
    public static function categoryBuildTreeParentDynprop($currentCategory)
    {
        $cacheKey = self::getCategoryBuildTreeParentDynpropCacheKey($currentCategory);
        if (Cache::has($cacheKey)) {
            $catDynpropSearch = Cache::get($cacheKey);
        } else {
            $catDynpropSearch = Categories::buildTreeParentDynprop($currentCategory);
            Cache::put($cacheKey, $catDynpropSearch, self::getCacheTime($cacheKey) * 60);
        }

        return $catDynpropSearch;
    }

    /**
     * Topda turgan bo'limlarda qancha elon bor ekanligini keshdan qaytaradi
     *
     * @param $currentCategory
     * @return array|mixed
     */
    public static function getTopCatItemCountCache($currentCategory)
    {
        $cacheKey = self::getTopCatItemCountCacheKey($currentCategory);
        if (Cache::has($cacheKey)) {
            $topCategories = Cache::get($cacheKey);
        } else {
            $topCategories = Categories::getTopCatItemCount($currentCategory);
            Cache::put($cacheKey, $topCategories, self::getCacheTime($cacheKey) * 60);
        }

        return $topCategories;
    }

    /**
     * Regionlardagi elonlarni keshdan o'qib olish
     *
     * @param $currentCategory
     * @return array|mixed
     */
    public static function itemInRegionCache($currentCategory)
    {
        $cacheKey = self::getItemInRegionCacheKey($currentCategory);
        if (Cache::has($cacheKey)) {
            $itemInRegion = Cache::get($cacheKey);
        } else {
            $itemInRegion = Categories::getItemInRegionCount($currentCategory);
            Cache::put($cacheKey, $itemInRegion, self::getCacheTime($cacheKey) * 60);
        }
        return $itemInRegion;
    }

    /**
     * Mavjud bo'limlarni keshdan o'qib olish
     *
     * @param $_request
     * @return mixed
     */
    public static function currentCategoryCache($_request)
    {
        $cacheKey = self::getCurrentCategoryCacheKey($_request->keyword);
        if (Cache::has($cacheKey)) {
            $currentCategory = Cache::get($cacheKey);
        } else {
            $currentCategory = Categories::where(['keyword' => $_request->keyword, 'enabled' => 1])->with(
                ['translates', 'children', 'parent']
            )->first();
            Cache::put($cacheKey, $currentCategory, self::getCacheTime($cacheKey) * 60);
        }

        return $currentCategory;
    }

    /**
     * Premium tariflardagi elonlarni keshdan o'qib olish
     *
     * @return array|mixed
     */
    public static function premiumItems()
    {
        $cacheKey = Caching::getPremiumItemsListCacheKey();
        if (Cache::has($cacheKey)) {
            $premiumItems = Cache::get($cacheKey);
        } else {
            $premiumItems = Items::getPremiumItems();
            Cache::put($cacheKey, $premiumItems, self::getCacheTime($cacheKey) * 60);
        }

        return $premiumItems;
    }

    /**
     * Elonlar bo'limida chiqadigan premium elonlar listini keshdan o'qib olish
     *
     * @param null $item_id
     * @return array|mixed
     */
    public static function premiumItemsInItem($item_id = null)
    {
        $cacheKey = Caching::getPremiumItemsInItemCacheKey($item_id);
        if (Cache::has($cacheKey)) {
            $premiumItems = Cache::get($cacheKey);
        } else {
            $premiumItems = Items::getPremiumItems($item_id);
            Cache::put($cacheKey, $premiumItems, self::getCacheTime($cacheKey) * 60);
        }

        return $premiumItems;
    }

    /**
     * Yangi elonlarni o'qib olish keshdan
     *
     * @return array|mixed
     */
    public static function newItems()
    {
        $cacheKey = Caching::getNewItemsListCacheKey();
        if (Cache::has($cacheKey)) {
            $newItems = Cache::get($cacheKey);
        } else {
            $newItems = Items::getNewItems();
            Cache::put($cacheKey, $newItems, self::getCacheTime($cacheKey) * 60);
        }

        return $newItems;
    }

    public static function lastItemsByCount($item)
    {
        $cacheKey = Caching::getLastItemsByCountCacheKey($item->id);
        if (Cache::has($cacheKey)) {
            $lastItemsByCount = Cache::get($cacheKey);
        } else {
            $lastItemsByCount = Items::getLastItemsByCount($item->link);
            Cache::put($cacheKey, $lastItemsByCount, self::getCacheTime($cacheKey) * 60);
        }
        return $lastItemsByCount;
    }

    /**
     * @return array|mixed
     */
    public static function getPopularItems()
    {
        $cacheKey = Caching::getPopularItemsListCacheKey();
        if (Cache::has($cacheKey)) {
            $newItems = Cache::get($cacheKey);
        } else {
            $newItems = Items::getPopularItems();
            Cache::put($cacheKey, $newItems, self::getCacheTime($cacheKey) * 60);
        }

        return $newItems;
    }

    /**
     * Like elonlarni o'qib olish
     *
     * @param $item
     * @return array|mixed
     */
    public static function getLikeItemsCache($item)
    {
        $cacheKey = Caching::getLikeItemsCacheKey($item->id);
        if (Cache::has($cacheKey)) {
            $likeItems = Cache::get($cacheKey);
        } else {
            $likeItems = Items::getLikeItems($item);
            Cache::put($cacheKey, $likeItems, self::getCacheTime($cacheKey) * 60);
        }

        return $likeItems;
    }

    /**
     * E'lon ko'rilayotgnda shu e'longa biriktirilgan do'kon  bo'ladigan bo'lsa
     * shu do'konning qolgan elonlarinixam ko'rsatish funksiyasi
     * Malumotlarni keshga yozish va u yerdan o'qib olish uchun
     *
     * @param $item
     * @return array|mixed
     */
    public static function getUserShopItemsCache($item)
    {
        $cacheKey = Caching::getUserShopItemsCacheKey($item->id);
        if (Cache::has($cacheKey)) {
            $userShopItems = Cache::get($cacheKey);
        } else {
            $userShopItems = Items::getUserShopItems($item);
            Cache::put($cacheKey, $userShopItems, self::getCacheTime($cacheKey) * 60);
        }

        return $userShopItems;
    }

    /**
     * Elonni ko'rish qismini keshdan tozalash
     *
     * @param $keyword
     */
    public static function clearItemViewCache($keyword)
    {
        $langList = Additional::getAllActiveLangList();
        foreach ($langList as $lang) {
            App::setlocale($lang);
            $cacheKey = Caching::getItemViewCacheKey($keyword);
            $item = Items::where(['link' => $keyword])->with(
                ['categoryWithDynprop', 'district', 'user', 'itemImages', 'category', 'currency']
            )->first();
            Cache::put($cacheKey, $item, self::getCacheTime($cacheKey) * 60);
        }
    }

    /**
     * Elonni ko'rish bo'limini keshdan olish
     *
     * @param $keyword
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|mixed|object|null
     */
    public static function getItemViewCache($keyword)
    {
        $cacheKey = Caching::getItemViewCacheKey($keyword);
        if (Cache::has($cacheKey)) {
            $item = Cache::get($cacheKey);
        } else {
            $item = Items::where(['link' => $keyword])->with(
                ['categoryWithDynprop', 'district', 'user', 'itemImages', 'category', 'currency']
            )->first();
            Cache::put($cacheKey, $item, self::getCacheTime($cacheKey) * 60);
        }
        return $item;
    }

    /**
     * Do'konlarni kategoriyalarini keshdan olish
     *
     * @return array
     */
    public static function getShopCategoriesListCache()
    {
        return ShopCategories::getList();
    }

    /**
     * Kalit so'zni olish
     *
     * @param $currentCategory
     * @return string
     */
    public static function getCategoryBuildTreeParentDynpropCacheKey($currentCategory)
    {
        if (isset($currentCategory->id)) {
            return 'catDynpropSearch-' . app()->getLocale() . '-' . $currentCategory->id;
        }
        return 'catDynpropSearch-' . app()->getLocale() . '-0';
    }

    /**
     * Top kategoriyalarni elonlarini kesh kalit so'zini olish
     *
     * @param $currentCategory
     * @return string
     */
    public static function getTopCatItemCountCacheKey($currentCategory)
    {
        if (isset($currentCategory->id)) {
            return 'topCatItemCount-' . app()->getLocale(
                ) . '-' . $currentCategory->id . '-' . Additional::getGlobalRegionKeyword();
        }
        return 'topCatItemCount-' . app()->getLocale() . '-0' . '-' . Additional::getGlobalRegionKeyword();
    }

    /**
     * Mintaqalarga tegishli elonlarni keshdan o'qib olish
     *
     * @param $currentCategory
     * @return string
     */
    public static function getItemInRegionCacheKey($currentCategory)
    {
        $global_region = Additional::getGlobalRegionKeyword();
        $key = '';
        if (isset($currentCategory->id)) {
            $key = 'itemInRegion-'. app()->getLocale() . '-' . $currentCategory->id;
        }else{
            $key .= 'itemInRegion-' . app()->getLocale() . '-0';
        }
        if($global_region != null){
            $key .= "_" . $global_region;
        }
        return $key;
    }

    /**
     * Hozirgi kategoriyani keshdan o'qib olish
     *
     * @param $keyword
     * @return string
     */
    public static function getCurrentCategoryCacheKey($keyword)
    {
        return 'currentCategory-' . app()->getLocale() . '-' . $keyword;
    }

    /**
     * @param $keyword
     * @return string
     */
    public static function getLikeItemsCacheKey($keyword)
    {
        return 'itemViewLikeItems-' . app()->getLocale() . '-' . $keyword;
    }

    /**
     * @param $keyword
     * @return string
     */
    public static function getUserShopItemsCacheKey($keyword)
    {
        return 'userShopViewItems-' . app()->getLocale() . '-' . $keyword;
    }

    /**
     * Do'konlar kategoriyalari listini, keshdagi kalit so'zini qaytarish
     *
     * @return string
     */
    public static function getShopCategoriesListCacheKey()
    {
        return 'shopCategoriesList-' . app()->getLocale() . '-' . Additional::getGlobalRegionKeyword();
    }

    /**
     * Servislar uchun kesh kalitini qaytarish
     *
     * @return string
     */
    public static function getServicesCacheKey()
    {
        return 'services-' . app()->getLocale();
    }

    /**
     * Top maqolalarni keshdagi keyini olish
     *
     * @return string
     */
    public static function getTopPostCacheKey()
    {
        return 'topPost';
    }

    /**
     * Ijtimoiy tarmoqlarni keshdan olish kalit so'zini qaytarish
     *
     * @return string
     */
    public static function getSocialListCacheKey()
    {
        return 'socialList';
    }

    /**
     * Elonlarni ko'rish bo'limini keshdagi kaliti so'zini qaytarish
     *
     * @param $link
     * @return string
     */
    public static function getItemViewCacheKey($link)
    {
        return 'itemView-' . app()->getLocale() . '-' . $link;
    }

    /**
     * Pull birliklarni keshdan olish kalit so'zini olish
     *
     * @return string
     */
    public static function getCurrencyListCacheKey()
    {
        return 'currencyList';
    }

    /**
     * Sozlamalarni keshdan olish kalit so'zi
     *
     * @param null $key
     * @return string
     */
    public static function getSettingCacheKey($key = null)
    {
        return 'setting-' . $key;
    }

    /**
     * Top katgoriyalarni keshdagi kalitini qytarish
     *
     * @return string
     */
    public static function getTopShopsCacheKey()
    {
        return 'topShops';
    }

    /**
     * Tillarning keshdagi kaliti
     *
     * @return string
     */
    public static function getLangsCacheKey()
    {
        return 'langs';
    }

    /**
     * Mintaqalarni keshdagi kaliti
     *
     * @return string
     */
    public static function getCountersCacheKey()
    {
        return 'counters';
    }

    /**
     * Top bloglar kesh keyini qaytarish
     *
     * @return string
     */
    public static function getTopBlogCacheKey()
    {
        return 'topBlog';
    }

    /**
     * Yangi bloglarni keshdan olish kaliti
     *
     * @return string
     */
    public static function getNewBlogsCacheKey()
    {
        return 'newBlogs';
    }

    /**
     * Premium elonlarni keshdagi kaliti
     *
     * @return string
     */
    public static function getPremiumItemsListCacheKey()
    {
        return 'premiumItems-' . app()->getLocale() . '-' . Additional::getGlobalRegionKeyword();
    }

    /**
     * Elonlar sahifasidagi premium elonlarni keshdan o'qib olish  kaliti
     *
     * @param $item_id
     * @return string
     */
    public static function getPremiumItemsInItemCacheKey($item_id)
    {
        return 'premiumItems-' . app()->getLocale() . '-' . $item_id;
    }

    /**
     * Yangi elonlarni kesh kaliti
     *
     * @return string
     */
    public static function getNewItemsListCacheKey()
    {
        return 'newItems-' . app()->getLocale() . '-' . Additional::getGlobalRegionKeyword();
    }

    public static function getLastItemsByCountCacheKey($item_id)
    {
        return 'lastItemsByCount-' . "-$item_id-" . app()->getLocale() . '-' . Additional::getGlobalRegionKeyword();
    }

    public static function getPopularItemsListCacheKey()
    {
        return 'popularItems-' . app()->getLocale() . '-' . Additional::getGlobalRegionKeyword();
    }
}
