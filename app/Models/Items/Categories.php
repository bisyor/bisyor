<?php

namespace App\Models\Items;

use App\Models\References\StaticFunction;
use Illuminate\Support\Facades\Cookie;
use Session;
use Illuminate\Database\Eloquent\Model;
use App\Models\References\Additional;
use App\Models\References\Translates;

/**
 * App\Models\Items\Categories
 *
 * @mixin IdeHelperCategories
 */
class Categories extends Model
{
    protected $table = 'categories';
    public $timestamps = false;
    protected $fillable = [
        'numlevel',
        'icon_b',
        'icon_s',
        'keyword',
        'keyword_edit',
        'enabled',
        'date_cr',
        'date_up',
        'parent_id',
        'title',
        'owner_private_form',
        'owner_private_search',
        'owner_business_form',
        'owner_business_search',
        'owner_search',
        'owner_search_business',
        'price_sett',
        'price_diapazone'
    ];
    public $price_title;
    public $curr;
    public $ranges;
    public $ex;
    public $mod_title;
    public $mod_check;
    public $is_exchange;
    public $is_free;
    public $is_deal;

    /**
     * Kategoriyaning parentlarini yig'ish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Kategoriyalar avlodlarini qaytarish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')
            ->where(['enabled' => 1])->with(['children', 'translates']);
    }

    /**
     * Tarjimalar bilan bog'lash va ularni qaytarish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function translates()
    {
        return $this->belongsTo(Translates::class, 'id', 'field_id')
            ->where(['table_name' => $this->table, 'field_name' => 'title', 'language_code' => app()->getLocale()]);
    }

    /**
     * Barcha tarjimalarni olish jadvalga bog'langan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translatesAll()
    {
        return $this->hasMany(Translates::class, 'field_id')
            ->where(['table_name' => $this->table, 'language_code' => app()->getLocale()]);
    }

    /**
     * Dyndropsni olish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriesDynprops()
    {
        return $this->hasMany(CategoriesDynprops::class, 'category_id', 'id')
            ->where(['enabled' => 1])->with(['categoriesDynpropsMulti', 'translates'])
            ->orderBy('num', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dynpropSearch()
    {
        return $this->hasMany(CategoriesDynprops::class, 'category_id', 'id')
            ->where(['enabled' => 1, 'in_search' => true])
            ->with(['categoriesDynpropsMulti', 'translates'])
            ->orderBy('num', 'asc');
    }

    /**
     * Katta ikonkasini chiqarish
     * Yoki no image
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function bigImage()
    {
        if ($this->icon_b == null || $this->icon_b == '') {
            return config('app.noImage');
        }
        return config('app.uploadPath') . 'categories/' . $this->icon_b;
    }

    /**
     * Kichik ikonkasini olish
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function smallImage()
    {
        if ($this->icon_s == null || $this->icon_s == '') {
            return config('app.noImage');
        }
        return config('app.uploadPath') . 'categories/' . $this->icon_s;
    }

    /**
     * Kategoriya input parametrlarini olish
     *
     * @return array
     */
    public function categoriesDynpropsDatas()
    {
        $result = [];
        foreach ($this->categoriesDynprops as $value) {
            $result [] = $value->getDynprop();
        }
        return $result;
    }

    /**
     * @return array
     */
    public function dynpropSearchDatas()
    {
        $result = [];
        foreach ($this->dynpropSearch as $value) {
            $result [] = $value->getDynprop();
        }
        return $result;
    }

    /**
     * Nomlarni olish
     *
     * @return mixed|string|null
     */
    public function getName()
    {
        $title = $this->title;
        if (app()->getLocale() != Additional::defaultLang()) {
            $translate = $this->translates;
            if ($translate != null && $translate->field_value != '') {
                $title = $translate->field_value;
            }
        }
        return $title;
    }

    /**
     * Kategoriyani qaytarish
     * Tarjimasi bilan
     *
     * @return array
     */
    public function getCategory()
    {
        if (app()->getLocale() != Additional::defaultLang()) {
            $translate = $this->translatesAll;
            if ($translate) {
                foreach ($translate as $trans) {
                    if ($trans->field_value) {
                        $this->{$trans->field_name} = $trans->field_value;
                    }
                }
            }
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'numlevel' => $this->numlevel,
            'icon_b' => $this->bigImage(),
            'icon_s' => $this->smallImage(),
            'keyword' => $this->numlevel == 0 ? '' : $this->keyword,
            'keyword_edit' => $this->keyword_edit,
            'parent_id' => $this->parent_id,
            'owner_private_form' => $this->owner_private_form,
            'owner_private_search' => $this->owner_private_search,
            'owner_business_form' => $this->owner_business_form,
            'owner_business_search' => $this->owner_business_search,
            'owner_search' => $this->owner_search,
            'owner_search_business' => $this->owner_search_business,
            'price_diapazone' => $this->price_diapazone,
        ];
    }

    /**
     * Kategoriyani dyndrop bilan birgalikda chiqarish
     *
     * @return array
     */
    public function getCategoryWithDynprop()
    {
        $title = $this->title;
        if (app()->getLocale() != Additional::defaultLang()) {
            $translate = $this->translates;
            if ($translate != null && $translate->field_value != null) {
                $title = $translate->field_value;
            }
        }
        return [
            'id' => $this->id,
            'title' => $title,
            'numlevel' => $this->numlevel,
            'icon_b' => $this->bigImage(),
            'icon_s' => $this->smallImage(),
            'keyword' => $this->keyword,
            'keyword_edit' => $this->keyword_edit,
            'parent_id' => $this->parent_id,
            'dynprop' => $this->categoriesDynpropsDatas(),
            'dynpropSearch' => $this->dynpropSearchDatas(),
        ];
    }

    /**
     * Kategoriyani o'zidan bir pog'ona pasdagisini olish
     *
     * @param $_cats
     * @return array
     */
    public function getSecond($_cats)
    {
        $result = [];
        foreach ($_cats as $value) {
            $title = $value->title;
            if (app()->getLocale() != Additional::defaultLang()) {
                $translate = $value->translates;
                if ($translate != null) {
                    $title = $translate->field_value;
                }
            }

            $thirdMenu = $value->getThirdMenu($value->children->take(15));
            $result [] = [
                'id' => $value->id,
                'title' => $title,
                'keyword' => $value->keyword,
                'keyword_edit' => $value->keyword_edit,
                'parent_id' => $value->parent_id,
                'thirdMenuCount' => count($thirdMenu),
                'thirdMenu' => $thirdMenu,
            ];
        }

        $array_map = array_map(
            function ($element) {
                return $element['thirdMenuCount'];
            },
            $result
        );
        array_multisort($array_map, SORT_DESC, $result);

        return $result;
    }

    /**
     * Kategoriyani o'zidan ikki pog'ona pasdagisini olish
     *
     * @param $_cats
     * @return array
     */
    public function getThirdMenu($_cats)
    {
        $result = [];
        foreach ($_cats as $value) {
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
                'keyword' => $value->keyword,
                'keyword_edit' => $value->keyword_edit,
                'parent_id' => $value->parent_id,
            ];
        }
        return $result;
    }

    /**
     * Top bo'limlarga tegishli elonlaring sonini aniqash
     *
     * @param $currentCategory
     * @param array $address
     * @return array
     */
    public static function getTopCatItemCount($currentCategory, $address = array())
    {
        if ($currentCategory == null) {
            $categories = Categories::where(['numlevel' => 1, 'enabled' => 1]);
        } else {
            $categories = Categories::where(['parent_id' => $currentCategory->id, 'enabled' => 1]);
        }

        if (count($address) > 0) {
            $categories = $categories->whereIn('address', $address)->with(['translates', 'children'])->orderBy(
                'sorting',
                'asc'
            )->get();
        } else {
            $categories = $categories->with(['translates', 'children'])->orderBy('sorting', 'asc')->get();
        }

        $result = [];
        foreach ($categories as $category) {
            $categoryChildIdList = $category->buildTree($category->children, $category->id);
            $categoryChildIdList [] = $category->id;

            $title = $category->title;
            if (app()->getLocale() != Additional::defaultLang()) {
                $translate = $category->translates;
                if ($translate != null) {
                    $title = $translate->field_value;
                }
            }
            $count = Items::categoryItemsCount($categoryChildIdList);

            if ($count > 0) {
                $result [] = [
                    'id' => $category->id,
                    'title' => $title,
                    'keyword' => $category->keyword,
                    'keyword_edit' => $category->keyword_edit,
                    'count' => number_format($count),
                    'categoryChildIdList' => $categoryChildIdList,
                ];
            }
        }
        return $result;
    }

    /**
     * Malum bo'limdagi elonlar sonini olish
     *
     * @param $currentCategory
     * @param array $address
     * @return array
     */
    public static function getCatItemCount($currentCategory, $address = array())
    {
        if ($currentCategory == null) {
            $categories = Categories::where(['numlevel' => 1, 'enabled' => 1]);
        } else {
            $categories = Categories::where(['parent_id' => $currentCategory->id, 'enabled' => 1]);
        }

        if (count($address) > 0) {
            $categories = $categories->whereIn('address', $address)->with(['translates', 'children'])->orderBy(
                'id',
                'asc'
            )->get();
        } else {
            $categories = $categories->with(['translates', 'children'])->orderBy('id', 'asc')->get();
        }

        $result = [];
        foreach ($categories as $category) {
            $categoryChildIdList = $category->buildTree($category->children, $category->id);
            $categoryChildIdList [] = $category->id;

            $title = $category->title;
            if (app()->getLocale() != Additional::defaultLang()) {
                $translate = $category->translates;
                if ($translate != null) {
                    $title = $translate->field_value;
                }
            }
            $count = Items::categoryItemsCountMap($categoryChildIdList);

            if ($count > 0) {
                $result [] = [
                    'id' => $category->id,
                    'title' => $title,
                    'keyword' => $category->keyword,
                    'keyword_edit' => $category->keyword_edit,
                    'count' => number_format($count),
                    'categoryChildIdList' => $categoryChildIdList,
                ];
            }
        }
        return $result;
    }

    /**
     * Mintaqadagi elonlarni olish
     *
     * @param $currentCategory
     * @return array
     */
    public static function getItemInRegion($currentCategory)
    {
        $regions = Additional::regDistrictsAsArray();
        $result = [];
        $categoryChildIdList = null;

        if ($currentCategory != null) {
            $categoryChildIdList = self::buildTree($currentCategory->children, $currentCategory->id);
        }
        self::getByRegion($regions, $categoryChildIdList, $result);
        return $result;
    }

    /**
     * Regionlarga tegishlig
     * kategoriyaga bog'liq elonlar sonini aniqlash funksiyasi
     *
     * @param $currentCategory
     * @return array
     */
    public static function getItemInRegionCount($currentCategory)
    {
        $regions = Additional::regDistrictsAsArray();
        $result = [];
        $categoryChildIdList = null;
        $global_region = Additional::getGlobalRegionKeyword();

        if ($currentCategory != null) {
            $categoryChildIdList = [$currentCategory->id];
            self::buildTree($currentCategory->children, $currentCategory->id, $categoryChildIdList);
        }

        if($global_region != null){
            $sup_region = StaticFunction::getRegion($global_region, $regions);

            if($sup_region !== false){
                $regions = $sup_region['districts'];
            }
        }

        self::getByRegion($regions, $categoryChildIdList, $result);
        return $result;
    }

    /**
     * Ko'rsatilgan regionlarga tegishli bo'lgan itemlar listini categoriyalar bo'yicha
     * filtrlab ularning sonini aniqlaab olish uchu ishlatiladi
     *
     * @param $regions
     * @param $categoryChildIdList
     * @param $result
     */
    public static function getByRegion($regions, $categoryChildIdList,  &$result){
        foreach ($regions as $region) {
            $distId = [];
            if(array_key_exists('districts', $region)){
                $distId = array_column($region['districts'], 'id');
            }else{
                $distId [] = $region['id'];
            }
            $name = $region['name'];
            if (app()->getLocale() != Additional::defaultLang()) {
                $translate = $region['translate'];
                if ($translate != null) {
                    $name = $translate['field_value'];
                }
            }

            $result [] = [
                'id' => $region['id'],
                'name' => $name,
                'keyword' => $region['keyword'],
                'count' => Items::regionItemsCount($distId, $categoryChildIdList),
            ];
        }
    }


    /**
     * Categoriyalarni yuqoridan pastga daraxt ko'rinishida saralash
     *
     * @param $elements
     * @param $parentId
     * @param array|null $result
     * @return array|null
     */
    public static function buildTree($elements, $parentId, array &$result = null)
    {
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $result [] = $element['id'];
                $children = self::buildTree($element['children'], $element['id'], $result);
                if ($children) {
                    $element['children'] = $children;
                }
            }
        }
        return $result;
    }

    /**
     * Categoriyalarni yuqoridan pastga daraxt ko'rinishida saralash
     *
     * @param $category
     * @param null $result
     * @return mixed|null
     */
    public static function buildTreeParent($category, &$result = null)
    {
        if ($category != null) {
            $result [] = $category->getCategory();
            self::buildTreeParent($category->parent, $result);
        } else {
            if ($result != null) {
                return $result;
            }
            $category = Categories::where(['id' => 1])->with(['translates'])->first();
            $result [] = $category->getCategory();
        }
        return $result;
    }

    /**
     *
     *
     * @param $category Categories
     * @param null $result
     * @return mixed|null
     */
    public static function buildTreeParentDynprop($category, &$result = null)
    {
        if ($category != null) {
            $result [] = $category->getCategoryWithDynprop();
            self::buildTreeParentDynprop($category->parent, $result);
        } else {
            if ($result != null) {
                return $result;
            }
            $category = Categories::where(['id' => 1])->with(['translates'])->first();
            $result [] = $category->getCategoryWithDynprop();
        }
        return $result;
    }

    /**
     * Dyndroplarni qidirish
     *
     * @param $categoriesDynprops
     * @return array
     */
    public static function getDynpropSearch($categoriesDynprops)
    {
        $result = [];
        $count = count($categoriesDynprops);
        for ($i = $count - 2; $i > -1; $i--) {
            foreach ($categoriesDynprops[$i]['dynpropSearch'] as $dynpropSearch) {
                $result [] = $dynpropSearch;
            }
        }
        return $result;
    }

    /**
     * price_sett bilan ishlash
     *
     * @param $langs
     */
    public function getPriceSett($langs)
    {
        if (!$this->price_sett) {
            return;
        }
        $price_sett = unserialize($this->price_sett);
        $arr = [];
        foreach ($langs as $key => $value) {
            $arr [$value->url] = '';
        }
        foreach ($arr as $key => $value) {
            if (isset($price_sett['title'][$key])) {
                $arr[$key] = $price_sett['title'][$key];
            }
        }

        $this->price_title = $arr;
        $this->curr = $price_sett['curr'];
        $this->ex = $price_sett['ex'];
        $this->ranges = $price_sett['ranges'];
        //mod_title ni yuklab olish
        $arr = [];
        foreach ($langs as $key => $value) {
            $arr [$value->url] = '';
        }
        foreach ($arr as $key => $value) {
            if (isset($price_sett['mod_title'][$key])) {
                $arr[$key] = $price_sett['mod_title'][$key];
            }
        }
        $this->mod_title = $arr;

        $ex = (int)$this->ex;
        if ($ex - 8 >= 0) {
            $ex -= 8;
            $this->is_deal = 1;
        }
        if ($ex - 4 >= 0) {
            $ex -= 4;
            $this->is_free = 1;
        }
        if ($ex - 2 >= 0) {
            $ex -= 2;
            $this->is_exchange = 1;
        }
        if ($ex - 1 >= 0) {
            $ex -= 1;
            $this->mod_check = 1;
        }
    }

    /**
     * Titleni qaytarish
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|mixed|string|null
     */
    public function getModTitle()
    {
        if (!$this->price_sett) {
            return '';
        }
        $price_sett = unserialize($this->price_sett);

        if (isset($price_sett['mod_title'][app()->getLocale()]) &&
            ($price_sett['mod_title'][app()->getLocale()] != null ||
                $price_sett['mod_title'][app()->getLocale()] != '')) {
            return $price_sett['mod_title'][app()->getLocale()];
        } else {
            return trans('messages.Bargaining is possible');
        }
    }

    /**
     * Categoriyaning parentlarini topib chiqaradi
     *
     * @param $category_id
     * @return array
     */
    public static function getParents($category_id)
    {
        $cat = self::where(['id' => $category_id])->first();
        $result = [];
        while ($cat->parent_id) {
            array_unshift($result, $cat->id);
            $cat = self::where(['id' => $cat->parent_id])->first();
        }
        return $result;
    }

    /**
     * Categoriyaning parentlarini topib chiqaradi
     *
     * @param $category_id
     * @return array
     */
    public static function getParentsName($category_id)
    {
        $cat = self::where(['id' => $category_id])->with('translates')->first();
        $result = [];
        while ($cat->parent_id) {
            $title = $cat->title;
            if (app()->getLocale() != Additional::defaultLang()) {
                $translate = $cat->translates;
                if ($translate != null) {
                    $title = $translate->field_value;
                }
            }
            array_unshift($result, $title);
            $cat = self::where(['id' => $cat->parent_id])->first();
        }
        return $result;
    }

    /**
     * Categoriyaning childlarini topamiz
     *
     * @param $category_id
     * @return array
     */
    public static function getChildren($category_id)
    {
        static $increment = 0;
        $childs = self::where(['parent_id' => $category_id])->get()->toArray();
        $result = [];
        if ($childs) {
            foreach ($childs as $child) {
                $result += self::getChildren($child['id']);
            }
        } else {
            $result[$increment++] = $category_id;
        }
        return $result;
    }

    /**
     * Categoriyaning childlarining keywordlarini topamiz.
     * bu funksiya redirect bolimiga kerak bolgan
     *
     * @param $category_id
     * @return array
     */
    public static function getChildrenKeyword($category_id)
    {
        static $increment = 0;
        $childs = self::where(['parent_id' => $category_id])->get()->toArray();
        $result = [];
        if ($childs) {
            foreach ($childs as $child) {
                $result += self::getChildrenKeyword($child['id']);
            }
        } else {
            $result[$increment++] = self::where(['id' => $category_id])->first()->keyword;
        }
        return $result;
    }

    /**
     * Categoriyalarga mos formani yuborish
     *
     * @return mixed
     */
    public function getAdditionalFields()
    {
        $categories = self::getParents($this->id);
        $fields = CategoriesDynprops::whereIn('category_id', $categories)->with(['categoryByNumlevel', 'translates'])
            ->orderBy('num', 'asc')->get();

        foreach ($fields as $key => $field){
            $fields[$key]->title = !empty($field->translates->field_value) ? $field->translates->field_value : $field->title;
        }
        return $fields;
    }

    /**
     * Categoriyani qidirish
     *
     * @param array $catList
     * @return array
     */
    public static function getCatListSearch(array $catList)
    {
        $result = [];
        if ($catList) {
            foreach ($catList as $category) {
                $title = $category['category']['title'];
                if($category['category']['translates']){
                    $title = $category['category']['translates']['field_value'];
                }
                $result[] = [
                    'title' => $title,
                    'keyword' => $category['category']['keyword'],
                    'count' => $category['count'],
                ];
            }
        }
        return $result;
    }

    public function items(){
        return $this->belongsTo('App\Models\Items\Items', 'id', 'cat_id');
    }

    /**
     * User qiziqayotgan har bir elonning kategriyasini cookielarga yi'g'ib yuriladi
     *
     * @param $category_id
     */
    public static function setUserCategories($category_id){
        $categories = Cookie::get('categories');
        $categories = explode(',', $categories);

        if(count($categories) > config('settings.recommendation_categories_count')){
            array_shift($categories);
        }
        if(!in_array($category_id, $categories)){
            array_push($categories, $category_id);
        }
        Cookie::queue('categories', implode(',', $categories), 1440);
    }

    /**
     * Cookieadan categoriyalarni olib berish
     *
     * @return false|string[]
     */
    public static function getUserCategories(){
        $categories = Cookie::get('categories');
        return array_filter(explode(',', $categories));
    }
}
