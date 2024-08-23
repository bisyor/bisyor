<?php

namespace backend\models\references;

use yii\data\ActiveDataProvider;
use backend\models\references\Translates;
use backend\models\references\Districts;
use Yii;

/**
 * This is the model class for table "regions".
 *
 * @property int $id
 * @property string|null $name Наименование
 *
 * @property Districts[] $districts
 */
class Regions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $translation_name;
    public $translation_declination;

    public static function tableName()
    {
        return 'regions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'keyword'], 'required'],
            [['name', 'keyword', 'declination'], 'string', 'max' => 255],
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


    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete()
    {
        $distcrits = Districts::find()->where(['region_id' => $this->id])->all();
        foreach ($distcrits as $distcrit){
            $distcrit->delete();
        }
        return parent::beforeDelete();
    }


    /**
     * @return ActiveDataProvider
     */
    public function getSubCategoryList()
    {
        $query = Districts::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['name'=>SORT_ASC]]            
        ]);

        $query->andFilterWhere(['region_id' => $this->id]);
        return $dataProvider;
    }


    /**
     * Gets query for [[Districts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts()
    {
        return $this->hasMany(Districts::className(), ['region_id' => 'id']);
    }
}
