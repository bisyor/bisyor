<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;


/**
 * @mixin IdeHelperSearchResults
 */
class SearchResults extends Model
{
    protected $table = 'search_results';
    public $timestamps = false;
    protected $fillable = ['pid', 'region_id', 'district_id', 'query', 'counter', 'hits', 'last_time', 'from_device'];

    /**
     * Xar bir izlangan so'zni bazaga yozib borish
     *
     * @param $data
     * @param $keyword
     */
    public static function setValues($data, $keyword)
    {
        $keyword = str_replace('+', ' ', $keyword);
        $count = $data->count();
        $getGlobalRegion = Additional::getGlRegionDistrict();
        $district_id = $getGlobalRegion['district_id'];
        $region_id = $getGlobalRegion['region_id'];

        $mainSearch = SearchResults::where(['query' => $keyword, 'pid' => 0])->first();
        if ($mainSearch == null) {
            $mainSearch = new SearchResults();
            $mainSearch->pid = 0;
            $mainSearch->region_id = null;
            $mainSearch->district_id = null;
            $mainSearch->query = $keyword;
            $mainSearch->from_device  = UserHistory::DEVICE_WEB_SITE;
            $mainSearch->counter = 1;
            if ($count > 0) {
                $mainSearch->hits = 1;
            } else {
                $mainSearch->hits = 0;
            }
            $mainSearch->last_time = date('Y-m-d H:i:s');
            $mainSearch->save();
        } else {
            $mainSearch->counter = $mainSearch->counter + 1;
            if ($count > 0) {
                $mainSearch->hits = $mainSearch->hits + 1;
            }
            $mainSearch->last_time = date('Y-m-d H:i:s');
            $mainSearch->from_device  = UserHistory::DEVICE_WEB_SITE;
            $mainSearch->save();
        }

        $search = new SearchResults();
        $search->pid = $mainSearch->id;
        $search->region_id = $region_id;
        $search->district_id = $district_id;
        $search->query = null;
        $search->counter = 1;
        $search->from_device  = UserHistory::DEVICE_WEB_SITE;
        if ($count > 0) {
            $search->hits = 1;
        } else {
            $search->hits = 0;
        }
        $search->last_time = date('Y-m-d H:i:s');
        $search->save();

        /*$search = SearchResults::where(['region_id' => $district_id, 'pid' => $mainSearch->id])->first();
        if ($search == null) {
            $search = new SearchResults();
            $search->pid = $mainSearch->id;
            $search->region_id = $district_id;
            $search->query = null;
            $search->counter = 1;
            if ($count > 0) {
                $search->hits = 1;
            } else {
                $search->hits = 0;
            }
            $search->last_time = date('Y-m-d H:i:s');
            $search->save();
        } else {
            $search->counter = $search->counter + 1;
            if ($count > 0) {
                $search->hits = $search->hits + 1;
            }
            $search->last_time = date('Y-m-d H:i:s');
            $search->save();
        }*/
    }
}
