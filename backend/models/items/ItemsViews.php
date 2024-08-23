<?php

namespace backend\models\items;


class ItemsViews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'items_views';
    }

    public function rules()
    {
        return [
            [['item_id', 'item_views', 'contacts_views'], 'integer'],
            [['period'], 'safe'],
            //[['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Items::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    public function getItems()
    {
        return $this->hasOne(Items::className(), ['id' => 'item_id'])
            ->select(['id','cat_id']);
    }


}