<?php

namespace backend\models\references;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string|null $name Наименование настройки
 * @property string|null $value Значение
 * @property string|null $key Ключ
 * @property string|null $type Тип полей
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'string'],
            [['name', 'key', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'key' => 'Key',
            'type' => 'Type',
        ];
    }
}
