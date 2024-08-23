<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\References\Subscribers
 *
 * @property int $id
 * @property string|null $email E-mail
 * @property string|null $date_cr Дата создание
 * @method static \Illuminate\Database\Eloquent\Builder|Subscribers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscribers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscribers query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscribers whereDateCr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscribers whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscribers whereId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperSubscribers
 */
class Subscribers extends Model
{
    public $timestamps = false;

    protected $fillable = ['date_cr', 'email',];

    public static function boot()
    {
        parent::boot();

        self::creating(
            function ($model) {
                $model->date_cr = date('Y-m-d H:i:s');
            }
        );

        self::created(
            function ($model) {
                // ... code here
            }
        );

        self::updating(
            function ($model) {
                // ... code here
            }
        );

        self::updated(
            function ($model) {
                // ... code here
            }
        );

        self::deleting(
            function ($model) {
                // ... code here
            }
        );

        self::deleted(
            function ($model) {
                // ... code here
            }
        );
    }

}
