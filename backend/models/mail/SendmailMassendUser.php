<?php

namespace backend\models\mail;

use backend\models\settings\SystemSettings;
use Yii;
use backend\models\users\Users;
use yii\base\BaseObject;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "sendmail_massend_user".
 *
 * @property int $id
 * @property int|null $user_id
 * @property bool|null $to_phone
 * @property bool|null $to_email
 * @property int|null $massend_id
 * @property int|null $service_id
 * @property string|null $title
 * @property string|null $phone
 * @property string|null $text
 * @property int|null $status
 * @property string|null $date_cr
 *
 * @property SendmailMassend $massend
 * @property Users $user
 */
class SendmailMassendUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sendmail_massend_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'massend_id', 'status'], 'default', 'value' => null],
            [['user_id', 'massend_id', 'status' ,'service_id'], 'integer'],
            [['to_phone', 'to_email'], 'boolean'],
            ['date_cr', 'safe'],
            [['text'], 'string'],
            [['title','phone'], 'string', 'max' => 255],
            [['massend_id'], 'exist', 'skipOnError' => true, 'targetClass' => SendmailMassend::className(), 'targetAttribute' => ['massend_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'to_phone' => 'К телефону',
            'to_email' => 'На электронную почту',
            'massend_id' => 'Massend ID',
            'title' => 'Тема',
            'text' => 'Сообщение',
            'status' => 'Статус',
            'date_cr' => 'Дата создание',
            'service_id' => 'Service id',
            'phone' => 'Телефон',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord)
        {
            $this->date_cr = date("Y-m-d H:i:s");
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[Massend]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMassend()
    {
        return $this->hasOne(SendmailMassend::className(), ['id' => 'massend_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
    public static function search($params, $id)
    {
        $query = SendmailMassendUser::find()->joinWith('user')->where(['massend_id' => $id]);
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
    public function getSmsAccessToken()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "notify.eskiz.uz/api/auth/login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('email' => Yii::$app->params['smsServisEmail'], 'password' => Yii::$app->params['smsServisPassword']),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response)->data->token;
    }

    public function sendSms($phone, $text, $token)
    {   
        $phone = str_replace('+','',$phone);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "notify.eskiz.uz/api/message/sms/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('mobile_phone' => $phone, 'message' => $text , 'from' => 'Bisyor'),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $token
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return true;
    }

    public function sendEmail()
    {
        return Yii::$app->mailer
            ->compose()
            ->setFrom(['bisyorrobot@gmail.com' => 'Bisyor.uz'])
            ->setTo($this->user->email)
            ->setSubject('Рассылка')
            ->setHtmlBody($this->text)->send();
    }

    public function validateNumber($phone)
    {   

        $phone = str_replace('+','',$phone);
        $subject = $phone;
        $pattern_phone_number = '/^998(9[012345789]|6[125679]|7[01234569])[0-9]{7}$/';
        $pattern_a_z = '/[a-z]$/';
        preg_match($pattern_a_z,$subject, $matches_a_z, PREG_OFFSET_CAPTURE);
        if(!$matches_a_z){
            preg_match($pattern_phone_number,$subject, $matches__phone_number, PREG_OFFSET_CAPTURE);
            if($matches__phone_number){
                return true;
            }
            else return  false;
        }
        return false;
    }

    public function sendOurSmsServiceData($phone , $message){
        $settings = SystemSettings::find()->where(['key' => 'sms_service_token'])->one();
        $token = $settings ? $settings->value : null;
        $data = (object)[
            'data' => (object)[
                'phone' => $phone,
                'code' => null,
                'message' => $message,
            ],
            'registration_ids' => [$token],
        ];
        $this->sendSmsService($data);
        return true;
    }

    public function sendSmsService($data)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $data_string = json_encode($data);
        $ch=curl_init($url);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json; charset=UTF-8',
                'Authorization: key='.Yii::$app->params['fireBase'],
            )
        );
        $result = curl_exec($ch);
        curl_close($ch);
        return true;
    }
}
