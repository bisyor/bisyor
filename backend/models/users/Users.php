<?php

namespace backend\models\users;

use backend\models\bills\Bills;
use backend\models\items\Items;
use Yii;
use backend\components\StaticFunction;
use backend\models\chats\Chats;
use backend\models\chats\ChatUsers;
use backend\models\chats\ChatMessage;
use backend\models\references\Districts;
use \yii\helpers\ArrayHelper;
use \yii\helpers\Url;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $login Логин
 * @property string|null $phone Телефон
 * @property string|null $email Эмаил
 * @property string|null $password Пароль
 * @property string|null $fio ФИО
 * @property string|null $avatar Аватар
 * @property int|null $status Статус пользователя 
 * @property int|null $sex Пол
 * @property string|null $lang_code Код языка
 * @property string|null $birthday Дата рождение
 * @property string|null $address Точный адрес
 * @property string|null $phones Допольнителные телефонные номеры
 * @property string|null $coordinate_x Coordinate X
 * @property string|null $coordinate_y Coordinate Y
 * @property string|null $telegram Телеграм Профил
 * @property string|null $site Веб Сайт
 * @property float|null $balance Баланс пользователья
 * @property float|null $referal_balance Реферальный Баланс
 * @property float|null $bonus_balance Бонусный Баланс
 * @property string|null $last_seen Последное активность
 * @property string|null $access_token Токен
 * @property int|null $expiret_at Жизненной цикл
 * @property int|null $district_id Район
 * @property int|null $referal_id Район
 * @property string|null $resume_file Резюме пользователя (файл)
 * @property string|null $admin_comment Комментария админа
 * @property bool|null $email_news_alert Получать рассылку о новостях Bisyor.uz
 * @property bool|null $email_message_alert Получать уведомления о новых сообщениях
 * @property bool|null $email_comment_alert Получать уведомления о новых комментариях на объявления
 * @property bool|null $email_fav_ads_price_alert Получать уведомления об изменении цены в избранных объявлениях
 * @property bool|null $sms_news_alert Получать уведомления о новых сообщениях
 * @property bool|null $sms_comment_alert Получать уведомления о новых комментариях на объявления
 * @property bool|null $sms_fav_ads_price_alert Получать уведомления об изменении цены в избранных объявлениях
 * @property string|null $sms_code Смс код
 * @property bool|null $email_verified E-mail Верифицирован
 * @property bool|null $phone_verified Телефон номер Верифицирован
 * @property string|null $google_api_key Google auth
 * @property string|null $facebook_api_key Facebook auth
 * @property string|null $telegram_api_key Telegram auth
 * @property string|null $apple_api_key  Apple auth
 * @property string|null $registry_date Дата регистрации
 * @property text $block_reason Причина блокировки
 *
 * @property UserHistory[] $userHistories
 * @property UserRoles[] $userRoles
 * @property Districts $district
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $new_password;
    public $image;
    public $resume;
    public $count;
    const EXPIRE_TIME = 3600 * 24 * 7;
    const USER = 22;
    const DIR_NAME = 'avatars';
    const MAN = 1;
    const WOMAN = 2;
    public $from_device;

    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'sex', 'expiret_at', 'district_id'], 'default', 'value' => null],
            [['status', 'sex', 'expiret_at', 'district_id', 'referal_id','count'], 'integer'],
            [['birthday', 'last_seen', 'registry_date'], 'safe'],
            [['address', 'phones', 'admin_comment', 'olx_link'], 'string'],
            [['balance', 'referal_balance', 'bonus_balance'], 'number'],
            [['image','new_password', 'resume'], 'safe'],
            [['email'], 'email'],
            [['is_verify'],'boolean'],
            [['phone', 'email', 'login'], 'unique'],
            [['fio'], 'required'],
            [['phone', 'email'], 'required', 'when' => function(){return !$this->email && !$this->phone;}, 'enableClientValidation' =>false],
            [['email_news_alert', 'email_message_alert', 'email_comment_alert', 'email_fav_ads_price_alert', 'sms_news_alert', 'sms_comment_alert', 'sms_fav_ads_price_alert', 'email_verified', 'phone_verified'], 'boolean'],
            [['login', 'phone', 'email', 'password', 'fio', 'avatar', 'coordinate_x', 'coordinate_y', 'telegram', 'site', 'access_token', 'resume_file', 'sms_code', 'google_api_key', 'facebook_api_key', 'telegram_api_key', 'apple_api_key'], 'string', 'max' => 255],
            ['password', 'required', 'when' => function($model) {return $this->isNewRecord;}, 'enableClientValidation' => false],
            ['block_reason', 'required', 'when' => function($model) {return ($this->status == 3 || $this->status == 4);}, 'enableClientValidation' => false],
            [['password', 'new_password',], 'string', 'min' => 5],
            [['lang_code'], 'string', 'max' => 10],
            ['phone','validateUserPhone'],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => Districts::className(), 'targetAttribute' => ['district_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'phone' => 'Телефон',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'fio' => 'ФИО',
            'referal_id' => 'Реферальный пользователь',
            'avatar' => 'Аватар',
            'status' => 'Статус',
            'sex' => 'Пол',
            'lang_code' => 'Код языка',
            'birthday' => 'Дата рождение',
            'address' => 'Точный адрес',
            'phones' => 'Дополнительные телефонные номеры',
            'coordinate_x' => 'Coordinate X',
            'coordinate_y' => 'Coordinate Y',
            'telegram' => 'Телеграм Профил',
            'site' => 'Веб Сайт',
            'balance' => 'Баланс пользователя',
            'referal_balance' => 'Реферальный Баланс',
            'bonus_balance' => 'Бонусный Баланс',
            'last_seen' => 'Последняя активность',
            'access_token' => 'Токен',
            'expiret_at' => 'Жизненной цикл',
            'district_id' => 'Район',
            'resume_file' => 'Резюме пользователя (файл)',
            'resume' => 'Резюме пользователя (файл)',
            'admin_comment' => 'Комментария админа',
            'email_news_alert' => 'Получать рассылку о новостях Bisyor.uz',
            'email_message_alert' => 'Получать уведомления о новых сообщениях',
            'email_comment_alert' => 'Получать уведомления о новых комментариях на объявления',
            'email_fav_ads_price_alert' => 'Получать уведомления об изменении цены в избранных объявлениях',
            'sms_news_alert' => 'Получать уведомления о новых сообщениях',
            'sms_comment_alert' => 'Получать уведомления о новых комментариях на объявления',
            'sms_fav_ads_price_alert' => 'Получать уведомления об изменении цены в избранных объявлениях',
            'sms_code' => 'Смс код',
            'email_verified' => 'E-mail Верифицирован',
            'phone_verified' => 'Телефон номер Верифицирован',
            'google_api_key' => 'Google auth',
            'facebook_api_key' => 'Facebook auth',
            'telegram_api_key' => 'Telegram auth',
            'apple_api_key' => 'Apple auth',
            'registry_date' => 'Дата регистрации',
            'new_password' => 'Новый пароль',
            'image' => 'Аватар',
            'block_reason' => 'Причина блокировки',
            'olx_link' => 'Olx ссылка пользователя',
            'is_verify' => 'Надежный',
        ];
    }

    public function  validateUserPhone($attribute)
    {
        $this->phone = str_replace('-','',$this->phone);
        $user = Users::find()
            ->andWhere(['phone' =>$this->phone])
            ->one();
        if($user != null && $user->id != $this->id)$this->addError($attribute,'Этот номер телефона уже существует');
    }

    public function beforeSave($insert){
        if ($this->isNewRecord) {
            $this->balance = 0;
            $this->status = 1;
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->access_token = Yii::$app->getSecurity()->generateRandomString();
            $this->login = StaticFunction::Unikal();
            $this->expiret_at = time() + $this::EXPIRE_TIME;
            $this->registry_date = date("Y-m-d H:i");   
            $this->last_seen = date("Y-m-d H:i");   
        }
        $this->phone = str_replace('-', '', $this->phone);
        if (!$this->isNewRecord) {
            if ($this->birthday != null) {
                $this->birthday = date("Y-m-d", strtotime($this->birthday));
            }
        }

        if($this->new_password != null) $this->password = Yii::$app->security->generatePasswordHash($this->new_password);
        if($this->birthday != null) $this->birthday = date("Y-m-d", strtotime($this->birthday ));
        if($this->phone_verified){
            $this->status = 1;
        }
        
        return parent::beforeSave($insert);
    }
    public function afterSave($insert, $changedAttributes)
    {
        if($insert){
                $chat = new Chats();
                $chat->name = '#admin_'.$this->id;
                $chat->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
                $chat->type = 1;
                $chat->save();

                $chat1 = new ChatUsers();
                $chat2 = new ChatUsers();
                
                $chat1->chat_id = $chat->id;
                $chat2->chat_id = $chat->id;
                $chat1->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
                $chat2->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
                $chat1->user_id = 1;
                $chat2->user_id = $this->id;

                $chat1->save();
                $chat2->save();

                $chatMessage = new ChatMessage();
                $chatMessage->chat_id = $chat->id;
                $chatMessage->user_id = 1;
                $chatMessage->message = '"Поздравляем! Вы успешно зарегистрировались на Bisyor.uz"';
                $chatMessage->save();

                $user_history = new UserHistory();
                $user_history->user_id = $this->id;
                $user_history->type = 2;
                $user_history->title = "Регистрация";
                $user_history->value = "Пользователь зарегистрирован";
                $user_history->save();

        } 
        parent::afterSave($insert, $changedAttributes);
    }
    public function beforeDelete()
    {
        $dir = '/web/uploads/'.self::DIR_NAME.'/';
        $conn_id = self::connectFtp();
        if($this->avatar != null){
            if(ftp_size($conn_id, $dir.$this->avatar) != -1){
                ftp_delete($conn_id, $dir . $this->avatar);
            }
        }
        $userRoles = UserRoles::find()->where(['user_id' => $this->id])->all();
        foreach ($userRoles as $value) {
            $value->delete();
        }
        $userHistory = UserHistory::find()->where(['user_id' => $this->id])->all();
        foreach ($userHistory as $value) {
            $value->delete();
        }
        $chats = ChatUsers::find()->where(['user_id' => $this->id])->all();
        foreach ($chats as $value) $value->delete();
        return parent::beforeDelete();
    }
    public function afterFind(){
        if ($this->birthday != null) {
            $this->birthday = date("d.m.Y", strtotime($this->birthday));
        }
        if ($this->coordinate_x == null && $this->coordinate_y == null) {
            $this->coordinate_x = '41.2748753';
            $this->coordinate_y = '69.2071344';
        }
        parent::afterFind();
    }
    public static function getSex()
    {
        return [
            self::MAN => "Мужчина",
            self::WOMAN => "Женщина",
        ];
    }
    /**
     * Gets query for [[UserHistories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserHistories()
    {
        return $this->hasMany(UserHistory::className(), ['user_id' => 'id']);
    }


    /**
     * Gets query for [[UserRoles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles()
    {
        return $this->hasMany(UserRoles::className(), ['user_id' => 'id']);
    }

    public function getBills()
    {
        return $this->hasOne(Bills::className(), ['user_id' => 'id'])->select(['id' , 'status','psystem','user_id']);
    }

    public function getItems()
    {
        return $this->hasMany(Items::className(), ['moderated_id' => 'id'])
            ->count();
    }

    /**
     * Gets query for [[District]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTypeDescription()
    {
        $roles = UserRoles::find()->select('role_id')->where(['user_id' => $this->id])->asArray()->all();
        $res =  array_column($roles, 'role_id');
        
       if (!isset($res)) {
           return  Roles::find()->where(['id' => $res[0]])->one()->name;
       }else return false;
     }

    /**
     * Adminka rasmlar sayt nomini qaytarish uchun
     * @return mixed
     */
    public static function getImageSiteName()
    {
        return Yii::$app->params['image_site'];
    }
    public function getAvatarForSite()
    {
        if ($this->avatar == '') {
            return '/backend/web/img/nouser.png';
        } else {
            return self::getImageSiteName() . "/web/uploads/" . self::DIR_NAME . "/" . $this->avatar;
        }
    }
    public function getAvatar()
    {
        if ($this->avatar == ''){
            return '/backend/web/img/nouser.png';
        }else{
            return self::getImageSiteName() . "/web/uploads/" . self::DIR_NAME . "/" . $this->avatar;
        }
    }

    public static function getAvatarApi($image)
    {
        if ($image == ''){
            return '/backend/web/img/nouser.png';
        }else{
            return self::getImageSiteName() . "/web/uploads/" . self::DIR_NAME . "/" . $image;
        }
    }
    
    public function getDistrict()
    {
        return $this->hasOne(Districts::className(), ['id' => 'district_id']);
    }

    /**
     * FTP server bilan bog'lanishni yoqish
     * @return false|resource
     */
    public static function connectFtp()
    {
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
            return $conn_id;
        }
    }
    public function upload()
    {
        if(!empty($this->image))
        {   $dir = '/web/uploads/'.self::DIR_NAME.'/';
            $conn_id = self::connectFtp();
            if($this->avatar != null){
                if(ftp_size($conn_id, $dir.$this->avatar) != -1){
                        ftp_delete($conn_id, $dir . $this->avatar);
                    }
            }
            $fileName = time() . '_' . $this->image->baseName . '.' . $this->image->extension;
            $ftp_path = $dir.$fileName;
            $ret = ftp_nb_put($conn_id, $ftp_path, $this->image->tempName, FTP_BINARY);
            while ($ret == FTP_MOREDATA) {
                $ret = ftp_nb_continue($conn_id);
            }
            if($ret != FTP_FINISHED){
               return "При загрузке файла произошла ошибка...";
            }
            Yii::$app->db->createCommand()->update('users', ['avatar' => $fileName], [ 'id' => $this->id ])->execute();
        }
    }
    public function uploadResume()
    {
        if(!empty($this->resume))
        {   $dir = '/web/uploads/resume/';
            $conn_id = self::connectFtp();
            if($this->resume_file != null){
                if(ftp_size($conn_id, $dir.$this->resume_file) != -1){
                        ftp_delete($conn_id, $dir . $this->resume_file);
                    }
            }
            $fileName = 'resume_'.time() . '_' . $this->login . '.' . $this->resume->extension;
            $ftp_path = $dir.$fileName;
            $ret = ftp_nb_put($conn_id, $ftp_path, $this->resume->tempName, FTP_BINARY);
            while ($ret == FTP_MOREDATA) {
                $ret = ftp_nb_continue($conn_id);
            }
            if($ret != FTP_FINISHED){
               return "При загрузке файла произошла ошибка...";
            }
            Yii::$app->db->createCommand()->update('users', ['resume_file' => $fileName], [ 'id' => $this->id ])->execute();
        }

        // if(!empty($this->resume)){
        //     if(file_exists('uploads/resume/'.$this->resume_file) && $this->resume_file != null){
        //         unlink('uploads/resume/'.$this->resume_file);
        //     }
        //     $fileName = time() . '_' . $this->resume->baseName . '.' . $this->resume->extension;
        //     $this->resume->saveAs('uploads/resume/' . $fileName);
        //     Yii::$app->db->createCommand()->update('users', ['resume_file' => $fileName], [ 'id' => $this->id ])->execute();
        // }
    }
    public function phones($post){
        $result = [];
        if (isset($post['phones'])) {
            foreach ($post['phones'] as $value) {
                if($value != ''){
                    $result [] = str_replace('-', '', $value);
                }
            }
            $result = json_encode($result);
            Yii::$app->db->createCommand()->update('users', ['phones'=> $result], ['id' => $this->id])->execute();
        }else{
            Yii::$app->db->createCommand()->update('users', ['phones'=> null], ['id' => $this->id])->execute();
        }
    }
    public function getDistricts($id)
    {   
        $region_id = Districts::find()->where(['id' => $id])->one()->region_id;
        return ArrayHelper::map(Districts::find()->where(['region_id' => $region_id])->all(), 'id', 'name');
    }
    public function getRegions()
    {   
        if ($this->district_id) {
            return Districts::find()->where(['id' => $this->district_id])->one()->region_id;
        }
    }

    public function getReferal()
    {
        if($this->referal_id == null) return 'Не задано';
        else{
            $ref = Users::find()->where(['id' => $this->referal_id])->one();
            if($ref == null) return 'Пользователь не найдено';
            else return $ref->getUserFio();
        }
    }

    public function getRoles($type = 'user')
    {   
        if ($type == 'user') {
            return ArrayHelper::map(Roles::find()->asArray()->all(), 'id', 'name');
        }else{
            return ArrayHelper::map(Roles::find()->where(['!=', 'id', self::USER])->asArray()->all(), 'id', 'name');
        }
    }
    public function getActivRoles()
    {   
        $role_id = UserRoles::find()->select('role_id')->where(['user_id' => $this->id])->asArray()->all();
        return array_column($role_id, 'role_id');
    }
    public function getChatMessageCount()
    {
        $chatId = ChatUsers::find()->select('chat_id')->where(['user_id' => $this->id])->asArray()->all();
        $res =  array_column($chatId, 'chat_id');
        return ChatMessage::find()
            ->where(['!=', 'user_id', $this->id])
            ->andWhere(['chat_id' => $res])
            ->andWhere(['is_read' => 0])
            ->count();
    }
    public function setRoles($post){
        $roles = $post['roles'];
        $command =  Yii::$app->db->createCommand();
        if($this->isNewRecord)
            $command->insert('user_roles', ['user_id'=> $this->id, 'role_id'=> self::USER, 'date_cr' => date('Y-m-d H:i')])->execute();
        $userrole = UserRoles::find()->select(['id', 'role_id'])->where(['user_id' => $this->id])->asArray()->all();
        $userroles =  array_column($userrole, 'role_id');
        foreach ($roles as $value) {
            if (!in_array($value, $userroles)) {
               $command->insert('user_roles', [
                    'user_id'=> $this->id,
                    'role_id'=> $value,
                    'date_cr' => date('Y-m-d H:i')
                ])->execute();
            }
        }
        foreach ($userrole as $value) {
            if (!in_array($value['role_id'], $roles)) {
                $command->delete('user_roles', ['id' => $value['id']])->execute();
            }
        }
    }

    /**
     * @param $user
     * @param int $role
     * @throws \yii\db\Exception
     */
    public function setType($user, $role = self::USER){
        Yii::$app->db->createCommand()->insert('user_roles', [
            'user_id'=> $user,
            'role_id'=> $role,
            'date_cr' => date('Y-m-d H:m:s')
        ])->execute();
    }

    public function getUserFio()
    {
        if($this->fio != null) return $this->fio;
        else {
            if($this->email != null) return $this->email;
            else return $this->phone;
        }
    }

    public function getChatUsers()
    {
        $result = [
            'userId' => $this->id,
            'image' => $this->getAvatar(),
            'userFIO' => $this->getUserFio(),
        ];
        return $result;
    }

    //userni magazinlari bulsa olish
    public function getUserShop()
    {
        $query = \backend\models\shops\Shops::find()->where(['user_id' => $this->id]);
        $count = $query->count();
        if($count == 0){
            $url = Url::to(['/shops/shops/create', 'user_id' => $this->id]);
            return 'нет, <a href="' . $url . '"> открыть магазин </a>';
        }else{
            $url = Url::to(['/shops/shops/create','id' => null, 'user_id' => $this->id]);
            return '<a href="'.$url.'">'.$count.' магазина</a>';
        }
    }

    //itemslar soni
    public function getItemsCount()
    {
        $query = \backend\models\items\Items::find()->where(['user_id' => $this->id]);
        $count = $query->count();
        return $count;
    }

    /**
     * Olx uchun user qo'shib berish uchun funksiya
     *
     * @param $phone
     * @param $fio
     * @param $district_id
     * @param $olx_link
     * @return bool
     */
    public static function addUser($phone, $fio, $district_id, $olx_link){
        $model = new self;
        $model->phone = $phone;
        $model->password = $phone;
        $model->fio = $fio;
        $model->district_id = $district_id;
        $model->olx_link = $olx_link;
        if($model->save(false)){
            return $model;
        }
        print_r($model->errors);
        die();

    }

    public function getDevice()
    {
        return $this->hasOne(UserHistory::class, ['user_id' => 'id'])->where(['type' => 2]);
    }

    // chats uchun
    public function getChats()
    {
        $chats = \backend\models\chats\ChatUsers::find()
            ->leftJoin('chats','chats.id=chat_users.chat_id')
            ->where(['chat_users.user_id'=> $this->id])
            ->andWhere(['chats.type' => 1])
            ->one();

        if($chats) {
            return $chats;
        }

        $chat = new Chats();
        $chat->name = '#admin_'.$this->id;
        $chat->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
        $chat->type = 1;
        $chat->save();

        $chat1 = new ChatUsers();
        $chat2 = new ChatUsers();
        
        $chat1->chat_id = $chat->id;
        $chat2->chat_id = $chat->id;
        $chat1->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
        $chat2->date_cr = Yii::$app->formatter->asDate(time(),'php: Y-m-d H:i');
        $chat1->user_id = 1;
        $chat2->user_id = $this->id;

        $chat1->save();
        $chat2->save();

        $chatMessage = new ChatMessage();
        $chatMessage->chat_id = $chat->id;
        $chatMessage->user_id = 1;
        $chatMessage->message = '"Поздравляем! Вы успешно зарегистрировались на Bisyor.uz"';
        $chatMessage->save();
        
        return $chat1;
    }
}

