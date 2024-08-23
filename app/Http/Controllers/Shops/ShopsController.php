<?php

namespace App\Http\Controllers\Shops;

use App\Models\Banners\Banners;
use App\Models\Items\Items;
use App\Models\Items\Services;
use App\Models\References\Settings;
use App\Models\Shops\ShopsComment;
use App\Models\Shops\ShopSlider;
use App\Models\Shops\ShopsRating;
use App\Models\Shops\ShopsSubscribers;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use App\Models\Shops\Shops;
use App\Models\Shops\ShopsClaims;
use App\Models\Shops\ShopsTariff;
use App\Models\Shops\ShopsSections;
use App\Models\Shops\ShopCategories;
use App\Models\Shops\ShopsAbonements;
use App\Models\Shops\ShopsAbonementPeriod;
use App\Models\References\Additional;
use App\Models\References\SocialNetworks;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\References\Seo;
use Illuminate\Support\Facades\Storage;
use App\Models\References\Caching;

class ShopsController extends Controller
{
    /**
     * Magazinlar ro'yxat bo'yicha ko'rishdagi action
     *
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request)
    {
        $currentCat = ShopCategories::where(['keyword' => $request->category])->with('translate')->first();
        $categories = Caching::getShopCategoriesListCache();
        $page = $request->page ?: 1;
        $shopsList = Shops::getShopList($currentCat, $request->sorting, $page);
        $parameters = request()->input();
        $sortingName = $request->sorting == 'popular' ? trans('messages.Popular shops') : trans('messages.New shops');
        $langs = Additional::getLangs();
        $brands = Additional::getBrandList();
        $segmants = Additional::getUrlSegmants(request()->segments());
        Banners::getGoogleAndYandexAds($shopsList, Banners::SHOPS_LIST);
        return view(
            'shops.list',
            [
                'segmants' => $segmants,
                'categories' => $categories,
                'catKey' => $request->category,
                'currentCat' => $currentCat,
                'shopsList' => $shopsList,
                'brands' => $brands,
                'langs' => $langs,
                'parameters' => $parameters,
                'sortingName' => $sortingName,
                'page' => $page + 1,
                'seo' => Seo::getMetaShopCategory(
                    Seo::getSeoKey('shops', app()->getLocale()),
                    app()->getLocale(),
                    $currentCat
                )
            ]
        );
    }

    /**
     * Shop listga scroll paginatsiya bo'lganda itemlarni qaytaradi.
     * Map va list uchunham shu funksiya ishlaydi
     * Map va listlar typga qarab ajratib olinadi
     *
     * @param Request $request
     * @return array
     * @throws \Throwable
     */
    public function listPage(Request $request)
    {
        $catKey = $request->category != 'all' ? $request->category : '';
        $type = $request->type;
        $sorting = $request->sorting;
        $page = $request->page;
        $currentCat = ShopCategories::where(['keyword' => $catKey])->first();
        $shopsList = Shops::getShopList($currentCat, $sorting, $page);
        $view = $type == 'map' ? 'shops.pagination.pagination_map': 'shops.pagination.pagination_list';
        return [
            'status' => 'success',
            'itemCount' => count($shopsList),
            'msg' => view($view)->with(compact('shopsList'))->render(),
        ];
    }

    /**
     * Do'konlarni xarita orqali ko'rish bo'limi
     *
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function map(Request $request)
    {
        $currentCat = ShopCategories::where(['keyword' => $request->category])->first();
        $page = $request->page ?: 1;
        $categories = Caching::getShopCategoriesListCache();
        $shopsList = Shops::getShopList($currentCat, $request->sorting, $page);
        $parameters = request()->input();
        $sortingName = $request->sorting == 'popular' ? trans('messages.Popular shops') : trans('messages.New shops');
        $langs = Additional::getLangs();
        $brands = Additional::getBrandList();
        $segmants = Additional::getUrlSegmants(request()->segments());

        return view(
            'shops.map',
            [
                'segmants' => $segmants,
                'categories' => $categories,
                'catKey' => $request->category,
                'currentCat' => $currentCat,
                'shopsList' => $shopsList,
                'brands' => $brands,
                'langs' => $langs,
                'parameters' => $parameters,
                'sortingName' => $sortingName,
                'seo' => Seo::getMetaShopCategory(
                    Seo::getSeoKey('shops', app()->getLocale()),
                    app()->getLocale(),
                    $currentCat
                ),
                'page' => $page + 1,
            ]
        );
    }


    protected function infoShop(Request $request){
        $keyword = $request->keyword;
        $shop = Shops::where(['keyword' => $keyword])
            ->where('status', '!=', Shops::STATUS_DELETED)
            ->with(['districts', 'sections', 'slides', 'ratings', 'subscribers', 'rating', 'comments'])
            ->withCount('comments')
            ->firstOrFail();
        if ($shop->status != Shops::STATUS_ACTIVE) {
            if (!auth()->check() || (auth()->id() != $shop->user_id)) {
                abort(404);
            }
        }
        $premium = Caching::premiumItems();
        shuffle($premium);
        $shop->increment('view_count');
        $card = $shop->viewShop('', false);
//        dd($card);
        return [
            'shop_id' => $shop->id,
            'segmants' => Additional::getUrlSegmants(request()->segments()),
            'shop' => $card,
            'category_list' => Additional::getTopCategories(),
            'langs' => Additional::getLangs(),
            'banner' => [],
            'seo' => Seo::getMetaShopView(Seo::getSeoKey('shops', app()->getLocale()), $card, app()->getLocale()),
            'premium_item' => $premium ? $premium[0] : false,
        ];
    }

    /**
     * Do'konni ko'rish oynasi (View)
     *
     * @param Request $request
     * @return mixed
     */
    public function view(Request $request)
    {
        $result = $this->infoShop($request);
        $page = $request->page ?: 1;
        $result += ['items' => Items::getShopItems($result['shop_id'], $page, $request), 'page' => $page + 1];
        return view(
            'shops.view',
            $result
        );
    }


    public function about(Request $request)
    {
        return view(
            'shops.about_shop',
            $this->infoShop($request)
        );
    }

    public function portfolio(Request $request)
    {
        return view(
            'shops.view_portfolio',
            $this->infoShop($request)
        );
    }

    /**
     * Foydalanuvchi o'z do'konlari ro'yxatini ko'rayotganda keyingi pagelarni ochish.
     * User scroll qilganda avtomatik qoshilib boradi.
     * Ajax so'rov qabul qilinadi
     *
     * @param Request $request
     * @return array
     */
    public function userListPage(Request $request)
    {
        $items = Items::getShopItems($request->shop, $request->page, $request);
        try {
            return [
                'status' => 'success',
                'itemCount' => count($items),
                'msg' => view('shops.shop_card_item_list')->with(['items' => $items])->render(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 'success',
                'itemCount' => count($items),
            ];
        }
    }

    /**
     * Userning do'konlar ro'yxati
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shopsList()
    {
        $user = Auth::user();
        $shopsList = Shops::getUserShopList($user);
        return view('shops.user-shop-list', compact('user', 'shopsList'));
    }


    /**
     * Tarif rejasiga mos periodlar listini yuboradi
     *
     * @param Request $request
     * @return array
     */
    public function getTerm(Request $request)
    {
        $periods = ShopsAbonementPeriod::where(['abonement_id' => $request->id])->get();
        $str = '';
        $summary = null;
        $date = null;
        $i = 0;
        foreach ($periods as $value) {
            $str .= '<option value="' . $value->id . '">' . $value->month . ' ' . trans('messages.month') . '</option>';
            if ($i == 0) {
                $summary = str_replace('{term_sum}', $value->total_price, trans('messages.Term summary'));
                $date = str_replace(
                    '{term_date}',
                    date('d.m.Y', strtotime($value->month . " months", time())),
                    trans('messages.Term date')
                );
            }
            $i++;
        }
        return [
            'str' => $str,
            'summary' => $summary,
            'date' => $date,
        ];
    }


    /**
     * Shopda tarifni periodini tanlaganda mos narhlar listini aytarish uchun funksiya
     *
     * @param Request $request
     * @return array|null[]
     */
    public function setTermPrices(Request $request)
    {
        $period = ShopsAbonementPeriod::where(['id' => $request->id])->first();
        if ($period != null) {
            return [
                'summary' => str_replace('{term_sum}', $period->total_price, trans('messages.Term summary')),
                'date' => str_replace(
                    '{term_date}',
                    date('d.m.Y', strtotime($period->month . " months", time())),
                    trans('messages.Term date')
                ),
            ];
        }
        return [
            'summary' => null,
            'date' => null,
        ];
    }

    /**
     * magazin yaratishda ishlatiladigan forma
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $user = Auth::user();
        $additional = new Additional();
        $model = new Shops();
        $model->coordinate_x = config('app.coordinate_x');
        $model->coordinate_y = config('app.coordinate_y');
        $settings = Settings::where(['key' => 'shops_phones_limit'])->first();
        $abonements = ShopsAbonements::where(['enabled' => 1])->orderBy('id', 'asc')->with(['period'])->get();
        $categories = ShopCategories::getList();
        $socialNetworks = SocialNetworks::getSocialFullList();

        return view(
            'shops.create',
            [
                'user' => $user,
                'model' => $model,
                'abonements' => $abonements,
                'categories' => $categories,
                'socialNetworks' => $socialNetworks,
                'regDistricts' => $additional->regDistricts(),
                'settings' => $settings,
            ]
        );
    }

    /**
     * Do'kon tahrirlash uchun mahsus formani qaytarish
     *
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $additional = new Additional();
        $model = Shops::where(['keyword' => $request->keyword, 'user_id' => $user->id])->firstOrFail();

        $model->phones = json_decode(json_decode($model->phones)) ?: [];
        $model->socialNetworksValues = $model->socialNetworksValues();
        $model->socialNetworks = $model->socialNetworks();
        $model->category = $model->getCategoryName();
        $abonements = ShopsAbonements::where(['enabled' => 1])->with(['period'])->get();
        $categories = ShopCategories::getList();
        $socialNetworks = SocialNetworks::getSocialFullList();
        $settings = Settings::where(['key' => 'shops_phones_limit'])->first();

        return view(
            'shops.update',
            [
                'user' => $user,
                'model' => $model,
                'abonements' => $abonements,
                'categories' => $categories,
                'socialNetworks' => $socialNetworks,
                'regDistricts' => $additional->regDistricts(),
                'settings' => $settings,
            ]
        );
    }

    /**
     * Foydalanuvchi o'zi yaratgan do'konni ochirmoqchi bo'lganda ishga tushadigan funksiya
     * Do'kon foydalanuvchiga tegishli ekanlgi tasdiqlansa do'kon statusi o'chirilgan deb belgilanadi (Soft delete)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $model = Shops::where(['id' => $request->keyword, 'user_id' => Auth::user()->id])->first();
        if(!$model) abort(403);
        $model->status = Shops::STATUS_DELETED;
        $model->save();
        return redirect()->route('shops-success-deleted');
    }

    /**
     * Do'kon o'chirilgandan keyin foydalalnuvchiga maxsus xabarni ko'rsatish funksiyasi
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function successDeleted()
    {
        $user = Auth::user();
        return view('shops.success-deleted',['user' => $user]);
    }

    /**
     * Yangi do'kon yaratish uchun forma orqali post malumotlar jo'natiladi
     * bu yerda malumotlar tekshirishdan o'tib tasdiqlansa saqlanadi aks xolda xatolik xabari qaytariladi
     *
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $user = Auth::user();
        $this->shopValidator($request->all(), $user)->validate();
        $shop = new Shops();
        $shop->user_id = $user->id;
        $shop->name = $request->name;
        $shop->keyword = Str::slug($request->name);
        $shop->status = $shop::STATUS_MODERATION;
        $shop->description = $request->description;
        $shop->district_id = $request->district_id;
        $shop->address = $request->address;
        $shop->coordinate_x = $request->coordinate_x;
        $shop->coordinate_y = $request->coordinate_y;
        $shop->work_time = $request->work_time_begin . '-'. $request->work_time_end;
        if (isset($request->phones[0])) {
            $shop->phone = $request->phones[0];
        }
        if ($request->phones != null) {
            $shop->phones = json_encode(json_encode($request->phones));
        }
        $shop->site = $request->site;
        $shop->blocked_reason = null;
        $shop->admin_comment = null;
        $shop->social_networks = $shop->setSocialNetworks($request->socialNetworksValues, $request->socialNetworks);
        $shop->status_changed = date('Y-m-d H:i:s');
        $shop->view_count = 0;
        if ($request->temp_address) {
            $shop->setLogo($request->temp_address);
        }
        if ($request->temp_address_cover) {
            $shop->setCover($request->temp_address_cover);
        }
        if ($shop->save()) {
            $period = ShopsAbonementPeriod::where(['id' => $request->term])->first();
            $api = file_get_contents_curl(
                "https://api.bisyor.uz/api/v1/additional/create-bill?user_id=$user->id&type=5&abonement_id=$request->tariff&shop_id=$shop->id&abonement_period=$period->id"
            );
            if (json_decode($api, true)['status']) {
                ShopsTariff::create([
                    'abonement_id' => $request->tariff,
                    'shop_id' => $shop->id,
                    'status' => ShopsTariff::STATUS_ACTIVE,
                    'data_access' => date('Y-m-d', strtotime($period->month . " months", time())),
                    'price' => $period->total_price,
                ]);
            }
            if ($request->category) {
                foreach ($request->category as $value) {
                    $shopSection = new ShopsSections();
                    $shopSection->shop_id = $shop->id;
                    $shopSection->section_id = $value;
                    $shopSection->save();
                }
            }
        }
        return redirect()->route('set-services-shop', ['id' => $shop->id]);
    }

    /**
     * Do'konni tahrirlashda foydalanuvchi tomonidan jo'natilgan malumotlarni saqlab olish
     * hamda sahifani muvffaqiyatli saqlandi xabariga yo'naltirish
     *
     * @param Request $request
     * @return mixed
     */
    public function saveUpdate(Request $request)
    {
        $shop = Shops::where(['id' => $request->id])->first();
        $this->shopUpdateValidator($request->all(), $shop)->validate();

        $shop->name = $request->name;
        $shop->keyword = Str::slug($request->name);
        $shop->description = $request->description;
        $shop->district_id = $request->district_id;
        $shop->address = $request->address;
        $shop->coordinate_x = $request->coordinate_x;
        $shop->coordinate_y = $request->coordinate_y;
        if (isset($request->phones[0])) {
            $shop->phone = $request->phones[0];
        }
        $shop->work_time = $request->work_time_begin . '-'. $request->work_time_end;
        $shop->phones = json_encode(json_encode($request->phones));
        $shop->site = $request->site;
        $shop->telegram_channel = $request->telegram_channel;
        $shop->social_networks = $shop->setSocialNetworks($request->socialNetworksValues, $request->socialNetworks);
        $shop->view_count = 0;
        if ($request->temp_address) {
            Storage::disk('ftp')->delete($uploadPath = config('app.shopsRoute') . $shop->logo);
            $shop->setLogo($request->temp_address);
        }
        if ($request->temp_address_cover) {
            if($shop->cover){
                Storage::disk('ftp')->delete($uploadPath = config('app.shopsRoute') . $shop->cover);
            }
            $shop->setCover($request->temp_address_cover);
        }

        if ($shop->save()) {
            if ($request->category) {
                ShopsSections::where(['shop_id' => $shop->id, /*'section_id' => $request->category*/])->delete();
                foreach ($request->category as $value) {
                    $shopSection = new ShopsSections();
                    $shopSection->shop_id = $shop->id;
                    $shopSection->section_id = $value;
                    $shopSection->save();
                }
            }
        }

        return redirect()->route('set-services-shop', ['id' => $shop->id]);
    }

    /**
     * Do'kon muvaffaqiyatli saqlandi xabarini chiqarish funksiyasi
     *
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function successCreated(Request $request)
    {
        $user = Auth::user();
        $shop = Shops::where(['id' => $request->id, 'user_id' => $user->id])->first();

        if ($shop == null) {
            return abort(404);
        }

        return view(
            'shops.success-created',
            [
                'user' => $user,
                'shop' => $shop,
            ]
        );
    }

    /**
     * Do'kon muvaffaqiyatli tahrirlandi xabarini chiqarish uchun funksiya
     *
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function successSaved(Request $request)
    {
        $user = Auth::user();
        $shop = Shops::where(['id' => $request->id, 'user_id' => $user->id])->first();

        if ($shop == null) {
            return abort(404);
        }

        return view(
            'shops.success-saved',
            [
                'user' => $user,
                'shop' => $shop,
            ]
        );
    }


    /**
     * Yangi do'kon qo'shayotganda validatsiyadan o'tkazish
     *
     * @param array $data
     * @param $user
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function shopValidator(array $data, $user)
    {
        $validator = Validator::make(
            $data,
            [
                'tariff' => ['required'],
                'name' => ['required', 'string', 'unique:shops'],
                'category' => ['required'],
                'term' => ['required'],
                'profile_image' => 'image|max:3000',
            ]
        );

        $validator->after(
            function ($validator) use ($data, $user) {
                if (isset($data['tariff'])) {
                    $period = ShopsAbonementPeriod::where(
                        ['id' => $data['term']]
                    )->first();
                    if (isset($period) && $period->total_price > $user->balance) {
                        $validator->errors()->add('tariff', trans('messages.Empty balance'));
                    }
                }
            }
        );

        return $validator;
    }

    /**
     * Do'konni tahrirlashda uni validatsiya qilish uchun funksiya
     *
     * @param array $data
     * @param $shop
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function shopUpdateValidator(array $data, $shop)
    {
        $validator = Validator::make(
            $data,
            [
                'name' => ['required', 'string'],
                'category' => ['required'],
                'profile_image' => 'image|max:3000',
            ]
        );

        $validator->after(
            function ($validator) use ($data, $shop) {
                if ($shop->name != $data['name']) {
                    $newShop = Shops::where(['name' => $data['name']])->first();
                    if ($newShop != null) {
                        $validator->errors()->add('name', trans('validation.unique'));
                    }
                }
            }
        );

        return $validator;
    }

    /**
     * Forma orqali tanlangan rasmni serverga yuklab olish
     * Bunda vaqtincha papkaga yuklanadi rasm
     *
     * @param Request $request
     * @return string
     */
    public function uploadImage(Request $request)
    {
        $file = $request->file();
        $file_name_to_store = $request->post('names');
        $uploadPath = config('app.trashRoute') . $file_name_to_store;

        foreach ($file as $value) {
            Storage::disk('ftp')->put($uploadPath, fopen($value, 'r+'));
        }
        return $uploadPath;
    }

    /**
     * Servislar ulash uchun do'konlar hizmatlar to'plamini yuboradi
     *
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function services(Request $request)
    {
        $user = Auth::user();
        $model = Shops::where(['id' => $request->id, 'user_id' => $user->id])->first();
        if (!$model) {
            abort(404);
        }

        $services = Services::where(['module' => 'shops', 'enabled' => 1,])
            ->orderBy('type', 'ASC')
            ->orderBy('sorting', 'ASC')->get();

        return view(
            'shops.services.services',
            [
                'services' => $services,
                'model' => $model,
                'status' => 'added'
            ]
        );
    }

    /**
     * Servislarni biriktirish uchun funksiya
     * servislar shaxsiy balans yoki to'lov usullari bilan sotib olinadi
     *
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function servicesAdd(Request $request)
    {
        $user = Auth::user();
        $lang = app()->getLocale();
        if ($request->services == 0) {
            return redirect()->route('profile-shops-list');
        }

        $services = Services::find($request->services);
        $model = Shops::where(['id' => $request->id, 'user_id' => $user->id])->first();
        if (!$model) {
            abort(404);
        }


        $payment_method = $request->payment_method;

        if ($payment_method === 'm1my') {
            if ($user->balance - $services->price < 0) {
                $services = Services::where(['module' => 'shops', 'enabled' => 1])->orderBy('type', 'ASC')->orderBy(
                    'sorting',
                    'asc'
                )->get();
                return view(
                    'shops.services.services',
                    [
                        'services' => $services,
                        'model' => $model,
                        'status' => 'error'
                    ]
                );
            }
            $api = "https://api.bisyor.uz/api/v1/additional/create-bill?user_id=" . $user->id . "&amount=" . $services->price . "&type=5&item_id=" . $model->id . "&service_id=" . $services->id . "&lang=" . $lang;
            $json = file_get_contents_curl($api);
            $json = json_decode($json, true);

            return view(
                'items.services.message',
                [
                    'status' => $json['status'] ? 'success' : 'error',
                    'message' => $json['message'],
                    'user' => $user
                ]
            );
        } elseif ($payment_method === 'm1er') {
            $api = "https://api.bisyor.uz/api/v1/additional/create-bill?user_id=" . $user->id . "&amount=" . $services->price . "&type=1&item_id=" . $model->id . "&service_id=" . $services->id . "&lang=" . app(
                )->getLocale();
        } elseif ($payment_method === 'm2sev') {
            $api = "https://api.bisyor.uz/api/v1/additional/create-bill?user_id=" . $user->id . "&psystem=146&amount=" . $services->price . "&type=1&item_id=" . $model->id . "&service_id=" . $services->id . "&lang=" . app(
                )->getLocale();
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
     * Do'kon ustidan shikoyat qilish funksiyasi
     * Istalgan foydalanuvchi bir necha marta shikoyat qoldirishi mumkin
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setShopClaim(Request $request)
    {
        $model = new ShopsClaims();
        $model->beforeSave($request);
        $model->shop_id = $request->shop_id;
        $model->reason = $request->reason;
        if ($request->reason == 3) {
            $model->message = $request->message;
        }
        if ($model->save()) {
            return redirect()->back()->with('success-changed', trans('messages.Successfully sended'));
        }
        return redirect()->back();
    }

    /**
     * Do'konga foydalanuvchilar obuna bo'lishi mumkun, bir foydalanuvchi obuna bo'lish yoki bo'lmasa obunani
     * bekor qilishi mumkin
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function subscribe(Request $request)
    {
        $shop_id = $request->id;
        $shop = Shops::where(['id' => $shop_id])->first();
        if($shop == null) return redirect()->route('site-index');

        $user = Auth::user();
        $subscribe = ShopsSubscribers::where(['user_id' => $user->id, 'shop_id' => $shop_id])->first();
        if ($subscribe) {
            $subscribe->delete();
        } else {
            ShopsSubscribers::updateOrCreate(
                ['user_id' => $user->id, 'shop_id' => $shop_id],
                [
                    'user_id' => $user->id,
                    'shop_id' => $shop_id,
                    'date_cr' => date('Y-m-d H:i:s')
                ]
            );
        }

        return redirect()->back();
    }

    /**
     * Do'konga reyting baholash uchun
     * Faqat ro'yxatdan o'tgan foydalanuvchilar uchun ishlaydi
     * Bir foydalanuvchi bir marotaba baholaydi, keyingi safarlarda uni o'zgartirishi mumkun
     *
     * @param Request $request
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function shopRating(Request $request)
    {
        if(auth()->check()){
            $shop_id = $request->shop_id;
            $ball = $request->rating;
            ShopsRating::updateOrCreate(
                ['user_id' => auth()->id(), 'shop_id' => $shop_id],
                ['user_id' => auth()->id(), 'shop_id' => $shop_id, 'ball' => $ball <= 5 ? $ball : 5]
            );
        }
        if($request->message){
            ShopsComment::create(
                [
                    'enabled' => false,
                    'text' => $request->message,
                    'shop_id' => $request->shop_id,
                    'user_ip' => $request->ip(),
                    'fio' => auth()->check() ? auth()->user()->getUserFio() : '',
                ]
            );
        }
        return back();
    }

    public function getShopComment(Request $request)
    {
        $keyword = $request->keyword;
        $shop = Shops::where(['keyword' => $keyword, 'status' => 1])
            ->with(['districts', 'sections', 'slides', 'ratings', 'subscribers', 'rating', 'comments'])->firstOrFail();
        $segmants = Additional::getUrlSegmants(request()->segments());
        $langs = Additional::getLangs();
        $card = $shop->viewShop(false, false);
        return redirect()->route('shops-view', $keyword);
        /*return view(
            'shops.view',
            [
                'segmants' => $segmants,
                'shop' => $card,
                'langs' => $langs,
                'seo' => Seo::getMetaShopView(Seo::getSeoKey('shops', app()->getLocale()), $card, app()->getLocale()),
            ]
        );*/
    }


    /**
     * Do'konga tegishli slayderlar ro'yxatini olish uchun
     * Do'kon userga tegishli ekanligi tekshiriladi
     * Tasdiqdan so'ng sliderlar listi qaytariladi
     *
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sliders(Request $request)
    {
        $user = Auth::user();
        $shop = Shops::where(['user_id' => $user->id, 'id' => $request->shop_id])->first();
        if (!$shop) {
            abort(404);
        }
        return view(
            'shops.sliders.sliders',
            [
                'user' => Auth::user(),
                'shop' => $request->shop_id,
                'sliders' => ShopSlider::whereShopId($shop->id)->get()
            ]
        );
    }

    /**
     * Yangi slider qo'shish uchun funskiya
     * shop id bo'yicha tekshiruvdan o'tkaziladi
     *
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sliderCreate(Request $request)
    {
        $user = Auth::user();
        $shop = Shops::where(['id' => $request->shop_id, 'user_id' => $user->id])->first();
        if (!$shop) {
            abort(404);
        }
        return view('shops.sliders.slider_create', ['user' => $user, 'shop' => $request->shop_id]);
    }

    /**
     * Slayderni saqlash post metodi
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sliderSave(Request $request)
    {
        $user = Auth::user();
        $this->sliderValidator($request->all(), $user)->validate();
        $shop = Shops::where('id', $request->shop)->first();
        if (!$shop) {
            abort(404);
        }
        $model = new ShopSlider();
        $model->setData($request->all(), $shop->id);
        return redirect()->route('shops-sliders', ['shop_id' => $request->shop]);
    }

    /**
     * Sliderlarni tahrirlash
     * Slider tegishli bo'lgan magazin userga tegishli ekanligi tasdiqlanadi
     * Methodlar bo'yicha yangilash formasini qaytaradi yoki kelgan datani saqlab sliderlar ro'yxatiga qaytariladi
     *
     * @param Request $request
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function sliderUpdate(Request $request)
    {
        $user = Auth::user();
        $slider = ShopSlider::whereId($request->slider_id)->with('shops')->first();
        if ($slider->shops->user_id !== $user->id) {
            abort(404);
        }
        if ($request->isMethod('post')) {
            $this->sliderValidator($request->all(), $user)->validate();
            $slider->setData($request->all());
            return redirect()->route('shops-sliders', ['shop_id' => $slider->shops->id]);
        }
        return view('shops.sliders.slider_update', ['user' => $user, 'slider' => $slider]);
    }

    /**
     * Slider qo'shilganda validatsiya qilinadi
     * Update xolatida rasm reqiured so'ralmaydi
     *
     * @param array $data
     * @param $user
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function sliderValidator(array $data, $user)
    {
        $rule = [
            'title' => ['required', 'string'],
            'text' => ['required'],
            'link' => ['required']
        ];
        if(empty($data['temp_address'])){
            $rule += ['profile_image' => isset($data['shop']) ? 'required|image|max:3000' : 'image|max:3000'];
        }

        $validator = Validator::make($data, $rule);
        $validator->after(
            function ($validator) use ($data, $user) {
                if (isset($data['shop'])) {
                    if (!Shops::where(['id' => $data['shop'], 'user_id' => $user->id])->first()) {
                        $validator->errors()->add('shop', trans('messages.Wrong shop'));
                    }
                }
            }
        );
        return $validator;
    }


    /**
     * Magazinga qo'shilgan slayderni o'chirish uchun action
     * slider_id get parametr orqali keladi, kelgan id bo'yicha shunday slider va shop bor ekanligini
     * tekshiriladi xamda bu magazin userga tegishli ekanligi tasdiqlansa o'chirishga ruhsat beriladi
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSlider(Request $request)
    {
        $slider = ShopSlider::whereId($request->slider_id)->first();
        $user = Auth::user();
        $shop = Shops::where(['id' => $slider->shop_id, 'user_id' => $user->id])->first();
        if (!$shop) {
            abort(404);
        }
        try {
            $slider->delete();
        } catch (\Exception $e) {
            abort(404);
        }
        return redirect()->route('shops-sliders', ['shop_id' => $shop->id]);
    }
}
