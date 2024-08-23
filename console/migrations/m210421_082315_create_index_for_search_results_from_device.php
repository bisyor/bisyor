<?php

use yii\db\Migration;

/**
 * Class m210421_082315_create_index_for_search_results_from_device
 */
class m210421_082315_create_index_for_search_results_from_device extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'search_results_pid_from_device',
            'search_results',
            ['pid','from_device'],
        );

        $this->createIndex(
            'search_results_id',
            'search_results',
            ['id'],
        );

        $this->createIndex(
            'search_results_pid',
            'search_results',
            ['pid'],
        );

        $this->createIndex(
            'search_results_pid_from_device_id',
            'search_results',
            ['pid','from_device','id'],
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210421_082315_create_index_for_search_results_from_device cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210421_082315_create_index_for_search_results_from_device cannot be reverted.\n";

        return false;
    }
    */
}
