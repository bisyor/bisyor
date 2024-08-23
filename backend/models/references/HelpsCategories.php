<?php

namespace backend\models\references;
use yii\data\ActiveDataProvider;
use backend\models\references\Translates;
use backend\models\references\Districts;

use Yii;

/**
 * This is the model class for table "helps_categories".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property int|null $sorting Сортировка
 *
 * @property Helps[] $helps
 */
class HelpsCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $translation_name;

    public static function tableName()
    {
        return 'helps_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sorting'], 'default', 'value' => null],
            [['sorting'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['translation_name'],'safe'],
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
            'sorting' => 'Сортировка',
        ];
    }

    public static function NeedTranslation()
    {
        return [
            'name'=>'translation_name',
        ];
    }

    /**
     * Gets query for [[Helps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHelps()
    {
        return $this->hasMany(Helps::className(), ['helps_categories_id' => 'id']);
    }
}
