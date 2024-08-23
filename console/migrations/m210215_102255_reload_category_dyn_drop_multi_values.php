<?php

use yii\db\Migration;

/**
 * Class m210215_102255_reload_category_dyn_drop_multi_values
 */
class m210215_102255_reload_category_dyn_drop_multi_values extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = 'TRUNCATE TABLE categories_dynprops_multi  RESTART IDENTITY;';
        \Yii::$app->db->createCommand($sql)->execute();
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
        echo "m210215_102255_reload_category_dyn_drop_multi_values cannot be reverted.\n";

        return false;
    }
    */
}
