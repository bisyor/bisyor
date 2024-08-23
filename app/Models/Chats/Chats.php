<?php

namespace App\Models\Chats;

use Auth;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Chats\Chats
 *
 * @mixin \Eloquent
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $date_cr Дата создание
 * @property int|null $status Статус
 * @property int|null $type Тип чата
 * @property int|null $field_id Id поля
 * @property int|null $user_id_item чат объявлений
 * @property-read \App\Models\Chats\ChatMessage|null $chatMessages
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Chats\ChatMessage[] $chatMessagesCount
 * @property-read int|null $chat_messages_count_count
 * @method static \Illuminate\Database\Eloquent\Builder|Chats newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chats newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chats query()
 * @method static \Illuminate\Database\Eloquent\Builder|Chats whereDateCr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chats whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chats whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chats whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chats whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chats whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chats whereUserIdItem($value)
 * @mixin IdeHelperChats
 */
class Chats extends Model
{
    protected $table = 'chats';
    protected $fillable = ['name', 'date_cr', 'type', 'field_id', 'status'];

    const CREATED_AT = 'date_cr';
    const UPDATED_AT = null;
    /**
     * Chat type vars
     * Chat type --> 1-Чат с админом, 2-Простой чат, 3-Комментария блог, 4-Комментария объявлении, 5-Магазин
     * Status type --> 1 - Актив, 2- Не активно
     */
    const CHAT_ITEMS = 6;
    const CHAT_ADMIN = 1;

    /**
     * Xabarlar bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function chatMessages()
    {
        return $this->hasOne(ChatMessage::class, 'chat_id', 'id')
            ->with(['users'])->orderBy('date_cr', 'desc');
    }

    /**
     * Xabarlar soni
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chatMessagesCount()
    {
        return $this->hasMany(ChatMessage::class, 'chat_id', 'id');
    }

    /**
     * Foydalanuvchilar chati
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function chatUser()
    {
        return $this->hasOne(ChatUsers::class, 'chat_id', 'id')
            ->where('user_id', '!=', auth()->id())->with(['user']);
    }

    /**
     * O'qilmagan xabarlar soni
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function noReadMsgCount()
    {
        return $this->hasMany(ChatMessage::class, 'chat_id', 'id')
            ->where('user_id', '!=', auth()->id())->where('is_read', 0);
    }

    /**
     * Xabarlar ro'yxatini qaytarish
     *
     * @return array
     */
    public static function getChatList($type_list = 'all')
    {
        $chat_users = ChatUsers::chats();
        $admin = [];
        if($type_list == 'purchase'){
            $chat_users->where('items.user_id', '!=', auth()->id());
        }elseif($type_list == 'sale'){
            $chat_users->where('items.user_id', auth()->id());
        }else{
            $admin = ChatUsers::leftJoin('chats', 'chat_users.chat_id', '=', 'chats.id')
                ->where('chats.name', '#admin_'. auth()->id())
                ->where('user_id', '!=', auth()->id())
                ->with(['chat', 'user'])
                ->where('chats.type', self::CHAT_ADMIN)
                ->first();
        }
        $result = self::buildMessage($chat_users->get());
        if($admin){
            array_unshift($result, self::chatArray($admin, auth()->user()));
        }
        return $result;
    }

    /**
     * Xabar yuboruvchilar listini jo'natish uchun ishlatiladi.
     *
     * @param $chat_users
     * @return array
     */
    public static function buildMessage($chat_users): array
    {
        $user = auth()->user();
        $result = [];
        foreach ($chat_users as $chat_user) {
            if(!$chat_user->chat->chatMessages || !$chat_user->items){
                continue;
            }
            $result [] = self::chatArray($chat_user, $user);
        }
        array_multisort(array_column($result, 'lastMessageTime'), SORT_DESC, $result);
        return $result;
    }

    /**
     * Chat xabarni array ko'rinishiga o'tkazib tayyorlab beradi.
     * Faqat obyekt qabul qiladi va o'sa obyektlar bo'yichaa array qaytarishi kerak
     * Admin uchun xabar va foreachni ichida aylanganda ishlatiladi
     *
     * @param $chat_user
     * @param $user
     * @return array
     */
    public static function chatArray($chat_user, $user){
        $lastMessage = $chat_user->chat->chatMessages->getMsg($user);
        return [
            'user_id' => $chat_user->user_id,
            'chat_id' => $chat_user->chat->id,
            'name' => $chat_user->chat->name,
            'type' => $chat_user->chat->type,
            'field_id' => $chat_user->chat->field_id,
            'status' => $chat_user->chat->status,
            'userFio' => $chat_user->items->title ?? $chat_user->user->getUserFio(),
            'userAvatar' => $chat_user->user->getAvatar(),
            'userOnline' => $chat_user->user->getOnlineStatus(),
            'lastMessage' => $lastMessage,
            'lastMessageTime' => $lastMessage['time'],
            'noReadMsgCount' => $chat_user->chat->noReadMsgCount_count,
        ];
    }

    /**
     * Elonnga yozilgan xabarlari
     *
     * @param $user
     * @param $item_id
     * @return array
     */
    public static function getItemChatList($user, $item_id)
    {
        $chats = Chats::where(['type' => 6, 'field_id' => $item_id])
            ->with(['chatMessages', 'chatUser', 'noReadMsgCount'])->get();
        $result = [];
        
        
        foreach ($chats as $chat) {
            $chatUser = $chat->chatUser;
            $noReadMsgCount = $chat->noReadMsgCount->count();
            if ($noReadMsgCount == 0) {
                $noReadMsgCount = '';
            }
            
            $lastMessage = null;
            if($chat->chatMessages){
                $lastMessage = $chat->chatMessages->getMsg($user);
            } 
            
            $result [] = [
                'user_id' => $chatUser->user_id,
                'chat_id' => $chat->id,
                'name' => $chat->name,
                'type' => $chat->type,
                'field_id' => $chat->field_id,
                'status' => $chat->status,
                'userFio' => $chatUser->user->getUserFio(),
                'userAvatar' => $chatUser->user->getAvatar(),
                'userOnline' => $chatUser->user->getOnlineStatus(),
                'lastMessage' => $lastMessage,
                'lastMessageTime' => $lastMessage['time'] ?? null,
                'noReadMsgCount' => $noReadMsgCount,
            ];
        }
        array_multisort(array_column($result, 'lastMessageTime'), SORT_DESC, $result);
        return $result;
    }

    /**
     * Xabarlar sonini qaytarish
     *
     * @param $type
     * @param $field_id
     * @return int
     */
    public static function getMessageCount($type, $field_id)
    {
        $chat = Chats::where(['type' => $type, 'field_id' => $field_id])->first();
        if ($chat == null) {
            return 0;
        }
        return ChatMessage::where(['chat_id' => $chat->id])->get()->count();
    }

    /**
     * Chat yararish
     *
     * @param $id
     * @param $type
     * @param $msg
     * @return int|null
     */
    public static function createChat($id, $type, $msg)
    {
        $user = Auth::user();
        $chat = new Chats();
        if ($type == 1) {
            $chat->name = '#admin_' . $user->id;
        }
        if ($type == 2) {
            $chat->name = '#chat_' . $id . '_' . $user->id;
        }
        if ($type == 3) {
            $chat->name = '#blog_' . $id;
        }
        if ($type == 4) {
            $chat->name = '#item_' . $id;
        }
        if ($type == 5) {
            $chat->name = '#shop_' . $id;
        }
        $chat->field_id = $id;
        $chat->type = $type;
        $chat->status = 1;
        $chat->date_cr = date('Y-m-d H:i:s');

        if ($chat->save()) {
            $chatUser = new ChatUsers();
            $chatUser->chat_id = $chat->id;
            $chatUser->user_id = $user->id;
            $chatUser->date_cr = date('Y-m-d H:i:s');
            $chatUser->save();

            if ($type == 2) {
                $chatUser = new ChatUsers();
                $chatUser->chat_id = $chat->id;
                $chatUser->user_id = $id;
                $chatUser->date_cr = date('Y-m-d H:i:s');
                $chatUser->save();
            }

            ChatMessage::msgCreate($chat->id, $msg, 'msg', $user->id);
            return $chat->id;
        } else {
            return null;
        }
    }

    /**
     * Adminga xat yuborish
     *
     * @param $user_id
     * @param $type
     * @param $msg
     * @return int|null
     */
    public static function createAdminChat($user_id, $type, $msg)
    {
        $user = User::where(['id' => $user_id])->first();
        $chat = new Chats();
        if ($type == 1) {
            $chat->name = '#admin_' . $user->id;
        }
        $chat->field_id = $user_id;
        $chat->type = $type;
        $chat->status = 1;
        $chat->date_cr = date('Y-m-d H:i:s');

        if ($chat->save()) {
            $chatUser = new ChatUsers();
            $chatUser->chat_id = $chat->id;
            $chatUser->user_id = $user->id;
            $chatUser->date_cr = date('Y-m-d H:i:s');
            $chatUser->save();

            $chatUser = new ChatUsers();
            $chatUser->chat_id = $chat->id;
            $chatUser->user_id = 1; // admin
            $chatUser->date_cr = date('Y-m-d H:i:s');
            $chatUser->save();

            ChatMessage::msgCreate($chat->id, $msg, 'msg', 1); // message from admin
            return $chat->id;
        } else {
            return null;
        }
    }

    /**
     * Xabarlarni qaytarish
     *
     * @param $type
     * @param $field_id
     * @return array
     */
    public static function getMessages($type, $field_id)
    {
        $result = [];
        $user = Auth::user();
        $chat = Chats::where(['type' => $type, 'field_id' => $field_id])->first();
        if ($chat != null) {
            $chatMsg = ChatMessage::where(['chat_id' => $chat->id])->with(['users'])->orderBy('date_cr', 'asc')->get();
            foreach ($chatMsg as $value) {
                $self = 0;
                $type = 'msg';
                if ($user != null && $user->id == $value->user_id) {
                    $self = 1;
                }
                if ($value->file != null) {
                    $type = 'file';
                }
                $result [] = [
                    'id' => $value->id,
                    'chat_id' => $value->chat_id,
                    'user_id' => $value->user_id,
                    'userFio' => $value->users->getUserFio(),
                    'userAvatar' => $value->users->getAvatar(),
                    'userOnlineStatus' => $value->users->getOnlineStatus(),
                    'message' => $value->message,
                    'self' => $self,
                    'type' => $type,
                    'date_cr' => date('H:i d.m.Y', strtotime($value->date_cr)),
                    'is_read' => $value->is_read,
                    'answer_to' => $value->answer_to,
                ];
            }
        }
        return $result;
    }

    /**
     * Chatga bog'liq xabarlarni olish
     *
     * @param $user
     * @return array
     */
    public function getChatMessages($user)
    {
        $result = [];
        $chatMsg = ChatMessage::where(['chat_id' => $this->id])->with(['users'])->orderBy('date_cr', 'asc')->get();
        foreach ($chatMsg as $value) {
            $self = 0;
            $type = 'msg';
            $class = 'lefted';
            $message = $value->message;
            if ($user != null & $user->id == $value->user_id) {
                $self = 1;
                $class = 'righted';
            } else {
                $value->is_read = 1;
                $value->save();
            }
            if ($value->file != null) {
                $type = 'file';
//                $url = $value->getFile();
                $image_type = explode('.', $value->file);

                if(in_array(last($image_type) , ['jpg', 'png', 'jpeg', 'gif']))
                {
                    $message = "<a href='" . route('chat-download', $value->file) . "'><img style='max-width:200px; max-height: 200px' src='" . config('app.imgSiteName') . "/" . config('app.chatRoute') . $value->file . "' alt=''></a>";
                }else{
                    $message = '<a href="' . route('chat-download', $value->file) . '">' . $value->file . '</a>';
                }
            }

            if (date('d.m.Y', strtotime($value->date_cr)) == date('d.m.Y')) {
                $date = date('H:i', strtotime($value->date_cr));
            } else {
                $date = date('H:i d.m.Y', strtotime($value->date_cr));
            }

            $result [] = [
                'id' => $value->id,
                'chat_id' => $value->chat_id,
                'user_id' => $value->user_id,
                'userFio' => $value->users->getUserFio(),
                'userAvatar' => $value->users->getAvatar(),
                'userOnlineStatus' => $value->users->getOnlineStatus(),
                'message' => $message,
                'self' => $self,
                'class' => $class,
                'type' => $type,
                'date_cr' => $date,
                'totalDate' => date('d.m.Y', strtotime($value->date_cr)),
                'is_read' => $value->is_read,
                'answer_to' => $value->answer_to,
            ];
        }
        return $result;
    }

    /**
     * Elon uchun yozilgan xabarlarni barchasini o'chirib tashlash kerak bo'lganda ishlatiladigan funksiya
     *
     * @param int $item_id
     * @throws \Exception
     */
    public static function deleteItemMessage(int $item_id){
        self::where('field_id', $item_id)->delete();
    }

    public function getChatOrCreate(){

    }

}
