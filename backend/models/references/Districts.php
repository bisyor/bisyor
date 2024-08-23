<?php

namespace backend\models\references;

use Yii;
use backend\models\references\Regions;

/**
 * This is the model class for table "districts".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property int|null $last_id Old id
 * @property int|null $region_id Oбласть
 *
 * @property Regions $region
 */
class Districts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $translation_name;
    public $translation_declination;
    public static function tableName()
    {
        return 'districts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id'], 'integer'],
            [['name', 'keyword'], 'required'],
            [['name', 'keyword'], 'unique'],
            [['name', 'declination', 'coordinate_x', 'coordinate_y', 'keyword'], 'string', 'max' => 255],
            [['translation_name', 'translation_declination'], 'safe'],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::className(), 'targetAttribute' => ['region_id' => 'id']],
            [['metro'], 'boolean'],
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
            'region_id' => 'Oбласть',
            'keyword' => 'URL-keyword',
            'declination' => 'Склонение(где)',
            'coordinate_x' => 'координата_x',
            'coordinate_y' => 'координата_y',
            'metro' => 'Есть метро',
        ];
    }

    public static function NeedTranslation()
    {
        return [
            'name'=>'translation_name',
            'declination'=>'translation_declination',
        ];
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Regions::className(), ['id' => 'region_id']);
    }
}
