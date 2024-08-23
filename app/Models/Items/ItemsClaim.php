<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


/**
 * App\Models\Items\ItemsClaim
 *
 * @mixin IdeHelperItemsClaim
 */
class ItemsClaim extends Model
{
    protected $table = 'items_claim';
    public $timestamps = false;
    protected $fillable = ['user_id', 'item_id', 'user_ip', 'reason', 'message', 'date_cr'];

    const REASON_TYPE_LIST = [
        '0' => 'messages.Announcement is not relevant',
        '1' => 'messages.Prohibited item',
        '2' => 'messages.Invalid description, photo',
        '3' => 'messages.Invalid rubric',
        '4' => 'messages.Invalid price',
        '5' => 'messages.Fraud',
        '6' => 'messages.Spam',
        '7' => 'messages.Other',
    ];

    const ANOTHER_REASON = 7;

    /**
     * Modelni saqlashdan oldin modelga avtomatik qo'shilishi kerak bo'lgan parametrlarni qo'shadi
     *
     * @param $request
     */
    public function beforeSave($request)
    {
        $this->date_cr = date('Y-m-d H:i:s');
        if (Auth::check()) {
            $user = Auth::user();
            $this->user_id = $user->id;
        }
        $this->user_ip = $request->ip();
        $this->viewed = false;
    }
}
