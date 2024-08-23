<?php

namespace backend\models\references;

use backend\models\users\Users;
use yii\data\ActiveDataProvider;
use backend\models\references\Translates;
use backend\models\references\Countries;
use backend\models\references\Districts;
use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Regions[] $regions
 */

class Countries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $translation_name;
    public $translation_declination;

    public static function tableName()
    {
        return 'countries';
    }

    /**
     * {@inheritdoc}
     */
    
    public function rules()
    {
        return [
            [['name', 'keyword', 'declination'], 'string', 'max' => 255],
            [['name', 'keyword'], 'required'],
            [['translation_name', 'translation_declination'],'safe'],
            [['name', 'keyword'], 'unique'],
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
            'keyword' => 'keyword',
            'declination' => 'Склонение(где)',
        ];
    }

    public static function NeedTranslation()
    {
        return [
            'name'=>'translation_name',
            'declination'=>'translation_declination',
        ];
    }

    public function beforeDelete()
    {
        $regions = Regions::find()->where(['country_id' => $this->id])->all();
        foreach ($regions as $region){
            $region->delete();
        }
        return parent::beforeDelete();
    }

    /**
     * Gets query for [[Regions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Regions::className(), ['country_id' => 'id']);
    }
}
