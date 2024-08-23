<?php


namespace App\Models\References;


/**
 * App\Models\References\UserSubscribers
 *
 * @property int $id
 * @property int|null $from_user_id
 * @property int|null $to_user_id
 * @property-read \App\User|null $subscribers
 * @property-read \App\User|null $subscriptions
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscribers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscribers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscribers query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscribers whereFromUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscribers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSubscribers whereToUserId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperUserSubscribers
 */
class UserSubscribers extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'users_subscribers';
    public $timestamps = false;
    protected $fillable = ['from_user_id', 'to_user_id'];

    public function subscribers()
    {
        return $this->hasOne('App\User', 'id', 'from_user_id');
    }

    public function subscriptions()
    {
        return $this->hasOne('App\User', 'id', 'to_user_id');
    }

}
