<?php

namespace backend\models\items;

use Yii;
use backend\models\references\Translates;
use backend\models\references\Lang;
/**
 * This is the model class for table "categories_dynprops_multi".
 *
 * @property int $id
 * @property int|null $dynprop_id Динамическое свойства
 * @property string|null $name Наименование
 * @property string|null $value Значение
 * @property int|null $num Номер
 *
 * @property CategoriesDynprops $dynprop
 */
class CategoriesDynpropsMulti extends \yii\db\ActiveRecord
{
    public $translation_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories_dynprops_multi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dynprop_id', 'num'], 'default', 'value' => null],
            [['dynprop_id', 'num'], 'integer'],
            [['name', 'value'], 'string', 'max' => 255],
            [['dynprop_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriesDynprops::className(), 'targetAttribute' => ['dynprop_id' => 'id']],
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
            'dynprop_id' => 'Динамическое свойства',
            'translation_name' => 'Наименование',
            'name' => 'Наименование',
            'value' => 'Значение',
            'num' => 'Номер',
        ];
    }

    public function afterFind()
    {
        $this->getTranslations();
        return parent::afterFind();
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        Translates::deleteAll(['table_name'=>$this->tableName(),'field_id'=>$this->id]);
        return true;
    }
    
    public static function NeedTranslation()
    {
        return [
            'name' => 'translation_name',
        ];
    }
    /**
     * Gets query for [[Dynprop]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDynprop()
    {
        return $this->hasOne(CategoriesDynprops::className(), ['id' => 'dynprop_id']);
    }


    /**
     * tarjimalarni olish
     */
    public function getTranslations()
    {
        $langs = Lang::getLanguages();
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

}
