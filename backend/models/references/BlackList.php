<?php

namespace backend\models\references;
use backend\models\references\Translates;

use Yii;

/**
 * This is the model class for table "black_list".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property bool|null $enabled Статус
 */
class BlackList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const ACTIVE_STATUS = 1;
    const NO_ACTIVE_STATUS = 0;

    public static function tableName()
    {
        return 'black_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['enabled'], 'boolean'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'required'],
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
            'enabled' => 'Статус',
        ];
    } 

    public function statusname()
    {
        if($this->status == self::ACTIVE_STATUS) return 'Активно';
        else return 'Не активно';
    }

    public static function getStatusList()
    {
        return [
            self::ACTIVE_STATUS => 'Активно',
            self::NO_ACTIVE_STATUS => 'Не активно'
        ];
    }
}
