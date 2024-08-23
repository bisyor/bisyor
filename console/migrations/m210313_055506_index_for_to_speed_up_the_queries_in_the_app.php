<?php

use yii\db\Migration;

/**
 * Class m210313_055506_index_for_to_speed_up_the_queries_in_the_app
 */
class m210313_055506_index_for_to_speed_up_the_queries_in_the_app extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createIndex(
            'idx-favorites_items_and_users_type',
            'favorites',
            ['item_id','user_id','type'],
        );

        $this->createIndex(
            'idx-favorites_users_type',
            'favorites',
            ['user_id','type'],
        );

        $this->createIndex(
            'idx-users_access_token_index_for_app',
            'favorites',
            ['access_token'],
        );

        $this->createIndex(
            'idx-users_id_index_for_app',
            'favorites',
            ['id'],
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210313_055506_index_for_to_speed_up_the_queries_in_the_app cannot be reverted.\n";

        return false;
    }
    */
}
