<?php

namespace backend\models\references;

use Yii;
use yii\data\ActiveDataProvider;
use backend\models\references\Subscribers;
use backend\models\users\Users;

/**
 * This is the model class for table "subscribers".
 *
 * @property int $id
 * @property string|null $email E-mail
 * @property string|null $date_cr Дата создание
 */
class Subscribers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscribers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_cr'], 'safe'],
            [['email'], 'string', 'max' => 255],
            [['email'], 'email'],
            //[['date_cr'], 'default', 'value' => date("Y-m-d H:m:s")],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'E-mail',
            'date_cr' => 'Дата создание',
        ];
    }

    public function beforeSave($insert)
    {
        if (!$this->isNewRecord) {
            $this->date_cr = date("Y-m-d H:m:s");
        }

        return parent::beforeSave($insert);
    }
}
