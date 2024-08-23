<?php

use yii\db\Migration;

/**
 * Class m210211_085320_create_index_for_search_results
 */
class m210211_085320_create_index_for_search_results extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-search_results_with_pid',
            'search_results',
            ['query','pid'],
        );

        $this->createIndex(
            'idx-search_results_region_id_with_pid',
            'search_results',
            ['region_id','pid'],
        );
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
        echo "m210211_085320_create_index_for_search_results cannot be reverted.\n";

        return false;
    }
    */
}
