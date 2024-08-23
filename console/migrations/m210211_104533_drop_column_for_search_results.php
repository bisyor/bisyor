<?php

use yii\db\Migration;

/**
 * Class m210211_104533_drop_column_for_search_results
 */
class m210211_104533_drop_column_for_search_results extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%search_results}}', 'date_cr');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%search_results}}', 'date_cr', $this->datetime());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210211_104533_drop_column_for_search_results cannot be reverted.\n";

        return false;
    }
    */
}
