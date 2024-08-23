<?php

use yii\db\Migration;

/**
 * Class m210327_054726_index_for_users_id_debug_testing
 */
class m210327_054726_index_for_users_id_debug_testing extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-users_access_token_index_for_admin_system',
            'users',
            ['access_token'],
        );

        $this->createIndex(
            'idx-users_id_index_for_app__admin_system',
            'users',
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
        echo "m210327_054726_index_for_users_id_debug_testing cannot be reverted.\n";

        return false;
    }
    */
}
