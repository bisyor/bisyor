<?php

use yii\db\Migration;

/**
 * Class m210721_094507_add_is_delete_to_applications_table
 */
class m210721_094507_add_is_delete_to_applications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%applications}}', 'is_delete', $this->boolean());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%applications}}', 'is_delete');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210721_094507_add_is_delete_to_applications_table cannot be reverted.\n";

        return false;
    }
    */
}
