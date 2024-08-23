<?php

namespace App\Models\Chats;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Chats\ChatMessage
 *
 * @mixin IdeHelperChatMessage
 */

class ChatMessage extends Model
{
    protected $table = 'chat_message';
    public $timestamps = false;
    protected $fillable = ['chat_id', 'user_id', 'message', 'file', 'date_cr', 'is_read', 'answer_to'];

    /**
     * Foydalanuvchilar jadvali bilan bog'lanish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Faylni qaytarish
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    public function getFile()
    {
        if ($this->file == null || $this->file == '') {
            return config('app.noImage');
        } else {
            return config('app.uploadPath') . 'chats/' . $this->file;
        }
    }

    /**
     * Xabarni olish
     *
     * @param $user
     * @return array
     */
    public function getMsg($user)
    {
        $userPrefix = '';
        if ($this->user_id == $user->id) {
            $userPrefix = trans('messages.You') . ': ';
        }

        if ($this->message != null) {
            $type = 'msg';
            $msg = strip_tags($this->message);
        } else {
            $type = 'file';
            $msg = trans('messages.File');
        }

        if (date('d.m.Y', strtotime($this->date_cr)) == date('d.m.Y')) {
            $date = date('H:i', strtotime($this->date_cr));
        } else {
            $date = date('d.m.Y', strtotime($this->date_cr));
        }

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'userFio' => $this->users->getUserFio(),
            'userAvatar' => $this->users->getAvatar(),
            'userOnline' => $this->users->getOnlineStatus(),
            'type' => $type,
            'message' => $userPrefix . $msg,
            'file' => $this->file,
            'date_cr' => $date,
            'time' => strtotime($this->date_cr),
            'is_read' => $this->is_read,
            'answer_to' => $this->answer_to,
        ];
    }

    /**
     * Yangi xabar yaratish
     *
     * @param $chat_id
     * @param $msg
     * @param $type
     * @param $user_id
     * @return ChatMessage
     */
    public static function msgCreate($chat_id, $msg, $type, $user_id)
    {
        $msg = str_replace('\n', '<br />', $msg);
        $chatMsg = new ChatMessage();
        $chatMsg->chat_id = $chat_id;
        $chatMsg->user_id = $user_id;
        if ($type == 'msg') {
            $chatMsg->message = $msg;
        }
        $chatMsg->date_cr = date('Y-m-d H:i:s');
        $chatMsg->is_read = 0;
        $chatMsg->save();
        return $chatMsg;
    }

    public function setImage($file)
    {
        //get filename with extension
        $filenamewithextension = $file->getClientOriginalName();

        //get filename without extension
        $filename = \Str::snake(pathinfo($filenamewithextension, PATHINFO_FILENAME));

        //get file extension
        $extension = $file->getClientOriginalExtension();

        //filename to store
        $filenametostore = $filename . '_' . time() . '.' . $extension;

        //Upload File to external server
        $uploadPath = config('app.chatRoute');
        Storage::disk('ftp')->put($uploadPath . $filenametostore, fopen($file, 'r+'));

        //Store $filenametostore in the database
        $this->file = $filenametostore;
    }

}
