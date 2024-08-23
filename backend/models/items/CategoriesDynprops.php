<?php

namespace backend\models\items;

use Yii;
use yii\helpers\ArrayHelper;
use backend\models\references\Translates;
use backend\models\references\Lang;
/**
 * This is the model class for table "categories_dynprops".
 *
 * @property int $id
 * @property int|null $category_id Категория
 * @property string|null $title Заголовок
 * @property string|null $description Описание
 * @property int|null $type Тип
 * @property string|null $default_value Первоначалная значения
 * @property bool|null $enabled Статус
 * @property string|null $cache_key Кеш ключ
 * @property bool|null $req обязательное (для ввода)
 * @property bool|null $in_search поле поиска
 * @property bool|null $in_seek заполнять в объявлениях типа 'Ищу'
 * @property bool|null $num_first отображать перед наследуемыми (первым)
 * @property int|null $is_cache
 * @property string|null $extra
 * @property int|null $parent с прикреплением
 * @property int|null $parent_value Значение Наследова
 * @property int|null $data_field
 * @property int|null $num Сортировка
 * @property bool|null $txt
 * @property bool|null $in_table
 * @property bool|null $search_hidden
 *
 * @property Categories $category
 * @property CategoriesDynpropsMulti[] $categoriesDynpropsMultis
 */
class CategoriesDynprops extends \yii\db\ActiveRecord
{
    public $translation_title;
    public $translation_description;

    public $default_value_typ1;
    public $translation_default_value_typ1;

    public $default_value_typ2;
    public $translation_default_value_typ2;

    public $default_value_typ4;
    public $default_value_typ5;

    public $group_one_row_type8;
    public $group_one_row_type9;

    public $search_range_user_type10;
    public $search_ranges_type10;

    public $search_range_user_type11;
    public $search_ranges_type11;
    public $start;
    public $end;
    public $step;

    const TYPE1 = 1;
    const TYPE2 = 2;
    const TYPE4 = 4;
    const TYPE5 = 5;
    const TYPE6 = 6;
    const TYPE8 = 8;
    const TYPE9 = 9;
    const TYPE10 = 10;
    const TYPE11 = 11;

    const TYPE_LIST = [
        self::TYPE1 => 'Однострочное текстовое поле',
        self::TYPE2 => 'Многострочное текстовое поле',
        self::TYPE4 => 'Выбор Да/Нет',
        self::TYPE5 => 'Флаг',
        self::TYPE6 => 'Выпадающий список',
        self::TYPE8 => 'Группа св-в с единичным выбором',
        self::TYPE9 => 'Группа св-в с множественным выбором',
        self::TYPE10 => 'Число',
        self::TYPE11 => 'Диапазон'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories_dynprops';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'type', 'is_cache', 'parent', 'parent_value', 'data_field', 'num'], 'default', 'value' => null],
            [['category_id', 'type', 'is_cache', 'parent', 'parent_value', 'data_field', 'num','published_telegram'], 'integer'],
            [['enabled', 'req', 'in_search', 'in_seek', 'num_first', 'txt', 'in_table', 'search_hidden'], 'boolean'],
            [['extra'], 'string'],
            [['title', 'description', 'default_value', 'cache_key'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['title','data_field'],'required'],

            [['translation_title','translation_description', 'default_value_typ1', 'translation_default_value_typ1','default_value_typ1', 'translation_default_value_typ2', 'default_value_typ4','group_one_row_type8','group_one_row_type9','default_value_typ2','search_range_user_type10','default_value_typ5','search_range_user_type11','search_ranges_type10','search_ranges_type11','start','step','end'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'title' => 'Название',
            'description' => 'Уточнение к названию',
            'translation_title' => 'Название',
            'translation_description' => 'Уточнение к названию',
            'type' => 'Тип',
            'default_value_typ1' => 'Значение по-умолчанию',
            'translation_default_value_typ1' => 'Значение по-умолчанию',
            'default_value_typ2' => 'Значение по-умолчанию',
            'translation_default_value_typ2' => 'Значение по-умолчанию',
            'default_value_typ4' => 'Значение по-умолчанию',
            'enabled' => 'Статус',
            'cache_key' => 'Кеш ключ',
            'req' => 'обязательное (для ввода)',
            'in_search' => 'поле поиска',
            'in_seek' => 'заполнять в объявлениях типа \'Ищу\'',
            'num_first' => 'отображать перед наследуемыми (первым)',
            'is_cache' => 'Is Cache',
            'extra' => 'Extra',
            'parent' => 'с прикреплением',
            'parent_value' => 'Наследование',
            'data_field' => 'Поле данных',
            'num' => 'Сортировка',
            'txt' => 'Txt',
            'in_table' => 'In Table',
            'search_hidden' => 'Search Hidden',
            'group_one_row_type8' => 'Отображать в одну строку',
            'group_one_row_type9' => 'Отображать в одну строку',
            'search_range_user_type10' => 'пользовательский вариант',
            'search_range_user_type11' => 'пользовательский вариант',
            'published_telegram' =>'Публикаци телеграм',
        ];
    }


    /**
     * tarjima qilish uchun kerakli polayalar
     * @return string[]
     */
    public static function NeedTranslation()
    {
        return [
            'title' => 'translation_title',
            'description' => 'translation_description',
            'default_value_typ1' => 'translation_default_value_typ1',
            'default_value_typ2' => 'translation_default_value_typ2',
        ];
    }

    public function beforeSave($insert)
    {
        $category = $this->category;
        if($category && $category->ifHaveChild()){
            $this->parent_value = 1;
        }

        return parent::beforeSave($insert);
    }


    public function afterFind()
    {
        $extra = unserialize($this->extra);

        if($this->type == self::TYPE1){
            $this->default_value_typ1 = $this->default_value;
        }

        if($this->type == self::TYPE2){
            $this->default_value_typ2 = $this->default_value;
        }

        if($this->type == self::TYPE4){
            $this->default_value_typ4 = $this->default_value;
        }

        if($this->type == self::TYPE5){
            $this->default_value_typ5 = $this->default_value;
        }

        if($this->type == self::TYPE8){
            $arr = unserialize($this->extra);
            $this->group_one_row_type8 = $arr['group_one_row'];
        }

        if($this->type == self::TYPE9){
            $arr = unserialize($this->extra);
            $this->group_one_row_type9 = $arr['group_one_row'];
        }

        if($this->type == self::TYPE10){
            $arr = unserialize($this->extra);
            $this->search_ranges_type10 = $arr['search_ranges'];
            $this->search_range_user_type10 = $arr['search_range_user'];
        }

        if($this->type == self::TYPE11){
            $arr = unserialize($this->extra);
            $this->search_ranges_type11 = $arr['search_ranges'];
            $this->search_range_user_type11 = $arr['search_range_user'];
            $this->start = $arr['start'];
            $this->end = $arr['end'];
            $this->step = $arr['step'];
        }
        return parent::afterFind();
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[CategoriesDynpropsMultis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesDynpropsMultis()
    {
        return $this->hasMany(CategoriesDynpropsMulti::className(), ['dynprop_id' => 'id']);
    }

    public function getTypeList()
    {
        return self::TYPE_LIST;
    }

    public function getTypeDescription()
    {
        return self::TYPE_LIST[$this->type];
    }

    public function getParent()
    {
        return [
            1 => 'Да',
            0 => 'Нет',
        ];
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        Translates::deleteAll(['table_name'=>$this->tableName(),'field_id'=>$this->id]);
        return true;
    }

    public function getParentDesc()
    {
        return ($this->category->ifHaveChild()) ? "да" : "нет";
    }


    /**
     * variantlarni olish
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getVariants()
    {
        $query = CategoriesDynpropsMulti::find()
                ->where(['dynprop_id' => $this->id])
                ->orderBy(['num' => SORT_ASC]);
        return $query->all();
    }

    public  static function getStartId()
    {
        $sql = "SELECT MAX(id) FROM categories_dynprops_multi;";
        $id = \Yii::$app->db->createCommand($sql)->queryScalar() + 1;
        return $id;
    }

    /**
     * variantlarni saqlash
     * @param $post
     * @param $langs
     */
    public function saveVariants($post,$langs)
    {
        if($this->type == self::TYPE1){
            $this->default_value = $this->default_value_typ1;
            $this->save(false);
        }
        if($this->type == self::TYPE2){
            $this->default_value = $this->default_value_typ2;
            $this->save(false);
        }
        if($this->type == self::TYPE4){
            $this->default_value = $this->default_value_typ4;
            $this->save(false);
        }
        if($this->type == self::TYPE5){
            $this->default_value = $this->default_value_typ5;
            $this->save(false);
        }
        if($this->type == self::TYPE6){
            if(isset($post['type6-checked']) && $post['type6-checked'] == 0){
                $this->default_value = 0;
                $this->save(false);
            }
            if(empty($post['type6-title'])) return;
            if(!isset($post['type6-ids']))$post['type6-ids'] = [];

            if(isset($post['type6-old_ids']) && !empty($post['type6-old_ids'])){
                $deleteIds = array_diff($post['type6-old_ids'],$post['type6-ids']);
                CategoriesDynpropsMulti::deleteAll(['id' => $deleteIds]);
            }
            $titles = $post['type6-title'];
            $sorts = $post['type6-sort'];
            $k = 0;
            for ($i = 0; $i < count($titles); $i = $i + 1) {

                if($i%3 == 0){
                    if(! $model = CategoriesDynpropsMulti::findOne($sorts[$i/3]))
                        $model = new CategoriesDynpropsMulti();
                    $k++;
                }
                if($i%3 == 0){
                    if ($titles[$i]['ru'] == '') {
                        $i = $i + 2;
                        continue;
                    }
                    $model->dynprop_id = $this->id;
                    $model->name = $titles[$i]['ru'];
                    $model->num = $k;
                    $model->save(false);
                    if( isset( $post['type6-checked']) && $post['type6-checked'] && $sorts[$i/3] == $post['type6-checked']){
                        $this->default_value = $model->id;
                        $this->save(false);
                    }
                    Translates::deleteAll(['table_name' => $model->tableName(),'field_id' => $model->id]);
                }else{
                    foreach ($titles[$i] as $key => $value) {
                        $t = new Translates();
                        $t->table_name = $model->tableName();
                        $t->field_id = $model->id;
                        $t->field_name = 'name';
                        $t->field_value = $value;
                        $t->language_code = $key;
                        $t->save(false);
                    }
                }
            }
        }
        if($this->type == self::TYPE8){
            $this->default_value = $post['type8-checked'];
            $this->save(false);

            $arr['group_one_row'] = $this->group_one_row_type8;
            $this->extra = serialize($arr);
            $this->save(false);
            if(empty($post['type8-title'])) return;
            if(!isset($post['type8-ids']))$post['type8-ids'] = [];
            if(isset($post['type8-old_ids']) && !empty($post['type8-old_ids'])){
                $deleteIds = array_diff($post['type8-old_ids'],$post['type8-ids']);
                CategoriesDynpropsMulti::deleteAll(['id' => $deleteIds]);
            }
            $titles = $post['type8-title'];
            $sorts = $post['type8-sort'];
            $k = 0;
            for ($i = 3; $i < count($titles); $i = $i + 1) {

                if($i%3 == 0){
                    if(! $model = CategoriesDynpropsMulti::findOne($sorts[$i/3]))
                        $model = new CategoriesDynpropsMulti();
                    $k++;
                }
                if($i%3 == 0){
                    if ($titles[$i]['ru'] == '') {
                        $i = $i + 2;
                        continue;
                    }
                    $model->dynprop_id = $this->id;
                    $model->name = $titles[$i]['ru'];
                    $model->value = $k;
                    $model->num = $k;
                    $model->save(false);
                    if($sorts[$i/3] == $post['type8-checked']){
                        $this->default_value = $model->id;
                        $this->save(false);
                    }
                    Translates::deleteAll(['table_name' => $model->tableName(),'field_id' => $model->id]);
                }else{
                    foreach ($titles[$i] as $key => $value) {
                        $t = new Translates();
                        $t->table_name = $model->tableName();
                        $t->field_id = $model->id;
                        $t->field_name = 'name';
                        $t->field_value = $value;
                        $t->language_code = $key;
                        $t->save(false);
                    }
                }
            }
        }
        if($this->type == self::TYPE9){
            $arr['group_one_row'] = $this->group_one_row_type9;
            $this->extra = serialize($arr);
            if(empty($post['type9-title'])) return;
            if(!isset($post['type9-ids']))$post['type9-ids'] = [];

            if(isset($post['type9-old_ids']) && !empty($post['type9-old_ids'])){
                $deleteIds = array_diff($post['type9-old_ids'],$post['type9-ids']);

                CategoriesDynpropsMulti::deleteAll(['id' => $deleteIds]);
            }
            $titles = $post['type9-title'];
            $sorts = $post['type9-sort'];
            $checks = $post['type9-radio'];
            $p = 0.5;
            $sum = 0;
            $k = 0;
            for ($i = 3; $i < count($titles); $i = $i + 1) {

                if($i%3 == 0){
                    if(! $model = CategoriesDynpropsMulti::findOne($sorts[$i/3]))
                        $model = new CategoriesDynpropsMulti();
                    $k++;
                }
                if($i%3 == 0){
                    if ($titles[$i]['ru'] == '') {
                        $i = $i + 2;
                        continue;
                    }
                    $p = $p * 2;
                    if($checks[$i/3] == 1){
                        $sum += $p;
                    }
                    $model->value = $p;
                    $model->dynprop_id = $this->id;
                    $model->name = $titles[$i]['ru'];
                    $model->num = $k;
                    $model->save(false);
                    // if($sorts[$i/3] == $post['type9-checked']){
                    //     $this->data_field = $model->id;
                    //     $this->save(false);
                    // }
                    Translates::deleteAll(['table_name' => $model->tableName(),'field_id' => $model->id]);
                }else{
                    foreach ($titles[$i] as $key => $value) {
                        $t = new Translates();
                        $t->table_name = $model->tableName();
                        $t->field_id = $model->id;
                        $t->field_name = 'name';
                        $t->field_value = $value;
                        $t->language_code = $key;
                        $t->save(false);
                    }
                }
            }

            $this->default_value = $sum;
            $this->save(false);
        }

        if($this->type == self::TYPE10){
            $arr['search_range_user'] = $this->search_range_user_type10;
            $k = 1;
            $ranges = [];
            foreach ($post['type10-from'] as $key => $value) {
                if($key == 0) continue;
                $ranges[$k] = [
                    'id' => $k,
                    'from' => $value,
                    'to' => $post['type10-to'][$key]
                ];
                $k++;
            }
            $arr['search_ranges'] = $ranges;
            $this->extra = serialize($arr);
            $this->save(false);
        }

        if($this->type == self::TYPE11){
            $arr['search_range_user'] = $this->search_range_user_type11;
            $k = 1;
            $ranges = [];

            $arr['start'] = $post['type11-start'];
            $arr['end'] = $post['type11-end'];
            $arr['step'] = $post['type11-step'];

            foreach ($post['type11-from'] as $key => $value) {
                if($key == 0) continue;
                $ranges[$k] = [
                    'from' => $value,
                    'to' => $post['type11-to'][$key],
                ];
                $k++;
            }
            $arr['search_ranges'] = $ranges;
            $this->extra = serialize($arr);
            $this->save(false);
        }
    }


    /**
     * tarjimalarni saqlash
     * @param $post
     * @param $langs
     */
    public function SaveTranslates($post,$langs)
    {
        $attr = self::NeedTranslation();
        foreach ($langs as $lang) {
            $l = $lang->url;
            if($l == 'ru'){continue;}
            foreach ($attr as $key=>$value) {
                if(!isset($post["CategoriesDynprops"][$value][$l])) continue;
                $t = Translates::find()->where(['table_name' => $this->tableName(),'field_id' => $this->id,'language_code' => $l,'field_name'=>$key]);
                if($t->count() == 1){
                    $tt = $t->one();
                    $tt->field_value=$post["CategoriesDynprops"][$value][$l];
                    $tt->save();
                }else{
                    $t = new Translates();
                    $t->table_name = $this->tableName();
                    $t->field_id = $this->id;
                    $t->field_name = $key;
                    $t->field_value = $post["CategoriesDynprops"][$value][$l];
                    $t->language_code = $l;
                    $t->save(false);
                }
            }
        }
    }


    /**
     * tarjimalarni olish
     * @param $langs
     */
    public function getTranslations($langs)
    {
        $attr = self::NeedTranslation();
        foreach ($attr as $key => $value) {
            $translations = Translates::find()->where(['table_name' => $this->tableName(), 'field_id' => $this->id,'field_name' => $key])->all();
            foreach ($translations as $translation) {
                $$value[$translation->language_code] = $translation->field_value;
            }
            if(!isset($$value))
                $$value = null;
            $this->{$value} = $$value;
        }
    }

    public function getDataField()
    {
        $data_field = [1=>1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25];
        if(!$this->isNewRecord){
            return  $data_field;
        }
        $categories = \backend\models\items\Categories::getParents($this->category_id);
        $Id = CategoriesDynprops::find()
            ->andWhere(['or',
                ['category_id' => $this->category_id],
                ['category_id' =>$categories]
            ])
            ->select('data_field')
            ->asArray()
            ->all();
        if($Id){
            $Id = array_column($Id ,'data_field');
            return array_diff($data_field , $Id);
        }else{
            return $data_field;
        }

    }
}
