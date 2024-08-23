<?php

namespace backend\models\references;
use backend\models\references\Translates;

use Yii;

/**
 * This is the model class for table "wordforms".
 *
 * @property int $id
 * @property string|null $sinonim Синоним
 * @property string|null $original Оригинал
 */
class Redirects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'redirects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_ip'], 'string', 'max' => 255],
            [['from_uri'], 'required'],
            ['from_uri', 'unique'],
            [['id', 'status', 'user_id', 'joined'], 'integer'],
            [['from_uri', 'to_uri', 'joined_module'], 'string'],
            [['date_cr', 'date_up'], 'safe'],
            [['is_relative', 'add_extra', 'add_query', 'enabled'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_uri' => 'Исходный URL',
            'to_uri' => 'Итоговый URL',
            'status' => 'Статус',
            'is_relative' => 'is_relative',
            'add_extra' => 'Использовать локализацию/регион и подобные настройки из исходного URL',
            'add_query' => 'Использовать параметры запроса из исходного URL',
            'enabled' => 'Включен',
            'date_cr' => 'Дата создание',
            'date_up' => 'Дата изменение',
            'user_id' => 'Пользователь',
            'user_ip' => 'IP пользователя',
            'joined' => 'joined',
            'joined_module' => 'joined_module',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) 
        {
            $this->user_id = Yii::$app->user->identity->id;
            $this->date_cr = date("Y-m-d H:i:s");
            $this->user_ip = Yii::$app->request->userIP;
        }

        $this->date_up = date("Y-m-d H:i:s");
        
        return parent::beforeSave($insert);
    }

    public static function changeBase($from, $to)
    {
        $redirects = Redirects::find()->all();
        foreach ($redirects as $redirect) {
            if(substr($redirect->from_uri, 0, strlen($from)) == $from) {
                $redirect->to_uri = $to . $redirect->to_uri;
                $redirect->save();
            }
        }
    }
}
