<?php

namespace App\Http\Controllers\References;

use App;
use Illuminate\Http\Request;
use App\Models\References\Additional;
use App\Models\References\Regions;

use App\User;
use App\Http\Controllers\Controller;
use App\Models\References\Redirects;
use App\Models\Items\Categories;

class StaticController extends Controller
{
    /**
     * Regionlar listini statik fayldan o'qib olish
     *
     * @param Request $request
     */
    public function staticRegion(Request $request)
    {
        $langs = Additional::getAllActiveLangList();
        foreach ($langs as $lang) {
            App::setlocale($lang);
            $destination = base_path() . '/resources/views/static/global-regions/region-' . $lang . '.php';
            $regions = Regions::with(['districts', 'translate', 'translateDec'])->orderBy('name', 'asc')->get(
            )->toArray();
            $toJson = json_encode($regions);

            $file = fopen($destination, "w+");
            fputs($file, $toJson);
            fclose($file);
        }
    }

    /**
     * @param Request $request
     */
    public function staticHeader(Request $request)
    {
        $langs = Additional::getAllActiveLangList();
        foreach ($langs as $lang) {
            App::setlocale($lang);
            $cats = Categories::where(['numlevel' => 1, 'enabled' => 1])->with(['children', 'translates'])->orderBy(
                'sorting',
                'asc'
            )->get();
            $result = [];
            foreach ($cats as $value) {
                $title = $value->title;
                if ($lang != Additional::defaultLang()) {
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

            $destination = base_path() . '/resources/views/static/header/top-menu-' . $lang . '.php';
            $toJson = json_encode($result);

            $file = fopen($destination, "w+");
            fputs($file, $toJson);
            fclose($file);
        }
    }

    /**
     * Top kategoriyalar statik fayldan olish va yozish
     *
     * @param Request $request
     */
    public function staticTopCategories(Request $request)
    {
        $langs = Additional::getAllActiveLangList();
        foreach ($langs as $lang) {
            App::setlocale($lang);
            $categories = Categories::where(['numlevel' => 1, 'enabled' => 1])->with(['translates'])->orderBy(
                'sorting',
                'asc'
            )->get();
            $result = [];
            foreach ($categories as $category) {
                $title = $category->title;
                if ($lang != Additional::defaultLang()) {
                    $translate = $category->translates;
                    if ($translate != null) {
                        $title = $translate->field_value;
                    }
                }
                $result [] = $category->getCategory();
            }

            $destination = base_path() . '/resources/views/static/top-categories/categories-' . $lang . '.php';
            $toJson = json_encode($result);

            $file = fopen($destination, "w+");
            fputs($file, $toJson);
            fclose($file);
        }
    }
}
