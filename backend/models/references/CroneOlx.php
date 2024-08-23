<?php

namespace backend\models\references;

use backend\models\users\Users;
use Yii;

/**
 * This is the model class for table "crone_olx".
 *
 * @property int $id
 * @property int|null $user_id Пользователи
 * @property string|null $today_date Дата
 * @property int|null $status Статус
 * @property string|null $olx_link Olx link
 *
 * @property Users $user
 */
class CroneOlx extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crone_olx';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'default', 'value' => null],
            [['user_id', 'status'], 'integer'],
            [['today_date'], 'safe'],
            [['olx_link'], 'string', 'max' => 255],
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
            'user_id' => 'User ID',
            'today_date' => 'Today Date',
            'status' => 'Status',
            'olx_link' => 'Olx Link',
        ];
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
