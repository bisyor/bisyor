<?php

namespace backend\models\users;

use Yii;

/**
 * This is the model class for table "users_banlist".
 *
 * @property int $id
 * @property string|null $ip_list Ip Адрес
 * @property string|null $date_cr Дата создание
 * @property string|null $finished Дата окончание
 * @property int|null $type Тип
 * @property int|null $selected Выбранный
 * @property string|null $description Причина блокировки дост
 * @property string|null $reason Причина, показываемая пользова
 * @property bool|null $exclude Добавить в белый спис
 * @property bool|null $status Статус
 */
class UsersBanlist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_banlist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_cr', 'finished'], 'safe'],
            [['type', 'selected'], 'default', 'value' => null],
            [['ip_list', 'type', 'exclude'], 'required'],
            [['type', 'selected'], 'integer'],
            [['description', 'reason'], 'string'],
            [['exclude', 'status'], 'boolean'],
            [['ip_list'], 'string', 'max' => 255],
            ['finished', 'required', 'when' => function($model) {return ($model->type == 9);}, 'enableClientValidation' => true],
            ['ip_list', 'ipValidate'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip_list' => 'Ip Адрес',
            'date_cr' => 'Дата создание',
            'finished' => 'Дата окончание',
            'type' => 'Тип',
            'selected' => 'Выбранный',
            'description' => 'Причина блокировки дост',
            'reason' => 'Причина, показываемая пользователю',
            'exclude' => 'Добавить в белый список',
            'status' => 'Статус',
        ];
    }
    public function getType(){
        return [
            '1' => 'бессрочно',
            '2' => '30 минут',
            '3' => '1 час',
            '4' => '6 часов',
            '5' => '1 день',
            '6' => '7 дней',
            '7' => '2 недели',
            '8' => '1 месяц',
            '9' => 'До даты ...',
        ];
    }
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $today = date("Y-m-d H:i");
            $this->date_cr = $today;
            switch ($this->type) {
                case 1: $this->finished = null; break;
                case 2: $this->finished = date("Y-m-d H:i", strtotime($today." +30 minute")); break;
                case 3: $this->finished = date("Y-m-d H:i", strtotime($today." +1 hour")); break;
                case 4: $this->finished = date("Y-m-d H:i", strtotime($today." +6 hour")); break;
                case 5: $this->finished = date("Y-m-d H:i", strtotime($today." +1 day")); break;
                case 6: $this->finished = date("Y-m-d H:i", strtotime($today." +1 week")); break;
                case 7: $this->finished = date("Y-m-d H:i", strtotime($today." +2 week")); break;
                case 8: $this->finished = date("Y-m-d H:i", strtotime($today." +1 month")); break;
                case 9: $this->finished = date("Y-m-d H:i", strtotime($this->finished)); break;
            }
        }
        return parent::beforeSave($insert);
    }
    public function ipValidate($attribute){
        $ip_list = explode('*', $this->ip_list);
        foreach ($ip_list as $ip) {
            if (!filter_var($ip, FILTER_VALIDATE_IP)) {
                $this->addError("ip_list", "Это не IP-адрес! Пожалуйста, попробуйте еще раз!");
                return false;
                break;
            }
            return true;
        }
    }
    public function TypeLabel(){
        switch ($this->type) {
            case 1: return "бессрочно";
            case 2: return "30 минут";
            case 3: return "1 час";
            case 4: return "6 часов";
            case 5: return "1 день";
            case 6: return "7 дней";
            case 7: return "2 недели";
            case 8: return "1 месяц";
            case 9: return "До даты ...";
        }
    }
}
