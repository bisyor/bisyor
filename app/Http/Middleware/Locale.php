<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use App\Models\References\Additional;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */

    public static function getLocale()
    {
        $uri = Request::path(); // Получаем URI
        $segmentsURI = explode('/', $uri); // делим на части по разделитель /
        $mainLanguage = Additional::defaultLang();
        $languages = Additional::getAllActiveLangList();
        // Проверяем метку языка - есть ли среди доступных языков
        if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], $languages)) {
            if ($segmentsURI[0] != $mainLanguage) {
                return $segmentsURI[0];
            }
        }

        return null;
    }

    public function handle($request, Closure $next)
    {
        $locale = self::getLocale();

        $mainLanguage = Additional::defaultLang();

        if (!$locale) {
            $locale = $mainLanguage;
        }

        App::setlocale($locale);

        //if(Cookie::get('lang') != $locale) {
        if (Additional::getCurrentLang() != $locale) {
            return $next($request);
        }

        return $next($request);
    }
}
