<?php

namespace App\Models\Shops;

use App\Models\Crm\Available;
use App\Models\Crm\Clients;
use App\Models\Crm\Goods;
use App\Models\Items\Items;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\References\SocialNetworks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\References\Additional;
use PhpParser\Node\Expr\Cast\Object_;

/**
 * @mixin \Eloquent
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin IdeHelperShops
 */
class Shops extends Model
{
    public $tariff, $socialNetworksValues, $socialNetworks, $category;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_MODERATION = 2;
    const STATUS_BLOCKED = 3;
    const STATUS_DELETED = 4;
    const CREATED_AT = 'date_cr';
    const UPDATED_AT = 'date_up';

    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'keyword',
        'status',
        'description',
        'district_id',
        'address',
        'coordinate_x',
        'coordinate_y',
        'phone',
        'phones',
        'site',
        'blocked_reason',
        'admin_comment',
        'social_networks',
        'date_cr',
        'date_up',
        'view_count',
        'svc_fixed',
        'svc_fixed_order',
        'svc_fixed_to',
        'svc_marked_to',
        'work_time'
    ];

    /**
     * Do'konga tegishli elonlarni chiqarish uchun bog'lanish
     *
     * @return mixed
     */
    public function items()
    {
        return $this->hasMany(Items::class, 'shop_id', 'id')
            ->with(['currency', 'district', 'itemViews', 'category', 'favorite'])
            ->where(['is_moderating' => Items::NEW_STATUS_PUBLICATIOM,
                'is_publicated' => Items::NEW_STATUS_INPUBLICATION, 'status' => Items::STATUS_PUBLICATION])
            ->orderBy('id', 'desc');
    }

    /**
     * Magazinga tegishli ixtiyoriy premium elonnni olib berish uchun
     *
     * @return mixed
     */
    public function premium(){
        return Items::where('svc_premium', 1)
            ->where('shop_id', $this->id)
            ->with(['currency', 'district', 'itemViews', 'category', 'favorite'])
            ->where(['is_moderating' => Items::NEW_STATUS_PUBLICATIOM,
                'is_publicated' => Items::NEW_STATUS_INPUBLICATION, 'status' => Items::STATUS_PUBLICATION])
            ->inRandomOrder('id')
            ->first();
    }

    /**
     * Do'konga tegishli slidelarni chiqrish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function slides()
    {
        return $this->hasMany('App\Models\Shops\ShopSlider', 'shop_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sections()
    {
        return $this->hasMany('App\Models\Shops\ShopsSections', 'shop_id', 'id')->with(['section']);
    }

    /**
     * Do'konni joylashgan tumanlarni nomi bilan chiqarish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function districts()
    {
        return $this->hasOne('App\Models\References\Districts', 'id', 'district_id');
    }

    /**
     * Do'kon logosini qaytaruvchi funksiya
     * Agar u bo'lmasa odatiy rasm yo'o ma'nosidagi rasmni yborish
     *
     * @return string
     */
    public function getLogo()
    {
        return ($this->logo == null || $this->logo == '') ? config('app.noImage') :
            config('app.uploadPath') . 'shops/' . $this->logo;
    }

    /**
     * Magazin cover rasmini jo'natish
     *
     * @return mixed
     */
    public function getCover()
    {
        return ($this->cover == null || $this->cover == '') ? config('app.noImage') :
            config('app.uploadPath') . 'shops/' . $this->cover;
    }

    /**
     * Do'konlarni saqlayapganda vaqtinchalik papkada turgan rasmni bazaga yozib
     * do'kon uchun mahsus papkaga o'tkazib qo'yish
     *
     * @param $file
     */
    public function setLogo($file)
    {
        $uploadPath = config('app.shopsRoute');
        $old_path = config('app.trashRoute');
        Storage::disk('ftp')->move($old_path . $file, $uploadPath . $file);
        $this->logo = $file;
    }

    public function setCover($file)
    {
        $uploadPath = config('app.shopsRoute');
        $old_path = config('app.trashRoute');
        Storage::disk('ftp')->move($old_path . $file, $uploadPath . $file);
        $this->cover = $file;
    }

    /**
     * Do'konga berilgan reytinglar(baholar) qo'shib olish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
        return $this->hasMany('App\Models\Shops\ShopsRating', 'shop_id', 'id');
    }

    /**
     * Do'konning obunachilar ro'yxati
     *
     * @return mixed
     */
    public function subscribers()
    {
        return $this->belongsTo(ShopsSubscribers::class, 'id', 'shop_id')
            ->where('user_id', auth()->id());
    }

    /**
     * Do'konga bir foydalanuvchining bergan bahosini qaytaradi
     *
     * @return Object
     */
    public function rating()
    {
        return $this->belongsTo('App\Models\Shops\ShopsRating', 'id', 'shop_id')
            ->where('user_id', Auth::user() ? Auth::user()->id : false);
    }

    /**
     * Do'konga qoldirilgan izohlarni qaytaradi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Shops\ShopsComment', 'shop_id', 'id');
    }

    /**
     *
     * @param $socialNetworksValues
     * @param $socialNetworks
     * @return false|string
     */
    public function setSocialNetworks($socialNetworksValues, $socialNetworks)
    {
        $result = [];
        foreach ($socialNetworksValues as $key => $value) {
            if ($value != null) {
                $result += [$socialNetworks[$key] => $value];
            }
        }
        return json_encode($result);
    }

    /**
     * @return array
     */
    public function socialNetworksValues()
    {
        $array = [];
        if ($this->social_networks == null) {
            return $array;
        }
        foreach (json_decode($this->social_networks) as $key => $value) {
            array_push($array, $value);
        }
        return $array;
    }

    /**
     * @return array
     */
    public function socialNetworks()
    {
        $array = [];
        if ($this->social_networks == null) {
            return $array;
        }
        foreach (json_decode($this->social_networks) as $key => $value) {
            array_push($array, $key);
        }
        return $array;
    }

    /**
     * @return array|null
     */
    public function getCategoryName()
    {
        $shopSection = ShopsSections::where(['shop_id' => $this->id])->get(
        )->toarray();
        if ($shopSection != null) {
            return array_column($shopSection, 'section_id');
        } else {
            return null;
        }
    }

    /**
     * Do'konning ijtimoiy tarmoqdagi user namelarini json decode qilish funksiyasi
     *
     * @return array
     */
    public function getSocial()
    {
        $result = [];
        $social = json_decode($this->social_networks);
        if ($social != null) {
            $socialList = Additional::getSocialList();
            $list = SocialNetworks::getSocialList();
            foreach ($social as $_key => $_value) {
                $name = 'Facebook';
                foreach ($socialList as $value) {
                    if ($value->id == $_key) {
                        $name = $value->name;
                        break;
                    }
                }
                $icon = $list[$_key];
                $result [] = [
                    'icon' => $icon,
                    'value' => $_value,
                    'name' => $name,
                ];
            }
        }
        return $result;
    }

    /**
     * Do'kon status xolati nomini qaytarish
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function statusName()
    {
        if ($this->status == $this::STATUS_ACTIVE) {
            return trans('messages.Shop active status');
        } elseif ($this->status == $this::STATUS_INACTIVE) {
            return trans('messages.Shop noactive status');
        } elseif ($this->status == $this::STATUS_MODERATION) {
            return trans('messages.Shop moderation status');
        } elseif ($this->status == $this::STATUS_BLOCKED) {
            return trans('messages.Shop blocked status');
        } elseif ($this->status == $this::STATUS_DELETED) {
            return trans('messages.Shop deleted status');
        }
    }

    /**
     * Do'kon telefon raqamlarini jsondan decode qilib qaytarish
     *
     * @return false|string[]
     */
    protected function getPhones()
    {
        $ad = json_decode($this->phones);
        $ad = substr($ad, 1, strlen($ad) - 1);
        $ad = substr($ad, 0, strlen($ad) - 1);
        $ad = str_replace('"', '', $ad);
        $ad = explode(',', $ad);
        return $ad;
    }

    /**
     *
     * @return string
     */
    protected function catNames()
    {
        $string = "";
        $i = 0;
        foreach ($this->sections as $value) {
            if ($i == 0) {
                $string = $value->section->title;
            } else {
                $string .= ', ' . $value->section->title;
            }
            $i++;
        }
        return $string;
    }

    /**
     * Do'konlar listini yig'ib berish funksiyasi, so'ralgan categoriya va page bo'yicha
     *
     * @param $currentCat
     * @param string $sorting
     * @param int $page
     * @return array
     */
    public static function getShopList($currentCat, $sorting = 'new', $page = 1)
    {
        $result = [];
        $count = config('settings.shop_items_pagesize');
        $limit = $count * $page;
        $skip = $limit - $count;
        $distId = Additional::getRegionsDistrict();
        $shops = Shops::where(['status' => self::STATUS_ACTIVE])
            ->with(['districts', 'sections', 'slides'])->withCount('items');
        if ($currentCat == null) {
            if ($sorting == 'popular') {
                if (count($distId) > 0) {
                    $shops = $shops->whereIn('district_id', $distId);
                }
                $shops = $shops->orderBy('svc_fixed_to', 'ASC')
                    ->orderBy('view_count', 'DESC')->skip($skip)->take($count)
                    ->get();
            } else {
                if (count($distId) > 0) {
                    $shops = $shops->whereIn('district_id', $distId);
                }
                $shops = $shops->orderBy('svc_fixed_to', 'ASC')
                    ->orderBy('id', 'DESC')->skip($skip)->take($count)
                    ->get();
            }
        } else {
            $categories = ShopsSections::where(['section_id' => $currentCat->id])->get()->toArray();
            $idList = array_column($categories, 'shop_id');
            if ($sorting == 'popular') {
                if (count($distId) > 0) {
                    $shops = $shops->whereIn('district_id', $distId);
                }
                $shops = $shops->whereIn('id', $idList)
                    ->orderBy('svc_fixed_to', 'ASC')
                    ->orderBy('view_count', 'DESC')->skip($skip)->take($count)
                    ->get();
            } else {
                if (count($distId) > 0) {
                    $shops = $shops->whereIn('district_id', $distId);
                }
                $shops = $shops->whereIn('id', $idList)
                    ->orderBy('svc_fixed_to', 'ASC')
                    ->orderBy('id', 'DESC')->skip($skip)->take($count)
                    ->get();
            }
        }

        $color = Additional::serviceShopMarkedColor();
        foreach ($shops as $shop) {
            $result [] = $shop->getShopCardForList($color);
        }
        return $result;
    }

    /**
     * Foydalanuvchi o'zi yaraatgan do'konlar ro'yxatini qaytaradigan funksiya
     *
     * @param $user
     * @return array
     */
    public static function getUserShopList($user)
    {
        $result = [];
        $color = Additional::serviceShopMarkedColor();
        $shops = Shops::where(['user_id' => $user->id])
            ->where('status', '<>', Shops::STATUS_DELETED)
            ->with(['districts', 'sections', 'items', 'slides'])
            ->orderBy('svc_fixed_to', 'ASC')
            ->orderBy('id', 'DESC')
            ->get();

        foreach ($shops as $shop) {
            $result [] = $shop->viewShop($color);
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getShop()
    {
        return [
            'id' => $this->id,
            'date_cr' => date('d.m.Y', strtotime($this->date_cr)),
            'logo' => $this->getLogo(),
            'name' => $this->name,
            'status' => $this->status,
            'statusName' => $this->statusName(),
            'keyword' => $this->keyword,
            'description' => $this->description,
            'address' => $this->address,
            'itemCount' => count($this->items),
            'catNames' => $this->catNames(),
            'link' => route('shops-view', $this->keyword),
            'is_verify' => $this->is_verify
        ];
    }
    public function ratingsCountCalc()
    {
        $result = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        foreach ($this->ratings as $rating){
            $result[$rating->ball]++;
        }
        return $result;
    }

    public function getShopCardForList($markColor = null){
        $district = $this->districts != null ? $this->districts->name : null;
        return [
            'id' => $this->id,
            'date_cr' => Carbon::parse($this->date_cr)->format('d.m.Y'),
            'logo' => $this->getLogo(),
            'name' => $this->name,
            'user_id' => $this->user_id,
            'keyword' => $this->keyword,
            'status' => $this->status,
            'statusName' => $this->statusName(),
            'description' => $this->description,
            'address' => $this->address,
            'itemCount' => $this->items_count,
            'catNames' => $this->catNames(),
            'slides' => $this->slides,
            'site' => $this->site,
            'getPhones' => $this->getPhones(),
            'getSocial' => $this->getSocial(),
            'coordinate_x' => $this->coordinate_x,
            'coordinate_y' => $this->coordinate_y,
            'districts' => $district,
            'district_id' => $this->district_id,
            'serviceFixed' => $this->serviceFixed(),
            'serviceMarked' => $this->serviceMarked(),
            'serviceMarkedColor' => $markColor,
            'work_time' => $this->work_time,
            'is_verify' => $this->is_verify,
        ];
    }

    public function viewShop($markColor = null, $isItemUse = 1)
    {
        $district = $this->districts != null ? $this->districts->name : null;
        $items = $isItemUse == 1 ? self::getShopItems($this->items) : null;
        return [
            'id' => $this->id,
            'date_cr' => date('d.m.Y', strtotime($this->date_cr)),
            'logo' => $this->getLogo(),
            'name' => $this->name,
            'user_id' => $this->user_id,
            'keyword' => $this->keyword,
            'status' => $this->status,
            'statusName' => $this->statusName(),
            'description' => $this->description,
            'address' => $this->address,
            'itemCount' => $this->items->count(),
            'catNames' => $this->catNames(),
            'items' => $items,
            'slides' => $this->slides,
            'site' => $this->site,
            'getPhones' => $this->getPhones(),
            'getSocial' => $this->getSocial(),
            'coordinate_x' => $this->coordinate_x,
            'coordinate_y' => $this->coordinate_y,
            'districts' => $district,
            'district_id' => $this->district_id,
            'serviceFixed' => $this->serviceFixed(),
            'serviceMarked' => $this->serviceMarked(),
            'serviceMarkedColor' => $markColor,
            'ratings' => number_format($this->ratings->avg('ball'), 1),
            'subscribe' => $this->subscribers ? true : false,
            'rating' => $this->rating ? $this->rating->ball : false,
            'rating_count_by_line' => $this->ratingsCountCalc(),
            'rating_count' => $this->ratings->count(),
            'comments' => $this->comments ?: [],
            'comments_count' => $this->comments_count,
            'work_time' => $this->work_time,
            'is_verify' => $this->is_verify,
            'cover' => $this->getCover(),
        ];
    }

    /**
     * Biriktirilgan hizmatlarni statusi
     *
     * @return bool
     */
    public function serviceFixed()
    {
        if ($this->svc_fixed && time() < strtotime($this->svc_fixed_to)) {
            return true;
        }
        return false;
    }

    /**
     * Xizmat holatini ajratib ko'rsatish
     *
     * @return bool
     */
    public function serviceMarked()
    {
        if (time() < strtotime($this->svc_marked_to)) {
            return true;
        }
        return false;
    }

    /**
     * Do'kon elonnlarini olish
     *
     * @param $items
     * @return array
     */
    public static function getShopItems($items)
    {
        $result = [];
        foreach ($items as $item) {
            $result [] = $item->getShopItemsList();
        }
        return $result;
    }

    /**
     * Topdagi do'konlarni qaytarish funksiyasi
     *
     * @return mixed
     */
    public static function getTopShopsList()
    {
        return Shops::where(['status' => 1])->orderBy('view_count', 'DESC')->limit(4)->get();
    }


    public function good(){
        return $this->hasOne(Goods::class, 'shop_id');
    }

    public function available(){
        return $this->hasOne(Available::class, 'shop_id');
    }

    public function clients(){
        return $this->hasMany(Clients::class, 'shop_id');
    }
}
