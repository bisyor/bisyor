<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%chats}}`.
 */
class m201016_091012_add_user_id_column_to_chats_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%chats}}', 'user_id_item', $this->integer()->comment('чат объявлений'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%chats}}', 'user_id');
    }
}
