<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%chat_users}}`.
 */
class m201116_043458_add_item_id_column_to_chat_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%chat_users}}', 'item_id', $this->integer());
        // creates index for column `tag_id`
        $this->createIndex(
            'idx-chat_users_item-item_id',
            'chat_users',
            'item_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%chat_users}}', 'item_id');
    }
}
