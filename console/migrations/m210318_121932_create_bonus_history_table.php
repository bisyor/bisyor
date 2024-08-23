<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bonus_history}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%bonus_list}}`
 */
class m210318_121932_create_bonus_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bonus_history}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment("Пользователи"),
            'bonus_id' => $this->integer()->comment("Бонусы"),
            'date_cr' => $this->datetime()->comment("Дата создания"),
            'summa' => $this->float()->comment("Сумма"),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-bonus_history-user_id}}',
            '{{%bonus_history}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-bonus_history-user_id}}',
            '{{%bonus_history}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `bonus_id`
        $this->createIndex(
            '{{%idx-bonus_history-bonus_id}}',
            '{{%bonus_history}}',
            'bonus_id'
        );

        // add foreign key for table `{{%bonus_list}}`
        $this->addForeignKey(
            '{{%fk-bonus_history-bonus_id}}',
            '{{%bonus_history}}',
            'bonus_id',
            '{{%bonus_list}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-bonus_history-user_id}}',
            '{{%bonus_history}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-bonus_history-user_id}}',
            '{{%bonus_history}}'
        );

        // drops foreign key for table `{{%bonus_list}}`
        $this->dropForeignKey(
            '{{%fk-bonus_history-bonus_id}}',
            '{{%bonus_history}}'
        );

        // drops index for column `bonus_id`
        $this->dropIndex(
            '{{%idx-bonus_history-bonus_id}}',
            '{{%bonus_history}}'
        );

        $this->dropTable('{{%bonus_history}}');
    }
}
