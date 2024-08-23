<?php

use yii\db\Migration;

/**
 * Class m201017_060616_create_items_counters_delete_all
 */
class m201017_060616_create_items_counters_delete_all extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand()
            ->delete('items_counters',)
            ->execute();

        $this->addColumn('{{%items_counters}}', 'items_active', $this->integer()->comment('Объявление публикатсии'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%items_counters}}', 'items_active');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201017_060616_create_items_counters_delete_all cannot be reverted.\n";

        return false;
    }
    */
}
