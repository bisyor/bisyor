<?php

namespace backend\models\references;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "vacancies".
 *
 * @property int $id
 * @property string|null $title Наименование
 * @property int|null $canacy_count количество вакансий
 */
class Vacancies extends \yii\db\ActiveRecord
{
    public $translation_title;
    public $translation_description;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vacancy_count'], 'default', 'value' => null],
            [['vacancy_count'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['title','vacancy_count','category_id'], 'required'],
            [['translation_title','translation_description'],'safe'],
            [['price'],'safe'],
            [['currency_id'],'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => VacancyCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }


    public static function NeedTranslation()
    {
        return [
            'title'=>'translation_title',
            'description'=>'translation_description',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Наименование',
            'vacancy_count' => 'Количество вакансий',
            'description' => 'Описания',
            'category_id' => 'Категория',
            'price' => 'Цена',
            'currency_id' => 'Валюта',
        ];
    }

    /**
     * Gets query for [[Currency]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currencies::className(), ['id' => 'currency_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(VacancyCategory::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[VacancyResumes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVacancyResumes()
    {
        return $this->hasMany(VacancyResume::className(), ['vacancy_id' => 'id']);
    }


    /**
     * @return array
     * @throws \yii\db\Exception
     */
    public function getCategoriesList()
    {
        $sql = "SELECT r.name as parent, d.id as id, d.name as child FROM vacancy_category AS r, vacancy_category AS d WHERE d.parent_id=r.id;";
        $data = \Yii::$app->db->createCommand($sql)->queryAll();
        return \yii\helpers\ArrayHelper::map($data,'id','child','parent');
    }


    /**
     * @return mixed
     */
    public static  function getCaregoryList()
    {
        $category = VacancyCategory::find()->all();
        return ArrayHelper::map($category, 'id', 'name');
    }


    public static function getCurrdencyList()
    {
        $currency = Currencies::find()->all();
        return ArrayHelper::map($currency, 'id', 'name');
    }

}
