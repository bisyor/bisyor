<?php

namespace backend\models\references;
use backend\models\users\Users;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use backend\models\references\Translates;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string|null $filename Наименование
 * @property int|null $changed_id Заголовок
 * @property string|null $date_cr Дата создание
 * @property string|null $date_up Дата изменение
 * @property bool|null $noindex ishlatmasligimiz ham mumkin
 * @property string|null $title Заголовок
 * @property string|null $description Описание
 * @property string|null $mtitle Meta title
 * @property string|null $mkeywords Meta Keyword
 * @property string|null $mdescription Meta desctiption
 *
 * @property Users $changed
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $translation_description;
    public $translation_mkeywords;
    public $translation_mdescription;
    public $translation_mtitle;
    public $translation_title;
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['changed_id'], 'default', 'value' => null],
            [['changed_id'], 'integer'],
            [['filename'], 'required'],
            [['mkeywords'], 'required'],
            [['date_cr', 'date_up'], 'safe'],
            [['translation_description', 'translation_mkeywords', 'translation_mdescription', 'translation_mtitle', 'translation_title'],'safe'],
            [['noindex'], 'boolean'],
            [['description', 'mtitle', 'mkeywords'], 'string'],
            [['filename', 'title', 'mdescription'], 'string', 'max' => 255],
            [['changed_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['changed_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function NeedTranslation()
    {
        return [
            'title' =>'translation_title',
            'description' => 'translation_description',
            'mkeywords' => 'translation_mkeywords',
            'mdescription' => 'translation_mdescription',
            'mtitle' => 'translation_mtitle',
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Имя файла',
            'title' => 'Заголовок',
            'noindex' => 'Скрыть от индексации',
            'description' => 'Описание',
            'changed_id' => 'Кто изменил',
            'date_cr' => 'Дата создание',
            'date_up' => 'Дата изменение',
            'mtitle' => 'Заголовок (title)',
            'mkeywords' => 'Ключевые слова (meta keywords)',
            'mdescription' => 'Описание (meta desctiption)',
        ];
    }


    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->date_cr = date("Y-m-d H:i:s");
            $this->filename = $this->filename . ".html";
        }
        
        $this->changed_id = Yii::$app->user->identity->id;
        $this->date_up = date("Y-m-d H:i:s");
        
        return parent::beforeSave($insert);
    }


    /**
     * Gets query for [[Changed]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChanged()
    {
        return $this->hasOne(Users::className(), ['id' => 'changed_id']);
    }
}
