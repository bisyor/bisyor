<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\SocialNetworks
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $icon Иконка
 * @property bool|null $status Статус
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworks newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworks newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworks query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworks whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworks whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworks whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworks whereStatus($value)
 * @mixin \Eloquent
 * @mixin IdeHelperSocialNetworks
 */
class SocialNetworks extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'icon', 'status'];

    /**
     * Ijtimoiy tarmoqlar iconlarini qaytarish
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function getIcon()
    {
        if ($this->icon == null || $this->icon == '') {
            return config('app.noImage');
        }
        return config('app.uploadPath') . 'social_icons/' . $this->icon;
    }

    /**
     * Ijtimoiy tarmoqlarni ro'yxatini qaytarish
     *
     * @return array|string[]
     */
    public static function getSocialList()
    {
        $social = Additional::getSocialList();
        $array = [];
        foreach ($social as $soc) {
            $icon = 'fab fa-facebook-square';
            if ($soc->name == 'Facebook') {
                $icon = 'fab fa-facebook-square';
            }
            if ($soc->name == 'Instagram') {
                $icon = 'fab fa-instagram';
            }
            if ($soc->name == 'Twitter') {
                $icon = 'fab fa-twitter';
            }
            if ($soc->name == 'YouTube') {
                $icon = 'fab fa-youtube';
            }
            if ($soc->name == 'Telegram') {
                $icon = 'fab fa-telegram';
            }
            if ($soc->name == 'Google') {
                $icon = 'fab fa-google';
            }
            if ($soc->name == 'Yahoo') {
                $icon = 'fab fa-yahoo';
            }
            if ($soc->name == 'Linkedin') {
                $icon = 'fab fa-linkedin';
            }
            if ($soc->name == 'Live') {
                $icon = 'fab fa-live';
            }
            if ($soc->name == 'Foursquare') {
                $icon = 'fab fa-foursquare';
            }
            if ($soc->name == 'AOL') {
                $icon = 'fab fa-aol';
            }
            if ($soc->name == 'OpenID') {
                $icon = 'fab fa-openid';
            }
            if ($soc->name == 'Яндекс') {
                $icon = 'fab fa-yandex';
            }
            if ($soc->name == 'Мой мир') {
                $icon = 'fab fa-moymir';
            }
            if ($soc->name == 'Вконтакте') {
                $icon = 'fab fa-vk';
            }
            if ($soc->name == 'Одноклассники') {
                $icon = 'fab fa-odno';
            }
            $array += [
                $soc->id => $icon,
            ];
        }
        return $array;
    }

    /**
     * Tarmoqlarning to'liq listini bazadan olish
     *
     * @return array
     */
    public static function getSocialFullList()
    {
        $social = Additional::getSocialList();
        $array = [];
        foreach ($social as $soc) {
            $icon = 'fab fa-facebook-square';
            if ($soc->name == 'Facebook') {
                $icon = 'fab fa-facebook-square';
            }
            if ($soc->name == 'Instagram') {
                $icon = 'fab fa-instagram';
            }
            if ($soc->name == 'Twitter') {
                $icon = 'fab fa-twitter';
            }
            if ($soc->name == 'YouTube') {
                $icon = 'fab fa-youtube';
            }
            if ($soc->name == 'Telegram') {
                $icon = 'fab fa-telegram';
            }
            if ($soc->name == 'Google') {
                $icon = 'fab fa-google';
            }
            if ($soc->name == 'Yahoo') {
                $icon = 'fab fa-yahoo';
            }
            if ($soc->name == 'Linkedin') {
                $icon = 'fab fa-linkedin';
            }
            if ($soc->name == 'Live') {
                $icon = 'fab fa-live';
            }
            if ($soc->name == 'Foursquare') {
                $icon = 'fab fa-foursquare';
            }
            if ($soc->name == 'AOL') {
                $icon = 'fab fa-aol';
            }
            if ($soc->name == 'OpenID') {
                $icon = 'fab fa-openid';
            }
            if ($soc->name == 'Яндекс') {
                $icon = 'fab fa-yandex';
            }
            if ($soc->name == 'Мой мир') {
                $icon = 'fab fa-moymir';
            }
            if ($soc->name == 'Вконтакте') {
                $icon = 'fab fa-vk';
            }
            if ($soc->name == 'Одноклассники') {
                $icon = 'fab fa-odno';
            }
            $array [] = [
                'id' => $soc->id,
                'name' => $soc->name,
                'icon' => $icon,
            ];
        }
        return $array;
    }
}
