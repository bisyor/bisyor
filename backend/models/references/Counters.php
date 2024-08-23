<?php

namespace backend\models\references;

use Yii;

/**
 * This is the model class for table "counters".
 *
 * @property int $id
 * @property string|null $title Заголовок
 * @property string|null $code
 * @property int|null $code_position
 * @property bool|null $enabled Статус
 * @property string|null $date_cr Дата создание
 * @property int|null $num Сортировка
 */
class Counters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'counters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'string'],
            [['code_position', 'num'], 'default', 'value' => null],
            [['code_position', 'num'], 'integer'],
            [['enabled'], 'boolean'],
            [['date_cr'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'code' => 'Code',
            'code_position' => 'Положение на странице',
            'enabled' => 'Статус',
            'date_cr' => 'Дата создание',
            'num' => 'Сортировка',
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->date_cr = date('Y-m-d H:i');
        }
        return parent::beforeSave($insert);
    }


    /**
     * month name
     * @return string
     */
    public function getMonthName()
    {   
        $name = date('F' , strtotime($this->date_cr));
        $month = "";
        switch ($name) {
            case 'January': $month = 'Январь'; break;
            case 'February': $month = 'Февраль'; break;
            case 'March': $month = 'Март'; break;
            case 'April': $month = 'Апрель'; break;
            case 'May': $month = 'Май'; break;
            case 'June': $month = 'Июнь'; break;
            case 'July': $month = 'Июль'; break;
            case 'August': $month = 'Август'; break;
            case 'September': $month = 'Сентябрь'; break;
            case 'October': $month = 'Октябрь'; break;
            case 'November': $month = 'Ноябрь'; break;
            case 'December': $month = 'Декабрь'; break;
            default: break;
           
        }
        return date('d',strtotime($this->date_cr))." ".$month." ".date('Y',strtotime($this->date_cr)).", ".date('H:i',strtotime($this->date_cr));
    }


    /**
     * status list
     * @return string[]
     */
    public function getStaus()
    {
        return [
            1 => "в блоке head",
            2 => "после открывающим body",
            3 => "перед открывающим body",
            0 => "в подвале сайта",
        ];
    }
}
