<?php

namespace backend\models\references;

use Yii;
use yii\base\Model; 
use common\modules\translations\models\SourceMessage;
use common\modules\translations\models\Message;
use backend\models\references\Lang;

class LangMessages extends Model
{
    public $key;
    public $translate;

    public function rules()
    {
        return [
            [['key', 'translate' ],'safe'],
            [['key'],'required'],
            ['key', 'keyValidate'],
            ['translate' , 'translateValidate'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'key' => 'Ключ',
            'translate' => 'Перевести',
        ];
    }

    public function keyValidate($attribute,$params)
    { 
        $source_message = SourceMessage::find()->where(['message' => $this->key])->all();
        if($source_message != null)
        $this->addError($attribute, 'Этот ключ существует');
    }

    public function translateValidate($attribute,$params)
    { 
        $langs = Lang::find()->all();
        foreach ($langs as $lang) {
            $url = $lang->url;
            if(!$this->translate[$url]){
                $this->addError($attribute, 'Этот ключ существует');
            }
        }
    }


    public function saveTranslate()
    {
        $source_message = new SourceMessage();
        $source_message->category = 'app';
        $source_message->message = $this->key;
        $source_message->save();

        $langs = Lang::find()->all();

        foreach ($langs as $lang) {
        $url = $lang->url;
            $messages = new Message();
            $messages->id = $source_message->id;
            $messages->language = $url;
            $messages->translation = $this->translate[$url];
            $messages->save();
        }
    }

}
