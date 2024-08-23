<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items_enotify}}`.
 */
class m200506_024658_create_items_enotify_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%items_enotify}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(),
            'sended' => $this->date(),
            'message_type' => $this->tinyInteger(),
        ]);

        $this->createIndex(
            '{{%idx-items_enotify-item_id}}',
            '{{%items_enotify}}',
            'item_id'
        );

        $this->addForeignKey(
            '{{%fk-items_enotify-item_id}}',
            '{{%items_enotify}}',
            'item_id',
            '{{%items}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-items_enotify-item_id}}',
            '{{%items_enotify}}'
        );

        $this->dropIndex(
            '{{%idx-items_enotify-item_id}}',
            '{{%items_enotify}}'
        );
        $this->dropTable('{{%items_enotify}}');
    }
}
