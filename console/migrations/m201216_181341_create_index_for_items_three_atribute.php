<?php

use yii\db\Migration;

/**
 * Class m201216_181341_create_index_for_items_three_atribute
 */
class m201216_181341_create_index_for_items_three_atribute extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-items_publicated',
            'items',
            ['status','is_publicated','is_moderating'],
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
        echo "m201216_181341_create_index_for_items_three_atribute cannot be reverted.\n";

        return false;
    }
    */
}
