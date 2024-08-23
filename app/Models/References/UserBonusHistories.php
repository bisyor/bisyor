<?php

namespace App\Models\References;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\UserBonusHistories
 *
 * @property int $id
 * @property int|null $user_id Пользователи
 * @property int|null $bonus_id Бонусы
 * @property string|null $date_cr Дата создания
 * @property float|null $summa Сумма
 * @method static \Illuminate\Database\Eloquent\Builder|UserBonusHistories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBonusHistories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBonusHistories query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBonusHistories whereBonusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBonusHistories whereDateCr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBonusHistories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBonusHistories whereSumma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBonusHistories whereUserId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperUserBonusHistories
 */
class UserBonusHistories extends Model
{
    protected $table = "bonus_history";
    public $timestamps = false;
    public $fillable = ['user_id', 'bonus_id', 'date_cr', 'summa'];

    /**
     * Bonus va bonus history jadvali bilan bog'lash
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getBonus(){
        return $this->belongsTo(Bonuses::class, 'bonus_id');
    }

    /**
     * Sana format yasab jo'natish table ichida
     *
     * @return string
     */
    public function getDate(){
        return Carbon::parse($this->date_cr)->format('d.m.Y');
    }
}
