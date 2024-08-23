<?php

namespace App\Http\Controllers\Items;

use App\Models\Items\BuyedLimits;
use App\Models\Items\ItemNotes;
use App\Models\Items\ItemsClaim;
use App\Models\Items\ItemsScale;
use App\Models\Items\Limits;
use App\Models\Items\Services;
use App\Models\References\PromoCode;
use App\Models\References\Settings;
use App\Models\References\UserSubscribers;
use App\Models\Shops\Shops;
use Auth;
use App\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Items\Favorites;
use App\Models\Items\Items;
use App\Models\Items\ItemsImages;
use App\Models\Chats\Chats;
use App\Models\Items\ItemsViews;
use App\Models\Chats\ChatMessage;
use App\Models\Items\Categories;
use App\Models\Banners\Banners;
use App\Models\References\Additional;
use App\Models\References\Seo;
use App\Models\References\Lang;
use App\Models\References\StaticFunction;
use Intervention\Image\Facades\Image;
use Symfony\Component\Console\Input\Input;
use App\Models\References\Caching;

class ItemsController extends Controller
{
    /**
     * Yangi elon qo'shish formasini yborish
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->phone_verified === false) {
            if (empty($user->email)) {
                $login = $user->phone;
            } else {
                $login = $user->email;
            }
            return redirect()->route('verify-code-get', ['login' => $login]);
        }
        $additional = new Additional();
        $segmants = $additional->getUrlSegmants(request()->segments());
        $langs = $additional->getLangs();
        $settings = Settings::where(['key' => 'shops_phones_limit'])->first();
        $shops = Shops::where(['user_id' => $user->id])->count();

        return view(
            'items.form.create-form',
            [
                'user' => $user,
                'segmants' => $segmants,
                'langs' => $langs,
                'category_list' => $additional->getCategoriesList(),
                'regDistricts' => $additional->regDistricts(),
                'settings' => $settings,
                'shops' => $shops,
                'seo' => Seo::getMetaItemsCreate(Seo::getSeoKey('items', app()->getLocale()), app()->getLocale()),
            ]
        );
    }

    /**
     * Do'kon orqali elon qo'shish funksiyasi
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createByShops()
    {
        $user = Auth::user();
        $additional = new Additional();
        $shop_list = Shops::getUserShopList($user);
        $segmants = $additional->getUrlSegmants(request()->segments());
        $langs = $additional->getLangs();
        if (!$shop_list) {
            redirect(route('shops-create'));
        }
        $settings = Settings::where(['key' => 'shops_phones_limit'])->first();

        return view(
            'items.form.forshops.create-form-shops',
            [
                'user' => $user,
                'segmants' => $segmants,
                'langs' => $langs,
                'category_list' => $additional->getCategoriesList(),
                'regDistricts' => $additional->regDistricts(),
                'shopList' => $shop_list,
                'settings' => $settings,
                'seo' => Seo::getMetaItemsCreate(Seo::getSeoKey('items', app()->getLocale()), app()->getLocale()),
            ]
        );
    }


    public function priceStatisticsItem(Request $request){
        $item = Items::find($request->item);

        $price_statistics = Items::itemPriceStatisticsInYear($item->cat_id);
        $price_statistic_labels = array_map(function ($label) {
            return date('d.m.Y', strtotime($label));
        }, array_column($price_statistics, 'group_date'));

        $current_price = json_encode(array_fill(0, count($price_statistic_labels), $item->price_search), true);
        $min_price_statistics = json_encode(array_column($price_statistics, 'min_price'), true);
        $max_price_statistics = json_encode(array_column($price_statistics, 'max_price'), true);
        $price_statistic_labels = json_encode($price_statistic_labels, true);

        return view('items.view.statistica', [
            'price_statistic_labels' => $price_statistic_labels,
            'min_price_statistics' => $min_price_statistics,
            'max_price_statistics' => $max_price_statistics,
            'current_price' => $current_price
        ])->render();
    }

    /**
     * Elonni syatda ko'rish oynasi
     *
     * @param Request $request
     * @return mixed
     */
    public function view(Request $request)
    {
        $item = Items::where(['link' => $request->keyword])->with(
            ['categoryWithDynprop', 'district', 'user', 'itemImages', 'category', 'currency', 'itemNote']
        )->first();
//        $item = Caching::getItemViewCache($request->keyword);
        if ($item == null) {
            return abort(404);
        }

        $item_note = $item->itemNote;

        $segmants = Additional::getUrlSegmants(request()->segments());
        ItemsViews::setViewCount($item->id, 1);
        $currentCategory = $item->category;
        Categories::setUserCategories($currentCategory->id);

        $user = $item->user;
        $itemImages = $item->itemImages;
        $mainCategories = Caching::categoryBuildTreeParentDynprop($currentCategory);
        $premiumItems = Caching::premiumItemsInItem($item->id);
        Favorites::setFavorite($item->id, Favorites::TYPE_VIEW);
        $msgList = Chats::getMessages(4, $item->id);
        $likeItems = Caching::getLikeItemsCache($item);
        $user_items = Caching::getUserShopItemsCache($item);
        $langs = Additional::getLangs();
        $view_comments = config('settings.view_comments');

        $dynpropValues = Items::getDynpropValues($mainCategories, $item);
        $content_page = $item->getItem();
        $seo = Seo::getMetaItemsView(
            Seo::getSeoKey('items', app()->getLocale()),
            $content_page,
            app()->getLocale(),
            $mainCategories,
            $user
        );
        $noActualStatus = 0;
        $itemErrosMsgText = 'active';
        if (!$item->checkUser()) {
            $noActualStatus = 1;
            $itemErrosMsgText = $item->itemErrosMsgText();
        }
        $newItems = Caching::lastItemsByCount($item);
        $users = User::where('id', '<>', Auth::id())
                ->whereIn('id' , [$item->user_id])
                ->get();
        Banners::getGoogleAndYandexAds($newItems, Banners::ITEMS_CARD_NEW_ITEMS);
        Banners::getGoogleAndYandexAds($likeItems, Banners::ITEMS_CARD_OTHER_ITEMS);
        return view(
            'items.view.information',
            [
                'segmants' => $segmants,
                'noActualStatus' => $noActualStatus,
                'itemErrosMsgText' => $itemErrosMsgText,
                'item' => $content_page,
                'user' => $user,
                'itemImages' => $itemImages,
                'premiumItems' => $premiumItems,
                'mainCategories' => $mainCategories,
                'msgList' => $msgList,
                'langs' => $langs,
                'view_comments' => $view_comments,
                'dynpropValues' => $dynpropValues,
                'likeItems' => $likeItems,
                'user_items' => $user_items,
                'seo' => $seo,
                'item_note' => $item_note,
                'newItems' => $newItems,
                'reason_type_list' => ItemsClaim::REASON_TYPE_LIST,
                'another_reason' => ItemsClaim::ANOTHER_REASON,
                'users' => $users,
                'video' => true,
            ]
        );
    }

    public function viewOrder(Request $request)
    {
        $item = Items::where(['link' => $request->keyword])->with(
            ['categoryWithDynprop', 'district', 'user', 'itemImages', 'category', 'currency', 'itemNote']
        )->first();
//        $item = Caching::getItemViewCache($request->keyword);
        if ($item == null) {
            return abort(404);
        }

        $item_note = $item->itemNote;

        $segmants = Additional::getUrlSegmants(request()->segments());
        ItemsViews::setViewCount($item->id, 1);
        $currentCategory = $item->category;
        Categories::setUserCategories($currentCategory->id);

        $user = $item->user;
        $itemImages = $item->itemImages;
        $mainCategories = Caching::categoryBuildTreeParentDynprop($currentCategory);
        Favorites::setFavorite($item->id, Favorites::TYPE_VIEW);
        $user_items = Caching::getUserShopItemsCache($item);
        $langs = Additional::getLangs();

        $dynpropValues = Items::getDynpropValues($mainCategories, $item);
        $content_page = $item->getItem();
        $seo = Seo::getMetaItemsView(
            Seo::getSeoKey('items', app()->getLocale()),
            $content_page,
            app()->getLocale(),
            $mainCategories,
            $user
        );
        $noActualStatus = 0;
        $itemErrosMsgText = 'active';
        if (!$item->checkUser()) {
            $noActualStatus = 1;
            $itemErrosMsgText = $item->itemErrosMsgText();
        }
        $users = User::where('id', '<>', Auth::id())
            ->whereIn('id' , [$item->user_id])
            ->get();

        return view(
            'items.view.order',
            [
                'segmants' => $segmants,
                'noActualStatus' => $noActualStatus,
                'itemErrosMsgText' => $itemErrosMsgText,
                'item' => $content_page,
                'user' => $user,
                'itemImages' => $itemImages,
                'mainCategories' => $mainCategories,
                'langs' => $langs,
                'dynpropValues' => $dynpropValues,
                'user_items' => $user_items,
                'seo' => $seo,
                'item_note' => $item_note,
                'reason_type_list' => ItemsClaim::REASON_TYPE_LIST,
                'another_reason' => ItemsClaim::ANOTHER_REASON,
            ]
        );
    }

    /**
     * Elon ostida izoh qoldirish funksiyasi
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendComment(Request $request)
    {
        $user = Auth::user();
        if ($user != null) {
            $chat = Chats::where(['type' => 4, 'field_id' => $request->item_id])->first();
            if ($chat == null) {
                Chats::createChat($request->item_id, 4, $request->message);
            } else {
                ChatMessage::msgCreate($chat->id, $request->message, 'msg', $user->id);
            }
        }
        return back()->with('success', trans('messages.Successfully saved'));
    }

    /**
     * Elonlar ro'yxatini karta (Xaritada) ko'rsatish
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function map(Request $request)
    {
        Items::setActiveTab('map');
        $page = $request->page ?: 1;
        $currentCategory = Categories::where(['keyword' => $request->keyword, 'enabled' => 1, 'address' => 1])
            ->with(['translatesAll', 'children', 'parent'])->first();
        if ($request->keyword != null && $currentCategory == null) {
            abort(404);
        }

        $segmants = Additional::getUrlSegmants(request()->segments());
        $catDynpropSearch = Caching::categoryBuildTreeParentDynprop($currentCategory);
        $dynpropSearch = Categories::getDynpropSearch($catDynpropSearch);
        Session::put('dynpropSearch', $dynpropSearch);
        $currencies = Additional::getCurrenciesList();
        $post = Additional::setPostDatas($request, $currencies);
        $topCategories = Categories::getTopCatItemCount($currentCategory, [1]);
        $itemInRegion = Caching::itemInRegionCache($currentCategory);
        $mainCategories = Categories::buildTreeParent($currentCategory);
        $itemsList = Items::getItemList($request->keyword, $page, $post);
        $banners = Banners::getBanners(['item_list']);
        $langs = Additional::getLangs();

        $curCat = null;
        $keywordParent = null;
        $address = false;
        if ($currentCategory != null) {
            $address = $currentCategory->address;
            $curCat = $currentCategory->getCategory();
            if ($currentCategory->parent != null) {
                if ($currentCategory->parent->keyword != 'root') {
                    $keywordParent = $currentCategory->parent->keyword;
                } else {
                    $keywordParent = '';
                }
            }
        }
        $urlParams = str_replace($request->url(), '', $request->fullUrl());
        $actionFilterRoute = '';
        if ($curCat != null) {
            $actionFilterRoute = route('items-map', $curCat['keyword'] . $urlParams);
        }
        Banners::getGoogleAndYandexAds($itemsList, Banners::ITEMS_MAP);
        return view(
            'items.map',
            [
                'actionFilterRoute' => $actionFilterRoute,
                'urlParams' => $urlParams,
                'segmants' => $segmants,
                'currentCategory' => $curCat,
                'topCategories' => $topCategories,
                'keywordParent' => $keywordParent,
                'keyword' => $request->keyword,
                'mainCategories' => $mainCategories,
                'itemInRegion' => $itemInRegion,
                'itemsList' => $itemsList,
                'banners' => $banners,
                'dynpropSearch' => $dynpropSearch,
                'currencies' => $currencies,
                'post' => $post,
                'address' => $address,
                'langs' => $langs,
                'seo' => Seo::getMetaItemsList(
                    Seo::getSeoKey('items', app()->getLocale()),
                    app()->getLocale(),
                    $mainCategories,
                    $curCat,
                    $topCategories,
                ),
                'page' => $page + 1
            ]
        );
    }

    /**
     * Elonlarni galereya ko'rinishida qaytarish
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function gallery(Request $request)
    {
        Items::setActiveTab('gallery');
        $page = $request->page ?: 1;
        $currentCategory = Categories::where(['keyword' => $request->keyword, 'enabled' => 1])
            ->with(['translatesAll', 'children', 'parent'])->first();
        if ($request->keyword != null && $currentCategory == null) {
            abort(404);
        }

        $segmants = Additional::getUrlSegmants(request()->segments());
        $catDynpropSearch = Caching::categoryBuildTreeParentDynprop($currentCategory);

        $dynpropSearch = Categories::getDynpropSearch($catDynpropSearch);
        Session::put('dynpropSearch', $dynpropSearch);
        $currencies = Additional::getCurrenciesList();
        $post = Additional::setPostDatas($request, $currencies);
        $topCategories = Caching::getTopCatItemCountCache($currentCategory);
        $itemInRegion = Caching::itemInRegionCache($currentCategory);
        $mainCategories = Categories::buildTreeParent($currentCategory);
        $itemsList = Items::getItemList($request->keyword, $page, $post);
        $banners = Banners::getBanners(['item_list']);
        $langs = Additional::getLangs();

        $curCat = null;
        $keywordParent = null;
        $address = false;
        if ($currentCategory != null) {
            $address = $currentCategory->address;
            $curCat = $currentCategory->getCategory();
            if ($currentCategory->parent != null) {
                if ($currentCategory->parent->keyword != 'root') {
                    $keywordParent = $currentCategory->parent->keyword;
                } else {
                    $keywordParent = '';
                }
            }
        }
        $urlParams = str_replace($request->url(), '', $request->fullUrl());
        $actionFilterRoute = '';
        if ($curCat != null) {
            $actionFilterRoute = route('items-gallery', $curCat['keyword'] . $urlParams);
        }
        Banners::getGoogleAndYandexAds($itemsList, Banners::ITEMS_GALLERY);
        return view(
            'items.gallery',
            [
                'actionFilterRoute' => $actionFilterRoute,
                'urlParams' => $urlParams,
                'segmants' => $segmants,
                'currentCategory' => $curCat,
                'topCategories' => $topCategories,
                'keywordParent' => $keywordParent,
                'keyword' => $request->keyword,
                'mainCategories' => $mainCategories,
                'itemInRegion' => $itemInRegion,
                'itemsList' => $itemsList,
                'banners' => $banners,
                'dynpropSearch' => $dynpropSearch,
                'currencies' => $currencies,
                'post' => $post,
                'address' => $address,
                'langs' => $langs,
                'seo' => Seo::getMetaItemsList(
                    Seo::getSeoKey('items', app()->getLocale()),
                    app()->getLocale(),
                    $mainCategories,
                    $curCat,
                    $topCategories,
                ),
                'page' => $page+1,
            ]
        );
    }

    /*Список обявлении в виде лист*/
    /**
     * Elonlar ro'yxati sahifasi uchun (list ko'rinishida)
     *
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request)
    {
        $active_tab = Items::getActiveTab();
        $page = $request->page ?: 1;
        $segments = $this->prev_segments(url()->previous());
        if (!(in_array('map', $segments) || in_array('gallery', $segments))) {
            if ($active_tab == 'map') {
                return redirect()->route('items-map', ['keyword' => $request->keyword]);
            } elseif ($active_tab == 'gallery') {
                return redirect()->route('items-gallery', ['keyword' => $request->keyword]);
            }
        }
        Items::setActiveTab('list');
        $currentCategory = Categories::where(['keyword' => $request->keyword, 'enabled' => 1])
            ->with(['translatesAll', 'children', 'parent'])
            ->first();
        if ($request->keyword != null && $currentCategory == null) {
            abort(404);
        }

        $segmants = Additional::getUrlSegmants(request()->segments());
        $catDynpropSearch = Caching::categoryBuildTreeParentDynprop($currentCategory);
        $dynpropSearch = Categories::getDynpropSearch($catDynpropSearch);
        Session::put('dynpropSearch', $dynpropSearch);
        $currencies = Additional::getCurrenciesList();
        $post = Additional::setPostDatas($request, $currencies);
        $topCategories = Caching::getTopCatItemCountCache($currentCategory);
        $itemInRegion = Caching::itemInRegionCache($currentCategory);
        $mainCategories = Categories::buildTreeParent($currentCategory);
        $itemsList = Items::getItemList($request->keyword, $page, $post);
        $banners = Banners::getBanners(['item_list']);
        $langs = Additional::getLangs();

        $curCat = null;
        $keywordParent = null;
        $address = false;
        if ($currentCategory != null) {
            $address = $currentCategory->address;
            $curCat = $currentCategory->getCategory();
            if ($currentCategory->parent != null) {
                if ($currentCategory->parent->keyword != 'root') {
                    $keywordParent = $currentCategory->parent->keyword;
                } else {
                    $keywordParent = '';
                }
            }
        }
        $urlParams = str_replace($request->url(), '', $request->fullUrl());
        $actionFilterRoute = '';
        if ($curCat != null) {
            $actionFilterRoute = route('items-list', $curCat['keyword'] . $urlParams);
        }
        $seo = Seo::getMetaItemsList(
            Seo::getSeoKey('items', app()->getLocale()),
            app()->getLocale(),
            $mainCategories,
            $curCat,
            $topCategories,
        );

        Banners::getGoogleAndYandexAds($itemsList, Banners::ITEMS_LIST);
        return view(
            'items.list',
            [
                'actionFilterRoute' => $actionFilterRoute,
                'urlParams' => $urlParams,
                'segmants' => $segmants,
                'currentCategory' => $curCat,
                'topCategories' => $topCategories,
                'keywordParent' => $keywordParent,
                'keyword' => $request->keyword,
                'mainCategories' => $mainCategories,
                'itemInRegion' => $itemInRegion,
                'itemsList' => $itemsList,
                'dynpropSearch' => $dynpropSearch,
                'currencies' => $currencies,
                'post' => $post,
                'address' => $address,
                'banners' => $banners,
                'langs' => $langs,
                'seo' => $seo,
                'page' => $page+1,
            ]
        );
    }

    /**
     * Yangi elonlar ro'yxati
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function itemNewList(Request $request)
    {
        $itemsList = Items::getNewItems($request->page);
        $getHtmlItemList = Items::getHtmlNewItemList($itemsList);
        $response = [
            'status' => 'success',
            'itemCount' => count($itemsList),
            'msg' => $getHtmlItemList,
        ];
        return response()->json($response);
    }


    /**
     * Elonlar ro'yxati scroll paginatsiya uchun
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function itemPageList(Request $request)
    {
        $post = Session::get('itemsPostDatas');
        $page = $request->page ?: 1;
        $itemsList = Items::getItemList($request->keyword, $page, $post);
        $getHtmlItemList = Items::getHtmlItemList($itemsList);
        $response = array(
            'status' => 'success',
            'itemCount' => count($itemsList),
            'msg' => $getHtmlItemList,
        );
        return response()->json($response);
    }

    /**
     * Karta ko'rinishidagi sahifa uchun scroll paginatsiya qaytaruvchi
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function itemPageMap(Request $request)
    {
        $post = Session::get('itemsPostDatas');
        $itemsList = Items::getItemList($request->keyword, $request->page, $post);
        $getHtmlItemList = Items::getHtmlItemMap($itemsList);
        $response = [
            'status' => 'success',
            'itemCount' => count($itemsList),
            'msg' => $getHtmlItemList,
        ];
        return response()->json($response);
    }

    /**
     * Galareya ko'rinishidagi  sahifa paginatsiyasi
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function itemPageGallery(Request $request)
    {
        $post = Session::get('itemsPostDatas');
        $itemsList = Items::getItemList($request->keyword, $request->page, $post);
        $getHtmlItemList = Items::getHtmlNewItemList($itemsList);
        $response = array(
            'status' => 'success',
            'itemCount' => count($itemsList),
            'msg' => $getHtmlItemList,
        );
        return response()->json($response);
    }

    /**
     * Foydalanuvchilarni barcha elonlarini ko'rish
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function userItems(Request $request)
    {
        $user = User::orWhere(['email' => $request->login])
            ->orWhere(['phone' => $request->login])
            ->orWhere(['login' => $request->login])
            ->withCount(['subscribers', 'subscriptions'])
            ->firstOrFail();
        $page = $request->page ?: 1;
        $auth_user = Auth::user();
        $subscribe = false;
        if($auth_user){
            $subscribe = !!UserSubscribers::where([
                'from_user_id' => $auth_user->id,
                'to_user_id' => $user->id
            ])->first();
        }
        $userItems = Items::getUserActiveItems($user->id, $page);
        $seo = Seo::getMetaItemsUser(Seo::getSeoKey('items', app()->getLocale()), $user, app()->getLocale());
        return view(
            'items.view.user',
            [
                'userItems' => $userItems,
                'user' => $user,
                'subscriber' => $subscribe,
                'seo' => $seo,
                'page' => $page + 1
            ]
        );
    }

    public function userSubscribers(Request $request){
        $type = $request->type;

        $user = User::orWhere(['email' => $request->login])->orWhere(['phone' => $request->login])
            ->orWhere(['login' => $request->login])->withCount(['subscribers', 'subscriptions'])->firstOrFail();

        $auth_user = Auth::user();
        $subscribe = false;
        if($auth_user){
            $subscribe = !!UserSubscribers::where(['from_user_id' => $auth_user->id, 'to_user_id' => $user->id])->first();
        }
        $seo = Seo::getMetaItemsUser(Seo::getSeoKey('items', app()->getLocale()), $user, app()->getLocale());

        $sub = $type == 'subscribers' ? $user->subscribers : $user->subscriptions;
        $langs = Additional::getLangs();
        foreach($sub as $key => $value){
            if($value->{$type}->district){
                $name = $value->{$type}->district->name;
                if($value->{$type}->district->translate){
                    $sub[$key]->district = $value->{$type}->district->translate->field_value;
                }
                $sub[$key]->district = $name;
            }else{
                $sub[$key]->district = '';
            }
        }
        $segmants = Additional::getUrlSegmants(request()->segments());
        return view(
            'items.view.subscribers',
            [
                'user' => $user,
                'subscriber' => $subscribe,
                'subscribers' => $sub,
                'type' => $type ==  'subscribers' ? 'subscribers' : 'subscriptions',
                'seo' => $seo,
                'langs' => $langs,
                'segmants' => $segmants
            ]
        );
    }

    /**
     * Foydalanuvchi elonlarining scroll paginatsiyasini qaytaradi
     *
     * @param Request $request
     * @return array|void
     * @throws \Throwable
     */
    public function userItemsPage(Request $request)
    {
        $user = User::orWhere(['email' => $request->login])->orWhere(['phone' => $request->login])
            ->orWhere(['login' => $request->login])->first();
        if ($user == null) {
            return abort(404);
        }
        $page = $request->page;
        $userItems = Items::getUserActiveItems($user->id, $page);

        return [
            'status' => 'success',
            'itemCount' => count($userItems),
            'msg' => view('items.view.page')->with(compact('userItems'))->render(),
        ];
    }

    /**
     * Elonni sevimlilargga qo'shish
     *
     * @param Request $request
     */
    public function setFavorite(Request $request)
    {
        Favorites::setFavorite($request->id, $request->type);
    }

    /**
     * Elonni sevimlilarga qo'shish (Ro'yxatdan o'tmaganlar uchun)
     *
     * @param Request $request
     * @return mixed
     */
    public function setFavoriteNoauth(Request $request)
    {
        if (Session::get('noAuthUserFavorites') == null) {
            $array = [];
            $array [] = $request->id;
            Session::put('noAuthUserFavorites', $array);
        } else {
            $array = Session::get('noAuthUserFavorites');
            if (in_array($request->id, $array)) {
                if (($key = array_search($request->id, $array)) !== false) {
                    array_splice($array, $key, 1);
                }
            } else {
                array_push($array, $request->id);
            }
            Session::put('noAuthUserFavorites', $array);
        }
        return Session::get('noAuthUserFavorites');
    }

    /**
     * Telefon raqamni ko'rishni sanash
     *
     * @param Request $request
     */
    public function setContactView(Request $request)
    {
        ItemsViews::setViewCount($request->id, 2);
    }

    /**
     * Formada kategoriyani tanlaganiga qarab kerakli inputlarni qaytarish
     *
     * @param $category_id
     * @return array
     * @throws \Throwable
     */
    public function ShowAdditionalFields($category_id)
    {
        $user = Auth::user();
        $langs = Lang::getLanguages();
        $category = Categories::find($category_id);
        $category->getPriceSett($langs);
        $fields = $category->getAdditionalFields();
        $currenies = Caching::getCurrencyCache();
        $limitList = '';
        $checkLimit = Limits::check($category_id);
        if ($checkLimit !== false) {
            $limitList = view('items.form.limitList')->with(
                [
                    'limitPack' => Limits::limitTarif($checkLimit)['settings'],
                    'category' => $category->getParentsName($category_id)
                ]
            )->render();
        }
        return [
            'form' => view('items.form.additional_fields')->with(
                compact('user', 'fields', 'category', 'currenies')
            )->render(),
            'limitList' => $limitList
        ];
    }

    /**
     * Vaqtinchalik yuklangan rasmlarni saqlash uchun funksiyasi
     * Formada rasm tanlanishi bilan ishlaydi
     *
     * @param Request $request
     * @return false|string
     */
    public function uploadImage(Request $request)
    {
        $dir = '/web/uploads/trash/';
        $file = $request->file()['file'];
        $filename = $request->post('names');
        $i = 0;
        foreach ($file as $value) {
            $fPath = $filename[$i];
            $image_upload_val ['image[' . $i . ']'] = new \CurlFile($value, $value->getClientMimeType(), $fPath);
            $i++;
        }

        // curl connection
        $ch = curl_init();
        // set curl url connection
        $curl_url = config('app.imgSiteNameSelf') . 'api/upload-file';
        // pass curl url
        curl_setopt($ch, CURLOPT_URL, $curl_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        // image upload Post Fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $image_upload_val);
        // set CURL ETURN TRANSFER type
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_result = curl_exec($ch);
        curl_close($ch);
        if ($server_result) {
            return config('app.imgSiteName') . $dir;
        } else {
            return false;
        }
    }

    /**
     * Rasmni o'chirish
     * Agar rasm xali asosiy papkaga o'tmagan bo'lsagina bu funksiya ishlaydi
     *
     * @param Request $request
     */
    public function uploadImageDelete(Request $request)
    {
        $file = $request->post('name');
        $uploadPath = config('app.trashRoute');

        Storage::disk('ftp')->delete($uploadPath . $file);
    }

    /**
     * Rasmni aylantirish uchun
     *
     * @param Request $request
     * @return string
     */
    public function rotateImage(Request $request)
    {
        $filename = $request->post('name');
        $update = $request->post('update');

        $uploadPath = config('app.trashRoute');
        $trashPath = config('app.trashPath');

        $pathinfo = pathinfo($filename);
        $file_ext = $pathinfo['extension'];

        if ($update) {
            $trashPath = config('app.itemsPath');
        }

        $img_new_name = "bisyor_" . round(microtime(true) * 1000) . "." . $file_ext;

        $pathname = $uploadPath . $img_new_name;

        $img = Image::make($trashPath . $filename)->rotate(-90);
        Storage::disk('ftp')->put($pathname, $img->encode('jpg'));

        return $img_new_name;
    }

    /**
     * Elonni saqlash
     * Yangi elon yaratish uchun formani to'ldirib jo'natganda forma to'gri to'ldirilgan ekanligi tekshiriladi
     * Tasdiqdan o'tgan malumotlar bazaga saqlanadi va foydalanuvchinig pullik servislarni sotib olish sahifasi taklif
     * qilinadi
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveItems(Request $request)
    {
        $user = Auth::user();
        $this->itemsValidator($request->all(), $request->for_req, $user->id)->validate();
        $buyedLimit = Limits::limitValidate($request);
        if ($buyedLimit == 'balance') {
            return redirect()->back()->withInput($request->all())->withErrors(['limitbalance' => true]);
        } elseif ($buyedLimit === 'required') {
            return redirect()->back()->withInput($request->all())->withErrors(['limit' => 'Siz limit tanlamadingiz']);
        }
        $model = new Items();
        $model->owner_type = 1;
        $model->from_device = 1;
        $model->beforeSave($request);
        $model->user_id = $user->id;
        $model->user_ip = $request->getClientIp();
        $model->title = StaticFunction::removePhone(StaticFunction::remove_emoji(ucfirst($request->title)));
        $model->keyword = Str::slug($request->title, '-');
        $model->cat_id = $request->cat_id;
        $model->description = StaticFunction::removePhone(StaticFunction::remove_emoji($request->description));
        $model->video = $request->video;
        $model->district_id = $request->district_id;
        $model->owner_type = $request->owner_type;
        $model->cat_type = $request->cat_type;
        $model->coordinate_x = $request->coordinate_x;
        $model->coordinate_y = $request->coordinate_y;
        $model->price = (float)str_replace(" ", "", $request->price);
        $model->price_end = (float)str_replace(" ", "", $request->price_end);
        $model->currency_id = $request->currency_id;
        $model->address = $request->address;
        $model->price_ex = $request->price_ex;
        $model->name = $request->name;
        $model->is_publicated_telegram = 0;
        if ($model->currency_id != null) {
            $model->price_search = $model->currency->rate * $model->price;
        }
        // Modeldagi 25 ta f polyalarga ma'lumotlar yuklash
        $model->phonesSerialize($request);
        for ($i = 1; $i <= 25; $i++) {
            $model->{"f$i"} = $request->{"f$i"};
        }
        if ($model->save()) {
            $model->link = $model->keyword . "-" . $model->id . ".html";
            $model->save();
            $model->uploadImage($request->photos);
            $model->save();
            ItemsScale::setBallItems($model);
        }
        if ($buyedLimit) {
            $buyedLimit->used_count = $buyedLimit->used_count + 1;
            $json = json_decode($buyedLimit->items);
            $json = $json != null ? $json : [];
            array_push($json, $model->id);
            $buyedLimit->items = json_encode($json);
            if ($buyedLimit->item_count <= $buyedLimit->used_count) {
                $buyedLimit->active = false;
            }
            $buyedLimit->save();
        }

        return redirect()->route('items-service', $model->id);
    }

    /**
     * Magazin orqali elon qo'shishda kelgan malumotlarni saqlash funksiyasi
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveItemShops(Request $request)
    {
        $user = Auth::user();
        $this->itemsValidator($request->all(), $request->for_req, $user->id, false, true)->validate();
        $model = new Items();
        $model->owner_type = 2;
        $model->from_device = 1;
        $model->beforeSave($request);
        $model->user_id = $user->id;
        $model->shop_id = $request->shop_id;
        $model->user_ip = $request->getClientIp();
        $model->title = StaticFunction::removePhone(StaticFunction::remove_emoji(ucfirst($request->title)));
        $model->keyword = Str::slug($request->title, '-');
        $model->cat_id = $request->cat_id;
        $model->description = StaticFunction::removePhone(StaticFunction::remove_emoji($request->description));
        $model->video = $request->video;
        $model->district_id = $request->district_id;
        $model->owner_type = $request->owner_type;
        $model->cat_type = $request->cat_type;
        $model->coordinate_x = $request->coordinate_x;
        $model->coordinate_y = $request->coordinate_y;
        $model->price = (float)str_replace(" ", "", $request->price);
        $model->price_end = (float)str_replace(" ", "", $request->price_end);
        $model->currency_id = $request->currency_id;
        $model->address = $request->address;
        $model->price_ex = $request->price_ex;
        $model->name = $request->name;
        $model->is_publicated_telegram = 0;
        if ($model->currency_id != null) {
            $model->price_search = $model->currency->rate * $model->price;
        }
        $model->phonesSerialize($request);
        for ($i = 1; $i <= 25; $i++) {
            $model->{"f$i"} = $request->{"f$i"};
        }
        if ($model->save()) {
            $model->link = $model->keyword . "-" . $model->id . ".html";
            $model->save();
            $model->uploadImage($request->photos);
            $model->save();
            ItemsScale::setBallItems($model);
        }
        return redirect()->route('items-service', $model->id);
    }

    /**
     * Itemsni validatsiya qilish uchun ishlatiladi
     * $shops bo'lgan xolda magazin itemsni validatsiyaga qo'shadi
     *
     * @param array $data
     * @param $required_list
     * @param $user_id
     * @param bool $update
     * @param bool $shopValidate
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function itemsValidator(array $data, $required_list, $user_id, $update = false, bool $shopValidate = false)
    {
        $required_list = json_decode($required_list);
        $short_lsit = [];
        if ($required_list) {
            foreach ($required_list as $value) {
                if ($value->req == true) {
                    $short_lsit += ["f{$value->data_field}" => ['required']];
                }
            }
        }
        if ($shopValidate) {
            $short_lsit += ['shop_id' => ['required'],];
        }
        /* Checked for duplicate title*/

        $duplicate = Items::whereUserId($user_id)->whereTitle($data['title'])->where(
            'status',
            '!=',
            Items::STATUS_TYPE[Items::NEW_STATUS_DELETED]['statuses']['status']
        )->where(
            function ($q) use ($update) {
                if ($update !== false) {
                    $q->where('id', '!=', $update);
                }
            }
        )->get()->isNotEmpty();


        $short_lsit += [
            'title' => ['required', 'max:70'],
            'name' => ['required', 'string',],
            'cat_id' => ['required'],
            'description' => ['required'],
            'district_id' => ['required'],
            'phones.*' => ['required']
        ];
        $validator = Validator::make($data, $short_lsit);

        $validator->after(
            function ($validator) use ($data, $duplicate) {
                if ($data['video'] != '') {
                    $pattern = '#^(?:https?://)?';    # Optional URL scheme. Either http or https.
                    $pattern .= '(?:www\.)?';         #  Optional www subdomain.
                    $pattern .= '(?:';                #  Group host alternatives:
                    $pattern .= 'youtu\.be/';       #    Either youtu.be,
                    $pattern .= '|youtube\.com';    #    or youtube.com
                    $pattern .= '(?:';              #    Group path alternatives:
                    $pattern .= '/embed/';        #      Either /embed/,
                    $pattern .= '|/v/';           #      or /v/,
                    $pattern .= '|/watch\?v=';    #      or /watch?v=,
                    $pattern .= '|/watch\?.+&v='; #      or /watch?other_param&v=
                    $pattern .= ')';                #    End path alternatives.
                    $pattern .= ')';                  #  End host alternatives.
                    $pattern .= '([\w-]{11})';        # 11 characters (Length of Youtube video ids).
                    $pattern .= '(?:.+)?$#x';         # Optional other ending URL parameters.
                    preg_match($pattern, $data['video'], $matches_a_z, PREG_OFFSET_CAPTURE);
                    if (!$matches_a_z) {
                        $validator->errors()->add('video', trans('messages.Youtube link error'));
                    }
                }
                if ($duplicate) {
                    $validator->errors()->add('title', trans('messages.This title have all ready'));
                }
            });
        return $validator;
    }

    /**
     * Update uchun formani tayorlab qaytarishi uchun funksiya
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $model = Items::where(['link' => $request->link, 'user_id' => $user->id])->first();
        if (!$model) {
            abort(404);
        }

        $additional = new Additional();
        $container = [];
        $content = [];
        $photos = ItemsImages::where(['item_id' => $model->id])->get();
        if ($photos) {
            foreach ($photos as $key => $value) {
                $container[] = $value->extstor_img_o;
                $content[] = [
                    'filename' => $value->extstor_img_o,
                    'image_m' => $value->extstor_img_m
                ];
            }
            $container = implode(',', $container);
        }
        unset($photos);
        $settings = Settings::where(['key' => 'shops_phones_limit'])->first();
        $langs = Lang::getLanguages();
        $category = Categories::find($model->cat_id);
        $category->getPriceSett($langs);
        $fields = $category->getAdditionalFields();
        if ($model->shop_id) {
            $template = 'items.form.forshops.update-form';
            $shopList = Shops::getUserShopList($user);
        } else {
            $template = 'items.form.update-form';
            $shopList = null;
        }
        $currenies = Caching::getCurrencyCache();

        return view(
            $template,
            [
                'user' => $user,
                'model' => $model,
                'category_list' => $additional->getCategoriesList(),
                'regDistricts' => $additional->regDistricts(),
                'photos' => $content,
                'container' => $container,
                'langs' => $langs,
                'category' => $category,
                'fields' => $fields,
                'shopList' => $shopList,
                'settings' => $settings,
                'currenies' => $currenies
            ]
        );
    }

    /**
     * Izmenit qilish uchun formadan kelgan ma'lumotlarni bazaga saqlash uchun funksiya
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveUpdate(Request $request)
    {
        $user = Auth::user();
        $model = Items::where(['link' => $request->link, 'user_id' => $user->id])->first();
        if (!$model) {
            abort(404);
        }
        if ($model->shop_id) {
            $this->itemsValidator($request->all(), $request->post('for_req'), $user->id, $model->id, true)->validate();
        } else {
            $this->itemsValidator($request->all(), $request->post('for_req'), $user->id, $model->id)->validate();
        }
        $title = StaticFunction::removePhone(StaticFunction::remove_emoji(ucfirst($request->title)));
        $description = StaticFunction::removePhone(StaticFunction::remove_emoji($request->description));
        $model->beforeUpdate($request);
        $model->old_title = $model->title != $title ? $model->title:$model->old_title;
        $model->old_description = $model->description != $description ? $model->description:$model->old_description;
        $model->user_id = $user->id;
        $model->user_ip = $request->getClientIp();
        $model->title = $title;
        $model->keyword = Str::slug($request->title, '-');
        $model->cat_id = $request->cat_id;
        $model->description = $description;
        $model->video = $request->video;
        $model->district_id = $request->district_id;
        $model->owner_type = $request->owner_type;
        $model->cat_type = $request->cat_type;
        $model->coordinate_x = $request->coordinate_x;
        $model->coordinate_y = $request->coordinate_y;
        $model->price = (float)str_replace(" ", "", $request->price);
        $model->price_end = (float)str_replace(" ", "", $request->price_end);
        $model->currency_id = $request->currency_id;
        $model->address = $request->address;
        $model->price_ex = $request->price_ex;
        $model->name = $request->name;
        if ($model->currency_id != null) {
            $model->price_search = $model->currency->rate * $model->price;
        }
        // Modeldagi 25 ta f polyalarga ma'lumotlar yuklashning ixcham yo'li
        for ($i = 1; $i <= 25; $i++) {
            $model->{"f$i"} = $request->{"f$i"};
        }
        $model->phonesSerialize($request);
        if ($model->save()) {
            $model->link = $model->keyword . "-" . $model->id . ".html";
            $model->updateImage($request);
            $model->save();
            ItemsScale::setBallItems($model);
        }
        return redirect()->route('profile-items-list');
    }

    /**
     * Foydalanuvchi elonini olib tashlashi uchun funksiyasi
     * Elon statusi o'chirilganlikga o'zgartiriladi
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $user = Auth::user();
        $model = Items::where(['id' => $request->id, 'user_id' => $user->id])->first();
        if (!$model) {
            abort(404);
        }
        $model->status = Items::STATUS_TYPE[Items::NEW_STATUS_DELETED]['statuses']['status'];
        $model->is_moderating = Items::STATUS_TYPE[Items::NEW_STATUS_DELETED]['statuses']['is_moderating'];
        $model->is_publicated = Items::STATUS_TYPE[Items::NEW_STATUS_DELETED]['statuses']['is_publicated'];
        $model->save();
        return redirect()->route('profile-items-list');
    }

    /**
     * Foydalanuvchi elonni qayta faollashtirish uchun funksiya
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activityItem(Request $request)
    {
        $user = Auth::user();
        $model = Items::where(
            ['id' => $request->id, 'user_id' => $user->id, 'is_publicated' => 0, 'is_moderating' => 0, 'status' => 4]
        )->first();
        if (!$model) {
            abort(404);
        }

        $statuses = $model::STATUS_TYPE[$model::NEW_STATUS_MODERATING]['statuses'];
        $model->status_prev = $model->status;
        $model->status = $statuses['status'];
        $model->is_moderating = $statuses['is_moderating'];
        $model->is_publicated = $statuses['is_publicated'];
        $model->publicated_to = date("Y-m-d H:i:s", strtotime("+" . $model->publicated_period . " days"));
        $model->date_up = date('Y-m-d H:i:s');
        $model->publicated = date('Y-m-d H:i:s');
        //$model->status_changed = date('Y-m-d H:i:s');

        $model->save();
        return redirect()->route('profile-items-list');
    }

    /**
     * Servislar ulash uchun ro'yxatni yboradi
     */
    public function services(Request $request)
    {
        $user = Auth::user();
        $model = Items::where(['id' => $request->id, 'user_id' => $user->id])->first();
        if (!$model) {
            abort(404);
        }
        $services = Services::where(['module' => 'bbs', 'enabled' => 1,])
            ->orderBy('type', 'ASC')
            ->orderBy('sorting', 'ASC')->get();
        return view('items.services.services', ['services' => $services, 'model' => $model, 'status' => 'added']);
    }

    /**
     * Foydalanuvchi elonga servislarni biriktirishi uchun funksiya
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function servicesAdd(Request $request)
    {
        $user = Auth::user();
        $lang = app()->getLocale();

        if ($request->services == 0) {
            return redirect()->route('profile-items-list');
        }

        $services = Services::find($request->services);

        $model = Items::where(['id' => $request->id, 'user_id' => $user->id])->first();
        if (!$model || !$services) {
            abort(404);
        }

        $payment_method = $request->payment_method;
        $billCreateUrl = config('app.billCreateUrl');

        if ($payment_method === 'm1my') {
            if ($user->balance - $services->price < 0) {
                $services = Services::where(['module' => 'bbs', 'enabled' => 1])->orderBy('type', 'ASC')->orderBy(
                    'sorting',
                    'asc'
                )->get();
                return view(
                    'items.services.services',
                    [
                        'services' => $services,
                        'model' => $model,
                        'status' => 'error'
                    ]
                );
            }
            $api = $billCreateUrl . "?user_id=" . $user->id . "&amount=" . $services->price . "&type=5&item_id=" . $model->id . "&service_id=" . $services->id . "&lang=" . $lang;
            $json = file_get_contents_curl($api);
            $json = json_decode($json, true);

            if (!$json['status']) {
                return view(
                    'items.services.message',
                    [
                        'status' => $json['status'] ? 'success' : 'error',
                        'message' => $json['message'],
                        'user' => $user
                    ]
                );
            }
            return redirect()->to(route('profile-items-list'))->with('success-saved', $json['message']);
        } elseif ($payment_method === 'm1er') {
            $api = $billCreateUrl . "?user_id=" . $user->id . "&amount=" . $services->price . "&type=1&item_id=" . $model->id . "&service_id=" . $services->id . "&lang=" . app()->getLocale();
        } elseif ($payment_method === 'm2sev') {
            $api = $billCreateUrl . "?user_id=" . $user->id . "&psystem=146&amount=" . $services->price . "&type=1&item_id=" . $model->id . "&service_id=" . $services->id . "&lang=" . app()->getLocale();
        }

        $json = file_get_contents_curl($api);
        $json = json_decode($json, true);
        if (!$json['status']) {
            return view(
                'items.services.message',
                [
                    'user' => $user,
                    'status' => 'error',
                    'message' => $json['message']
                ]
            );
        }
        return redirect()->to($json['url']);
    }

    /**
     * Foydalanuvchi to'lov qilish uchun funksiya
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function payment(Request $request)
    {
        $user = Auth::user();
        $amount = (int)str_replace(" ", "", $request->amount);
        $pay_method = $request->payment_method;
        $type = $request->type;
        $billCreateUrl = config('app.billCreateUrl');
        if ($type == 'pay') {
            if ($amount < 1000 || $amount > 10000000 || !$pay_method) {
                return redirect()->back()->withInput(Input::all());
            }
            switch ($pay_method) {
                case "m2sev" :
                    $api = $billCreateUrl . "?user_id=" . $user->id . "&psystem=146&amount=" . $amount . "&type=1&lang=" . app()->getLocale();
                    break;
                case "m1er" :
                    $api = $billCreateUrl . "?user_id=" . $user->id . "&amount=" . $amount . "&type=1&lang=" . app()->getLocale();
                    break;
                default :
                    abort(404);
            }
            $json = file_get_contents_curl($api);
            $json = json_decode($json, true);
            if (!$json['status']) {
                return view(
                    'items.services.message',
                    [
                        'user' => $user,
                        'status' => 'error',
                        'message' => $json['message']
                    ]
                );
            }
            return redirect()->to($json['url']);
        } else {
            $promo = $request->promo;
            $code_id = PromoCode::where(['code' => $promo])->first();
            if (!$code_id) {
                return redirect()->back()->withInput($request->all())->withErrors(
                    ['promo' => trans('messages.Code not exsist')]
                );
            }
            $api = $billCreateUrl . "?user_id=" . $user->id . "&promocode_id=" . $code_id->id . "&lang=" . app()->getLocale();
            $json = file_get_contents_curl($api);
            $json = json_decode($json, true);
            if (!$json['status']) {
                return view(
                    'items.services.message',
                    [
                        'user' => $user,
                        'status' => 'error',
                        'message' => $json['message']
                    ]
                );
            } else {
                return view(
                    'items.services.message',
                    [
                        'user' => $user,
                        'status' => 'success',
                        'message' => $json['message']
                    ]
                );
            }
        }
    }

    /**
     * Elon uchun shikoyatlar yuborish
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setItemClaim(Request $request)
    {
        $model = new ItemsClaim();
        $model->beforeSave($request);
        $model->item_id = $request->item_id;
        $model->reason = $request->reason;
        if ($request->reason == ItemsClaim::ANOTHER_REASON) {
            $model->message = $request->message;
        }
        if ($model->save()) {
            return redirect()->back()->with('success-changed', trans('messages.Successfully sended'));
        }
        return redirect()->back();
    }

    /**
     * E'longa zamteka qo'shish funksiyasi
     *
     * @param Request $request
     * @return mixed
     */
    public function addNote(Request $request)
    {
        $user = Auth::user();
        $item_id = $request->item_id;
        $message = $request->message;
        if (ItemNotes::updateOrCreate(
            ['user_id' => $user->id, 'item_id' => $item_id],
            ['message' => $message]
        )) return $message;
        return 0;
    }

    /**
     * Actionga oldin kelgan urlini tekshirish uchun
     *
     * @param $uri
     * @return array
     */
    public function prev_segments($uri)
    {
        $segments = explode('/', str_replace('' . url('') . '', '', $uri));

        return array_values(array_filter($segments, function ($value) {
            return $value !== '';
        }));
    }

}
