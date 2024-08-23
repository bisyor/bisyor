<?php

namespace App\Models\References;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\PromoCode
 *
 * @property int $id
 * @property string|null $code Промокод
 * @property string|null $title Название
 * @property int|null $type Тип
 * @property int|null $amount Сумма пополнения
 * @property int|null $usage_by Кто может применить
 * @property int|null $discount_type Вариант скидки
 * @property int|null $discount Размер скидки
 * @property int|null $usage_for Зона действия
 * @property string|null $category_list Список категории
 * @property string|null $regions_list Список регионов
 * @property bool|null $active Активен
 * @property string|null $active_to Действует до
 * @property int|null $usage_limit Кол-во срабатываний
 * @property bool|null $is_once Доступно пользователю
 * @property int|null $break_days Не чаще чем
 * @property int|null $used Сколько использовано
 * @property string|null $created_at Дата создание
 * @property string|null $active_from Дата активации
 * @property int|null $service_id Услуга
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereActiveFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereActiveTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereBreakDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereCategoryList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereIsOnce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereRegionsList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereUsageBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereUsageFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereUsageLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PromoCode whereUsed($value)
 * @mixin \Eloquent
 * @mixin IdeHelperPromoCode
 */
class PromoCode extends Model
{
    protected $table = 'promocodes';
    public $timestamps = false;

}
