<?php

namespace App\Models\Shops;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shops\ShopsSeo
 *
 * @mixin Illuminate\Database\Eloquent
 * @mixin Builder
 * @property int $id
 * @property string|null $title Заголовок
 * @property string|null $keywords Ключевые слова
 * @property string|null $description Описание
 * @property string|null $breadcumb Хлебная крошка
 * @property string|null $h1_title Заголовок H1
 * @property string|null $seo_text SEO текст
 * @property int|null $category_id Категория
 * @method static Builder|ShopsSeo newModelQuery()
 * @method static Builder|ShopsSeo newQuery()
 * @method static Builder|ShopsSeo query()
 * @method static Builder|ShopsSeo whereBreadcumb($value)
 * @method static Builder|ShopsSeo whereCategoryId($value)
 * @method static Builder|ShopsSeo whereDescription($value)
 * @method static Builder|ShopsSeo whereH1Title($value)
 * @method static Builder|ShopsSeo whereId($value)
 * @method static Builder|ShopsSeo whereKeywords($value)
 * @method static Builder|ShopsSeo whereSeoText($value)
 * @method static Builder|ShopsSeo whereTitle($value)
 * @mixin IdeHelperShopsSeo
 */
class ShopsSeo extends Model
{
    protected $table = 'shops_category_seo';
    public $timestamps = false;
    protected $fillable = ['title', 'keywords', 'description', 'breadcump', 'h1_title', 'seo_text'];
}
