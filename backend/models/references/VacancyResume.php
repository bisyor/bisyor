<?php

namespace backend\models\references;

use Yii;

/**
 * This is the model class for table "vacancy_resume".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $phone Телефон
 * @property string|null $file Файл
 * @property string|null $description Описания
 * @property int|null $vacancy_id
 *
 * @property Vacancies $vacancy
 */
class VacancyResume extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancy_resume';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['vacancy_id'], 'default', 'value' => null],
            [['vacancy_id'], 'integer'],
            [['name', 'phone', 'file'], 'string', 'max' => 255],
            [['vacancy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacancies::className(), 'targetAttribute' => ['vacancy_id' => 'id']],
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
            'phone' => 'Телефон',
            'file' => 'Файл',
            'description' => 'Описания',
            'vacancy_id' => 'Vacancy ID',
        ];
    }

    /**
     * Gets query for [[Vacancy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVacancy()
    {
        return $this->hasOne(Vacancies::className(), ['id' => 'vacancy_id']);
    }
}
