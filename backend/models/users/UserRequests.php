<?php

namespace backend\models\users;

use Yii;

/**
 * This is the model class for table "user_requests".
 *
 * @property int $id
 * @property int|null $user_id Пользователь
 * @property string|null $link Ссылка
 * @property string|null $date_cr Дата создание
 *
 * @property Users $user
 */
class UserRequests extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_requests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['link'], 'string'],
            [['date_cr'], 'safe'],
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
            'link' => 'Ссылка',
            'date_cr' => 'Дата создание',
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
