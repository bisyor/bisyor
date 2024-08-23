<?php


namespace backend\models\items;
use Yii;

class ItemsBloked extends \yii\base\Model
{
    public $blocked_status;
    public $blocked_reason;
    public $ids;
    public $setvalue;

    const OTHER_VALUE = 'Другая причина';

    public function rules()
    {
        return [
            [['blocked_status','blocked_reason','ids','setvalue'] ,'safe'],
            [['blocked_status'] ,'required'],
        ];
    }

    public function blockedItemsList(): bool
    {
        if($this->blocked_status != self::OTHER_VALUE){
            $this->blocked_reason = $this->blocked_status;
        }
        if(!$this->ids) return true;
        $statuses = Items::STATUS_TYPE[4]['statuses'];
        foreach ($this->ids as $pk){
            $items = Items::findOne($pk);
            if($items){
                Yii::$app->db->createCommand()->update('items', [
                    'status_changed' => Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i:s'),
                    'status' => $statuses['status'],
                    'is_moderating' => $statuses['is_moderating'],
                    'is_publicated' => $statuses['is_publicated'],
                    'blocked_reason' =>  $this->blocked_reason,
                ], 'id = '.$items->id)->execute();
            }
        }
        return true;
    }

}