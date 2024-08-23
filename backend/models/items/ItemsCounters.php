<?php
/* 
    Веб разработчик: Abdulloh Olimov 
*/

namespace backend\models\items;
use backend\models\references\Districts;
use Yii;

/**
 * This is the model class for table "items_counters".
 *
 * @property int $id
 * @property int|null $cat_id
 * @property int|null $district_id
 * @property int|null $delivery
 * @property int|null $items
 */


class ItemsCounters extends   \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items_counters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_id', 'district_id', 'delivery', 'items'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Cat ID',
            'district_id' => 'District ID',
            'delivery' => 'Delivery',
            'items' => 'Items',
        ];
    }

    public function getCat()
    {
        return $this->hasOne(Categories::className(), ['id' => 'cat_id']);
    }

    public function getDistrict()
    {
        return $this->hasOne(Districts::className(), ['id' => 'district_id']);
    }
}