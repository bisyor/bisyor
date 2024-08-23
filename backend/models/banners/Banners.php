<?php

namespace backend\models\banners;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "banners".
 *
 * @property int $id
 * @property string|null $keyword Ключ
 * @property string|null $title  Наименование рекламы
 * @property bool|null $enabled Статус
 * @property float|null $width Ширина
 * @property float|null $height Высота
 * @property bool|null $filter_auth_users Скрывать для авторизованных пользов
 * @property BannersItems[] $bannersItems
 * @property BannersStatistic[] $bannersStatistics
 */
class Banners extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const ACTIVE_STATUS = 1;
    const NO_ACTIVE_STATUS = 0;

    public static function tableName()
    {
        return 'banners';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['enabled', 'filter_auth_users'], 'boolean'],
            [['width', 'height'], 'number'],
            [['keyword','title'], 'required'], 
            [['keyword', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'keyword' => 'Ключ',
            'title' => 'Наименование рекламы',
            'enabled' => 'Статус',
            'width' => 'Ширина',
            'height' => 'Высота',
            'filter_auth_users' => 'Скрывать для авторизованных пользователей',
        ];
    }

    /**
     * Gets query for [[BannersItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBannersItems()
    {
        return $this->hasMany(BannersItems::className(), ['banner_id' => 'id']);
    }

    public function statusname()
    {
        if($this->status == self::ACTIVE_STATUS) return 'Активно';
        else return 'Не активно';
    }

    public function getStatusName()
    {
        if($this->enabled == self::ACTIVE_STATUS) return 'Активно';
        else return 'Не активно';
    } 

    public function getStatusList()
    {
        if($this->filter_auth_users == self::ACTIVE_STATUS) return 'Скрыт';
        else return 'Не скрывать';
    }   
}
