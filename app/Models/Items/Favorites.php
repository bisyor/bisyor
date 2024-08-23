<?php

namespace App\Models\Items;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

/**
 * App\Models\Items\Favorites
 *
 * @property int $id
 * @property int|null $item_id Объявление
 * @property int|null $user_id Пользователья
 * @property float|null $default_price Первоначальная Цена
 * @property float|null $price Текущая цена
 * @property string|null $changed_date Дата изменение цены
 * @property int|null $type
 * @property string|null $search_text
 * @property-read \App\Models\Items\Items|null $item
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Favorites newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorites newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorites query()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorites whereChangedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorites whereDefaultPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorites whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorites whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorites wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorites whereSearchText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorites whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorites whereUserId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperFavorites
 */
class Favorites extends Model
{
    protected $table = 'favorites';
    public $timestamps = false;
    protected $fillable = ['item_id', 'user_id', 'default_price', 'price', 'changed_date', 'type'];

    const TYPE_FAVORITE = 1; // Избранные объявления
    const TYPE_SEARCH = 2; // Избранные результата поиска
    const TYPE_VIEW = 3; // Недавно просмотренные

    /**
     * Nomlar massivini qaytarish
     *
     * @return array
     */
    public function getTypeLabel()
    {
        return [
            self::TYPE_FAVORITE => trans('messages.Featured Ads'),
            self::TYPE_SEARCH => trans('messages.Featured Search Results'),
            self::TYPE_VIEW => trans('messages.Recently watched'),
        ];
    }

    /**
     * Foydalanuvchilar bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Sevimlilar bo'limiga elonlarni bog'lash
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id', 'id')
            ->with(['currency', 'category', 'district', 'favorite']);
    }

    /**
     * Sevimlilarga qo'shish
     *
     * @param $item_id
     * @param $type
     */
    public static function setFavorite($item_id, $type)
    {
        $item = Items::where(['id' => $item_id])->first();
        if (Auth::check() && $item) {
            $fav = Favorites::where(['item_id' => $item->id, 'type' => $type, 'user_id' => Auth::user()->id])->first();
            if ($fav == null) {
                Favorites::createModel($item, $type);
            } else {
                if (self::TYPE_FAVORITE == $type) {
                    $fav->delete();
                }
            }
        }
    }

    /**
     * @param $search_text
     */
    public static function setFavoriteText($search_text)
    {
        if (Auth::check()) {
            $fav = self::where(['search_text' => $search_text, 'type' => 4, 'user_id' => Auth::user()->id])->first();
            if ($fav == null) {
                $fav = new Favorites();
                $fav->user_id = Auth::user()->id;
                $fav->search_text = $search_text;
                $fav->type = 4;
                $fav->changed_date = date('Y-m-d H:i:s');
                $fav->save();
            }
        }
    }

    /**
     * Yangi model  yaratish
     *
     * @param $item
     * @param $type
     */
    public static function createModel($item, $type)
    {
        $fav = new Favorites();
        $fav->item_id = $item->id;
        $fav->user_id = Auth::user()->id;
        $fav->default_price = 0;
        $fav->price = $item->price;
        $fav->type = $type;
        $fav->save();
    }

    /**
     * Sevimlilardagi barchasini olish
     *
     * @param $user_id
     * @return array
     */
    public static function getAllFavorites($user_id)
    {
        $favorites = Favorites::where(['user_id' => $user_id])->with(['item'])->get();
        $result = [];

        foreach ($favorites as $value) {
            if ($value->item) {
                $result [] = $value->item->getItem();
            }
        }
        return $result;
    }

    /**
     * Foydalanuvchining o'ziga tegishli sevimlilarni olish
     *
     * @param $user_id
     * @return array
     */
    public static function getFavorites($user_id)
    {
        $favorites = Favorites::where(['user_id' => $user_id, 'type' => self::TYPE_FAVORITE,])
            ->with(['item'])->orderBy('id', 'desc')->get();
        $result = [];

        foreach ($favorites as $value) {
            if ($value->item_id != null) {
                $result [] = $value->item->getItem();
            }
        }
        return $result;
    }

    /**
     * Sevimlilarni ko'rish uchun
     *
     * @param $user_id
     * @return array
     */
    public static function getViewFavorites($user_id)
    {
        $favorites = Favorites::where(['user_id' => $user_id, 'type' => self::TYPE_VIEW])
            ->with(['item'])->orderBy('id', 'desc')->get();
        $result = [];

        foreach ($favorites as $value) {
            if ($value->item) {
                $result [] = $value->item->getItem();
            }
        }
        return $result;
    }

    /**
     * Qidirilayotgan so'z
     *
     * @return array
     */
    public static function getSearchedText()
    {
        $result = [];
        if (Auth::check()) {
            $user = Auth::user();
            $favorites = Favorites::where(['user_id' => $user->id, 'type' => 4])->get();

            foreach ($favorites as $value) {
                if ($value->search_text != '' or $value->search_text != null) {
                    $result [] = [
                        'id' => $value->id,
                        'type' => 'auth',
                        'text' => $value->search_text,
                        'date' => date('H:i d.m.Y', strtotime($value->changed_date)),
                    ];
                }
            }
        } else {
            $userSavedText = json_decode(Cookie::get('userSavedText'), true);
            if (is_array($userSavedText)) {
                foreach ($userSavedText as $value) {
                    if ($value['search_text'] != '' or $value['search_text'] != null) {
                        $result [] = [
                            'id' => $value['time'],
                            'type' => 'noauth',
                            'text' => $value['search_text'],
                            'date' => date('H:i d.m.Y', $value['time']),
                        ];
                    }
                }
            }
        }
        array_multisort(array_column($result, 'date'), SORT_DESC, $result);
        return $result;
    }
}
