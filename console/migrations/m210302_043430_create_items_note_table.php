<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items_note}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%items}}`
 * - `{{%users}}`
 */
class m210302_043430_create_items_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%items_note}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->comment('Объявления'),
            'user_id' => $this->integer()->comment('Пользователи'),
            'message' => $this->text()->comment('Текст'),
        ]);

        // creates index for column `item_id`
        $this->createIndex(
            '{{%idx-items_note-item_id}}',
            '{{%items_note}}',
            'item_id'
        );

        // add foreign key for table `{{%items}}`
        $this->addForeignKey(
            '{{%fk-items_note-item_id}}',
            '{{%items_note}}',
            'item_id',
            '{{%items}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-items_note-user_id}}',
            '{{%items_note}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-items_note-user_id}}',
            '{{%items_note}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%items}}`
        $this->dropForeignKey(
            '{{%fk-items_note-item_id}}',
            '{{%items_note}}'
        );

        // drops index for column `item_id`
        $this->dropIndex(
            '{{%idx-items_note-item_id}}',
            '{{%items_note}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-items_note-user_id}}',
            '{{%items_note}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-items_note-user_id}}',
            '{{%items_note}}'
        );

        $this->dropTable('{{%items_note}}');
    }
}
