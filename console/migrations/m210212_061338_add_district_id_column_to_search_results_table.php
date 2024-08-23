<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%search_results}}`.
 */
class m210212_061338_add_district_id_column_to_search_results_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%search_results}}', 'district_id', $this->integer());
        $model = \backend\models\references\SearchResults::find()->with(['regions'])->andWhere(['not' ,['region_id' => null]])->all();
        foreach ($model as $value){
            $value->district_id = $value->region_id;
            $value->region_id = $value->regions->region->id;
            $value->save(false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%search_results}}', 'district_id');
    }
}
