<?php

namespace backend\models\references;
use Yii;

/**
 * This is the model class for table "cache_clear".
 *
 * @property int $id
 * @property string|null $name Наимование
 * @property int|null $minutes Минут
 * @property string|null $key Ключ
 */
class CacheClear extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cache_clear';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['minutes'], 'integer'],
            [['name', 'key'], 'string', 'max' => 255],
            [['name','minutes','key'],'required'],
            [['key'],'unique'],
            ['minutes' ,'validateMinutes',]

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наимование',
            'minutes' => 'Минут',
            'key' => 'Ключ',
        ];
    }


    /**
     * @param $attribute
     * @param $params
     */
    public function validateMinutes($attribute, $params)
    {
        if (!$this->hasErrors()) {

            if ($this->minutes <=0 ) {
                $this->addError($attribute, 'Минус или нулевой ввод невозможен');
            }
        }
    }

}
