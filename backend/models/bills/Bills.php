<?php

namespace backend\models\bills;

use backend\models\items\Items;
use backend\models\promocodes\Promocodes;
use backend\models\references\Currencies;
use backend\models\shops\Services;
use backend\models\users\Roles;
use backend\models\users\UserRoles;
use backend\models\users\Users;
use phpDocumentor\Reflection\Types\Array_;
use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "bills".
 *
 * @property int $id
 * @property int|null $user_id Пользователь
 * @property float|null $user_balance Баланс пользователя
 * @property int|null $service_id Сервиз
 * @property bool|null $svc_activate Статус активации сервиса
 * @property string|null $svc_settings Настройки сервиса
 * @property int|null $item_id Объявление
 * @property int|null $type Тип
 * @property int|null $psystem Система оплаты
 * @property float|null $amount Сумма
 * @property float|null $money Денги
 * @property int|null $currency_id Валюта
 * @property string|null $date_cr Дата создание
 * @property string|null $date_pay Дата оплаты
 * @property int|null $status Статус
 * @property string|null $description Описание
 * @property string|null $details Деталь
 * @property string|null $ip Ip Пользователя
 * @property int|null $promocode_id Промо код
 *
 * @property Currencies $currency
 * @property Items $item
 * @property Promocodes $promocode
 * @property Services $service
 * @property Users $user
 */
class Bills extends \yii\db\ActiveRecord
{
    const STATUS_NEZAVERSHEN = 1;
    const STATUS_ZAVERSHEN = 2;
    const STATUS_OTMEN = 3;
    const STATUS_OBRABOT = 4;
    const TYPE_PAY = 1;
    const TYPE_PPRIZ = 2;
    const TYPE_REMOTE = 3;
    const TYPE_NON = 4;
    const TYPE_PAY_SER = 5;
    const P_SYSTEM_PAY_ME = 145;
    const P_SYSTEM_CLICK = 146;
    const P_SYSTEM_PAYNET = 147;

    const USER_ROLE_FILTER = 22;

    const PY_SYSTEMS_LIST = [self::P_SYSTEM_PAY_ME , self::P_SYSTEM_CLICK , self::P_SYSTEM_PAYNET];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bills';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'service_id', 'item_id', 'type', 'psystem', 'currency_id', 'status', 'promocode_id'], 'default', 'value' => null],
            [['user_id', 'service_id', 'item_id', 'type', 'psystem', 'currency_id', 'status', 'promocode_id'], 'integer'],
            [['user_balance', 'amount', 'money'], 'number'],
            [['svc_activate'], 'boolean'],
            [['svc_settings', 'description', 'details'], 'string'],
            [['date_cr', 'date_pay'], 'safe'],
            [['ip'], 'string', 'max' => 255],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currencies::className(), 'targetAttribute' => ['currency_id' => 'id']],
            //[['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Items::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['promocode_id'], 'exist', 'skipOnError' => true, 'targetClass' => Promocodes::className(), 'targetAttribute' => ['promocode_id' => 'id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['service_id' => 'id']],
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
            'user_balance' => 'Баланс пользователя',
            'service_id' => 'Сервиз',
            'svc_activate' => 'Статус активации сервиса',
            'svc_settings' => 'Настройки сервиса',
            'item_id' => 'Объявление|Магазин',
            'type' => 'Тип',
            'psystem' => 'Система оплаты',
            'amount' => 'Сумма',
            'money' => 'Денги',
            'currency_id' => 'Валюта',
            'date_cr' => 'Дата создание',
            'date_pay' => 'Дата оплаты',
            'status' => 'Статус',
            'description' => 'Описание',
            'details' => 'Деталь',
            'ip' => 'Ip Пользователя',
            'promocode_id' => 'Промо код',
        ];
    }

    // public static function getUsersList()
    // {
    //     $users = Users::find()->all();
    //     return ArrayHelper::map($users,'id',isset($users->phone) ? 'phone':'email');
    // }

    public static function getUsersList()
    {
        $data = Users::find()->select(['id','phone','email'])->asArray()->all();
        $arr = [];
        foreach ($data as $key => $value) {
            $arr[$value['id']] = $value['phone'] ? $value['phone'] :$value['email'];
        }
        return $arr;
    }

    /**
     * Gets query for [[Currency]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currencies::className(), ['id' => 'currency_id']);
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    /*public function getItem()
    {
        return $this->hasOne(Items::className(), ['id' => 'item_id']);
    }*/

    /**
     * Gets query for [[Promocode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromocode()
    {
        return $this->hasOne(Promocodes::className(), ['id' => 'promocode_id']);
    }

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Services::className(), ['id' => 'service_id']);
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

    public static function getStatus()
    {
        return [
            self::STATUS_NEZAVERSHEN => 'Незавершен',
            self::STATUS_ZAVERSHEN => 'Завершен',
            self::STATUS_OTMEN => 'Отменен',
            self::STATUS_OBRABOT => 'Обрабатывается',
        ];
    }
    public static function monthName()
    {
        return [
            1 => 'Января', 2 => 'Февраля', 3 => 'Марта', 4 => 'Апреля',
            5 => 'Мая', 6 => 'Июня', 7 => 'Июля', 8 => 'Августа',
            9 => 'Сентября', 10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря'
        ];
    }
    public static function getType()
    {
        return [
            self::TYPE_PAY => 'Пополнение счета',
            self::TYPE_PPRIZ=> 'Подарок',
            self::TYPE_REMOTE => 'списание со счета',
            self::TYPE_PAY_SER => 'Оплата услуги'
        ];
    }

    public static function getStatistics()
    {
        return [
            1 => 'Сегодня',
            2 => 'Вчера',
            3 => 'Последный 7 дней',
            4 => 'Последный 30 дней',
            5 => 'Последный 90 дней',
            6 => 'Год',
//            7 => 'Диапазон даты',
        ];
    }

    public static function getUsersListId()
    {
        $roles = UserRoles::find()
            ->where(['role_id' => self::USER_ROLE_FILTER])
            ->select('user_id')
            ->asArray()
            ->all();

        if($roles){
            return array_column($roles,'user_id');
        }
        return null;
    }

    public static function getPaySystem() : array
    {
        return [
            self::P_SYSTEM_CLICK=> 'Click',
            self::P_SYSTEM_PAY_ME => 'PayMe',
            self::P_SYSTEM_PAYNET => 'PayNet'];
    }

    public static function getBillsBalance($id)
    {
        $model = Users::find()->where(['id' => $id])->orderBy(['id' =>SORT_DESC])->one();
        if($model) return $model->balance; else return 0;
    }
}
