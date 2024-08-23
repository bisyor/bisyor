<?php

namespace backend\models\references;
use backend\models\references\Translates;

use Yii;

/**
 * This is the model class for table "wordforms".
 *
 * @property int $id
 * @property string|null $sinonim Синоним
 * @property string|null $original Оригинал
 */
class Wordforms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wordforms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sinonim', 'original'], 'string', 'max' => 255],
            [['sinonim'], 'required'],
            [['original'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sinonim' => 'Синоним',
            'original' => 'Оригинал',
        ];
    }
}
