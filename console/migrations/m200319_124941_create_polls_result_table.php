<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%polls_result}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%polls}}`
 * - `{{%users}}`
 * - `{{%polls_item}}`
 */
class m200319_124941_create_polls_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%polls_result}}', [
            'id' => $this->primaryKey(),
            'poll_id' => $this->integer()->comment('Опрос'),
            'user_id' => $this->integer()->comment('Пользователь'),
            'user_ip' => $this->string(255)->comment('Ip пользовате'),
            'date_cr' => $this->datetime()->comment('Дата созлзда'),
            'item_id' => $this->integer()->comment('Выбранный отве'),
            'own_answer' => $this->text()->comment('Свой вариан'),
        ]);

        // creates index for column `poll_id`
        $this->createIndex(
            '{{%idx-polls_result-poll_id}}',
            '{{%polls_result}}',
            'poll_id'
        );

        // add foreign key for table `{{%polls}}`
        $this->addForeignKey(
            '{{%fk-polls_result-poll_id}}',
            '{{%polls_result}}',
            'poll_id',
            '{{%polls}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-polls_result-user_id}}',
            '{{%polls_result}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-polls_result-user_id}}',
            '{{%polls_result}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `item_id`
        $this->createIndex(
            '{{%idx-polls_result-item_id}}',
            '{{%polls_result}}',
            'item_id'
        );

        // add foreign key for table `{{%polls_item}}`
        $this->addForeignKey(
            '{{%fk-polls_result-item_id}}',
            '{{%polls_result}}',
            'item_id',
            '{{%polls_item}}',
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
            '{{%fk-polls_result-poll_id}}',
            '{{%polls_result}}'
        );

        // drops index for column `poll_id`
        $this->dropIndex(
            '{{%idx-polls_result-poll_id}}',
            '{{%polls_result}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-polls_result-user_id}}',
            '{{%polls_result}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-polls_result-user_id}}',
            '{{%polls_result}}'
        );

        // drops foreign key for table `{{%polls_item}}`
        $this->dropForeignKey(
            '{{%fk-polls_result-item_id}}',
            '{{%polls_result}}'
        );

        // drops index for column `item_id`
        $this->dropIndex(
            '{{%idx-polls_result-item_id}}',
            '{{%polls_result}}'
        );

        $this->dropTable('{{%polls_result}}');
    }
}
