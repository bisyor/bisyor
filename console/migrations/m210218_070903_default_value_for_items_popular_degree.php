<?php

use yii\db\Migration;

/**
 * Class m210218_070903_default_value_for_items_popular_degree
 */
class m210218_070903_default_value_for_items_popular_degree extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \backend\models\items\Items::updateAll(['popular_degree' =>0]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210218_070903_default_value_for_items_popular_degree cannot be reverted.\n";

        return false;
    }
    */
}
