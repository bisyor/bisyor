<?php

namespace backend\models\references;

use yii\data\ActiveDataProvider;
use backend\models\references\Translates;

use Yii;

/**
 * This is the model class for table "vacancy_category".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property int|null $parent_id Категория вакансии
 * @property bool|null $is_parent
 * @property int|null $status Статус
 *
 * @property VacancyCategory $parent
 * @property VacancyCategory[] $vacancyCategories
 */
class VacancyCategory extends \yii\db\ActiveRecord
{
    public $translation_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancy_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'status'], 'default', 'value' => null],
            [['parent_id', 'status'], 'integer'],
            [['translation_name'],'safe'],
            [['is_parent'], 'boolean'],
            [['name'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => VacancyCategory::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'parent_id' => 'Категория вакансии',
            'is_parent' => 'Is Parent',
            'status' => 'Статус',
        ];
    }
    public static function NeedTranslation()
    {
        return [
            'name'=>'translation_name',
        ];
    }

    /**
     * @return ActiveDataProvider
     */
    public function getChildList()
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['name'=>SORT_ASC]]            
        ]);

        $query->andFilterWhere(['parent_id' => $this->id]);
        return $dataProvider;
    }
    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(VacancyCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[VacancyCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVacancyCategories()
    {
        return $this->hasMany(VacancyCategory::className(), ['parent_id' => 'id']);
    }

    public static function getStatusName($status = null)
    {
        return ($status == 1) ? '<span class="text-success text-muted">Активно</span>' : '<span class="text-danger text-muted">Не активно</span>';
    }
}
