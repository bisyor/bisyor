<?php

namespace App\Models\References;

use App\Models\Items\Categories;
use App\Models\Items\Items;
use App\Models\Shops\ShopsSeo;
use Session;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\Seo
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $value Значение
 * @property string|null $key Ключ
 * @property string|null $group Группа
 * @property string|null $type Тип полей
 * @method static \Illuminate\Database\Eloquent\Builder|Seo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seo whereValue($value)
 * @mixin \Eloquent
 * @mixin IdeHelperSeo
 */
class Seo extends Model
{
    protected $table = 'seo';
    public $timestamps = false;
    protected $fillable = ['value', 'key', 'group'];

    /**
     * Bloglar ro'yxati uchun seoni yuborish
     *
     * @param $seokey
     * @param $locale
     * @return array
     */
    public static function getMetaBlogList($seokey, $locale)
    {
        if ($locale == Additional::defaultLang()) {
            $array_key = 'value';
        } else {
            $array_key = 'field_value';
        }

        $additional = new Additional();
        $region_name = trans('messages.Uzbekistan');
        $region_in = trans('messages.Uzbekistan');
        $keyword = $additional->getGlobalRegionKeyword();

        foreach ($additional->regDistricts() as $region) {
            if ($region['keyword'] == $keyword) {
                $region_name = $region['name'];
                $region_in = $region['declination'];
                break;
            } else {
                foreach ($region['districtsList'] as $dist) {
                    if ($dist['keyword'] == $keyword) {
                        $region_name = $dist['name'];
                        $region_in = $dist['declination'];
                        break;
                    }
                }
            }
        }
        $array = [];
        foreach ($seokey as $value) {
            $result = isset($value[$array_key]) ? $value[$array_key] : $value['value'];
            $result = str_replace('{page}', '', $result);
            $result = str_replace('{site.title}', 'Bisyor.uz', $result);
            $result = str_replace('{meta-base}', '', $result);
            $result = str_replace('{region.in}', $region_in, $result);
            $array[$value['key']] = $result;
        }
        return $array;
    }

    /**
     * Bloglar kategoriyalar uchun seoni yuborish
     *
     * @param $seokey
     * @param $categoryName
     * @param $locale
     * @return array
     */
    public static function getMetaBlogCat($seokey, $categoryName, $locale)
    {
        if ($locale == 'ru') {
            $array_key = 'value';
        } else {
            $array_key = 'field_value';
        }

        $array = [];
        foreach ($seokey as $value) {
            $result = str_replace('{page}', '', isset($value[$array_key]) ? $value[$array_key] : $value['value']);
            $result = str_replace('{category}', $categoryName, $result);
            $result = str_replace('{site.title}', 'Bisyor.uz', $result);
            $result = str_replace('{meta-base}', '', $result);
            $array[$value['key']] = $result;
        }
        return $array;
    }

    /**
     * Blogni o'qish paytida chiqishi kerak bo'lgan seolarni yuboorish
     *
     * @param $seokey
     * @param $model
     * @param $locale
     * @param $tags
     * @return array
     */
    public static function getMetaBlogView($seokey, $model, $locale, $tags)
    {
        if ($locale == 'ru') {
            $array_key = 'value';
        } else {
            $array_key = 'field_value';
        }

        $tagNames = '';
        foreach ($tags as $value) {
            $tagNames .= $value->tag->name . ' ';
        }

        $array = [];
        foreach ($seokey as $key => $value) {
            $result = str_replace(
                '{title}',
                $model['title'],
                isset($value[$array_key]) ? $value[$array_key] : $value['value']
            );
            $result = str_replace('{site.title}', 'Bisyor.uz', $result);
            $result = str_replace('{page}', '', $result);
            $result = str_replace('{meta-base}', $model['title'] . $model['short_text'], $result);
            $result = str_replace('{textshort}', $model['short_text'], $result);
            $result = str_replace('{tags}', $tagNames, $result);
            $result = str_replace('{tag}', $tagNames, $result);
            $array[$value['key']] = $result;
        }
        return $array;
    }

    /**
     * Kirish uchun seolarni joylashtirish
     *
     * @param $seokey
     * @param $locale
     * @return array
     */
    public static function getMetaAuth($seokey, $locale)
    {
        if ($locale == 'ru') {
            $array_key = 'value';
        } else {
            $array_key = 'field_value';
        }

        $array = [];
        foreach ($seokey as $value) {
            $result = isset($value[$array_key]) ? $value[$array_key] : $value['value'];
            $result = str_replace('{site.title}', 'Bisyor.uz', $result);
            $array[$value['key']] = $result;
        }
        return $array;
    }

    /**
     * Do'konni korishda chiqishi kerak bo'lgan seolarni qaytarish
     *
     * @param $seokey
     * @param $model
     * @param $locale
     * @return array
     */
    public static function getMetaShopView($seokey, $model, $locale)
    {
        $array = [];
        $additional = new Additional();
        $country = trans('messages.Uzbekistan');

        if ($locale == 'ru') {
            $array_key = 'value';
        } else {
            $array_key = 'field_value';
        }

        $region_in = $model['districts'];
        $district_id = $model['district_id'];
        foreach ($additional->regDistricts() as $region) {
            foreach ($region['districtsList'] as $dist) {
                if ($dist['id'] == $district_id) {
                    $region_in = $dist['declination'];
                    break;
                }
            }
        }

        foreach ($seokey as $key => $value) {
            $result = isset($value[$array_key]) ? $value[$array_key] : $value['value'];
            $result = str_replace('{page}', '', $result);
            $result = str_replace('{title}', $model['name'], $result);
            $result = str_replace('{site.title}', 'Bisyor.uz', $result);
            $result = str_replace('{meta-base}', $model['name'] . $model['description'], $result);
            $result = str_replace('{description}', $model['description'], $result);
            $result = str_replace('{tags}', '', $result);
            $result = str_replace('{region.in}', $region_in, $result);
            $result = str_replace('{country}', $country, $result);
            $array[$value['key']] = $result;
        }
        return $array;
    }

    /**
     * Do'kon kategoriyalarida chiqishi keraak bo'lgan seolarni yuborish
     *
     * @param $seokey
     * @param $locale
     * @param null $currentCat
     * @return array
     */
    public static function getMetaShopCategory($seokey, $locale, $currentCat = null)
    {
        $array_key = 'field_value';
        $cat_seo_data = null;
        $title = '';
        if ($locale == 'ru') {
            $array_key = 'value';
        }
        $additional = new Additional();
        $keyword = $additional->getGlobalRegionKeyword();
        list($region_name, $region_in) = self::regionData($keyword, $additional);

        if ($currentCat) {
            $cat_seo_data = ShopsSeo::where('category_id', $currentCat->id)->first();
            $title = $currentCat->translate->field_value ?? $currentCat->title;
        }

        $array = [];
        foreach ($seokey as $value) {
            $result = isset($value[$array_key]) ? $value[$array_key] : $value['value'];
            if ($value['key'] == 'shops_category_title' && !empty($cat_seo_data->title)) {
                $result = $cat_seo_data->title;
            } elseif ($value['key'] == 'shops_category_description' && !empty($cat_seo_data->description)) {
                $result = $cat_seo_data->description;
            } elseif ($value['key'] == 'shops_category_keyword' && !empty($cat_seo_data->keywords)) {
                $result = $cat_seo_data->keywords;
            }

            $result = str_replace('{page}', '', $result);
            $result = str_replace('{site.title}', 'Bisyor.uz', $result);
            $result = str_replace('{meta-base}', '', $result);
            $result = str_replace('{region.in}', $region_in, $result);
            $result = str_replace('{region}', $region_name, $result);
            $result = str_replace('{total}', 0, $result);
            $result = str_replace('{total}', '0 магазинов', $result);
            $result = str_replace('{category}', $title, $result);
            $result = str_replace('{category+parent}', $title, $result);
            $result = str_replace('{categories}', $title, $result);
            $result = str_replace('{categories.reverse}', $title, $result);
            $array[$value['key']] = $result;
        }
        return $array;
    }

    /**
     * Bosh saxifada chiqish kerak bo'lgan seolarni yuborish
     *
     * @param $seokey
     * @param $locale
     * @return array
     */
    public static function getMetaIndex($seokey, $locale)
    {
        if ($locale == 'ru') {
            $array_key = 'value';
        } else {
            $array_key = 'field_value';
        }

        $array = [];
        $additional = new Additional();
        $region_in = str_replace('{country}', trans('messages.Uzbekistan'), trans('messages.country.in'));
        $keyword = $additional->getGlobalRegionKeyword();
        foreach ($additional->regDistricts() as $region) {
            if ($region['keyword'] == $keyword) {
                $region_in = $region['declination'];
                break;
            } else {
                foreach ($region['districtsList'] as $dist) {
                    if ($dist['keyword'] == $keyword) {
                        $region_in = $dist['declination'];
                        break;
                    }
                }
            }
        }
        foreach ($seokey as $value) {
            $result = isset($value[$array_key]) ? $value[$array_key] : $value['value'];
            $result = str_replace('{site.title}', 'Bisyor.uz', $result);
            $result = str_replace('{title}', 'Bisyor.uz', $result);
            if (!$keyword) {
                $result = str_replace('{region.in}', '', $result);
            } else {
                $result = str_replace('{region.in}', $region_in, $result);
            }

            $array[$value['key']] = $result;
        }
        return $array;
    }

    /**
     * Elonlar uchun seolarni yuborish
     *
     * @param $seokey
     * @param null $category
     * @param $locale
     * @param null $topCategories
     * @param $mainCategories
     * @param string|null $query
     * @return array
     */
    public static function getMetaItemsList(
        $seokey,
        $locale,
        $mainCategories,
        $category = null,
        $topCategories = null,
        string $query = null
    )
    {
        $array_key = $locale == Additional::defaultLang() ? 'value' : 'field_value';
        $categories_list = [];
        $title = '';
        $array = [];
        $cat_seo_data = null;
        $itemsCount = 0;

        if ($category) {
            $cat_seo_data = self::changedAttributeValue($category['id'], $locale);
            $title = $category['title'];
        }
        if ($query == null) {
            $query = '';
        }
        if ($topCategories != null) {
            foreach ($topCategories as $value) {
                $itemsCount += (int)str_replace(',', '', $value['count']);
            }
        } elseif ($category) {
            $itemsCount = Items::categoryItemsCount([$category['id']]);
        }
        if (!empty($mainCategories)) {
            for ($i = count($mainCategories) - 2; $i >= 0; $i--) {
                array_push($categories_list, $mainCategories[$i]['title']);
            }
        }
        $categories_reverse = '';
        $category_parent = '';
        $categories = '';
        if (!empty($categories_list)) {
            $categories_reverse = implode(', ', $categories_list);
            $categories_list = array_reverse($categories_list);
            $category_parent = count(
                $categories_list
            ) >= 2 ? $categories_list[0] . ", " . $categories_list[1] : $categories_list[0];
            $categories = implode(', ', $categories_list);
        }

        $additional = new Additional();
        $keyword = $additional->getGlobalRegionKeyword();
        list($region_name, $region_in) = self::regionData($keyword, $additional);
        foreach ($seokey as $value) {
            $result = isset($value[$array_key]) ? $value[$array_key] : $value['value'];
            if ($value['key'] == 'items_category_title' && !empty($cat_seo_data['mtitle'])) {
                $result = $cat_seo_data['mtitle'];
            } elseif ($value['key'] == 'items_category_description' && !empty($cat_seo_data['mdescription'])) {
                $result = $cat_seo_data['mdescription'];
            }elseif ($value['key'] == 'items_category_title_h1' && !empty($cat_seo_data['titleh1'])) {
                $result = $cat_seo_data['titleh1'];
            } elseif ($value['key'] == 'items_category_keyword' && !empty($cat_seo_data['mkeywords'])) {
                $result = $cat_seo_data['mkeywords'];
            } elseif ($value['key'] == 'items_category_seo_text' && !empty($cat_seo_data['seotext'])) {
                $result = $cat_seo_data['seotext'];
            } elseif ($value['key'] == 'seo_translation_name_categories_seotext' && empty($cat_seo_data['seotext'])) {
                if (!$category) {
                    $result = $value[$array_key];
                } else {
                    $result = '';
                }
                $value['key'] = 'items_category_seo_text';
            }

            $result = str_replace('{page}', '', $result);
            $result = str_replace('{site.title}', 'Bisyor.uz', $result);
            $result = str_replace('{query}', $query, $result);
            $result = str_replace('{category}', $title, $result);
            $result = str_replace('{region.in}', $region_in, $result);
            $result = str_replace('{region}', $region_name, $result);
            $result = str_replace('{category+parent}', $category_parent, $result);
            $result = str_replace(
                '{total.text}',
                str_replace('{count}', $itemsCount, trans('messages.total.text')),
                $result
            );
            $result = str_replace('{meta-base}', '', $result);
            $result = str_replace('{total}', $itemsCount, $result);

            /* This place will be edited later*/
            $result = str_replace('{categories}', $categories, $result);
            $result = str_replace('{categories.reverse}', $categories_reverse, $result);
            $array[$value['key']] = $result;
        }
        return $array;
    }

    /**
     * Elonni to'liq ko'rishda chiqadigan seoarni yuborish
     *
     * @param $seokey
     * @param $content
     * @param $locale
     * @param $mainCategories
     * @param $user
     * @return array
     */
    public static function getMetaItemsView($seokey, $content, $locale, $mainCategories, $user)
    {
        $array_key = 'field_value';
        if ($locale == 'ru') {
            $array_key = 'value';
        }
        $cat_seo_data = null;
        if ($mainCategories[0]) {
            $cat_seo_data = self::changedAttributeValue($mainCategories[0]['id'], $locale);
        }
        $mainCategoriesTitle = '';
        $mainCategoriesTitleTrue = '';
        $category_parent = '';
        $categories_reverse = '';

        for ($i = 0; $i < count($mainCategories) - 1; $i++) {
            if ($i == 0) {
                $mainCategoriesTitle = $mainCategories[$i]['title'];
                $categories_reverse = $mainCategories[$i]['title'];
                $mainCategoriesTitleTrue = $mainCategories[$i]['title'];
            } else {
                $mainCategoriesTitle .= ', ' . $mainCategories[$i]['title'];
                $mainCategoriesTitleTrue = $mainCategories[$i]['title'] . ', ' . $mainCategoriesTitleTrue;
            }
            if ($i < 2) {
                $category_parent = $mainCategoriesTitleTrue;
            }
        }


        $additional = new Additional();
        $region_in = $content['regionName'];
        foreach ($additional->regDistricts() as $region) {
            foreach ($region['districtsList'] as $dist) {
                if (isset($content['district']['id']) && $dist['id'] == $content['district']['id']) {
                    $region_in = $dist['declination'];
                    break;
                }
            }
        }

        $array = [];
        foreach ($seokey as $value) {
            $result = isset($value[$array_key]) ? $value[$array_key] : $value['value'];
            if ($value['key'] == 'items_ads_title' && !empty($cat_seo_data['view_mtitle'])) {
                $result = $cat_seo_data['view_mtitle'];
            } elseif ($value['key'] == 'items_ads_description' && !empty($cat_seo_data['view_mdescription'])) {
                $result = $cat_seo_data['view_mdescription'];
            } elseif ($value['key'] == 'items_ads_keyword' && !empty($cat_seo_data['view_mkeywords'])) {
                $result = $cat_seo_data['view_mkeywords'];
            }

            $result = str_replace('{page}', '', $result);
            $result = str_replace('{site.title}', 'Bisyor.uz', $result);
            $result = str_replace('{title}', $content['title'], $result);
            $result = str_replace(
                '{price}',
                $content['price'] . ($content['price_ex'] ? ' ' . $content['price_ex_title'] : ''),
                $result
            );
            $result = str_replace('{categories.reverse}', $mainCategoriesTitle, $result);
            $result = str_replace('{categories}', $mainCategoriesTitleTrue, $result);
            $result = str_replace(
                '{address}, ',
                (strlen($content['selfAddress']) > 0 ? $content['selfAddress'] . ', ' : null),
                $result
            );
            $result = str_replace('{city}', $content['regionName'], $result);
            $result = str_replace('{country}', trans('messages.Uzbekistan'), $result);
            $result = str_replace('{id}', $content['id'], $result);
            $result = str_replace('{region.in}', $region_in, $result);
            $result = str_replace('{meta-base}', '', $result);
            $result = str_replace('{name}', $user->getUserFio(), $result);
            $result = str_replace('{description}', $content['description'], $result);
            $result = str_replace(
                '{district}',
                isset($content['district']['name']) ? $content['district']['name'] : 'error',
                $result
            );
            $result = str_replace('{category+parent}', $category_parent, $result);
            $result = str_replace('{region}', $content['regionName'], $result);
            $result = str_replace('{category}', $content['categoryName'], $result);
            $result = str_replace('{category+parent}', $category_parent, $result);
            /* This place will be edited later*/
            $result = str_replace('{categories}', $mainCategoriesTitle, $result);
            $result = str_replace('{categories.reverse}', $mainCategoriesTitleTrue, $result);
            if ('items_ads_title' != $value['key']) {
                $result = str_replace('"', '', $result);
            }
            $array[$value['key']] = $result;
        }
        return $array;
    }

    /**
     * Elonni yaratishda chiqadigan seolarni tayorlash
     *
     * @param $seokey
     * @param $locale
     * @return array
     */
    public static function getMetaItemsCreate($seokey, $locale)
    {
        if ($locale == 'ru') {
            $array_key = 'value';
        } else {
            $array_key = 'field_value';
        }
        $array = [];

        foreach ($seokey as $value) {
            $result = isset($value[$array_key]) ? $value[$array_key] : $value['value'];
            $result = str_replace('{page}', '', $result);
            $result = str_replace('{site.title}', 'Bisyor.uz', $result);
            $array[$value['key']] = $result;
        }
        return $array;
    }

    public static function getMetaItemsUser($seokey, $user, $locale)
    {
        $array_key = 'field_value';
        if ($locale == 'ru') {
            $array_key = 'value';
        }

        $country = str_replace('{country}', trans('messages.Uzbekistan'), trans('messages.country.in'));
        $additional = new Additional();
        $keyword = $additional->getGlobalRegionKeyword();
        list($region_name, $region_in) = self::regionData($keyword, $additional);

        $array = [];
        foreach ($seokey as $value) {
            $result = isset($value[$array_key]) ? $value[$array_key] : $value['value'];
            $result = str_replace('{page}', '', $result);
            $result = str_replace('{site.title}', 'Bisyor.uz', $result);
            $result = str_replace('{name}', $user->getUserFio(), $result);
            $result = str_replace('{country}', trans('messages.Uzbekistan'), $result);
            $result = str_replace('{region}', (isset($user->district) ? $user->district->region->name : ''), $result);
            $result = str_replace('{region.in}', $region_in, $result);
            $array[$value['key']] = $result;
        }
        return $array;
    }

    /**
     * Yordam bo'limi uchun seo kodlarni olish
     *
     * @param $seokey
     * @param $locale
     * @param null $query
     * @return array
     */
    public static function getMetaHelpList($seokey, $locale, $query = null)
    {
        if ($locale == 'ru') {
            $array_key = 'value';
        } else {
            $array_key = 'field_value';
        }

        $array = [];
        foreach ($seokey as $value) {
            $result = isset($value[$array_key]) ? $value[$array_key] : $value['value'];
            $result = str_replace('{site.title}', 'Bisyor.uz', $result);
            $result = str_replace('{query}', $query, $result);
            $result = str_replace('{page}', '', $result);
            $array[$value['key']] = $result;
        }
        return $array;
    }

    /**
     * Yordamnni to'liq ochib ko'rishdagi seolarni yuborish
     *
     * @param $seokey
     * @param $model
     * @param $locale
     * @return array
     */
    public static function getMetaHelpView($seokey, $model, $locale)
    {
        if ($locale == 'ru') {
            $array_key = 'value';
        } else {
            $array_key = 'field_value';
        }

        $array = [];
        foreach ($seokey as $key => $value) {
            $result = isset($value[$array_key]) ? $value[$array_key] : $value['value'];
            $result = str_replace('{title}', $model['name'], $result);
            $result = str_replace('{site.title}', 'Bisyor.uz', $result);
            $result = str_replace('{textshort}', $model['helps'] ? $model['helps'][0]['text'] : '', $result);
            $result = str_replace('{category}', $model['name'], $result);
            $array[$value['key']] = $result;
        }
        return $array;
    }

    /**
     * Statik saxifalarning seolarini yuborish
     *
     * @param string $page
     * @param string $locale
     * @return mixed
     */
    public static function staticPages(string $page, string $locale)
    {
        if ($locale == 'ru') {
            return Pages::find($page);
        }

        $seo_trans = Pages::join('translates', 'pages.id', '=', 'translates.field_id')->where(
            ['translates.table_name' => 'pages', 'pages.id' => $page, 'translates.language_code' => $locale]
        )->get();

        return ($seo_trans->count() != 0) ? $seo_trans : Pages::find($page);
    }

    /**
     * Seo uchun kalit so'zlarni aniqlash va yuborish
     *
     * @param $table_name
     * @param $locale
     * @return mixed
     */
    public static function getSeoKey($table_name, $locale)
    {
        if ($locale == Additional::defaultLang()) {
            return Seo::where(['group' => $table_name])->get();
        }

        $seo_trans = Seo::join('translates', 'seo.id', '=', 'translates.field_id')->where(
            ['translates.table_name' => 'seo', 'seo.group' => $table_name, 'translates.language_code' => $locale]
        )->get();
        return ($seo_trans->count() != 0) ? $seo_trans : Seo::where(['group' => $table_name])->get();
    }

    /**
     * Seolardagi meta kodlarni yuborish statik uchun
     *
     * @param $seokey
     * @return string[]
     */
    public static function getMetaStatic($seokey)
    {
        $array = ['mtitle' => '', 'mkeywords' => '', 'mdescription' => ''];
        if ($seokey == null) {
            return $array;
        }

        if (app()->getLocale() == 'ru') {
            $array['mtitle'] = str_replace('{site.title}', 'Bisyor.uz', $seokey->mtitle);
            $array['mtitle'] = str_replace('{title}', 'Bisyor.uz', $array['mtitle']);
            $array['mkeywords'] = str_replace('{meta-base}', '', $seokey->mkeywords);
            $array['mdescription'] = str_replace('{meta-base}', '', $seokey->mdescription);
        } else {
            if (isset($seokey->id)) {
                if ($seokey->field_name === 'mtitle') {
                    $array['mtitle'] = str_replace('{site.title}', 'Bisyor.uz', $seokey->field_value);
                    $array['mtitle'] = str_replace('{title}', 'Bisyor.uz', $array['mtitle']);
                } elseif ($seokey->field_name === 'mkeywords') {
                    $array['mkeywords'] = str_replace('{meta-base}', '', $seokey->field_value);
                } else {
                    $array['mdescription'] = str_replace('{meta-base}', '', $seokey->field_value);
                }
            } else {
                foreach ($seokey as $value) {
                    if ($value->field_name === 'mtitle') {
                        $array['mtitle'] = str_replace('{site.title}', 'Bisyor.uz', $value->field_value);
                        $array['mtitle'] = str_replace('{title}', 'Bisyor.uz', $array['mtitle']);
                    } elseif ($value->field_name === 'mkeywords') {
                        $array['mkeywords'] = str_replace('{meta-base}', '', $value->field_value);
                    } else {
                        $array['mdescription'] = str_replace('{meta-base}', '', $value->field_value);
                    }
                }
            }
        }

        return $array;
    }

    /**
     * region malumotlarni tayorlash uchun ichki funksiya
     *
     * @param $keyword
     * @param Additional $additional
     * @return array
     */
    protected static function regionData($keyword, Additional $additional)
    {
        $region_name = trans('messages.Uzbekistan');
        $region_in = str_replace('{country}', trans('messages.Uzbekistan'), trans('messages.country.in'));
        foreach ($additional->regDistricts() as $region) {
            if ($region['keyword'] == $keyword) {
                $region_name = $region['name'];
                $region_in = $region['declination'];
                break;
            } else {
                foreach ($region['districtsList'] as $dist) {
                    if ($dist['keyword'] == $keyword) {
                        $region_name = $dist['name'];
                        $region_in = $dist['declination'];
                        break;
                    }
                }
            }
        }
        return [$region_name, $region_in];
    }

    /**
     * Attributlarni qiymatini avtomatik o'zgartirish
     * Tarjimasi bilan
     *
     * @param $category
     * @param $locale
     * @return array
     */
    protected static function changedAttributeValue($category, $locale)
    {
        $cat_seo_data = Categories::with('translatesAll')->find($category)->toArray();
        $cat_seo_data += array_column(
            $cat_seo_data['translates_all'],
            'field_value',
            'field_name'
        );
        /* Places translation values in the desired fields */
        if ($locale != 'ru') {
            foreach ($cat_seo_data['translates_all'] as $key => $value) {
                if ($value['field_value']) {
                    $cat_seo_data[$value['field_name']] = $value['field_value'];
                }
            }
        }
        return $cat_seo_data;
    }
}
