<?php

use yii\db\Migration;
/**
 * Class m201021_051109_create_items_update_column
 */
class m201021_051109_create_items_update_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
           Yii::$app->db->createCommand()->update('items', ['moderated_id' => 1], 'moderated_id is null')->execute();
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
        echo "m201021_051109_create_items_update_column cannot be reverted.\n";

        return false;
    }
    */
}
