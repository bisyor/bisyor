<?php


namespace App\Models\Items;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Items\Limits
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property int $id
 * @property int|null $cat_id
 * @property int|null $district_id
 * @property int|null $shop
 * @property int|null $free
 * @property int|null $items
 * @property string|null $settings
 * @property int|null $enabled
 * @property int|null $group_id
 * @property string|null $title
 * @method static \Illuminate\Database\Eloquent\Builder|Limits newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Limits newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Limits query()
 * @method static \Illuminate\Database\Eloquent\Builder|Limits whereCatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Limits whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Limits whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Limits whereFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Limits whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Limits whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Limits whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Limits whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Limits whereShop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Limits whereTitle($value)
 * @mixin IdeHelperLimits
 */
class Limits extends Model
{
    protected $table = 'items_limits';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'cat_id',
        'district_id',
        'shop',
        'free',
        'items',
        'settings',
        'enabled',
        'group_id',
        'title'
    ];

    /**
     * Bu funksiyani checkLimit funksiyasidan keyin ishlatiladi
     * Agar checkLimit funksiyasi false qaytarsa demak oxirgi qadam bir user uchun limit qo'yilganmi tekshiramiz
     * Agar limit qo'yilgan bo'lsa usernig elonlar soni shu limitdan o'tmaganmi yo'qmi.
     * Agar limitdan xali o'tmagan bo'lsa false qaytaradi
     * Agar limitdan o'tgan bo'lsa
     *
     * @return array|false
     */
    public static function globalCheck()
    {
        $user = Auth::user();
        $globalLimit = Limits::where(
            [
                'shop' => 0,
                'cat_id' => null,
                'enabled' => 1,
                'free' => 1,
                'group_id' => 0
            ]
        )->first();
        if ($globalLimit) {
            $userLimitPack = BuyedLimits::where(['user_id' => $user->id, 'shop' => 0])->get()->toArray();
            $userLimitPack = $userLimitPack ? array_column($userLimitPack, 'category_id') : [];
            $userItems = Items::where(['user_id' => $user->id])->whereNotIn('cat_id', $userLimitPack)->count();
            if ($userItems >= $globalLimit->items) {
                return ['categoryLimit' => $globalLimit->items, 'categoryId' => 0];
            }
        }
        return false;
    }

    /**
     * Kelgan kategoriyani idsi bo'yicha limit bormi yoki yo'q tekshiradi
     * Agar limit bo'lmasa false qaytaradi
     * Agar limit bo'lsa limit mmiqdori va o'sha categoriyani idsini qaytaradi
     *
     * @param $categoryId
     * @return array|false
     */
    public static function checkLimit($categoryId)
    {
        $categoryLimit = Limits::where(['shop' => 0, 'cat_id' => $categoryId, 'enabled' => 1, 'free' => 1])->first();
        if ($categoryLimit) {
            return ['categoryLimit' => $categoryLimit->items, 'categoryId' => $categoryId];
        } else {
            $categoryId = Categories::find($categoryId)->parent_id;
            if ($categoryId != 1) {
                return self::checkLimit($categoryId);
            } else {
                return false;
            }
        }
    }

    /**
     * Userning elonlari aytilgan categoriyadagi limitdan o'tanmi yo'qmi shuni tekshirish uchun ishlatiladi
     * Kategoriyani idsini oladi va shu kategoriyaga birikitirilgan barcha tugovchi kategoriyalarni yigadi
     * Undan keyin user shu kategoriyalar bo'yicha limit sotib olganmi tekshiradi
     * Sotib olingan kaegoriyalarni $categoryListdan o'chirib tashlaydi
     * Ohirida shu categorylistga tegishli barcha elonlar sonini topadi
     * Agar elonlar soni limitdan oshgan bo'lsa categoriya idsiga limit list sotib olganmi va u faol holatdami tekshiriladi
     * Natija sifatida array qaytariladi
     *
     * @param array $limitList
     */
    public static function countUserItems(array $limitList)
    {
        $categoryId = $limitList['categoryId'];
        $categoryLimit = $limitList['categoryLimit'];

        $user = Auth::user();
        $cat = Categories::where(['id' => $limitList['categoryId']])->with(['children'])->first();
        $limitAll = Limits::where('cat_id', '!=', 0)->orWhere(
            ['shop' => 0, 'cat_id' => null, 'enabled' => 1, 'free' => 1, 'group_id' => 0]
        )->get()->toArray();
        $limitAll = array_column($limitAll, 'cat_id');

        if (count($cat->children) > 0) {
            $categoryList = self::getChildren($cat->children, $limitAll);
        } else {
            $categoryList = [$cat->id];
        }

        $items = Items::whereIn('cat_id', $categoryList)->get()->toArray();
        $items = $items ? array_column($items, 'id') : [];

        $limitPacks = BuyedLimits::where(['user_id' => $user->id])->get();
        $res = [];
        if ($limitPacks) {
            foreach ($limitPacks as $limit) {
                $res += json_decode($limit->items);
            }
        }
        $categoryList = array_diff($items, $res);

        $userItemCount = count($categoryList);
        if ($userItemCount >= $categoryLimit) {
            return true;
        }
        return false;
    }

    /**
     * Categoriyaga limitlar tarifi
     *
     * @param $categoryId
     * @return array
     */
    public static function limitTarif($categoryId)
    {
        $settings = [];
        $id = '';
        $limitPack = Limits::where(['shop' => 0, 'cat_id' => $categoryId, 'enabled' => 1, 'free' => 0])->first();
        if ($limitPack) {
            $id = $limitPack->id;
            $tempArray = unserialize($limitPack->settings);
            foreach ($tempArray as $temp) {
                if ($temp['checked']) {
                    $settings[$temp['id']] = $temp;
                }
            }
        }
        return [
            'id' => $id,
            'settings' => $settings
        ];
    }

    /**
     * Limit sotib olishda formani tekshirish qoidalari
     *
     * @param $request
     * @return BuyedLimits|false|Model|object|string
     */
    public static function limitValidate($request)
    {
        $user = Auth::user();
        $result = false;
        $check = Limits::checkLimit($request->cat_id);
        if ($check) {
            if (Limits::countUserItems($check)) {
                $buyedLimit = BuyedLimits::buyedLimit($check['categoryId']);
                if (!$buyedLimit) {
                    $tarif = Limits::limitTarif($check['categoryId']);
                    $buyedLimit = self::buyPack($request, $tarif, $user);
                }
                $result = $buyedLimit;
            }
        } else {
            $globalCheck = self::globalCheck();
            if ($globalCheck) {
                $buyedLimit = BuyedLimits::buyedLimit(0);
                if (!$buyedLimit) {
                    $tarif = Limits::limitTarif(0);
                    $buyedLimit = self::buyPack($request, $tarif, $user);
                }
                $result = $buyedLimit;
            }
        }
        return $result;
    }

    /**
     * Limitlar to'plamini sotib olish
     *
     * @param $request
     * @param $tarif
     * @param $user
     * @return BuyedLimits|string
     */
    protected static function buyPack($request, $tarif, $user)
    {
        if ($request->limitbuy) {
            if (in_array($request->limitbuy, array_column($tarif['settings'], 'id'))) {
                if ($user->balance - $tarif['settings'][$request->limitbuy]['price'] >= 0) {
                    $buyedLimit = new BuyedLimits();
                    $buyedLimit->user_id = $user->id;
                    $buyedLimit->active = 1;
                    $buyedLimit->shop = 0;
                    $buyedLimit->item_count = $tarif['settings'][$request->limitbuy]['items'];
                    $buyedLimit->used_count = 0;
                    $buyedLimit->category_id = $request->cat_id;
                    $buyedLimit->summa = $tarif['settings'][$request->limitbuy]['price'];
                    $buyedLimit->date_cr = Carbon::parse(time())->format('Y-m-d H:i');
                    $buyedLimit->date_to = date("Y-m-d H:i", strtotime("+1 month"));
                    $buyedLimit->save();
                    $userBalance = User::find($user->id);
                    $userBalance->balance = $userBalance->balance - $tarif['settings'][$request->limitbuy]['price'];
                    $userBalance->save();
                } else {
                    return 'balance';
                }
            } else {
                return 'required';
            }
        } else {
            return 'required';
        }
        return $buyedLimit;
    }

    /**
     * Foydalanuvchini limiti tugagagan ekanligini tekshirish
     *
     * @param $category_id
     * @return false|mixed|null
     */
    public static function check($category_id)
    {
        $checkLimit = self::checkLimit($category_id);
        if ($checkLimit) {
            if (Limits::countUserItems($checkLimit)) {
                if (!BuyedLimits::buyedLimit($checkLimit['categoryId'])) {
                    return $checkLimit['categoryId'];
                }
            }
        } else {
            if (self::globalCheck()) {
                if (!BuyedLimits::buyedLimit(0)) {
                    return null;
                }
            }
        }
        return false;
    }

    /**
     * Caategoriyani o'zidan pasdagilarni olish
     *
     * @param $cat
     * @param array $limitCatList
     * @return array
     */
    public static function getChildren($cat, array $limitCatList)
    {
        static $increment = 0;
        $result = [];
        foreach ($cat as $value) {
            if (in_array($value->id, $limitCatList)) {
                continue;
            }
            if (count($value->children) > 0) {
                $result += self::getChildren($value->children, $limitCatList);
            } else {
                $result[$increment] = $value->id;
            }
            $increment++;
        }
        return $result;
    }

}
