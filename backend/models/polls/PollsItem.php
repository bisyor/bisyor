<?php

namespace backend\models\polls;

use Yii;


/**
 * This is the model class for table "polls_item".
 *
 * @property int $id
 * @property int|null $poll_id Опрос
 * @property string|null $title Вариант ответа
 * @property int|null $sorting Сортировка
 *
 * @property Polls $poll
 * @property PollsResult[] $pollsResults
 */
class PollsItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'polls_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['poll_id', 'sorting'], 'default', 'value' => null],
            [['poll_id', 'sorting'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'poll_id' => 'Опрос',
            'title' => 'Вариант ответа',
            'sorting' => 'Сортировка',
        ];
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

    /**
     * Gets query for [[PollsResults]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPollsResults()
    {
        return $this->hasMany(PollsResult::className(), ['item_id' => 'id']);
    }
}
