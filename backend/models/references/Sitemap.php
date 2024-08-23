<?php

namespace backend\models\references;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "sitemap".
 *
 * @property int $id
 * @property int|null $sitemap_id Меню
 * @property string|null $name Наименвоание
 * @property int|null $type Тип
 * @property string|null $keyword Ключ
 * @property string|null $link Ссылка
 * @property string|null $target Таргет
 * @property bool|null $is_system Системный или нет
 * @property bool|null $allow_submenu
 * @property bool|null $enabled Статус
 * @property string|null $date_cr Дата создания
 *
 * @property Sitemap $sitemap
 * @property Sitemap[] $sitemaps
 */
class Sitemap extends \yii\db\ActiveRecord
{

    const TYPE_ONE = 1;
    const TYPE_TWO = 2;
    const TYPE_THIRD = 3;
    const TYPE_FOURTH = 4;
    const TARGET_SELF = '_self';
    const TARGET_BLANK = '_blank';
    public $translation_name;
    public $pages;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sitemap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sitemap_id', 'type'], 'default', 'value' => null],
            [['sitemap_id', 'type'], 'integer'],
            [['is_system', 'allow_submenu', 'enabled'], 'boolean'],
            [['date_cr',  'translation_name', 'pages'], 'safe'],
            [['name', 'keyword', 'link', 'target'], 'string', 'max' => 255],
            [['type', 'name', 'keyword'], 'required', 'when' => function($model){return ($model->isNewRecord);}, 'enableClientValidation' => true],
            [['keyword'], 'unique'],
            [['link'], 'required', 'when' => function($model){return ($model->isNewRecord && $model->type != 2);}, 'enableClientValidation' => true],
            ['pages', 'required', 'when' => function($model){return ($model->isNewRecord && $model->type == 2);}, 'enableClientValidation' => true],
            [['sitemap_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sitemap::className(), 'targetAttribute' => ['sitemap_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sitemap_id' => 'Меню',
            'name' => 'Название',
            'type' => 'Тип',
            'keyword' => 'Ключ',
            'link' => 'Ссылка',
            'target' => 'Таргет',
            'is_system' => 'Системный или нет',
            'allow_submenu' => 'Разрешать вложенные меню',
            'enabled' => 'Статус',
            'date_cr' => 'Дата создания',
        ];
    }


    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert){
            if ($this->isNewRecord){
                $this->date_cr = date("Y-m-d H:i:s");
                $this->is_system = 1;
                $this->enabled = 1;
            }
            if($this->type == 2){
                $this->link = Pages::findOne($this->pages)->filename;
            }
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }


    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete()
    {
        $model = Sitemap::find()->where(['sitemap_id' => $this->id])->all();
        foreach ($model as $value){
            $value->delete();
        }
        $translate = Translates::find()->where(['field_id' => $this->id])->all();
        foreach ($translate as $value){
            $value->delete();
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    /**
     * Gets query for [[Sitemap]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSitemap()
    {
        return $this->hasOne(Sitemap::className(), ['id' => 'sitemap_id']);
    }

    /**
     * Gets query for [[Sitemaps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSitemaps()
    {
        return $this->hasMany(Sitemap::className(), ['sitemap_id' => 'id']);
    }


    /**
     * @return ActiveDataProvider
     */
    public function getSubMenuList()
    {
        $query = Sitemap::find()->orderBy(['id' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
        $query->andFilterWhere(['sitemap_id' => $this->id]);
        return $dataProvider;
    }


    /**
     * @return string[]
     */
    public static function getType()
    {
        return [
            self::TYPE_ONE => 'Меню',
            self::TYPE_TWO => 'Ссылка на текстовую страницу',
            self::TYPE_THIRD => 'Ссылка',
            self::TYPE_FOURTH => '',
        ];
    }


    /**
     * @return string[]
     */
    public static function NeedTranslation()
    {
        return [
            'name'=>'translation_name',
        ];
    }


    /**
     * @return string[]
     */
    public static function getTarget()
    {
       return [
           self::TARGET_BLANK => 'в новом окне',
           self::TARGET_SELF => 'в текушем  окне'
       ];
    }


    /**
     * @param $id
     * @return string
     */
    public function getRoot($id)
    {
        $result = '';
        $sitemap = Sitemap::find()->asArray()->orderBy(['id' => SORT_ASC])->all();
        $sitemap_name = array_column($sitemap, 'name', 'id');
        $sitemap = array_column($sitemap, 'sitemap_id', 'id');
        do{
            $id = $sitemap[$id];
            $result = $sitemap_name[$id] . " > " . $result;

        }while($id != 1);
        return rtrim( $result, ' > ');
    }
}
