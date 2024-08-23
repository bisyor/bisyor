<?php

namespace backend\models\references;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use backend\models\references\Translates;
use backend\models\references\Districts;

use Yii;

/**
 * This is the model class for table "helps".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property int|null $helps_categories_id категория
 * @property int|null $sorting Сортировка
 * @property string|null $text Текст
 * @property int|null $usefull_count Да
 * @property int|null $nousefull_count Нет
 *
 * @property HelpsCategories $helpsCategories
 */
class Helps extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $translation_name;
    public $translation_text;
 
    public static function tableName()
    {
        return 'helps';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['helps_categories_id', 'sorting', 'usefull_count', 'nousefull_count'], 'default', 'value' => null],
            [['helps_categories_id', 'sorting', 'usefull_count', 'nousefull_count'], 'integer'],
            [['text', 'name', 'helps_categories_id'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['helps_categories_id'], 'exist', 'skipOnError' => true, 'targetClass' => HelpsCategories::className(), 'targetAttribute' => ['helps_categories_id' => 'id']],
             [['translation_name', 'translation_text'],'safe'],
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
            'helps_categories_id' => 'Категория',
            'sorting' => 'Сортировка',
            'text' => 'Текст',
            'usefull_count' => 'Полезно (+)',
            'nousefull_count' => 'Неполезно (-)',
        ];
    }

    public static function NeedTranslation()
    {
        return [
            'name'=>'translation_name',
            'text'=>'translation_text',
        ];
    }


    /**
     * @return array
     */
    public static function getHelpsCategoriesList()
    {
        $helps_categories = HelpsCategories::find()->all();
        return ArrayHelper::map($helps_categories, 'id', 'name');
    }
 
    /**
     * Gets query for [[HelpsCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHelpsCategories()
    {
        return $this->hasOne(HelpsCategories::className(), ['id' => 'helps_categories_id']);
    }
}
