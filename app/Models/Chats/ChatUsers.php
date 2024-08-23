<?php

namespace App\Models\Chats;

use App\Models\Items\Items;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin IdeHelperChatUsers
 */
class ChatUsers extends Model
{
    protected $table = 'chat_users';
    const CREATED_AT = 'date_cr';
    const UPDATED_AT = null;
    protected $fillable = ['chat_id', 'user_id', 'item_id'];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public static function createUser($user_id, $chat_id, $item_id)
    {
        return self::firstOrCreate(['chat_id' => $chat_id, 'user_id' => $user_id, 'item_id' => $item_id]);
    }

    public function items(){
        return $this->belongsTo(Items::class, 'item_id', 'id');
    }

    public function chat(){
        return $this->belongsTo(Chats::class, 'chat_id', 'id')
            ->with('chatMessages')
            ->withCount('noReadMsgCount');
    }

    public function scopeChats($query){
        return $query->leftJoin('chats', 'chat_users.chat_id', '=', 'chats.id')
            ->leftJoin('items','chat_users.item_id', '=', 'items.id')
            ->with(['items','chat','user'])
            ->where('chat_users.user_id', auth()->id())
            ->whereNotNull('chat_users.item_id')
            ->where('type', Chats::CHAT_ITEMS)
            ->whereNotNull('chats.field_id');
    }
}
