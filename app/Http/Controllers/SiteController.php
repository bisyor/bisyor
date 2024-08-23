<?php

namespace App\Http\Controllers;

use App\Models\References\Vacancy;
use App\Models\References\VacancyCategory;
use App\Models\References\VacancyResume;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Validator;
use Route;
use Session;
use Auth;
use App\User;
use App\Models\Items\Items;
use App\Models\Items\Services;
use App\Models\Items\Categories;
use App\Models\Blogs\BlogPosts;
use App\Models\Banners\Banners;
use App\Models\Banners\BannersItems;
use App\Models\References\Helps;
use App\Models\References\Seo;
use App\Models\References\Subscribers;
use App\Models\References\Contacts;
use App\Models\References\Pages;
use App\Models\References\HelpsCategories;
use App\Models\References\Additional;
use App\Models\References\SearchResults;
use App\Models\References\Regions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\References\SubscribersRequest;
use App\Models\Shops\ShopsAbonements;
use App\Models\References\Caching;

class SiteController extends Controller
{
    /**
     * Bosh saxifa
     * https://www.bisyor.uz
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index()
    {
        $lng = Additional::getCurrentLang();
        if ($lng != null && $lng != app()->getLocale() && $lng != Additional::defaultLang()) {
            return redirect($lng);
        }
        $segmants = Additional::getUrlSegmants(request()->segments());
        $topCategories = Additional::getTopCategories();
        $newBlogs = Caching::newBlogs($type = 'main');
        $topPost = Caching::topPost($type = 'main');

        $premiumItems = Caching::premiumItems();
        //$newItems = Caching::newItems();
        $newItems = Caching::getPopularItems();

        if(empty($newItems)){
            $newItems = [];
            $not_in = [];
        }else{
            $not_in = array_column($newItems, 'id');
        }
        Items::getRecommendationItems($not_in, $newItems);
        shuffle($newItems);
        $banners = Banners::getBanners(
            ['site_index_item_before', 'site_index_item_after_left', 'site_index_item_after_right']
        );
        $langs = Additional::getLangs();
        Banners::getGoogleAndYandexAds($newItems);
        return view(
            'site.index',
            [
                'segmants' => $segmants,
                'langs' => $langs,
                'banners' => $banners,
                'topPost' => $topPost,
                'newBlogs' => $newBlogs,
                'newItems' => $newItems,
                'premiumItems' => $premiumItems,
                'topCategories' => $topCategories,
                'currentRoute' => Route::currentRouteName(),
                'seo' => Seo::getMetaIndex(
                    Seo::getSeoKey(
                        'site-settings',
                        app()->getLocale()
                    ),
                    app()->getLocale()
                ),
            ]
        );
    }

    /**
     * Saytda qidiruv bo'lganda ishga tushadigan funskiya
     * get orqali so'rovni oladi va shu kalit bo'yicha natija qaytaradi
     * Agar get orqali ajax so'rov yuborilsa pagination ishlab navbatdagi sahifani json render qiladi
     *
     * @param Request $request
     * @return mixed
     * @throws \Throwable
     */
    public function searchSite(Request $request)
    {
        $allView = $request->input('all');
        $keyword = $request->input('query');
        $kiril = Additional::latinToCyril($keyword);
        $lotin = Additional::cyrilToLatin($keyword);
        $currentCategory = null;
        if($request->keyword != null) {
            $currentCategory = Categories::where(['keyword' => $request->keyword, 'enabled' => 1])
                ->with(['translates'])
                ->first();
        }

        $currencies = Additional::getCurrenciesList();
        $post = Additional::setPostDatas($request, $currencies);
        $distId = Additional::getRegionsDistrict();
        $filtrDatas = "query={$keyword}&search_from_desc={$post['search_from_desc']}&only_photo={$post['only_photo']}&sorting={$post['sorting']}&price_f={$post['price_f']}&price_t={$post['price_t']}&price_c={$post['price_c']}";

        $data = Items::where(['is_moderating' => 0, 'is_publicated' => 1, 'status' => Items::STATUS_PUBLICATION])
            ->where(
                function ($query) use ($keyword, $post, $kiril, $lotin) {
                    if ($post['search_from_desc'] != 1) {
                        $query->orWhere('title', 'ilike', "%$keyword%")
                            ->orWhere('title', 'ilike', "%$lotin%")
                            ->orWhere('title', 'ilike', "%$kiril%");
                    }
                    $query->orWhere('description', 'ilike', "%$keyword%")
                        ->orWhere('description', 'ilike', "%$lotin%")
                        ->orWhere('description', 'ilike', "%$kiril%");
                }
            )
            ->with(['currency', 'category', 'district', 'favorite', 'itemViews']);

        if (!empty($distId)) {
            $data->whereIn('district_id', $distId);
        }
        Items::filtrPostDatasForSearch($post, $data);
        $catList = clone $data;
        $catList = $catList->select(DB::raw('count(cat_id) as count'), 'cat_id')
            ->groupBy('cat_id')->get()->toArray();

        if ($currentCategory) {
            $data->where(['cat_id' => $currentCategory->id]);
        }
        if (isset($post['sorting'])) {
            if ($post['sorting'] == 'new') {
                $data->orderBy('status_changed', 'desc')->orderBy('id', 'desc');
            } elseif ($post['sorting'] == 'price_asc') {
                $data->orderBy('price_search', 'asc')->orderBy('price_ex', 'asc');
            } elseif ($post['sorting'] == 'price_desc') {
                $data->orderBy('price_search', 'desc')->orderBy('publicated', 'asc');
            }
        } else {
            $data->orderBy('status_changed', 'desc')->orderBy('id', 'desc');
        }
        $data = $data->simplePaginate(config('settings.general_item_count_in_new_items'));
        $data->setPath(
            route(
                'site-search',
                $filtrDatas . ($currentCategory ? '&keyword=' . $currentCategory->keyword : '')
            )
        );

        if ($request->ajax()) {
            return [
                'statuss' => 'success',
                'msg' => view('site.search_page')->with('itemsList', Items::searchResult($data))->render(),
                'page' => $data->nextPageUrl()
            ];
        } else {
            if ($keyword != null && $keyword != '') {
                SearchResults::setValues($data, $keyword);
            }
            $catList = Categories::getCatListSearch($catList);
            $search_results = Items::searchResult($data);
            return view(
                'site.search-result',
                [
                    'catList' => $catList,
                    'itemsList' => $search_results,
                    'page' => $data->nextPageUrl(),
                    'currencies' => $currencies,
                    'post' => $post,
                    'allView' => $allView,
                    'keyword' => $keyword,
                    'filtrDatas' => $filtrDatas,
                    'is_result' => !($data != null && count($data) == 0),
                    'seo' => Seo::getMetaItemsList(
                        Seo::getSeoKey('items', app()->getLocale()),
                        app()->getLocale(),
                        $catList,
                        '',
                        $catList,
                        $keyword
                    ),
                ]
            );
        }
    }

    /**
     * Saytdan ro'yxatdan o'tmagan userlarning sevimlilar safifasi
     *
     * @param Request $request
     * @return array|Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function noAuthUserFavoritesList(Request $request)
    {
        $keyword = $request->input('keyword');
        $currentCategory = Categories::where(['keyword' => $request->keyword, 'enabled' => 1])
            ->with(['translates'])->first();

        if (Session::get('noAuthUserFavorites')) {
            $data = Items::whereIn('id', Session::get('noAuthUserFavorites'))
                ->with(['currency', 'category', 'district', 'favorite']);
        } else {
            $data = Items::where(['id' => null])->with(['currency', 'category', 'district', 'favorite']);
        }
        $catList = clone $data;
        $catList = $catList->select(DB::raw('count(cat_id) as count'), 'cat_id')
            ->groupBy('cat_id')->get()->toArray();

        if ($currentCategory) {
            $data = $data->where(['cat_id' => $currentCategory->id])->paginate(
                config('settings.general_item_count_in_new_items')
            );
        } else {
            $data = $data->paginate(config('settings.general_item_count_in_new_items'));
        }

        $data->setPath(
            route('noauth-user-favorites-list') . ($currentCategory ? '?keyword=' . $currentCategory->keyword : '')
        );
        $seo = Seo::getMetaItemsList(
            Seo::getSeoKey('items', app()->getLocale()),
            app()->getLocale(),
            array_column($catList, 'category'),
            $currentCategory,
            $catList
        );
        if ($request->ajax()) {
            return [
                'statuss' => 'success',
                'msg' => view('site.search_page')->with('itemsList', Items::searchResult($data))->render(),
                'page' => $data->nextPageUrl()
            ];
        } else {
            return view(
                'site.noauth-favorites-list',
                [
                    'currentCategory' => $currentCategory,
                    'keyword' => $keyword,
                    'catList' => Categories::getCatListSearch($catList),
                    'itemsList' => Items::searchResult($data, $for_favorites = true),
                    'page' => $data->nextPageUrl(),
                    'seo' => $seo,
                ]
            );
        }
    }

    /**
     * Saytdan ro'yxatdan o'tmagan userlar biron elonni sevimlilardan chiqarish
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function noAuthUserFavoritesDelete(Request $request)
    {
        Session::put('noAuthUserFavorites', []);
        return back()->with('success-deleted-message', trans('messages.Successful deleted'));
    }

    /**
     * Bannerlarni itemlari
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bannerItem($id)
    {
        $bannerItem = BannersItems::where(['id' => $id])->first();
        if ($bannerItem == null) {
            return back();
        } else {
            $bannerItem->setStatistic();
            return redirect()->route('away', ['link' => $bannerItem->url]);
        }
    }

    /**
     * Saytga obuna bo'lish
     *
     * @param SubscribersRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscribers(SubscribersRequest $request)
    {
        $request->validate(['email' => 'email:rfc,dns']);
        $subs = Subscribers::where('email', $request->email)->first();
        if ($subs == null) {
            $subs = new Subscribers();
            $subs->email = $request->email;
            $subs->save();
            return redirect()
                ->route('site-index')
                ->with('create-subscribers', trans('messages.Success subscribed'));
        }
        return redirect()->route('site-index')
            ->with('success-changed', trans('messages.Success old subscribed'));
    }

    /**
     * Tilni almashtirish
     *
     * @param Request $request
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function setLocale(Request $request)
    {
        $lang = $request->lang;
        $mainLanguage = Additional::defaultLang();
        $languages = Additional::getAllActiveLangList();

        $referer = Redirect::back()->getTargetUrl(); // Url предыдущей страницы
        $parse_url = parse_url($referer, PHP_URL_PATH); // Url предыдущей страницы

        //разбываем на массив по разделителю
        $segments = explode('/', $parse_url);

        //Если URL (где нажали на переключение языка) содержал корректную метку языка
        if (!empty($segments[1]) && in_array($segments[1], $languages)) {
            unset($segments[1]); // удаляем метку
        }

        //Добавляем метку языка в URL (если выбран не язык по-умолчанию)
        if ($lang != $mainLanguage) {
            array_splice($segments, 1, 0, $lang);
        }

        Additional::setCurrentLang($lang);

        //формируем полный URL
        $url = \Illuminate\Support\Facades\Request::root() . implode("/", $segments);

        //если были еще GET-параметры - добавляем их
        if (parse_url($referer, PHP_URL_QUERY)) {
            $url = $url . '?' . parse_url($referer, PHP_URL_QUERY);
        }

        $url = str_replace(env('SITE_LINK'), "", $url);
        return redirect($url, 301);
    }

    /**
     * Global regionlarni o'zgartirish
     * Odatiy xolda butun O'zbekiston bo'ladi
     *
     * @param Request $request
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function globalRegion(Request $request)
    {
        $keyword = $request->key;
        $getAllRegionKeys = Additional::getRegionKeywordList();
        $languages = Additional::getAllActiveLangList();

        $referer = Redirect::back()->getTargetUrl(); // Url предыдущей страницы
        $parse_url = parse_url($referer, PHP_URL_PATH); // Url предыдущей страницы
        //разбываем на массив по разделителю
        $segments = explode('/', $parse_url);
        Additional::setGlobalRegionKeyword($keyword);
        //urldagi 1-belgi lang bolsa
        if (!empty($segments[1]) && in_array($segments[1], $languages)) {
            //urldagi 2-belgi global-keyword bolsa
            $global_url = !empty($segments[2]) && in_array($segments[2], $getAllRegionKeys);

            $path = null;
            if (!empty($segments[2])) {
                $path = $segments[2];
            }
            $list_key = 3;

            if ($global_url) {
                unset($segments[2]); // удаляем метку
                $list_key = 4;
            }
            if ($keyword != null && $global_url || in_array($path, ['obyavlenie', 'shops', 'search'])) {
                if(array_key_exists($list_key, $segments)){
                    if(in_array($segments[$list_key], ['list', 'gallery', 'map'])){
                        array_splice($segments, 2, 0, $keyword);
                    }
                }else{
                    array_splice($segments, 2, 0, $keyword);
                }
            }
        } else {
            $global_url = !empty($segments[1]) && in_array($segments[1], $getAllRegionKeys);

            $path = null;
            if (!empty($segments[1])) {
                $path = $segments[1];
            }
            $list_key = 2;
            if ($global_url) {
                unset($segments[1]); // удаляем метку
                $list_key = 3;
            }

            if ($keyword != null && $global_url || in_array($path, ['obyavlenie', 'shops', 'search'])) {
                if(array_key_exists($list_key, $segments)){
                    if(in_array($segments[$list_key], ['list', 'gallery', 'map'])){
                        array_splice($segments, 1, 0, $keyword);
                    }
                }else{
                    array_splice($segments, 1, 0, $keyword);
                }
            }
        }
        $key = array_key_last($segments);
        if ($segments[$key] == "site-map-regions") {
            $segments[$key] = $keyword . "/obyavlenie/list";
        }
        //формируем полный URL
        $url = \Illuminate\Support\Facades\Request::root() . implode("/", $segments);

        //если были еще GET-параметры - добавляем их
        if (parse_url($referer, PHP_URL_QUERY)) {
            $url = $url . '?' . parse_url($referer, PHP_URL_QUERY);
        }

        $url = str_replace(env('SITE_LINK'), "", $url);
        return redirect($url, 301);
    }

    /**
     * Foydalanish shartlari sahifasi
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function terms()
    {
        $langs = Additional::getLangs();
        $term = Pages::find(1);
        $segmants = Additional::getUrlSegmants(request()->segments());

        return view(
            'site.terms',
            [
                'segmants' => $segmants,
                'langs' => $langs,
                'term' => $term,
                'seo' => Seo::getMetaStatic(Seo::staticPages(1, app()->getLocale())),
            ]
        );
    }

    /**
     * Kontakt saxifasi
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact()
    {
        $langs = Additional::getLangs();
        $segmants = Additional::getUrlSegmants(request()->segments());

        return view(
            'site.contact',
            [
                'langs' => $langs,
                'segmants' => $segmants,
                'seo' => Seo::getMetaIndex(
                    Seo::getSeoKey(
                        'site-settings',
                        app()->getLocale()
                    ),
                    app()->getLocale()
                )
            ]
        );
    }

    /**
     * Saytdan foydalanish
     * Maslahatlar ro'yxati
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function help()
    {
        $categories = HelpsCategories::getList();
        $langs = Additional::getLangs();
        $segmants = Additional::getUrlSegmants(request()->segments());

        return view(
            'site.help',
            [
                'segmants' => $segmants,
                'langs' => $langs,
                'categories' => $categories,
                'seo' => Seo::getMetaHelpList(Seo::getSeoKey('helps', app()->getLocale()), app()->getLocale()),
            ]
        );
    }

    /**
     * Maslahat bo'limiga tegishlilarni ko'rsatish
     *
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function helpIn(Request $request)
    {
        $category = HelpsCategories::where(['id' => (int)$request->id])->with(['translates', 'helps'])->first();
        if ($category == null) {
            return view('errors.404', []);
        }
        $cat = $category->getHelpCategory();
        $categories = HelpsCategories::getList();
        $langs = Additional::getLangs();
        $segmants = Additional::getUrlSegmants(request()->segments());

        return view(
            'site.help-in',
            [
                'categories' => $categories,
                'segmants' => $segmants,
                'category' => $cat,
                'categoryId' => $request->id,
                'langs' => $langs,
                'seo' => Seo::getMetaHelpView(
                    Seo::getSeoKey(
                        'helps',
                        app()->getLocale()
                    ),
                    $cat,
                    app()->getLocale()
                ),
            ]
        );
    }

    /**
     * Yordam sahifasi ichidan izlash
     *
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchHelp(Request $request)
    {
        $request->flash();
        $keyword = $request->q;
        $langs = Additional::getLangs();
        $segmants = Additional::getUrlSegmants(request()->segments());
        $seo = Seo::getMetaHelpList(Seo::getSeoKey('helps', app()->getLocale()), app()->getLocale(), $keyword);

        $data = Helps::where('text', 'LIKE', '%' . $keyword . '%')
            ->orWhere('name', 'LIKE', '%' . $keyword . '%')->get();
        return view(
            'site.help-search-result',
            [
                'data' => $data,
                'count' => count($data),
                'segmants' => $segmants,
                'seo' => $seo,
                'langs' => $langs,
                'keyword' => $keyword,
            ]
        );
    }

    /**
     * Aloxida helpni ko'rish
     *
     * @param $id
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showOneHelp($id)
    {
        $help = Helps::where(['id' => $id])->first();
        $langs = Additional::getLangs();
        $segmants = Additional::getUrlSegmants(request()->segments());
        $category = HelpsCategories::where(['id' => $help->helps_categories_id])
            ->with(['translates', 'helps'])->first();
        $cat = $category->getHelpCategory();
        $seo = Seo::getMetaHelpView(Seo::getSeoKey('helps', app()->getLocale()), $cat, app()->getLocale());

        return view(
            'site.help-one-item',
            [
                'data' => $help,
                'segmants' => $segmants,
                'seo' => $seo,
                'langs' => $langs
            ]
        );
    }

    /**
     * @param Request $request
     * @return array
     */
    public function helpUsefull(Request $request)
    {
        $help = Helps::where(['id' => $request->id])->first();
        $session = Session::get("help_$help->id");

        if ($help != null) {
            if (empty($session)) {
                if ($request->type == 'yes') {
                    $help->usefull_count++;
                    Session::put("help_$help->id", 'like');
                }
                if ($request->type == 'no') {
                    $help->nousefull_count++;
                    Session::put("help_$help->id", 'dislike');
                }
            } elseif (!empty($session)) {
                if ($request->type == 'yes' && $session === 'like') {
                    $help->usefull_count--;
                    Session::put("help_$help->id", null);
                } elseif ($request->type == 'yes' && $session === 'dislike') {
                    $help->usefull_count++;
                    $help->nousefull_count--;
                    Session::put("help_$help->id", 'like');
                } elseif ($request->type == 'no' && $session === 'dislike') {
                    $help->nousefull_count--;
                    Session::put("help_$help->id", null);
                } elseif ($request->type == 'no' && $session === 'like') {
                    $help->usefull_count--;
                    $help->nousefull_count++;
                    Session::put("help_$help->id", 'dislike');
                }
            }
            $help->save();
        }
        return [
            'like' => $help ? $help->usefull_count : '',
            'dislike' => $help ? $help->nousefull_count : ''
        ];
    }

    /**
     * Sayt xaritasi
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function siteMap()
    {
        $additional = new Additional();
        $langs = Additional::getLangs();
        $headerCategories = $additional->categoriesSiteMap();
        return view(
            'site.sitemap',
            [
                'headerCategories' => $headerCategories,
                'langs' => $langs,
                'seo' => Seo::getMetaIndex(
                    Seo::getSeoKey(
                        'site-settings',
                        app()->getLocale()
                    ),
                    app()->getLocale()
                )
            ]
        );
    }

    /**
     * Sayt xaritasi (Mintaqalar bo'yicha)
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function siteMapRegions()
    {
        $additional = new Additional();
        $langs = Additional::getLangs();
        $headerCategories = $additional->regDistrictsAsItems();

        foreach ($headerCategories as &$values) {
            $values['count'] = array_sum(array_column($values['districts_item'], 'items_count'));
        }
        return view(
            'site.sitemap-regions',
            [
                'headerCategories' => $headerCategories,
                'langs' => $langs,
                'seo' => Seo::getMetaIndex(
                    Seo::getSeoKey(
                        'site-settings',
                        app()->getLocale()
                    ),
                    app()->getLocale()
                )
            ]
        );
    }

    /**
     * Saytdan eng ko'p qidirilgan e'lonlar
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function popularSearchs()
    {
        $search_results = SearchResults::whereNotNull('query')->where('hits', '!=', 0)->orderBy('counter', "DESC")
            ->limit(100)->get()->toArray();
        $langs = Additional::getLangs();
        return view(
            'site.popular',
            [
                'search_results' => $search_results,
                'langs' => $langs,
                'seo' => Seo::getMetaIndex(
                    Seo::getSeoKey('site-settings', app()->getLocale()),
                    app()->getLocale()
                )
            ]
        );
    }

    /**
     * Saytda mavjud xizmatlar bilan tanishish
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function services()
    {
        $services = Caching::getServicesCache();
        $banners = Banners::getBanners(['service_list']);
        $langs = Additional::getLangs();
        $segmants = Additional::getUrlSegmants(request()->segments());

        return view(
            'site.services',
            [
                'segmants' => $segmants,
                'services' => $services,
                'banners' => $banners,
                'langs' => $langs,
                'seo' => Seo::getMetaIndex(
                    Seo::getSeoKey(
                        'site-settings',
                        app()->getLocale()
                    ),
                    app()->getLocale()
                )
            ]
        );
    }

    /**
     * Bo'sh ish o'rinlari sahifasi
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function vacancy()
    {
        $vacancy = Pages::find(3);
        $segmants = Additional::getUrlSegmants(request()->segments());
        $seo = Seo::getMetaStatic(Seo::staticPages(3, app()->getLocale()));
        $vacancies = VacancyCategory::whereIsParent(true)
            ->whereStatus(true)
            ->with(['children', 'translate'])
            ->get()->toArray();

        VacancyCategory::vacanciesCount($vacancies);
        Vacancy::getTranslates($vacancies);
        return view(
            'site.vacancy.vacancy',
            [
                'segmants' => $segmants,
                'vacancy' => $vacancy,
                'vacancies' => $vacancies,
                'langs' => $langs = Additional::getLangs(),
                'seo' => $seo,
            ]
        );
    }

    public function vacancyViewList(Request $request)
    {
        $seo = Seo::getMetaStatic(Seo::staticPages(3, app()->getLocale()));
        $segmants = Additional::getUrlSegmants(request()->segments());
        $vacancy_category_id = $request->id;
        $vacancy = VacancyCategory::whereId($vacancy_category_id)
            ->with(['children', 'translate', 'children.vacancies'])
            ->first()->toArray();

        return view('site.vacancy.vacancy_list', [
            'seo' => $seo,
            'langs' => $langs = Additional::getLangs(),
            'segmants' => $segmants,
            'vacancy' => $vacancy
        ]);
    }

    public function vacancyView(Request $request)
    {
        $seo = Seo::getMetaStatic(Seo::staticPages(3, app()->getLocale()));
        $segmants = Additional::getUrlSegmants(request()->segments());
        $vacancy_id = $request->id;
        $vacancy = Vacancy::whereId($vacancy_id)
            ->with(['translate', 'currency', 'category'])
            ->first()->toArray();
        return view('site.vacancy.vacancy_view', [
            'seo' => $seo,
            'langs' => $langs = Additional::getLangs(),
            'segmants' => $segmants,
            'vacancy' => $vacancy
        ]);
    }

    public function saveResume(Request $request)
    {
        $data = $request->all();
        $data['phone'] = str_replace('-', '', $data['phone']);
        $validator = Validator::make($data, VacancyResume::rules());

        if ($validator->fails()) {
            return \redirect()->back()->withErrors($validator)->withInput();
        }
        $model = new VacancyResume();
        $model->name = $request->name;
        $model->phone = $data['phone'];
        $model->description = $request->description;
        $model->vacancy_id = $request->id;
        if($request->file) {
            $model->setCv($request->file);
        }
        $model->save();
        return \redirect()->route('vacancy-view', ['id' => $request->id])->with('success-changed', trans('messages.Successfully saved'));
    }

    /**
     * Reklama sahifasi
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reclama()
    {
        $adv = Pages::find(2);
        $segmants = Additional::getUrlSegmants(request()->segments());
        $abonements = ShopsAbonements::where(['enabled' => 1])->with(['period'])->get();

        return view(
            'site.reclama',
            [
                'segmants' => $segmants,
                'adv' => $adv,
                'abonements' => $abonements,
                'langs' => $langs = Additional::getLangs(),
                'seo' => Seo::getMetaStatic(Seo::staticPages(2, app()->getLocale())),
            ]
        );
    }

    /**
     * Biz haqimizda
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        $about = Pages::getPage(5);
        $segmants = Additional::getUrlSegmants(request()->segments());
        $langs = Additional::getLangs();

        return view(
            'site.about',
            [
                'segmants' => $segmants,
                'about' => $about,
                'langs' => $langs,
                'seo' => Seo::getMetaStatic(Seo::staticPages(5, app()->getLocale())),
            ]
        );
    }

    /**
     * Biron boshqa urlga o'tish uchun
     *
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function away(Request $request)
    {
        $link = 'http://' . preg_replace(['#^https://#', '#^http://#'], '', $request->link);
        return view('site.away', ['link' => $link]);
    }

    /**
     * Biz bian aloqa xabarni saqlash
     *
     * @param Request $req
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitMessage(Request $request)
    {
        $request->validate(['phone' => 'required', 'name' => 'required', 'message' => 'required']);
        $contact = new Contacts();
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->type = $request->type;
        $contact->message = $request->message;
        $contact->user_ip = $request->ip();
        if (Auth::check()) {
            $contact->user_id = auth()->id();
        }
        $contact->useragent = $request->server('HTTP_USER_AGENT');
        $contact->viewed = false;
        $contact->save();

        return redirect()->route('site-index')->with(
            'success-submit-message',
            __('messages.Message sent successfully')
        );
    }

    /**
     * Zip faylni yuklash
     *
     * @return bool[]
     */
    public function downloadZip()
    {
        $ch = curl_init();
        $source = config('app.zipLink');
        curl_setopt($ch, CURLOPT_URL, $source);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        $destination = base_path() . '/public/extracted/archive.zip';
        $file = fopen($destination, "w+");
        fputs($file, $data);
        fclose($file);
        $zip = new \ZipArchive;
        $res = $zip->open(base_path() . '/public/extracted/archive.zip');
        if ($res === true) {
            $zip->extractTo(base_path() . '/public/extracted');
            $zip->close();
            unlink(base_path() . '/public/extracted/archive.zip');
        }

        rename(base_path() . '/public/extracted/settings.php', base_path() . '/config/settings.php');
        $files = scandir(base_path() . '/public/extracted');
        foreach ($files as $file) {
            if (!(strpos($file, '.php') === false)) {
                rename(
                    base_path() . '/public/extracted/' . $file,
                    base_path() . '/resources/lang/' . str_replace('.php', '', $file) . '/messages.php'
                );
            }
        }

        return [
            'success' => true,
        ];
    }

    /**
     * @return bool[]
     */
    public function downloadSitemapImage()
    {
        $ch = curl_init();
        $source = config('app.sitemapImagezipLink');
        curl_setopt($ch, CURLOPT_URL, $source);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        $destination = base_path() . '/public/extracted/sitemapimage.zip';
        $file = fopen($destination, "w+");
        fputs($file, $data);
        fclose($file);

        $zip = new \ZipArchive;
        $res = $zip->open(base_path() . '/public/extracted/sitemapimage.zip');
        if ($res === true) {
            $zip->extractTo(base_path() . '/public/sitemaps');
            $zip->close();
            unlink(base_path() . '/public/extracted/sitemapimage.zip');
        }

        return [
            'success' => true,
        ];
    }

    /**
     * Robotlarni yuklash
     *
     * @return bool[]
     */
    public function downloadRobots()
    {
        $ch = curl_init();
        $source = config('app.robotsLink');
        curl_setopt($ch, CURLOPT_URL, $source);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        $destination = base_path() . '/public/robots.txt';
        $file = fopen($destination, "w+");
        fputs($file, $data);
        fclose($file);
        return [
            'success' => true,
        ];
    }

    /**
     * Sayt xaritasini yuklash
     *
     * @param Request $request
     * @return bool[]
     */
    public function downloadSitemap(Request $request)
    {
        ini_set('max_execution_time', 900); //15 minut
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $fileName = $request->fileName;
        if ($request->path == '1') {
            $path = '/public/sitemaps/';
        } else {
            $path = '/public/';
        }

        $ch = curl_init();
        $source = config('app.sitemapLink') . '?filename=' . $fileName;
        curl_setopt($ch, CURLOPT_URL, $source);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        $destination = base_path() . $path . $fileName;
        $file = fopen($destination, "w+");
        fputs($file, $data);
        fclose($file);
        return [
            'success' => true,
        ];
    }

    /**
     * Saytga kirish
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userAuth(Request $request)
    {
        $user = User::where(['login' => $request->login])->first();
        if ($user != null) {
            if (\Auth::loginUsingId($user->id)) {
                return redirect()->route('site-index');
            } else {
                dd('Ошибка при авторизации');
            }
        } else {
            dd('Пользователь не найдено');
        }
    }

    public function inProcess(){
        return view('crm.includes.in-process');
    }
}
