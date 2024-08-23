<?php

use yii\db\Migration;

/**
 * Class m210408_055450_add_column_cover_to_shops_table
 */
class m210408_055450_add_column_cover_to_shops_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	$this->addColumn('{{%shops}}', 'cover', $this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('{{%shops}}', 'cover');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210408_055450_add_column_cover_to_shops_table cannot be reverted.\n";

        return false;
    }
    */
}
