<?php

namespace backend\models\references;

use Yii;

/**
 * This is the model class for table "seo".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $value Значение
 * @property string|null $key Ключ
 * @property string|null $group Группа
 * @property string|null $type Тип полей
 */
class Seo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $translation_name;
    public static function tableName()
    {
        return 'seo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'string'],
            [['name', 'key', 'group', 'type'], 'string', 'max' => 255],
            [['translation_name'],'safe'],
        ];
    }

    public static function NeedTranslation()
    {
        return [
            'name'=>'translation_name',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'value' => 'Значение',
            'key' => 'Ключ',
            'group' => 'Группа',
            'type' => 'Тип полей',
        ];
    }
}
