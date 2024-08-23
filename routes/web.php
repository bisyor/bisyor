<?php

use App\Models\References\Additional;
use App\Models\References\Redirects;
use Illuminate\Support\Facades\Route;
use App\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$adt = new Additional();
$locale = Request::segment(1); //fetches first URI segment
$glRegionKeyword = Request::segment(2); //fetches second URI segment
$languages = $adt->getAllActiveLangList();
$getAllRegionKeys = $adt->getRegionKeywordList();
$fullPath = url()->full();

/**
 * Elon kartochkasiga global region bilan kirishga uringanda
 */
\App\Http\Middleware\GlobalKeyword::removeGlobalKeyInUrl($fullPath, $getAllRegionKeys);


$fullPath = str_replace(env('SITE_LINK'), '', $fullPath);
if (in_array($locale, $languages)) {
    $fullPath = str_replace('/' . $locale, '', $fullPath);
}

if (in_array($locale, $getAllRegionKeys)) {
    $fullPath = str_replace('/' . $locale, '', $fullPath);
} elseif (in_array($glRegionKeyword, $getAllRegionKeys)) {
    $fullPath = str_replace('/' . $glRegionKeyword, '', $fullPath);
}

$redir = Redirects::where(['enabled' => 1])
    ->where(
        function ($query) use ($fullPath) {
            $query->orWhere(['from_uri' => $fullPath]);
            $query->orWhere(['from_uri' => '/' . $fullPath]);
            $query->orWhere(['from_uri' => '/' . $fullPath . '/']);
            $query->orWhere(['from_uri' => $fullPath . '/']);
        }
    )
    ->first();
if ($redir != null) {
    $to_uri = '';
    if (in_array($locale, $languages)) {
        $to_uri = '/' . $locale;
        if (in_array($glRegionKeyword, $getAllRegionKeys)) {
            $to_uri .= '/' . $glRegionKeyword;
        }
    } else {
        if (in_array($locale, $getAllRegionKeys)) {
            $to_uri .= '/' . $locale;
        } elseif (in_array($glRegionKeyword, $getAllRegionKeys)) {
            $to_uri .= '/' . $glRegionKeyword;
        }
    }

    $to_uri = $to_uri . $redir->to_uri;
    return redirect()->to($to_uri, $redir->status)->send();
}
$glRegionKeyword = App\Http\Middleware\GlobalKeyword::getKeyword();




Route::group(
    ['prefix' => App\Http\Middleware\Locale::getLocale()],
    function () use ($glRegionKeyword){

        Auth::routes();
        Route::middleware(['guest'])->group(
            function () {
                Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login-index');
                Route::post('/login', 'Auth\LoginController@login')->name('login');
            }
        );
        Route::get('', 'SiteController@index')->name('site-default');
        Route::prefix($glRegionKeyword)->group(
            function () {
                Route::get('', 'SiteController@index')->name('site-index');
                Route::get('/search', 'SiteController@searchSite')->name('site-search');
            }
        );

        // ****** for video chat begin ********

        Route::group(['middleware' => 'auth'], function () {
            Route::get('/video-chat', function () {
                // fetch all users apart from the authenticated user
                $users = User::where('id', '<>', Auth::id())
                ->whereIn('id' , [1198 , 173])
                ->get();
                return view('video-chat', ['users' => $users]);
            });

            Route::post('/video/call-user', 'VideoChatController@callUser');
            Route::post('/video/accept-call', 'VideoChatController@acceptCall');
            Route::post('/video/decline-call', 'VideoChatController@declineCall');
        });



        // ***** for video chat end *******




        Route::post('/subscribers', 'SiteController@subscribers')->name('subscribers');
        Route::get('/change-lang', 'SiteController@lang')->name('change-lang');
        Route::get('/verify', 'Auth\VerifyController@getVerify')->name('verify-code-get');
        Route::post('/verify', 'Auth\VerifyController@postVerify')->name('verify-code-post');
        Route::post('/verify-login', 'Auth\VerifyController@postVerifyLogin')->name('verify-login-post');
        Route::get('/verify-page-ajax', 'Auth\VerifyController@getVerifyPage')->middleware(['auth'])->name('verify-page-ajax');
        Route::post('/verify-ajax', 'Auth\VerifyController@sendCodeAjax')->name('verify-code-get-ajax');
        Route::post('/verify-post-ajax', 'Auth\VerifyController@postVerifyAjax')->name('verify-code-post-ajax');
        Route::get('/re-verify-get-ajax', 'Auth\VerifyController@reSendCodeAjax')->name('re-verify-code-ajax');
        Route::get('/retry-code', 'Auth\VerifyController@sendRetryVerifyCode')->name('retry-verify-code');
        Route::get('/success-registered', 'Auth\VerifyController@success')->name('success-registered');
        Route::get('/success-recovery-password', 'Auth\VerifyController@successRecoveryPassword')
            ->name('success-recovery-password');
        Route::get('/terms', 'SiteController@terms')->name('site-terms');
        Route::get('/forgot-password', 'Auth\VerifyController@getForgotPassword')->name('forgot-password-get');
        Route::post('/forgot-password', 'Auth\VerifyController@postForgotPassword')->name('forgot-password-post');
        Route::post('/new-password', 'Auth\VerifyController@postNewPassword')->name('new-password-post');
        Route::get('/new-password', 'Auth\VerifyController@getNewPassword')->name('new-password-get');
        Route::get('/contact', 'SiteController@contact')->name('contact');
        Route::get('/help', 'SiteController@help')->name('help');
        Route::get('/help/{id}', 'SiteController@helpIn')->name('help-in');
        Route::get('/help-usefull/{id}/{type}', 'SiteController@helpUsefull')->name('help-usefull');
        Route::get('/site-map', 'SiteController@siteMap')->name('site-map');
        Route::get('/site-map-regions', 'SiteController@siteMapRegions')->name('site-map-regions');
        Route::get('/popular', 'SiteController@popularSearchs')->name('popular');
        Route::get('/services', 'SiteController@services')->name('services');
        Route::get('/vacancy', 'SiteController@vacancy')->name('vacancy');
        Route::get('/vacancy-list/{id}', 'SiteController@vacancyViewList')->name('vacancy-list');
        Route::get('/vacancy-view/{id}', 'SiteController@vacancyView')->name('vacancy-view');
        Route::post('/send-resume/{id}', 'SiteController@saveResume')->name('send-resume');
        Route::get('/about', 'SiteController@about')->name('about');
        Route::get('/away', 'SiteController@away')->name('away');
        Route::get('/gl', 'SiteController@globalRegion')->name('global-region');
        Route::get('/banner-item/{id}', 'SiteController@bannerItem')->name('banner-item');
        Route::post('/submit-message', 'SiteController@submitMessage')->name('submit-message');
        Route::get('/advertising', 'SiteController@reclama')->name('advertising');
        Route::get('/help-search', 'SiteController@searchHelp')->name('help-search');
        Route::get('/site-search/{id}', 'SiteController@showOneHelp')->name('help-search-one');
        Route::get('/favorites', 'SiteController@noAuthUserFavoritesList')->name('noauth-user-favorites-list');
        Route::get('/favorites-delete', 'SiteController@noAuthUserFavoritesDelete')
            ->name('noauth-user-delete-favorites');
        Route::get('/download', 'SiteController@downloadZip');
        Route::get('/download-sitemap-image', 'SiteController@downloadSitemapImage');
        Route::get('/download-robots', 'SiteController@downloadRobots');
        Route::get('/download-sitemap', 'SiteController@downloadSitemap');
        Route::get('/user-auth', 'SiteController@userAuth');
        Route::post('/messages/create-msg', 'Users\ChatsController@createChat')->name('chat-create-chat');
        Route::post('/items-send-claim', 'Items\ItemsController@setItemClaim')->name('items-claim');
        Route::post('/shops-send-claim', 'Shops\ShopsController@setShopClaim')->name('shops-claim');
        Route::get('/list-searched-text', 'Items\FavoritesController@list')->name('list-searched-text');
        Route::get('/delete-searched-text', 'Items\FavoritesController@delete')->name('delete-searched-text');
        Route::post('/save-search-text', 'Items\FavoritesController@save')->name('save-search-text');

        Route::prefix('/profile')->middleware(['auth'])->group(
            function () {
                Route::get('/settings', 'Users\ProfileController@settings')->name('profile-settings');
                Route::post('/change-settings', 'Users\ProfileController@updateSettings')
                    ->name('profile-change-settings');
                Route::post('/change-password', 'Users\ProfileController@changePassword')->name('change-password');
                Route::post('/change-phone', 'Users\ProfileController@changePhone')->name('change-phone');
                Route::post('/change-phone-verify', 'Users\ProfileController@verifyCode')->name('change-phone-verify');
                Route::post('/change-email', 'Users\ProfileController@changeEmail')->name('change-email');
                Route::post('/delete-accaunt', 'Users\ProfileController@deleteAccaunt')->name('delete-accaunt');
                Route::get('/items-list', 'Users\ItemsController@itemsList')->name('profile-items-list');
                Route::post('/auto-raise', 'Users\ItemsController@autoRaise')->name('profile-items-auto-raise');
                Route::get('/item-auto-setting', 'Users\ItemsController@itemAutoSetting')->name('get-item-auto-setting');
                Route::get('/favorites', 'Users\ItemsController@favorites')->name('items-favorites');
                Route::get('/shops/list', 'Shops\ShopsController@shopsList')->name('profile-shops-list');
                Route::get('/shops/create', 'Shops\ShopsController@create')->name('shops-create');
                Route::get('/shops/update/{keyword}', 'Shops\ShopsController@update')->name('shops-update');
                Route::get('/shops/delete/{keyword}', 'Shops\ShopsController@delete')->name('shops-delete');
                Route::get('/shops/success-deleted', 'Shops\ShopsController@successDeleted')->name(
                    'shops-success-deleted'
                );
                Route::get('/shops/sliders/{shop_id}', 'Shops\ShopsController@sliders')->name('shops-sliders');
                Route::get('/shops/slider-create/{shop_id}', 'Shops\ShopsController@sliderCreate')->name('shops-slider-create');
                Route::post('/shops/slider-save', 'Shops\ShopsController@sliderSave')->name('shops-slider-save');
                Route::get('/shops/slider-update/{slider_id}', 'Shops\ShopsController@sliderUpdate')->name('shops-slider-update');
                Route::post('/shops/slider-update', 'Shops\ShopsController@sliderUpdate')->name('shops-slider-update-save');
                Route::get('/shops/slider-delete/{slider_id}', 'Shops\ShopsController@deleteSlider')->name('shops-slider-delete');

                Route::post('/shops/save', 'Shops\ShopsController@save')->name('shops-save');
                Route::post('/shops/update-save', 'Shops\ShopsController@saveUpdate')->name('shops-update-save');
                Route::get('/shops/success', 'Shops\ShopsController@successCreated')->name('shops-success-created');
                Route::get('/shops/success-saved', 'Shops\ShopsController@successSaved')->name('shops-success-saved');
                Route::post('/shops/upload-image', 'Shops\ShopsController@uploadImage')->name('shops-upload-image');
                Route::get('/item-chats-list/', 'Users\ChatsController@itemMsgList')->name('item-chats-list');
                Route::get('/messages/{type_list?}', 'Users\ChatsController@list')->name('chats-list');
                Route::get('/messages-list', 'Users\ChatsController@messagesList')->name('messages-list');
                Route::post('/messages/send-msg', 'Users\ChatsController@sendMsg')->name('chat-send-msg');
                Route::post('/messages/send-file', 'Users\ChatsController@sendFile')->name('chat-send-file');
                Route::get('/file/{fileName}', 'Users\ChatsController@downloadFile')->name('chat-download');
                Route::get('/bills-list', 'Users\ProfileController@bills')->name('bills-list');
                Route::get('/bills-replenish', 'Users\ProfileController@replenish')->name('bills-replenish');
                Route::post('/bills-payment', 'Users\ProfileController@payment')->name('bills-payment');
                Route::get('/items-pagination', 'Users\ItemsController@itemListPage')->name('user-items-page');

                /* Elonlar qo'shish uchun routlar kiritiladi */
                Route::get('/obyavlenie/create', 'Items\ItemsController@create')->name('create-item');
                Route::get('/obyavlenie/update/{link}', 'Items\ItemsController@update')->name('update-item');
                Route::get('/obyavlenie/create-by-shops', 'Items\ItemsController@createByShops')->name(
                    'create-item-shops'
                );
                Route::post('/obyavlenie/add-note', 'Items\ItemsController@addNote')->name(
                    'add-note'
                );
                Route::get('/obyavlenie/subscribe-user/{id}', 'Users\ItemsController@subscribeUser')->name(
                    'subscribe-user'
                );
                Route::post('/obyavlenie/save-items', 'Items\ItemsController@saveItems')->name('items-save');
                Route::post('/obyavlenie/save-items-update/{link}', 'Items\ItemsController@saveUpdate')->name(
                    'items-save-update'
                );
                Route::post('/obyavlenie/save-items-shop', 'Items\ItemsController@saveItemShops')
                    ->name('items-save-shops');
                Route::post(
                    '/obyavlenie/show-aditional-fields/{category_id?}',
                    'Items\ItemsController@ShowAdditionalFields'
                )->name('show-aditional-fields');
                Route::post('/obyavlenie/items/upload-image', 'Items\ItemsController@uploadImage')
                    ->name('items-upload-image');
                Route::post('/obyavlenie/items/upload-image-delete', 'Items\ItemsController@uploadImageDelete')->name(
                    'items-upload-image-delete'
                );
                Route::post('/obyavlenie/items/image-rotate', 'Items\ItemsController@rotateImage')->name(
                    'items-rotate-image'
                );
                Route::get('/obyavlenie/items/delete/{id}', 'Items\ItemsController@delete')->name('items-delete');
                Route::get('/obyavlenie/items/service/{id}', 'Items\ItemsController@services')->name('items-service');
                Route::get('/obyavlenie/items/service-add/{id}', 'Items\ItemsController@servicesAdd')->name(
                    'items-service-add'
                );
                Route::get('/obyavlenie/items/activity-item/{id}', 'Items\ItemsController@activityItem')->name(
                    'activity-item'
                );
                Route::post('/items/payment', 'Items\ItemsController@payment')->name('items-payment');
                Route::post('/items-send-message', 'Users\ItemsController@message')->name('items-message');
                Route::get('/item-change-status', 'Users\ItemsController@changeStatus')->name('item-change-status');

                // For video item video gallery
                Route::prefix('{keyword}')->group(function (){
                    Route::resource('video-gallery', 'Items\VideoGalleriesController')
                        ->except('show');
                });

                Route::get('/shop-subscribe/{id}', 'Shops\ShopsController@subscribe')->middleware(['auth'])->name('shop-subscribe');
//                Avatar change bo'lganda rasmni trashga saqlab olish
//                Route::post('/change-avatar', 'Users\ProfileController@uploadAvatar')->name('change-avatar');
                Route::get('/reset-count/{id}/{type}', 'Users\ItemsController@resetCount')->name('reset-count');
                Route::get('/bonus-lists', 'Users\ProfileController@bonusList')->name('profile.bonus-lists');
                Route::get('/get-bonus/{bonus}', 'Users\ProfileController@getBonusInDay')->name('profile.get-bonus');
                Route::get('/referrals', 'Users\ProfileController@referrals')->name('profile.referrals');
                Route::get('/item-stats/{item}', 'Users\ItemsController@itemViewsStat')
                    ->name('profile.item.stat');
                Route::get('{transfer}-to-main-balance', 'Users\ProfileController@transferToMain')->name('transfer-to-main');
                Route::get('success', 'Users\ProfileController@successMessage')->name('success-message');
                Route::get('translate', 'Users\ChatsController@translate')->name('translate');
                Route::get('in-process', 'SiteController@inProcess')->name('in-process');
            }
        );

        /**
         * Ortiqcha global region kerak bo'lmagan xol uchun
         */


        Route::prefix($glRegionKeyword . '/obyavlenie')->group(
            function () {
                Route::get('/list/{keyword?}', 'Items\ItemsController@list')->where('keyword', '[A-Za-z0-9_/-]+')
                    ->name('items-list');

                Route::get('/item-page-list', 'Items\ItemsController@itemPageList')->name('item-page-list');
                Route::post('/sendComment', 'Items\ItemsController@sendComment')->name('items-send-comment');
                Route::get('/map/{keyword?}', 'Items\ItemsController@map')->where('keyword', '[A-Za-z0-9_/-]+')
                    ->name('items-map');
                Route::get('/item-page-map', 'Items\ItemsController@itemPageMap')->name('item-page-map');
                Route::get('/gallery/{keyword?}', 'Items\ItemsController@gallery')->where('keyword', '[A-Za-z0-9_/-]+')
                    ->name('items-gallery');
                Route::get('/item-page-gallery', 'Items\ItemsController@itemPageGallery')->name('item-page-gallery');
                Route::get('/set-favorite/{id}', 'Items\ItemsController@setFavorite')->name('item-set-favorite');
                Route::get('/set-favorite-noauth/{id}', 'Items\ItemsController@setFavoriteNoauth')
                    ->name('item-set-favorite-noauth');
                Route::get('/item-new-list', 'Items\ItemsController@itemNewList')->name('item-new-list');
//                Route::get('/{keyword}', 'Items\ItemsController@view')->name('view-item');
                Route::get('/set-contact-view/{id}', 'Items\ItemsController@setContactView')->name('set-contact-view');
                Route::get('/get-user-phone/{login}', 'Users\ProfileController@getUserPhone')->name('get-user-phone');
                Route::get('/get-item-user-phone/{id}', 'Users\ProfileController@getItemUserPhone')
                    ->name('get-item-user-phone');
                Route::post('/set-offer', 'References\ContactController@storeFeedback')->name('contact-offer-store');
                Route::post('to-order', 'Items\ApplicationsController@store')->name('to-order');
            }
        );

        Route::prefix('/obyavlenie')->group(function (){
            Route::get('/list/{keyword?}', 'Items\ItemsController@list')->where('keyword', '[A-Za-z0-9_/-]+')
                ->name('items-list');
            Route::get('/{keyword}', 'Items\ItemsController@view')->name('view-item');
            Route::get('/order/{keyword}', 'Items\ItemsController@viewOrder')->name('view-item-order');
            Route::get('/statistics/{item}', 'Items\ItemsController@priceStatisticsItem')->name('item-statistics');
        });

        Route::prefix('/blogs')->group(
            function () {
                Route::get('/category/{categoryKey}', 'Blogs\BlogsController@category')->name('blogs-category');
                Route::get('/list', 'Blogs\BlogsController@list')->name('blogs-list');
                Route::get('/{slug}', 'Blogs\BlogsController@view')->name('blogs-view');
                Route::get('/set-like/{blog_id}', 'Blogs\BlogsController@setLike')->name('set-like');
                Route::post('/sendComment', 'Blogs\BlogsController@sendComment')->name('blogs-send-comment');
            }
        );

        Route::prefix($glRegionKeyword . '/shops')->group(
            function () {
                Route::get('/list', 'Shops\ShopsController@list')->name('shops-list');
                Route::get('/map', 'Shops\ShopsController@map')->name('shops-map');
                Route::get('/shops-page-list', 'Shops\ShopsController@listPage')->name('shops-page');
                Route::get('/create/get-term', 'Shops\ShopsController@getTerm')->name('shops-get-term');
                Route::get('/create/set-term-prices/{id}', 'Shops\ShopsController@setTermPrices')
                    ->name('set-term-prices');
                Route::get('/set-service/{id}', 'Shops\ShopsController@services')->middleware(['auth'])->name('set-services-shop');
                Route::get('/buy-service/{id}', 'Shops\ShopsController@servicesAdd')->name('buy-services-shop');
                Route::get('/shop-commentary/{keyword}', 'Shops\ShopsController@getShopComment')->name('shop-commentary');
                Route::get('/shop-user-page', 'Shops\ShopsController@userListPage')->name('shop-user-page');
                Route::get('/about/{keyword}', 'Shops\ShopsController@about')->name('shops-about');
                Route::get('/portfolio/{keyword}', 'Shops\ShopsController@portfolio')->name('shops-portfolio');
                Route::get('/{keyword}', 'Shops\ShopsController@view')->name('shops-view');
                Route::post('/shop-rating', 'Shops\ShopsController@shopRating')->name('shop-rating');
            }
        );

        Route::prefix('/users')->group(
            function () {
                Route::get('/{login}/{type}', 'Items\ItemsController@userSubscribers')
                    ->name('user-subscribers');
                Route::get('/items-users-page', 'Items\ItemsController@userItemsPage')->name('items-users-page');
                Route::get('/{login}', 'Items\ItemsController@userItems')->name('user-items');
            }
        );

        /* For CRM routes */

        Route::prefix('{keyword}/crm')->middleware('auth')->group(function (){
            Route::resource('clients', 'Crm\ClientsController')->except('show');
            Route::get('download-clients-example', 'Crm\ClientsController@downloadExampleSheet')
                ->name('clients.example-import');
            Route::post('clients/import', 'Crm\ClientsController@import')->name('clients.import');
            Route::get('clients/export', 'Crm\ClientsController@export')->name('clients.export');

            Route::post('services/import', 'Crm\ServicesController@import')->name('services.import');
            Route::get('services/export', 'Crm\ServicesController@export')->name('services.export');

            Route::get('services/example', 'Crm\ServicesController@downloadExampleSheet')
                ->name('services.example');
            Route::resource('services', 'Crm\ServicesController')->except('show');

            Route::get('available/good-info', 'Crm\AvailableController@goodInfo')
                ->name('available.good-info');
            Route::get('available-example', 'Crm\AvailableController@downloadExampleSheet')
                ->name('available.example');
            Route::post('available/import', 'Crm\AvailableController@import')
                ->name('available.import');
            Route::get('available/export', 'Crm\AvailableController@export')
                ->name('available.export');
            Route::resource('available', 'Crm\AvailableController');
            Route::resource('order', 'Crm\OrdersController');
            Route::get('order/clients', 'Crm\OrdersController@clientsByType')
                ->name('order.clients');
        });
    }
);

Route::get('setLocale', 'SiteController@setLocale')->name('setLocale');

Route::get(
    'set-session',
    function (\Illuminate\Http\Request $request) {
        session([$request->key => $request->value]);
    }
);
//Route::get('auth/social', 'Auth\LoginController@show')->name('social.login');
Route::get('auth/{driver}', 'Auth\LoginController@redirectToProvider')->name('social.oauth');
Route::get('auth/{driver}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');

Route::prefix('/rss')->group(
    function () {
        Route::get('/categories', 'Items\RssController@categories')->name('rss-cat');
        Route::get('/users', 'Items\RssController@users')->name('rss-user');
        Route::get('/shops', 'Items\RssController@shops')->name('rss-shop');
        Route::get('/shop', 'Items\RssController@shop')->name('rss-shop-one');
        Route::get('/blogs', 'Items\RssController@blogs')->name('rss-blog');
    }
);

Route::get('static-region', 'References\StaticController@staticRegion')->name('staticRegion');
Route::get('static-header', 'References\StaticController@staticHeader')->name('staticHeader');
Route::get('static-top-categories', 'References\StaticController@staticTopCategories')->name('staticTopCategories');
Route::get('clear-item-cache/{keyword}', 'References\TrashController@clearItem')->name('clearItemCache');

Route::get(
    '/clear-cache',
    function () {
        Artisan::call('cache:clear');
        return "Cache is cleared";
    }
);

Route::get('/video-chat-user/{user_id}', function ($user_id) {
    $user = User::where('id', $user_id)->first();
    return [
        'id' => $user->id,
        'name' => $user->getUserFio()
    ];
});

Route::get('/clear-session', function () {
    $files = File::allFiles(storage_path('framework/sessions/'));
    foreach($files as $file){
        File::delete(storage_path('framework/sessions/'.$file->getFilename()));
    }
    return "Session is cleared";
}
);
