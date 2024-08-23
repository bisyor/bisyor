<?php

namespace common\modules\translations\models;

use common\modules\langs\components\QueryBehavior;
use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;
//Системные
use jakharbek\core\behaviors\DateTimeBehavior;
//Языки
use jakharbek\langs\models\Langs;
use jakharbek\langs\components\ModelBehavior;
//Пользовтели
//Категории
use jakharbek\categories\behaviors\CategoryModelBehavior;
use jakharbek\categories\models\Categories;
//Теги

/**
 * This is the ActiveQuery class for [[SourceMessage]].
 *
 * @see SourceMessage
 */
class SourceMessageQuery extends \yii\db\ActiveQuery
{

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SourceMessage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    
    /**
     * @inheritdoc
     * @return SourceMessage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    public function statuses($status = null){
        if($status == SourceMessage::STATUS_ACTIVE):
            return Yii::t('app','Active');
        else:
            return Yii::t('app','Deactive');
        endif;
    }
    public function messages(){
        return $this->joinWith(['messages']);
    }
}
