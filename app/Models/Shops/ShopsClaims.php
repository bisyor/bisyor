<?php

namespace App\Models\Shops;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Shops\ShopsClaims
 *
 * @property int $id
 * @property int|null $shop_id Магазин
 * @property int|null $user_id Пользователь
 * @property string|null $user_ip Ip пользователья
 * @property int|null $reason Причина
 * @property string|null $message Сообщение (текст)
 * @property bool|null $viewed Просмотрено да или Нет
 * @property string|null $date_cr Дата создание
 * @property-read \App\Models\Shops\Shops|null $shop
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsClaims newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsClaims newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsClaims query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsClaims whereDateCr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsClaims whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsClaims whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsClaims whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsClaims whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsClaims whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsClaims whereUserIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopsClaims whereViewed($value)
 * @mixin \Eloquent
 * @mixin IdeHelperShopsClaims
 */
class ShopsClaims extends Model
{
	protected $table = 'shops_claims';
	public $timestamps = false;
	const REASON_LIST = ['Неверная рубрика','Запрещенный товар/услуга','Неверный адрес','Другое'];
	protected $fillable = ['shop_id', 'user_id', 'user_ip', 'reason', 'message', 'viewed', 'date_cr', 'telegram_channel'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function shop()
    {
        return $this->belongsTo('App\Models\Shops\Shops', 'shop_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'user_id');
    }

    /**
     * Saqlashdan oldin parametrlarni to'ldirish
     * @param $request
     */
    public function beforeSave($request)
    {

        $this->date_cr = date('Y-m-d H:i:s');
        if(Auth::check()){
            $user = Auth::user();
            $this->user_id = $user->id;
        }
        $this->user_ip = $request->ip();
        $this->viewed = false;
    }
}
