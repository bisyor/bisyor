<?php

namespace backend\models\references;

use Yii;

/**
 * This is the model class for table "google_analytics".
 *
 * @property int $id
 * @property string|null $name Наименвоание
 * @property string|null $value Значение
 */
class GoogleAnalytics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'google_analytics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименвоание',
            'value' => 'Значение',
        ];
    }
}
