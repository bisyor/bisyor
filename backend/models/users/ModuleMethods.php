<?php

namespace backend\models\users;

use Yii;

/**
 * This is the model class for table "module_methods".
 *
 * @property int $id
 * @property string|null $module Модуль
 * @property string|null $method Метод
 * @property string|null $title Заголовок
 * @property int|null $number Сортировка
 *
 * @property RoleMethods[] $roleMethods
 */
class ModuleMethods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'module_methods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number'], 'default', 'value' => null],
            [['number'], 'integer'],
            [['module', 'method', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module' => 'Module',
            'method' => 'Method',
            'title' => 'Title',
            'number' => 'Number',
        ];
    }

    /**
     * Gets query for [[RoleMethods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoleMethods()
    {
        return $this->hasMany(RoleMethods::className(), ['method_id' => 'id']);
    }
}
