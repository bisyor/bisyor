<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\CacheClear
 *
 * @mixin \Eloquent
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property string $name
 * @property int $minutes
 * @property string $key
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|CacheClear newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CacheClear newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CacheClear query()
 * @method static \Illuminate\Database\Eloquent\Builder|CacheClear whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CacheClear whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CacheClear whereMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CacheClear whereName($value)
 * @mixin IdeHelperCacheClear
 */
class CacheClear extends Model
{
    protected $table = 'cache_clear';
    public $timestamps = false;
    protected $fillable = ['name', 'minutes', 'key'];
}
