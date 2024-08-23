<?php

namespace backend\models\seobase;

use Yii;

/**
 * This is the model class for table "landingpages".
 *
 * @property int $id
 * @property string|null $landing_uri
 * @property string|null $original_uri
 * @property string|null $title
 * @property string|null $date_cr
 * @property string|null $modified
 * @property int|null $user_id
 * @property string|null $user_ip
 * @property int|null $enabled
 * @property int|null $is_relative
 * @property int|null $joined
 * @property string|null $joined_module
 * @property string|null $titleh1
 * @property string|null $mtitle
 * @property string|null $mkeywords
 * @property string|null $mdescription
 * @property string|null $seotext
 */
class Landingpages extends \yii\db\ActiveRecord
{
    public $translation_title;
    public $translation_mkeywords;
    public $translation_mdescription;
    public $translation_titleh1;
    public $translation_mtitle;
    public $translation_seotext;

    public static function tableName()
    {
        return 'landingpages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['landing_uri', 'original_uri', 'title', 'joined_module', 'titleh1', 'mtitle', 'mkeywords', 'mdescription', 'seotext'], 'string'],
            [['date_cr', 'modified' ,'translation_title' ,'translation_mkeywords' ,'translation_mdescription' ,'translation_titleh1' ,'translation_mtitle' ,'translation_seotext' ], 'safe'],
            [['user_id', 'enabled', 'is_relative', 'joined'], 'integer'],
            [['user_ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'landing_uri' => 'Посадочный URL',
            'original_uri' => 'Оригинальный URL',
            'title' => 'Заголовок',
            'date_cr' => 'Дата создание',
            'modified' => 'Дата изменение',
            'user_id' => 'Пользовател',
            'user_ip' => 'Ip Адрес',
            'enabled' => 'Статус',
            'is_relative' => 'Is Relative',
            'joined' => 'Joined',
            'joined_module' => 'Joined Module',
            'titleh1' => 'Заголовок H1',
            'mtitle' => 'Хлебная крошка',
            'mkeywords' => 'Ключевые слова',
            'mdescription' => 'Описание',
            'seotext' => 'SEO текст',
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
            $this->modified = date("Y-m-d H:i:s");
            $this->user_id = Yii::$app->user->identity->id;
            $this->user_ip = Yii::$app->request->userIP;
        }
        $this->modified = date("Y-m-d H:i:s");
        return parent::beforeSave($insert);
    }


    /**
     * @return string[]
     */
    public static function NeedTranslation()
    {
        return [
            'title'=>'translation_title',
            'mkeywords'=>'translation_mkeywords',
            'mdescription'=>'translation_mdescription',
            'titleh1'=>'translation_titleh1',
            'mtitle'=>'translation_mtitle',
            'seotext'=>'translation_seotext',
        ];
    }
}
