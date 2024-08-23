<?php

namespace App\Models\References;

use DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Request;
use App\User;
use App\Models\Items\Services;
use App\Models\References\Lang;
use App\Models\Items\Favorites;
use App\Models\Items\Categories;
use App\Models\References\MessageSend;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Models\References\Caching;

class Additional
{
    public $list;

    /**
     * Gender types
     */
    const MAN = 1;
    const WOMAN = 2;

    /**
     * Regionlarga bog'langan tumanlarni qaytarish
     *
     * @return mixed
     */
    public static function regDistricts()
    {
        $regions = self::regDistrictsAsArray();

        if (app()->getLocale() == self::defaultLang()) {
            foreach ($regions as $reg) {
                $distResult = [];
                foreach ($reg['districts'] as $district) {
                    $distResult [] = [
                        'id' => $district['id'],
                        'name' => $district['name'],
                        'keyword' => $district['keyword'],
                        'declination' => $district['declination'],
                    ];
                }

                array_multisort(array_column($distResult, 'name'), SORT_ASC, $distResult);
                $result [] = [
                    'id' => $reg['id'],
                    'name' => $reg['name'],
                    'keyword' => $reg['keyword'],
                    'declination' => $reg['declination'],
                    'districtsList' => $distResult,
                ];
            }
            array_multisort(array_column($result, 'name'), SORT_ASC, $result);
            return $result;
        } else {
            foreach ($regions as $reg) {
                $distResult = [];
                foreach ($reg['districts'] as $district) {
                    $distResult [] = [
                        'id' => $district['id'],
                        'name' => isset($district['translate']) ? $district['translate']['field_value'] : $district['name'],
                        'keyword' => $district['keyword'],
                        'declination' => isset($district['translate_dec']) ? $district['translate_dec']['field_value'] : $district['declination'],
                    ];
                }
                array_multisort(array_column($distResult, 'name'), SORT_ASC, $distResult);
                $result [] = [
                    'id' => $reg['id'],
                    'keyword' => $reg['keyword'],
                    'name' => isset($reg['translate']) ? $reg['translate']['field_value'] : $reg['name'],
                    'declination' => isset($reg['translate_dec']) ? $reg['translate_dec']['field_value'] : $reg['declination'],
                    'districtsList' => $distResult,
                ];
            }
            array_multisort(array_column($result, 'name'), SORT_ASC, $result);
            return $result;
        }
    }

    /**
     * Tasdiqlash kodini yuborish funksiyasi
     * Emailga yoki bo'lmasa telefon raqamiga
     *
     * @param $login
     * @return int
     * @throws \Exception
     */
    public function sendRetryVerifyCode($login)
    {
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $login)->first();
            if ($user != null) {
                $user->sms_code = random_int(10000, 99999);
                $user->save();

                $msg = new MessageSend();
                $msg->sendMessageToEmail($login, 'Code: ' . $user->sms_code, "Код подтверждении");
            } else {
                return 0;
            }
        } else {
            $user = User::where('phone', str_replace('-', '', $login))->first();
            if ($user != null) {
                $user->sms_code = random_int(10000, 99999);
                $user->save();

                $msg = new MessageSend();
                $token = $msg->getSmsAccessToken();
                $msg->sendSms(str_replace('+', '', (string)$user->phone), 'Code: ' . $user->sms_code, $token);
            } else {
                return 0;
            }
        }
        return 1;
    }

    /**
     * Odatiy tilni qaytrish funksiyasi
     *
     * @return string
     */
    public static function defaultLang()
    {
        return 'ru';
    }

    /**
     * Login uchun havolani olish
     *
     * @return string
     */
    public static function getLoginUrl()
    {
        $url = '';
        $glRgnKeyword = self::getGlobalRegionKeyword();
        $curLang = self::getCurrentLang();
        if ($curLang != null && $curLang != self::defaultLang()) {
            $url .= $curLang;
        }
        if ($glRgnKeyword != null) {
            $url .= '/' . $glRgnKeyword;
        }
        return $url;
    }

    /**
     * Global regionlar o'zgartirlganda ularni cookiega saqlash
     *
     * @param $keyword
     */
    public static function setGlobalRegionKeyword($keyword)
    {
        config(['app.glRegionKey' => $keyword]);
        Cookie::queue('globalRegionKeyword', $keyword, 1440);
    }

    /**
     * Faylga yuklangan region keywordni olish
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public static function getGlobalRegionKeyword()
    {
        return config('app.glRegionKey');
    }

    /**
     * Cookieda joylashgan global region keywordni olish
     *
     * @return array|string|null
     */
    public static function getGlbReg()
    {
        return Cookie::get('globalRegionKeyword');
    }

    /**
     * Ro'yxatdan o'tmagan userlarga sevimlilariga qo'shish
     */
    public static function setNoAuthUserFavoritesItems()
    {
        $array = Session::get('noAuthUserFavorites');
        if ($array != null) {
            foreach ($array as $item_id) {
                Favorites::setFavorite($item_id, 1);
            }
        }
        Session::put('noAuthUserFavorites', []);
    }

    /**
     * Ro'yxatdan o'tmagan userlarga sevimlilariga qo'shish
     */
    public static function setNoAuthUserFavoritesText()
    {
        $userSavedText = json_decode(Cookie::get('userSavedText'), true);
        if (is_array($userSavedText)) {
            foreach ($userSavedText as $value) {
                Favorites::setFavoriteText($value['search_text']);
            }
        }
    }

    /**
     * Barcha faool tillarni olish
     *
     * @return string[]
     */
    public static function getAllActiveLangList()
    {
        return array('ru', 'uz', 'en', 'oz');
        //return \Config::get('app.all_langs');

    }

    /**
     * Odaiy tilni o'zgartirish
     *
     * @param $lang
     * @return array|string|null
     */
    public static function setCurrentLang($lang)
    {
        Cookie::queue('lang', $lang, 43200);
        return Cookie::get('lang');
    }


    /**
     * Hozirgi tilni olish
     *
     * @return array|string|null
     */
    public static function getCurrentLang()
    {
        return Cookie::get('lang');
    }

    /**
     * Tillarni olish
     *
     * @return mixed
     */
    public static function getLangs()
    {
        return Caching::getLangs();
    }

    /**
     * Eng yuqoridagi bo'limlarni qaytarish
     * Statik fayldan
     *
     * @return array|mixed
     */
    public static function getTopCategories()
    {
        $filename = base_path() . '/resources/views/static/top-categories/categories-' . app()->getLocale() . '.php';

        if (file_exists($filename)) {
            $array = file_get_contents($filename);
            return json_decode($array, true);
        } else {
            $categories = Categories::where(['numlevel' => 1, 'enabled' => 1])->with(['translates'])
                ->orderBy('sorting', 'asc')->get();
            $result = [];
            foreach ($categories as $category) {
                $title = $category->title;
                if (app()->getLocale() != Additional::defaultLang()) {
                    $translate = $category->translates;
                    if ($translate != null) {
                        $title = $translate->field_value;
                    }
                }
                $result [] = $category->getCategory();
            }

            $destination = base_path() . '/resources/views/static/top-categories/categories-' . app()
                    ->getLocale() . '.php';
            $toJson = json_encode($result);

            $file = fopen($destination, "w+");
            fputs($file, $toJson);
            fclose($file);

            return $result;
        }
    }

    /**
     * Headerdagi bo'limlarni qaytarish
     *
     * @return array|mixed
     */
    public static function headerCategories()
    {
        $filename = base_path() . '/resources/views/static/header/top-menu-' . app()->getLocale() . '.php';

        // Add each line to an array
        if (file_exists($filename)) {
            $array = file_get_contents($filename);
            return json_decode($array, true);
        } else {
            $cats = Categories::where(['numlevel' => 1, 'enabled' => 1])->with(['children', 'translates'])->orderBy(
                'sorting',
                'asc'
            )->get();
            $result = [];
            foreach ($cats as $value) {
                $title = $value->title;
                if (app()->getLocale() != Additional::defaultLang()) {
                    $translate = $value->translates;
                    if ($translate != null) {
                        $title = $translate->field_value;
                    }
                }

                $result [] = [
                    'id' => $value->id,
                    'title' => $title,
                    'numlevel' => $value->numlevel,
                    'icon_b' => $value->bigImage(),
                    'icon_s' => $value->smallImage(),
                    'keyword' => $value->keyword,
                    'keyword_edit' => $value->keyword_edit,
                    'parent_id' => $value->parent_id,
                    'secondMenu' => $value->getSecond($value->children),
                ];
            }

            $destination = base_path() . '/resources/views/static/header/top-menu-' . app()->getLocale() . '.php';
            $toJson = json_encode($result);

            $file = fopen($destination, "w+");
            fputs($file, $toJson);
            fclose($file);

            return $result;
        }
    }

    /**
     * Sayt xaritasiga kategoriyalarni chiqarish
     *
     * @return array
     */
    public static function categoriesSiteMap()
    {
        $cats = Categories::where(['numlevel' => 1, 'enabled' => 1])->with(['children', 'translates'])
            ->orderBy('sorting', 'asc')->get();
        $result = [];
        foreach ($cats as $value) {
            $title = $value->title;
            if (app()->getLocale() != Additional::defaultLang()) {
                $translate = $value->translates;
                if ($translate != null) {
                    $title = $translate->field_value;
                }
            }

            $result [] = [
                'id' => $value->id,
                'title' => $title,
                'numlevel' => $value->numlevel,
                'icon_b' => $value->bigImage(),
                'icon_s' => $value->smallImage(),
                'keyword' => $value->keyword,
                'keyword_edit' => $value->keyword_edit,
                'secondMenu' => Categories::getCatItemCount($value),
            ];
        }
        return $result;
    }

    /**
     * Mintaqa va tumanlarni elonlarga bo'glab olish
     *
     * @return array
     */
    public static function regDistrictsAsItems()
    {
        return Regions::with(['districtsItem', 'translate', 'translateDec'])
            ->orderBy('name', 'asc')->get()->toArray();
    }

    /**
     * Brandlar listini olish
     *
     * @return mixed
     */
    public static function getBrandList()
    {
        return Brands::where(['enabled' => 1])->get();
    }

    /**
     * Ijtimoiy tarmoqlar ro'yxatini olish
     *
     * @return mixed
     */
    public static function getSocialList()
    {
        return Caching::getSocialList();
        //return SocialNetworks::where(['status' => 1])->get();
    }

    /**
     * Tuman va viloyatlarni array  ko'rinishida yuklab olish
     *
     * @return array|mixed
     */
    public static function regDistrictsAsArray()
    {
        $filename = base_path() . '/resources/views/static/global-regions/region-' . app()->getLocale() . '.php';

        if (file_exists($filename)) {
            $array = file_get_contents($filename);
            return json_decode($array, true);
        } else {
            $destination = base_path() . '/resources/views/static/global-regions/region-' . app()->getLocale() . '.php';
            $regions = Regions::with(['districts', 'translate', 'translateDec'])->orderBy('name', 'asc')->get(
            )->toArray();
            $toJson = json_encode($regions);

            $file = fopen($destination, "w+");
            fputs($file, $toJson);
            fclose($file);

            return $regions;
        }
    }

    /**
     * Region keywordlarni olish
     *
     * @return array
     */
    public static function getRegionKeywordList()
    {
        $result = [];
        $regions = self::regDistrictsAsArray();
        foreach ($regions as $region) {
            $result [] = $region['keyword'];
            foreach ($region['districts'] as $district) {
                $result [] = $district['keyword'];
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    public static function getItemsPostDatas()
    {
        $result = [
            "only_photo" => 0,
            "owner_private_search" => 0,
            "owner_business_search" => 0,
            "sorting" => 'new',
            "price_f" => '',
            "price_t" => '',
            "price_c" => '',
            "price_search_f" => "",
            "price_search_t" => "",
            "price_text" => trans('messages.Not important'),
            "d" => null,
        ];

        return $result;
    }

    /**
     * @return mixed
     */
    public static function getDynpropSearch()
    {
        if (Session::get('dynpropSearch') == null) {
            Session::put('dynpropSearch', null);
        }
        return Session::get('dynpropSearch');
    }

    /**
     * Region district olish
     *
     * @return array
     */
    public static function getRegionsDistrict()
    {
        $distId = [];
        $keyword = self::getGlobalRegionKeyword();

        if ($keyword != '') {
            $regions = Additional::regDistrictsAsArray();
            foreach ($regions as $region) {
                if ($region['keyword'] == $keyword) {
                    foreach ($region['districts'] as $district) {
                        $distId [] = $district['id'];
                    }
                    return $distId;
                } else {
                    foreach ($region['districts'] as $district) {
                        if ($district['keyword'] == $keyword) {
                            $distId [] = $district['id'];
                            return $distId;
                        }
                    }
                }
            }
        }
        return $distId;
    }

    /**
     * Global Regiondan region va districtni aniqlash
     *
     * @return array
     */
    public static function getGlRegionDistrict()
    {
        $result = [
            'region_id' => null,
            'district_id' => null
        ];
        $keyword = self::getGlobalRegionKeyword();

        if ($keyword != '') {
            $regions = Additional::regDistrictsAsArray();
            foreach ($regions as $region) {
                if ($region['keyword'] == $keyword) {
                    $result['region_id'] = $region['id'];
                    return $result;
                } else {
                    foreach ($region['districts'] as $district) {
                        if ($district['keyword'] == $keyword) {
                            $result['region_id'] = $region['id'];
                            $result['district_id'] = $district['id'];
                            return $result;
                        }
                    }
                }
            }
        }
        return $result;
    }

    /**
     * Rss uchun region va distrctlar bor
     *
     * @param $region_id
     * @param $district_id
     * @return array
     */
    public static function getRegionsDistrictForRss($region_id, $district_id)
    {
        $distId = [];
        if ($district_id != null) {
            $distId [] = $district_id;
            return $distId;
        } else {
            if ($region_id != null) {
                $regions = Additional::regDistrictsAsArray();
                foreach ($regions as $region) {
                    if ($region['id'] == $region_id) {
                        foreach ($region['districts'] as $district) {
                            $distId [] = $district['id'];
                        }
                        break;
                    }
                }
            }
            return $distId;
        }
    }

    /**
     * Pul birliklari listini olish
     *
     * @return array|mixed
     */
    public static function getCurrenciesList()
    {
        return Caching::getCurrencyListCache();
    }

    /**
     * Birlik nomini olish
     *
     * @param $currencies
     * @param $price_c
     * @return mixed|string
     */
    public static function getCurrencyName($currencies, $price_c)
    {
        $result = '';
        foreach ($currencies as $value) {
            if ($value['id'] == $price_c) {
                $result = $value['name'];
                break;
            }
        }
        return $result;
    }

    /**
     * Post dataga malumotlarni kirg'azish
     *
     * @param $request
     * @param $currencies
     * @return array
     */
    public static function setPostDatas($request, $currencies)
    {
        $not_important = trans('messages.Not important');
        $from_text = trans('messages.from summary');
        $to_text = trans('messages.to summary');

        $price_text = '';
        $result = [
            "only_photo" => 0,
            "owner_private_search" => 0,
            "owner_business_search" => 0,
            "sorting" => 'new',
            "price_f" => '',
            "price_t" => '',
            "price_c" => '',
            "price_search_f" => "",
            "price_search_t" => "",
            "search_from_desc" => 0,
            "price_text" => $not_important,
            "d" => $request->d,
        ];

        $currentRate = 1;
        if($request->price_c != null) {
            $thisCurrency = Currencies::where(['id' => $request->price_c])->first();
            if ($thisCurrency != null) {
                $currentRate = $thisCurrency->rate;
            }
        }

        if (isset($request->search_from_desc)) {
            $result['search_from_desc'] = $request->search_from_desc;
        }
        if (isset($request->only_photo)) {
            $result['only_photo'] = $request->only_photo;
        }
        if (isset($request->owner_private_search)) {
            $result['owner_private_search'] = $request->owner_private_search;
        }
        if (isset($request->owner_business_search)) {
            $result['owner_business_search'] = $request->owner_business_search;
        }
        if (isset($request->sorting)) {
            $result['sorting'] = $request->sorting;
        }
        if (isset($request->price_c)) {
            $result['price_c'] = $request->price_c;
        }
        if (isset($request->price_f)) {
            $result['price_f'] = $request->price_f;
            $result['price_search_f'] = $currentRate * $request->price_f;
            $price_text .= str_replace('{summary}', $result['price_f'], $from_text);
        }
        if (isset($request->price_t)) {
            $result['price_t'] = $request->price_t;
            $result['price_search_t'] = $currentRate * $request->price_t;
            $price_text .= ' ' . str_replace('{summary}', $result['price_t'], $to_text);
            if ($request->price_t == $request->price_f) {
                $price_text = str_replace('{summary}', $result['price_t'], $to_text);
            }
        }
        $result['price_text'] = $price_text;
        if ($price_text != '') {
            $result['price_text'] .= ' ' . Additional::getCurrencyName($currencies, $result['price_c']);
        } else {
            $result['price_text'] = $not_important;
        }

        if (isset($request->d)) {
            foreach ($request->d as $key => $value) {
                $text = trans('messages.Not important');
                if (isset($value['f'])) {
                    $text = str_replace('{summary}', $value['f'], $from_text);
                }
                if (isset($value['t'])) {
                    if ($text == trans('messages.Not important')) {
                        $text = '';
                    }
                    $text .= ' ' . str_replace('{summary}', $value['t'], $to_text);
                    if (isset($value['f'])) {
                        $text = $value['f'] . ' - ' . $value['t'];
                    }
                }
                $result = array_merge($result, ['d_' . $key . '_text' => $text]);
            }
        }

        Session::put('itemsPostDatas', $result);
        return $result;
    }

    /**
     * Servislarni rangli belgilanishi
     *
     * @return mixed
     */
    public static function serviceMarkedColor()
    {
        $service = Services::where(['keyword' => 'mark'])->first();
        return $service->color;
    }

    /**
     * Servislarni ranlgi belgilanishi do'konlar uchun
     *
     * @return mixed
     */
    public static function serviceShopMarkedColor()
    {
        $service = Services::where(['keyword' => 'mark_shop'])->first();
        return $service->color;
    }

    /**
     * Kategoriyalarni ajratib olish funksiyalari
     *
     * @return false|string
     */
    public function getCategoriesList()
    {
        $lang = app()->getLocale();
        $data = Categories::select(['id', 'parent_id', 'title', 'icon_b', 'price_diapazone'])->with(
            ['translates']
        )->where(['enabled' => 1])->orderBy('sorting', 'asc')->get()->toArray();
        $result = [];
        foreach ($data as $value) {
            $title = $value['title'];
            if ($lang != Additional::defaultLang()) {
                $translate = $value['translates'];
                if ($translate != null && $translate['field_value'] != '') {
                    $title = $translate['field_value'];
                }
            }

            $result [] = [
                'id' => $value['id'],
                'text' => $title,
                'img' => $value['icon_b'],
                'parent_id' => $value['parent_id'],
                'price_diapazone' => $value['price_diapazone'],
            ];
        }

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Tanlangan ma'lumotlarni olish
     *
     * @param $tree
     * @return mixed
     */
    public function getSelectData($tree)
    {
        if (!empty($tree)) {
            foreach ($tree as $key => $value) {
                $object = (object)[
                    'id' => $key,
                    'text' => $value['title'],
                    'parent_id' => $value['parent_id'],
                    'img' => $value['icon_b']
                ];
                $this->list[] = $object;
                if (!empty($value['childs'])) {
                    $this->getSelectData($value['childs']);
                }
            }
        }
        return $this->list;
    }

    /**
     * Urlni bo'laklarga bo'lib olish
     *
     * @param $segments
     * @return string
     */
    public static function getUrlSegmants($segments)
    {
        $result = '';
        $languages = self::getAllActiveLangList();
        foreach ($segments as $key => $value) {
            if ($key == 0 && !in_array($value, $languages)) {
                $result .= '/' . $value;
            }
            if ($key > 0) {
                $result .= '/' . $value;
            }
        }
        return $result;
    }

    public static function latinToCyril($latin)
    {
        //$textcyr="Тествам с кирилица";
        $cyr = [
            'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
            'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
            'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
            'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
        ];
        $lat = [
            'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
            'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya',
            'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P',
            'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
        ];
        //$textcyr = str_replace($cyr, $lat, $latin);
        $textlat = str_replace($lat, $cyr, $latin);
        return $textlat;
    }

    public static function cyrilToLatin($cyril)
    {
        //$textcyr="Тествам с кирилица";
        $cyr = [
            'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
            'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
            'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
            'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','Ҳ'
        ];
        $lat = [
            'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
            'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya',
            'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P',
            'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya','H'
        ];
        $textcyr = str_replace($cyr, $lat, $cyril);
        return $textcyr;
    }

    /**
     * Returned genders list with translates
     *
     * @return array
     */
    public static function getGenders(){
        return [
            self::MAN => trans('messages.Man'),
            self::WOMAN => trans('messages.Woman')
        ];
    }
}
