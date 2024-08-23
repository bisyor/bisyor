<?php

use yii\db\Migration;

/**
 * Class m210209_094436_create_index_for_get_translate
 */
class m210209_094436_create_index_for_get_translate extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-translates_get_translates',
            'translates',
            ['table_name','field_id','language_code','field_name'],
        );

        $this->createIndex(
            'idx-favorites_items_and_users',
            'favorites',
            ['item_id','user_id'],
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
        echo "m210209_094436_create_index_for_get_translate cannot be reverted.\n";

        return false;
    }
    */
}
