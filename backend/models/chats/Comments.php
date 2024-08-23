<?php

namespace backend\models\chats;
use backend\models\chats\Chats;
use backend\models\chats\ChatUsers;
use Yii;
use yii\base\Model;
use backend\models\chats\ChatMessage;
use backend\models\blogs\BlogPosts;
use backend\models\items\Items;
use backend\models\shops\Shops;
use backend\models\users\Users;
use yii\db\Expression;



class Comments extends Model
{       
    public $type;
    public $message;
    public $id;
    public $step;
    public $answer_to;
    public $file;
    public $check_user;
    const USER = 22;
    public function rules()
    {
        return [
            [['id','type'], 'integer'],
            [['message','file'], 'string'],
            [['file','answer_to','check_user'], 'safe'],
            ['type', 'in','range'=>['1','2','3','4','5','6']],
            ['check_user', 'in','range'=>['1','2','3','4']],
            [['check_user'],'required'],
            ['message', 'required', 'when' => function($model) {return $model->step == 1;}, 'enableClientValidation' => false],

        ];
    }

    public function attributeLabels()
    {
        return [
            'message' =>'Сообщения',
            'check_user' => 'Выберите, кому отправить сообщение',
        ];
    }

    public function chatControl($chats = null)
    {
    	$user_id = Yii::$app->user->identity->id;
    	$name = $this->getNameChat($user_id);
    	$chat = $this->checkChat($name , $user_id);
        if($chats) $chat = $chats;
    	if($chat != null){
    		return self::sendMessage($chat->id , $this->message , $user_id);
    	}
    	else {
    		if(self::checkItems($this->id) != $user_id) return $this->createChat($user_id);
    		else return true;
    	}
    }


    // ************************ chat or comment uchun ***********************************
    public function createChat($user_id)
    {	
    	$name = $this->getNameChat($user_id);
        $chat = $this->checkChat($name , $user_id);


        if($chat == null) {
            $chat = new Chats();
            $chat->name = $name;
            $chat->type = $this->type;
            $chat->field_id = $this->id;
            if($this->type == 6) $chat->user_id_item = $user_id;
            $chat->save();

            $chatUser = new ChatUsers();
            $chatUser->chat_id = $chat->id;
            $chatUser->user_id = $user_id;
            $chatUser->save();

            if($this->type == 1 || $this->type == 2){
	            $chatUser = new ChatUsers();
	            $chatUser->chat_id = $chat->id;
	            $chatUser->user_id = $this->id;
	            $chatUser->save();
	        
        	}
            elseif($this->type == 4 || $this->type == 5){
                $chatUser = new ChatUsers();
                $chatUser->chat_id = $chat->id;
                $chatUser->user_id = $this->checkShops();
                $chatUser->save();
            
            }

            elseif($this->type == 6){
                $chatUser = new ChatUsers();
                $chatUser->chat_id = $chat->id;
                $chatUser->user_id = $this->checkItems();
                $chatUser->save();

            }
        }
        self::sendMessage($chat->id , $this->message , $user_id );
        return $chat->id;
    }

    // **************************** send Message **********************************
  	public static function sendMessage($chat_id , $msg , $user_id )
  	{
  	    if($msg) {
            $message = new ChatMessage();
            $message->chat_id = $chat_id;
            $message->user_id = $user_id;
            $message->message = $msg != null ? $msg : null;
            $message->save();
        }

  		$chatUser = ChatUsers::find()->where(['chat_id' => $chat_id, 'user_id' => $user_id])->one();
        if($chatUser == null) {
            $chatUser = new ChatUsers();
            $chatUser->chat_id = $chat_id;
            $chatUser->user_id = $user_id;
            $chatUser->save();
        }
        return $chat_id;
  	}

  	// ******************************* check chat ******************************
  	public function checkChat($name , $user_id)
  	{
  	        if($this->type != 6) {
                $chat = Chats::find()
                    // chat for type = 2
                    ->orWhere(['name' => '#chat_' . $this->id . '_' . $user_id, 'type' => $this->type])
                    ->orWhere(['name' => '#chat_' . $user_id . '_' . $this->id, 'type' => $this->type])
                    /* for admin */
                    ->orWhere(['name' => $name, 'type' => $this->type ,'field_id' => $this->id])
                    // other
//	                ->orWhere(['field_id' => $this->id, 'type' => $this->type])
                    ->one();
            }else {
                $chat = Chats::find()
                    ->andWhere(['field_id' => $this->id, 'type' => $this->type])
                    ->andWhere(['user_id_item' =>$user_id])
                    ->one();
//                echo '<pre>';
//                print_r($chat); die;
            }
	        return $chat; 
  	}

  	// ******************* chatni nomini tekshirish uchuun ********************
  	public function getNameChat($user_id)
  	{
  		switch ($this->type) {
  			case 1: return  "#admin_".$this->id; break;
  			case 2: return  "#chat_".$this->id."_".$user_id; break;
  			case 3: return  "#blogs_".$this->id; break;
  			case 4: return  "#items_".$this->id; break;
            case 5: return  "#shops_".$this->id; break;
            case 6: return  '#'.$this->id.'_'.$user_id."_items_".$this->checkItems(); break;

        }
  	}

    public function checkShops()
    {
        if($this->type == 5){
            $shop = Shops::find()->where(['id' => $this->id])->one();
            return $shop != null ? $shop->user_id : null;
        }
        else {
            $items = Items::findOne($this->id);
            $shop = Shops::find()->where(['id' => $items->shop_id])->one();
            return $shop != null ? $shop->user_id : null;
        }
    }

    public function checkItems()
    {
        $items = Items::findOne($this->id);
        return $items != null ? $items->user_id : null;
    }

    //fayllarini saqlash uchun
    public function UploadImage()
    {   
        $dir = '/web/uploads/chats/';
        $host = Yii::$app->params['host'];
        //host 
        $name = $host['name'];
        $usr = $host['username'];
        $pwd = $host['password'];
       
        // connect to FTP server (port 21)
        $conn_id = ftp_connect($name, 21) or die ("Cannot connect to host");
        
        // send access parameters
        if(ftp_login($conn_id, $usr, $pwd)){
            ftp_pasv($conn_id, true);
        }

        $ext = "";
        $ext = substr(strrchr($_FILES['file']['name'], "."), 1); 
        if($ext != ""){
            $fileName = $this->id . '-' . Yii::$app->security->generateRandomString() . '.' . $ext;
            $ftp_path = $dir.$fileName;
            $ret = ftp_nb_put($conn_id, $ftp_path, $_FILES['file']['tmp_name'], FTP_BINARY);
            while ($ret == FTP_MOREDATA) {
               $ret = ftp_nb_continue($conn_id);
                $this->file = $fileName;
            }
            return Yii::$app->params['mediaSiteName'] . $ftp_path;
            if ($ret != FTP_FINISHED) {
               echo "При загрузке файла произошла ошибка...";
            }
        }
    }

    // ***************** chatlarni type ***************************
    public function getTypeUser()
    {
        return [
            1 => 'Новые участники',
            2 => 'Активные участники',
            3 => 'Участники, у которых есть магазин',
            4 => 'Все участники',
        ];
    }


    // ****************************** chatdagi userlar ro'yxati *******************************
    public function getUsersList()
    {       
        $all_users = Users::find()->join('LEFT JOIN', 'user_roles', 'users.id = user_roles.user_id')->where(['user_roles.role_id'=> self::USER])->asArray()->all();

        $polzovatel = array_column($all_users , 'id');
        $users = [];
        $user_id = Yii::$app->user->identity->id;
        switch ($this->check_user) {
            case 1:   $begin_date = date('Y-m-d H:i', strtotime('-1 WEEK', strtotime(date('Y-m-d H:i'))));
            $users = (new \yii\db\Query())
                        ->select(['id'])
                        ->from('users')
                        ->where(['between' ,'registry_date',$begin_date , date('Y-m-d H:i') ])
                        ->andWhere(['id' => $polzovatel])
                        // ->where(['>','registry_date',new Expression('DATE_SUB(NOW(), INTERVAL 1 WEEK)')])
                        ->all(); break;
            case 2:$begin_date = date('Y-m-d H:i', strtotime('-1 MONTH', strtotime(date('Y-m-d H:i'))));
            $users = (new \yii\db\Query())
                        ->select(['id'])
                        ->from('users')
                        ->where(['between' ,'registry_date',$begin_date , date('Y-m-d H:i') ])
                        ->andWhere(['id' => $polzovatel])
                        // ->where(['>','registry_date',new Expression('DATE_SUB(NOW(), INTERVAL 1 MONTH)')])
                        ->all(); break;
            case 3:$users = (new \yii\db\Query())
                        ->select(['users.id'])
                        ->from('users')
                        ->innerJoin('shops' , 'shops.user_id=users.id')
                        ->where(['id' => $polzovatel])
                        ->all(); break;
            case 4:$users = (new \yii\db\Query())
                        ->select(['id'])
                        ->from('users')
                        ->where(['!=' , 'id' , $user_id])
                        ->andWhere(['id' => $polzovatel])
                        ->all();break;
        }

        return array_column($users , 'id');
    }

    public function sendMultipleMesage()
    {   
        $user_id = Yii::$app->user->identity->id;
        $users = $this->getUsersList();
        $have_chats = Chats::find()->where(['type' => 1])->asArray()->all();
        $chat_array = array_column($have_chats, 'field_id');
        $new_chat_users = array_diff($users , $chat_array);

        $result = [];
        foreach ($new_chat_users as $key => $value) {
            $result [] = [
                'name' => '#admin_'.$value,
                'date_cr' => date('Y-m-d H:i'),
                'type' => '1',
                'field_id' => $value,
            ];
        }

        Yii::$app->db->createCommand()->batchInsert(
        Chats::tableName(), 
        ['name', 'date_cr', 'type' , 'field_id'], 
        $result
        )->execute();

        $new_chats = array_column($result, 'name');
        $chats = Chats::find()->where(['name' => $new_chats, 'type' => 1])->asArray()->all();

        $chat_users = [];
        foreach ($chats as $key => $value) {
            $chat_users [] = [
                'chat_id' => $value['id'] ,
                'user_id' => $value['field_id'],
                'date_cr' => date('Y-m-d H:i'),
            ];

            $chat_users [] = [
                'chat_id' => $value['id'] ,
                'user_id' => $user_id,
                'date_cr' => date('Y-m-d H:i'),
            ];

        }

        Yii::$app->db->createCommand()->batchInsert(
        ChatUsers::tableName(), 
        ['chat_id', 'user_id','date_cr'], 
        $chat_users
        )->execute();

        $chats_all =  Chats::find()->where(['type' => 1 , 'field_id' => $users])->asArray()->all();
        $new_chat_id = array_column($chats_all , 'id');
        $new_message = [];
        foreach ($new_chat_id as $key => $value) {
            $new_message [] = [
                'chat_id' => $value,
                'user_id' => $user_id,
                'message'=> $this->message,
                'date_cr' => date('Y-m-d H:i'),
                'is_read' => false,
            ];
        }

        Yii::$app->db->createCommand()->batchInsert(
        ChatMessage::tableName(), 
        ['chat_id', 'user_id','message','date_cr','is_read'], 
        $new_message
        )->execute();

        return true;
    }
}
