<?php

namespace backend\models\polls;

use Yii;
use backend\models\Users;


/**
 * This is the model class for table "polls_result".
 *
 * @property int $id
 * @property int|null $poll_id Опрос
 * @property int|null $user_id Пользователь
 * @property string|null $user_ip Ip пользовате
 * @property string|null $date_cr Дата созлзда
 * @property int|null $item_id Выбранный отве
 * @property string|null $own_answer Свой вариан
 *
 * @property Polls $poll
 * @property PollsItem $item
 * @property Users $user
 */
class PollsResult extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'polls_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['poll_id', 'user_id', 'item_id'], 'default', 'value' => null],
            [['poll_id', 'user_id', 'item_id'], 'integer'],
            [['date_cr'], 'safe'],
            [['own_answer'], 'string'],
            [['user_ip'], 'string', 'max' => 255],
            [['poll_id'], 'exist', 'skipOnError' => true, 'targetClass' => Polls::className(), 'targetAttribute' => ['poll_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => PollsItem::className(), 'targetAttribute' => ['item_id' => 'id']],
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
            'poll_id' => 'Опрос',
            'user_id' => 'Пользователь',
            'user_ip' => 'Ip пользователя',
            'date_cr' => 'Дата создат',
            'item_id' => 'Выбранный ответ',
            'own_answer' => 'Свой вариант',
        ];
    }

    /**
     * Gets query for [[Poll]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoll()
    {
        return $this->hasOne(Polls::className(), ['id' => 'poll_id']);
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(PollsItem::className(), ['id' => 'item_id']);
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
}
