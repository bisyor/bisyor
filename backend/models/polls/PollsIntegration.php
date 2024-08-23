<?php

namespace backend\models\polls;

use Yii;
use backend\models\references\Lang;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "polls_integration".
 *
 * @property int $id
 * @property int|null $poll_id Опроса
 * @property int|null $type Отобразить
 * @property bool|null $frame Цвет рамки
 * @property string|null $frame_color Цвет
 * @property bool|null $background Цвет фона
 * @property string|null $background_color Цвет
 * @property int|null $language_id Язык
 * @property bool|null $result Цвет результата
 * @property string|null $result_color Цвет
 * @property string|null $code Код для вставки
 *
 * @property Lang $language
 * @property Polls $poll
 */
class PollsIntegration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'polls_integration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['poll_id', 'type', 'language_id'], 'default', 'value' => null],
            [['poll_id', 'type', 'language_id'], 'integer'],
            [['frame', 'background', 'result'], 'boolean'],
            [['code'], 'string'],
            [['frame_color', 'background_color', 'result_color'], 'string', 'max' => 255],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['poll_id'], 'exist', 'skipOnError' => true, 'targetClass' => Polls::className(), 'targetAttribute' => ['poll_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'poll_id' => 'Опроса',
            'type' => 'Отобразить',
            'frame' => 'Цвет рамки',
            'frame_color' => 'Цвет',
            'background' => 'Цвет фона',
            'background_color' => 'Цвет',
            'language_id' => 'Язык',
            'result' => 'Цвет результата',
            'result_color' => 'Цвет',
            'code' => 'Код для вставки',
        ];
    }

    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Lang::className(), ['id' => 'language_id']);
    }

    /**
     * Gets query for [[Poll]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoll()
    {
        return $this->hasOne(Polls::className(), ['id' => 'poll_id']);
    }

    public function getType()
    {
        return [
            1 => "Форму",
            2 => "Результать",
        ];
    }

    public function getTypeDescription()
    {
        switch ($this->type) {
            case 1: return "Форму";
            case 2: return "Результат";
            default: return "Неизвестно";
        }
    }

    public function getLangList()
    {
        $list = Lang::getLanguages();
        return ArrayHelper::map($list, 'id','local');
    }

}
