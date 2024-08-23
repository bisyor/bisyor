<?php

namespace backend\models\settings;

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
            'name' => 'Наименование настройки',
            'value' => 'Значение',
            'key' => 'Ключ',
            'group' => 'Группа',
            'type' => 'Тип полей',
        ];
    }

    public function saveSetting($key,$value,$name,$type="string")
    {
        $model = Settings::getDb()->cache(function ($db) use($key) {
            return self::find()->where(['key' => $key])->one();
        });

        if(!$model){
            $model = new Settings();
            $model->group = $group;
            $model->name = $name;
            $model->key = $key;
        }
        $model->value = ($type == 'array') ? implode(",",$value) : $value;
        $model->type = $type;
        $model->save(false);
    }

    public function getModel($key)
    {
        $model = Settings::getDb()->cache(function ($db) use($key) {
            return self::find()->where(['key' => $key])->one();
        });
        return $model;
    }
}
