<?php

use yii\db\Migration;

/**
 * Class m210407_050021_create_index_for_categories_id
 */
class m210407_050021_create_index_for_categories_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-id_for_categories_index',
            'categories',
            ['id'],
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
        echo "m210407_050021_create_index_for_categories_id cannot be reverted.\n";

        return false;
    }
    */
}
