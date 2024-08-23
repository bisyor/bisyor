<?php

namespace App\Models\Shops;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shops\ShopsRating
 *
 * @mixin \Eloquent
 * @mixin IdeHelperShopsRating
 */
class ShopsRating extends Model
{
    protected $table = 'shops_rating';
    protected $fillable = ['shop_id', 'user_id', 'ball', 'date_cr'];
    const CREATED_AT = 'date_cr';
    const UPDATED_AT = null;
}
