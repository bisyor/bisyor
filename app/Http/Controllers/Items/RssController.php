<?php

namespace App\Http\Controllers\Items;

use App;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\References\Additional;
use App\Models\Blogs\BlogPosts;
use App\Models\References\Seo;
use App\Models\Shops\Shops;
use App\Models\Items\Items;
use App\Models\Items\Categories;

class RssController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|void
     */
	public function categories(Request $request)
  {
    $currentCategory = Categories::where(['id' => $request->cat, 'enabled' => 1])
            ->with(['translates', 'children', 'parent'])->first();
//        if($currentCategory == null) return abort(404);

    $page = $request->page;
    $lang = $request->lang;
    $region = $request->region;
    $district = $request->district;
        $topCategories = null;
        $mainCategories = null;
        if($currentCategory){
            $topCategories = Categories::getTopCatItemCount($currentCategory, [1]);
            $mainCategories = Categories::buildTreeParent($currentCategory);
        }
    $languages = Additional::getAllActiveLangList();
    if(!in_array($lang, $languages)) $lang = 'ru';
    App::setLocale($lang);

    $count = config('settings.general_item_count_in_new_items');
    $limit = $count * $page;
    $skip = $limit - $count;
        $itemsList = Items::getItemListForRss($currentCategory, $page, $region, $district);

    $seo = Seo::getMetaItemsList(
            Seo::getSeoKey('items', app()->getLocale()),
            app()->getLocale(),
            $mainCategories,
            $currentCategory ? $currentCategory->getCategory(): null,
            $topCategories,
        );

    $siteSeo = Seo::getMetaIndex(Seo::getSeoKey('site-settings', app()->getLocale()), app()->getLocale());

    $site = [
      'title' => $seo['items_all_category_title'],
      'link' => config('app.siteName'),
      'description' => $seo['items_all_category_description'],
      'language' => $lang . '-' . $lang,
      'pubDate' => date(DATE_ATOM, time()),
      'lastBuildDate' => date(DATE_ATOM, time()),
      'image_url' => config('app.siteLogo'),
      'image_title' => $siteSeo['site_settings_main_title'],
      'image_link' => config('app.siteName'),
    ];

    $result = [];
    foreach ($itemsList as $item) {
      $result [] = $item;
    }

        return response()->view('rss.categories', [
          'result' => $result,
          'site' => $site,
        ])->header('Content-Type', 'text/xml');
  }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|void
     */
	public function users(Request $request)
	{
		$page = $request->page;
		$lang = $request->lang;
		$languages = Additional::getAllActiveLangList();

		$user = User::where(['id' => $request->user, 'status' => 1])->first();
        if($user == null) return abort(404);

		if(!in_array($lang, $languages)) $lang = 'ru';
		App::setLocale($lang);

		$items = Items::getUserActiveItems($user->id, $page);
		$seo = Seo::getMetaItemsUser(Seo::getSeoKey('items', app()->getLocale()), $user, app()->getLocale());
		$siteSeo = Seo::getMetaIndex(Seo::getSeoKey('site-settings', app()->getLocale()), app()->getLocale());

		$site = [
			'title' => $user->getUserFio(),
			'link' => route('user-items', $user->getUserLogin()),
			'description' => $seo['items_user_desctiption'],
			'language' => $lang . '-' . $lang,
			'pubDate' => date(DATE_ATOM, time()),
			'lastBuildDate' => date(DATE_ATOM, time()),
			'image_url' => $user->getAvatar(),
			'image_title' => $user->getUserFio(),
			'image_link' => $user->getAvatar(),
		];

		$result = [];
		foreach ($items as $item) {
			$result [] = $item;
		}

        return response()->view('rss.users', [
        	'result' => $result,
        	'site' => $site,
        ])->header('Content-Type', 'text/xml');
	}

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
	public function shops(Request $request)
	{
		$languages = Additional::getAllActiveLangList();
		$color = Additional::serviceShopMarkedColor();

		$page = $request->page;
		$lang = $request->lang;

		if(!in_array($lang, $languages)) $lang = 'ru';
		App::setLocale($lang);

		$count = config('settings.shop_items_pagesize');
        $limit = $count * $page;
        $skip = $limit - $count;

		$seo = Seo::getMetaBlogList(Seo::getSeoKey('shops', app()->getLocale()), app()->getLocale());
		$siteSeo = Seo::getMetaIndex(Seo::getSeoKey('site-settings', app()->getLocale()), app()->getLocale());
		$shops = Shops::where(['status' => Shops::STATUS_ACTIVE])
            ->with(['districts', 'sections', 'items', 'slides'])
            ->orderBy('svc_fixed_to', 'ASC')
            ->orderBy('id', 'DESC')->skip($skip)->take($count)
            ->get();

		$site = [
			'title' => $seo['shops_all_category_title'],
			'link' => config('app.siteName'),
			'description' => $seo['shops_all_category_keyword'],
			'language' => $lang . '-' . $lang,
			'pubDate' => date(DATE_ATOM, time()),
			'lastBuildDate' => date(DATE_ATOM, time()),
			'image_url' => config('app.siteLogo'),
			'image_title' => $siteSeo['site_settings_main_title'],
			'image_link' => config('app.siteName'),
		];

		$result = [];
		foreach ($shops as $shop) {
			$result [] = $shop->viewShop($color);
		}

        return response()->view('rss.shops', [
        	'result' => $result,
        	'site' => $site,
        ])->header('Content-Type', 'text/xml');
	}

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|void
     */
	public function shop(Request $request)
	{
		$page = $request->page;
		$lang = $request->lang;
		$languages = Additional::getAllActiveLangList();

		$shop = Shops::where(['id' => $request->id, 'status' => 1])->with(['districts', 'sections', 'items', 'slides'])->first();
        if($shop == null) return abort(404);

		if(!in_array($lang, $languages)) $lang = 'ru';
		App::setLocale($lang);

		$items = Items::getShopItems($shop->id, $page);
		$card = $shop->viewShop();
		$seo = Seo::getMetaShopView(Seo::getSeoKey('shops', app()->getLocale()), $card, app()->getLocale());
		$siteSeo = Seo::getMetaIndex(Seo::getSeoKey('shops', app()->getLocale()), app()->getLocale());

		$site = [
			'title' => $shop->name,
			'link' => route('shops-view', $shop->keyword),
			'description' => $seo['shops_view_description'],
			'language' => $lang . '-' . $lang,
			'pubDate' => date(DATE_ATOM, time()),
			'lastBuildDate' => date(DATE_ATOM, time()),
			'image_url' => $shop->logo,
			'image_title' => $seo['shops_view_title'],
			'image_link' => $shop->logo,
		];

		$result = [];
		foreach ($items as $item) {
			$result [] = $item;
		}

        return response()->view('rss.shop', [
        	'result' => $result,
        	'site' => $site,
        ])->header('Content-Type', 'text/xml');
	}

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
	public function blogs(Request $request)
	{
		$page = $request->page;
		$lang = $request->lang;
		$languages = Additional::getAllActiveLangList();

		if(!in_array($lang, $languages)) $lang = 'ru';
		App::setLocale($lang);

		$count = config('settings.general_item_count_in_new_items');
		$limit = $count * $page;
		$skip = $limit - $count;
		$blogs = BlogPosts::with(['translates', 'users', 'categories', 'msgCount'])->skip($skip)->take($count)->get();
		$seo = Seo::getMetaBlogList(Seo::getSeoKey('blogs', app()->getLocale()), app()->getLocale());
		$siteSeo = Seo::getMetaIndex(Seo::getSeoKey('site-settings', app()->getLocale()), app()->getLocale());

		$site = [
			'title' => $seo['blog_list_title'],
			'link' => config('app.siteName'),
			'description' => $seo['blog_list_description'],
			'language' => $lang . '-' . $lang,
			'pubDate' => date(DATE_ATOM, time()),
			'lastBuildDate' => date(DATE_ATOM, time()),
			'image_url' => config('app.siteLogo'),
			'image_title' => $siteSeo['site_settings_main_title'],
			'image_link' => config('app.siteName'),
		];

		$result = [];
		foreach ($blogs as $blog) {
			$result [] = $blog->getPost();
		}

        return response()->view('rss.blogs', [
        	'result' => $result,
        	'site' => $site,
        ])->header('Content-Type', 'text/xml');
	}
}
