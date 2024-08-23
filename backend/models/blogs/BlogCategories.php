<?php

namespace backend\models\blogs;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use backend\models\references\Translates;

use Yii;

/**
 * This is the model class for table "blog_categories".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $key Ключ
 * @property int|null $sorting Сортировка
 * @property string|null $date_cr Дата создание
 * @property bool|null $enabled Статус
 *
 * @property BlogPosts[] $blogPosts
 */

class BlogCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const ACTIVE_STATUS = 1;
    const NO_ACTIVE_STATUS = 0;
    public $translation_name;

    public static function tableName()
    {
        return 'blog_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sorting'], 'default', 'value' => null],
            [['sorting'], 'integer'],
            [['sorting'], 'required'],
            [['date_cr'], 'safe'],
            [['enabled'], 'boolean'],
            [['translation_name'],'safe'],
            [['name', 'key'], 'string', 'max' => 255],
        ];
    }


    /**
     * translation uchun kerakli attribute
     * {@inheritdoc}
     */
    public static function NeedTranslation()
    {
        return [
            'name'=>'translation_name',
        ];
    }
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->date_cr = date("Y-m-d H:i");
        }
        return parent::beforeSave($insert);
    }

    public function statusname()
    {
        if($this->status == self::ACTIVE_STATUS) return 'Активно';
        else return 'Не активно';
    }

    public static function getStatusList()
    {
        return [
            self::ACTIVE_STATUS => 'Активно',
            self::NO_ACTIVE_STATUS => 'Не активно'
        ];
    }
    /**
     * Gets query for [[BlogPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogPosts()
    {
        return $this->hasMany(BlogPosts::className(), ['blog_categories_id' => 'id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'key' => 'Ключ',
            'sorting' => 'Сортировка',
            'date_cr' => 'Дата создание',
            'enabled' => 'Статус',
        ];
    }
}
