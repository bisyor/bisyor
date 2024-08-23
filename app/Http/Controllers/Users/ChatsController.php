<?php

namespace App\Http\Controllers\Users;

use Auth;
use App\Http\Controllers\Controller;
use Dejurin\GoogleTranslateForFree;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Models\Chats\Chats;
use App\Models\Items\Items;
use App\Models\Chats\ChatUsers;
use App\Models\Chats\ChatMessage;
use App\Models\References\Additional;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;

class ChatsController extends Controller
{
    /**
     * Foydalanuvchilar o'zlarining yozishmalarini ko'rish sahifasi
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request)
    {
        $user = Auth::user();
        $additional = new Additional();
        $chatsMessage = [];
        $chat = Chats::where(['id' => $request->id])->first();
        if ($chat != null) {
            $chatsMessage = $chat->getChatMessages($user);
        }
        $chatList = Chats::getChatList($request->type_list);

        return view(
            'users.chats.list',
            [
                'nowChat' => $chat,
                'user' => $user,
                'chatList' => $chatList,
                'additional' => $additional,
                'chatsMessage' => $chatsMessage,
            ]
        );
    }

    /**
     * Xabarlar listi
     *
     * @param Request $request
     * @return mixed
     */
    public function messagesList(Request $request)
    {
        $user = Auth::user();
        $chatsMessage = [];
        $chat = Chats::where(['id' => $request->chat_id])->first();
        if ($chat != null) {
            $chatsMessage = $chat->getChatMessages($user);
        }

        return view('users.chats.index', ['chatsMessage' => $chatsMessage, 'nowChat' => $chat]);
    }

    /**
     * Elonlar uchun xabarlar ro'yxato
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function itemMsgList(Request $request)
    {
        $user = Auth::user();
        $additional = new Additional();

        $chatsMessage = [];
        $chat = Chats::where(['id' => $request->id])->first();
        if ($chat != null) {
            $chatsMessage = $chat->getChatMessages($user);
        }
        $chatList = Chats::getItemChatList($user, $request->item_id);

        return view(
            'users.chats.item-chat-list',
            [
                'nowChat' => $chat,
                'user' => $user,
                'chatList' => $chatList,
                'additional' => $additional,
                'chatsMessage' => $chatsMessage,
                'item' => Items::where(['id' => $request->item_id])->first()
            ]
        );
    }

    /**
     * Foydaanuvchi yangi chat yaratish
     * Elon joylashtirga foydalanuvchiga xabar yuborishi
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createChat(Request $request)
    {
        $user = Auth::user();
        $user_id = $request->user_id;
        $item_id = $request->item_id;
        $phone = $request->phone;
        $name = $request->name;
        $msg = 'Запрос на обратный звонок к вашему объявлению №{item_id}:<br/>Тел: {phone}<br/>Имя: {name}<br/>Пожалуйста перезвоните по указанному номеру телефона.';
        $msg = str_replace('{item_id}', $item_id, $msg);
        $msg = str_replace('{phone}', $phone, $msg);
        $msg = str_replace('{name}', $name, $msg);

        $chat = Chats::where(['type' => 1, 'name' => '#admin_' . $user_id])->first();
        if ($chat != null) {
            ChatUsers::createUser(config('app.adminId'), $chat->id);
            ChatUsers::createUser($user_id, $chat->id);
            $chatMsg = ChatMessage::msgCreate($chat->id, $msg, 'msg', config('app.adminId'));
        } else {
            $chat = Chats::where(['type' => 1, 'name' => '#admin_' . $user_id])->first();
            if ($chat != null) {
                ChatUsers::createUser(config('app.adminId'), $chat->id);
                ChatUsers::createUser($user_id, $chat->id);
                ChatMessage::msgCreate($chat->id, $msg, 'msg', config('app.adminId'));
            } else {
                Chats::createAdminChat($user_id, 1, $msg);
            }
        }

        return redirect()->back()->with('success-changed', trans('messages.Successfully sended'));
    }

    /**
     * Mavjud chatda xabar yuborish
     *
     * @param Request $request
     * @throws \Pusher\PusherException
     */
    public function sendMsg(Request $request)
    {
        $user = Auth::user();
        $chatId = $request->chatId;
        $chatMsg = $request->chatMsg;
        $chatMessage = ChatMessage::msgCreate($chatId, $chatMsg, 'msg', $user->id);
        $toUser = ChatUsers::where(['chat_id' => $chatId])->where('user_id', '!=', $user->id)->first();

        $options = array(
            'cluster' => 'ap2',
            'useTls' => true
        );

        $pusher = new Pusher(
            env('SMS_PUSHER_APP_KEY'),
            env('SMS_PUSHER_APP_SECRET'),
            env('SMS_PUSHER_APP_ID'),
            $options,
        );

        $fromMsg = $chatMessage->getMsg($user);
        $fromMsgResult = [
            'userId' => $user->id,
            'userOnline' => $fromMsg['userOnline'],
            'type' => $fromMsg['type'],
            'message' => $fromMsg['message'],
            'file' => $fromMsg['file'],
            'date_cr' => $fromMsg['date_cr'],
            'is_read' => $fromMsg['is_read'],
        ];

        $toMsg = $chatMessage->getMsg($toUser->user);
        $toMsgResult = [
            'userId' => $toUser->user_id,
            'userOnline' => $toMsg['userOnline'],
            'type' => $toMsg['type'],
            'message' => $toMsg['message'],
            'file' => $toMsg['file'],
            'date_cr' => $toMsg['date_cr'],
            'is_read' => $toMsg['is_read'],
        ];

        $data = ['fromMsg' => $fromMsgResult, 'toMsg' => $toMsgResult];
        $pusher->trigger('my-channel', 'my-event', $data);
    }

    /**
     * Xabar bilan birga faylni yuborish
     *
     * @param Request $request
     * @throws \Pusher\PusherException
     */
    public function sendFile(Request $request)
    {
        $user = Auth::user();
        $chatId = $_POST['chat_id'];
        $chatMessage = new ChatMessage();
        $chatMessage->user_id = $user->id;
        $chatMessage->chat_id = $chatId;
        $chatMessage->date_cr = date('Y-m-d H:i:s');
        $chatMessage->is_read = 0;
        $validator = Validator::make(['file' => $request->file('file')], ['file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->get('file')
            ], 400);
        }
        if ($_FILES['file']) {
            $chatMessage->setImage($request->file('file'));
            $chatMessage->save();

            $toUser = ChatUsers::where(['chat_id' => $chatId])->where('user_id', '!=', $user->id)->first();
            $options = array(
                'cluster' => 'ap2',
                'useTls' => true
            );

            $pusher = new Pusher(
                env('SMS_PUSHER_APP_KEY'),
                env('SMS_PUSHER_APP_SECRET'),
                env('SMS_PUSHER_APP_ID'),
                $options,
            );

            $fromMsg = $chatMessage->getMsg($user);
            $fromMsgResult = [
                'userId' => $user->id,
                'userOnline' => $fromMsg['userOnline'],
                'type' => $fromMsg['type'],
                'message' => $fromMsg['message'],
                'file' => $fromMsg['file'],
                'date_cr' => $fromMsg['date_cr'],
                'is_read' => $fromMsg['is_read'],
            ];

            $toMsg = $chatMessage->getMsg($toUser->user);
            $toMsgResult = [
                'userId' => $toUser->user_id,
                'userOnline' => $toMsg['userOnline'],
                'type' => $toMsg['type'],
                'message' => $toMsg['message'],
                'file' => $toMsg['file'],
                'date_cr' => $toMsg['date_cr'],
                'is_read' => $toMsg['is_read'],
            ];

            $data = ['fromMsg' => $fromMsgResult, 'toMsg' => $toMsgResult];
            $pusher->trigger('my-channel', 'my-event', $data);
        }
    }

    /**
     * Xabarda biriktirilgan faylni yuklab olish
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadFile(Request $request)
    {
        $file = config('app.uploadPath') . 'chats/' . $request->fileName;
        return response()->streamDownload(
            function () use ($file) {
                echo file_get_contents($file);
            },
            $request->fileName
        );
    }

    public function translate(Request $request){
        $source = 'auto'; //$source = 'en';
        $target = $request->lang == 'oz' ? 'uz' : $request->lang;
        $attempts = 5;
        $text = $request->message;
        $tr = new GoogleTranslateForFree();
        return  $tr->translate($source, $target, $text, $attempts);
    }
}
