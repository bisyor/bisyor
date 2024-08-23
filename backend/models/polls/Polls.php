<?php

namespace backend\models\polls;

use Yii;
use backend\models\polls\PollsResult;
use backend\models\polls\PollsIntegration;


/**
 * This is the model class for table "polls".
 *
 * @property int $id
 * @property string|null $name Название опроса
 * @property string|null $start Дата начало
 * @property string|null $finish Дата завершени
 * @property int|null $status Статус
 * @property int|null $finish_type Дата завершени
 * @property bool|null $ownoption Свой вариант
 * @property string|null $ownoption_text Текст подсказки
 * @property int|null $choice Выбор ответа
 * @property int|null $view_result Отображать результаты
 * @property bool|null $resultvotes Отображать количество голосов
 * @property bool|null $showfinishing Отображать дату завершения
 * @property int|null $audience Участники
 *
 * @property PollsItem[] $pollsItems
 * @property PollsResult[] $pollsResults
 */
class Polls extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'polls';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start','name'], 'required'],
            [['start', 'finish'], 'safe'],
            [['status', 'finish_type', 'choice', 'view_result', 'audience'], 'integer'],
            [['ownoption', 'resultvotes', 'showfinishing'], 'boolean'],
            [['ownoption_text'], 'string'],
            [['name'], 'string', 'max' => 255],
            ['finish', 'finishDateValidate'],
            ['finish', 'required', 'when' => function($model) {return $model->finish_type == 2;}, 'enableClientValidation' => false],

            // ['finish', 'finishDateValidate'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название опроса',
            'start' => 'Дата начало',
            'finish' => 'Дата завершени',
            'status' => 'Статус',
            'finish_type' => 'Дата завершени',
            'ownoption' => 'Свой вариант',
            'ownoption_text' => 'Текст подсказки',
            'choice' => 'Выбор ответа',
            'view_result' => 'Отображать результаты',
            'resultvotes' => 'Отображать количество голосов',
            'showfinishing' => 'Отображать дату завершения',
            'audience' => 'Участники',
            'varinat_otver' => 'Вариант ответы',
        ];
    }


    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->start = Yii::$app->formatter->asDate($this->start, 'php:Y-m-d');

            if($this->finish != null )
                $this->finish = Yii::$app->formatter->asDate($this->finish, 'php:Y-m-d'); 
            else $this->finish = "";
        }
        else {
            $this->start = Yii::$app->formatter->asDate($this->start, 'php:Y-m-d');

            if($this->finish != null )
                $this->finish = Yii::$app->formatter->asDate($this->finish, 'php:Y-m-d'); 
            else $this->finish = "";
        }
        return parent::beforeSave($insert);
    }


    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->start = Yii::$app->formatter->asDate($this->start, 'php:d.m.Y'); 

        if($this->finish != null )
            $this->finish = Yii::$app->formatter->asDate($this->finish, 'php:d.m.Y'); 
        else $this->finish = "";
    }


    /**
     * count vote
     * @return bool|int|string|null
     */
    public function getVotes()
    {
        return PollsResult::find()->where(['poll_id'=>$this->id])->count();
    }


    /**
     * javoblar royxatii
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getPollsItemsList()
    {
        return PollsItem::find()->where(['poll_id'=>$this->id])->orderBy(['sorting'=>SORT_ASC])->all();
    }



    /**
     * itemlarga votelar
     * @param $id
     * @return bool|int|string|null
     */
    public function getVoteItemCount($id)
    {
        return PollsResult::find()->where(['item_id' => $id])->count();
    }


    /**
     *  Vote prosentda
     * @param $id
     * @return float|int
     */
    public function getVoteItemprosent($id)
    {
        if($this->getVotes() == 0) return 0;
        return round(100*(float)($this->getVoteItemCount($id)/$this->getVotes()),2);
    }

    // ----------------- sozdat qilyotgandaa finish datani balidatsiya qilish ---------------------------
    public function finishDateValidate($attribute,$params)
    { 
        $start = strtotime($this->start);
        $finish = strtotime($this->finish);
        if($start - $finish > 0 && $this->finish_type ==2)
        $this->addError($attribute, 'Дата завершения опроса не должна быть меньше чем дата начала опроса.');
    }


    /**
     * zaversheniya boldimi bolmadimi
     * @return string
     */
    public function getClosedVote()
    {
        if($this->finish_type == 1) return "-";
        if($this->finish_type == 2 && strtotime($this->finish) < strtotime(date('Y-m-d'))) return "Закрыто";
        else return "";
    }


    /**
     *  oprosda qatnashga users
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getUsersVote()
    {
         return PollsResult::find()->where(['poll_id'=>$this->id])->all();
    }


    /**
     *  kim ovoz bergan bolsa fio si yoki uning apisini chiqarish
     * @param $id
     * @return string|null
     */
    public function getUsersPersonal($id)
    {   
        $item = "";
        $item =  PollsResult::findOne($id);
        if($item->user_id != null) return $item->user->fio;
        if($item->user_ip != null) return $item->user_ip;
        if($item->user_id == null and $item->user_ip == null) return "";
    }


    /**
     * Vote Integration
     * @return array|\backend\models\polls\PollsIntegration|\yii\db\ActiveRecord|null
     */
    public function getIntgerration()
    {
        return PollsIntegration::find()->where(['poll_id' => $this->id])->one();
    }

    public function getPollsIntegrations()
    {
        return $this->hasMany(PollsIntegration::className(), ['poll_id' => 'id']);
    }

    /**
     * Gets query for [[PollsItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPollsItems()
    {
        return $this->hasMany(PollsItem::className(), ['poll_id' => 'id']);
    }

    /**
     * Gets query for [[PollsResults]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPollsResults()
    {
        return $this->hasMany(PollsResult::className(), ['poll_id' => 'id']);
    }


    /**
     * @return string[]
     */
    public function getStaus()
    {
        return [
            1 => "Активно",
            2 => "Черновек",
            3 => "Завершено",
        ];
    }


    /**
     * @return string
     */
    public function getStatusDescription()
    {
        switch ($this->status) {
            case 1: return "Активно";
            case 2: return "Черновек";
            case 3: return "Завершено";
            default: return "Неизвестно";
        }
    }


    /**
     * @return string[]
     */
    public function geFinishType()
    {
        return [
            1 => "Бессрочно",
            2 => "До указанной даты",
        ];
    }


    /**
     * @return string
     */
    public function getFinishTypeDescription()
    {
        switch ($this->finish_type) {
            case 1: return "Бессрочно";
            case 2: return "До указанной даты";
            default: return "Неизвестно";
        }
    }


    /**
     * @return string[]
     */
    public function getChoice()
    {
        return [
            1 => "Один из",
            2 => "Несколько",
        ];
    }


    /**
     * @return string
     */
    public function getChoiceDescription()
    {
        switch ($this->choice) {
            case 1: return "Один из";
            case 2: return "Несколько";
            default: return "Неизвестно";
        }
    }


    /**
     * @return string[]
     */
    public function getViewResult()
    {
        return [
            1 => "Проголосовавшим",
            2 => "После завершения",
            3 => "Доступны в любой момент",
        ];
    }


    /**
     * @return string
     */
    public function getViewResultDescription()
    {
        switch ($this->view_result) {
            case 1: return "Проголосовавшим";
            case 2: return "После завершения";
            case 3: return "Доступны в любой момент";
            default: return "Неизвестно";
        }
    }


    /**
     * @return string[]
     */
    public function getAudience()
    {
        return [
            1 => "Все",
            2 => "Только авторизованые",
        ];
    }


    /**
     * @return string
     */
    public function getAudienceDescription()
    {
        switch ($this->audience) {
            case 1: return "Все";
            case 2: return "Только авторизованые";
            default: return "Неизвестно";
        }
    }
}
