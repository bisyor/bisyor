<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%polls_item}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%polls}}`
 */
class m200319_124513_create_polls_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%polls_item}}', [
            'id' => $this->primaryKey(),
            'poll_id' => $this->integer()->comment('Опрос'),
            'title' => $this->string(255)->comment('Вариант ответа'),
            'sorting' => $this->integer()->comment('Сортировка'),
        ]);

        // creates index for column `poll_id`
        $this->createIndex(
            '{{%idx-polls_item-poll_id}}',
            '{{%polls_item}}',
            'poll_id'
        );

        // add foreign key for table `{{%polls}}`
        $this->addForeignKey(
            '{{%fk-polls_item-poll_id}}',
            '{{%polls_item}}',
            'poll_id',
            '{{%polls}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%polls}}`
        $this->dropForeignKey(
            '{{%fk-polls_item-poll_id}}',
            '{{%polls_item}}'
        );

        // drops index for column `poll_id`
        $this->dropIndex(
            '{{%idx-polls_item-poll_id}}',
            '{{%polls_item}}'
        );

        $this->dropTable('{{%polls_item}}');
    }
}
