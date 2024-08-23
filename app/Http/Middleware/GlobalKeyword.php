<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use App\Models\References\Additional;


class GlobalKeyword
{

    /**
     * Google orqali elonga global region
     * bilan kelib qolganda urldan regionni olib tashlab oddatiy xolatimizga o'tkazib yuboradi
     *
     * @param $fullPath
     * @param $globalRegionList
     */
    public static function removeGlobalKeyInUrl($fullPath, $globalRegionList){

        if(mb_stripos($fullPath, '.html') !== false){
            $locale = Request::segment(1); //fetches first URI segment
            $glRegionKeyword = Request::segment(2); //fetches second URI segment
            $new_url = false;
            if(in_array($locale, $globalRegionList)){
                $new_url = str_replace($locale. '/', '', $fullPath);
            }elseif(in_array($glRegionKeyword, $globalRegionList)){
                $new_url = str_replace($glRegionKeyword. '/', '', $fullPath);
            }
            if($new_url !== false){
                redirect()->to($new_url, 301)->send();
            }
        }
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public static function getKeyword()
    {
        $uri = Request::path(); // Получаем URI
        $segmentsURI = explode('/', $uri); // делим на части по разделитель /
        $getAllRegionKeys = Additional::getRegionKeywordList();
        $getGlobalRegion = Additional::getGlbReg();
        $languages = Additional::getAllActiveLangList();
        // Проверяем метку языка - есть ли среди доступных языков
        if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], $languages)) {
            if (!empty($segmentsURI[1]) && in_array($segmentsURI[1], $getAllRegionKeys)) {
                Additional::setGlobalRegionKeyword($segmentsURI[1]);
                return $segmentsURI[1];
            } elseif (!empty($segmentsURI[1]) && in_array($segmentsURI[1], [ 'shops'])) {
                Additional::setGlobalRegionKeyword(null);
                return null;
            }
        }else{
            if(!empty($segmentsURI[0]) && in_array($segmentsURI[0], $getAllRegionKeys)){
                Additional::setGlobalRegionKeyword($segmentsURI[0]);
                return $segmentsURI[0];
            }elseif (!empty($segmentsURI[0]) && in_array($segmentsURI[0], [/*'obyavlenie', */'shops'])){
                Additional::setGlobalRegionKeyword(null);
                return null;
            }
        }
        Additional::setGlobalRegionKeyword($getGlobalRegion);
        return $getGlobalRegion;
    }

    public function handle($request, Closure $next)
    {
        $globalKeyWord = Additional::getGlbReg();
        $getAllRegionKeys = Additional::getRegionKeywordList();

        if(!empty($globalKeyWord) && in_array($globalKeyWord, $getAllRegionKeys)){
            $segments = $request->segments();
            $languages = Additional::getAllActiveLangList();
            // Проверяем метку языка - есть ли среди доступных языков
            if (!empty($segments[0]) && in_array($segments[0], $languages)) {
                if(empty($segments[1])){
                    array_push($segments, $globalKeyWord);
                    return redirect()->to(implode('/', $segments));
                }
            }else{
                if(empty($segments[0])){
                    array_push($segments, $globalKeyWord);
                    return redirect()->to(implode('/', $segments));
                }
            }

        }

        return $next($request);
    }
}
