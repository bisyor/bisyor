<?php

namespace backend\models\references;

use Yii;
use yii\data\ActiveDataProvider;
use backend\models\references\Translates;
use backend\models\references\Districts;

/**
 * This is the model class for table "currencies".
 *
 * @property int $id
 * @property string|null $code Код валюты
 * @property string|null $short_name Короткое название
 * @property string|null $name Наименование
 * @property float|null $rate Курс валюты
 * @property int|null $sorting Сортировка
 * @property bool|null $enabled Вкл/Отк
 * @property bool|null $default Поумолчанию
 */
class Currencies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const ACTIVE_STATUS = 1;
    const NO_ACTIVE_STATUS = 0;
    public $translation_name;
    public $translation_short_name;

    public static function tableName()
    {
        return 'currencies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rate'], 'number'],
            [['name'], 'required'],
            [['sorting'], 'default', 'value' => null],
            [['sorting'], 'integer'],
            [['enabled', 'default'], 'boolean'],
            [['code', 'short_name', 'name'], 'string', 'max' => 255],
            [['translation_name', 'translation_short_name'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Код валюты',
            'short_name' => 'Короткое название',
            'name' => 'Наименование',
            'rate' => 'Курс валюты',
            'sorting' => 'Сортировка',
            'enabled' => 'Вкл/Отк',
            'default' => 'Поумолчанию',
        ];
    }

    public static function NeedTranslation()
    {
        return [
            'name' => 'translation_name',
            'short_name' => 'translation_short_name',
        ];
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
     * bankdagi kursni olish
     */
    public static function changeRate()
    {
        $kurs = file_get_contents(Yii::$app->params['currenciesCours']);
        $kurs = json_decode($kurs);
        // dollar
        $dollar = Currencies::find()->where(['code' => 'USD'])->one();
        $kurs_dolor = $kurs[0];
        $dollar->rate = $kurs_dolor->Rate;
        $dollar->save();
        // euro
        $euro = Currencies::find()->where(['code' => 'EUR'])->one();
        $kurs_euro = $kurs[1];
        $euro->rate = $kurs_euro->Rate;
        $euro->save();
        // rubl
        $rubl = Currencies::find()->where(['code' => 'RUB'])->one();
        $kurs_rubl = $kurs[2];
        $rubl->rate = $kurs_rubl->Rate;
        $rubl->save();

        $uzs = Currencies::find()->where(['code' => 'UZS'])->one();
        $uzs->rate = 1;
        $uzs->save();
    }
}
