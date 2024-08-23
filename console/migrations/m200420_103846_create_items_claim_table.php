<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items_claim}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%items}}`
 * - `{{%users}}`
 */
class m200420_103846_create_items_claim_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%items_claim}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->comment("Объявление"),
            'user_id' => $this->integer()->comment("Пользователь"),
            'user_ip' => $this->string(255)->comment("User IP"),
            'reason' => $this->integer()->comment("Причина"),
            'message' => $this->text()->comment("Сообщение"),
            'viewed' => $this->boolean()->comment("Обработан"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
        ]);

        // creates index for column `item_id`
        $this->createIndex(
            '{{%idx-items_claim-item_id}}',
            '{{%items_claim}}',
            'item_id'
        );

        // add foreign key for table `{{%items}}`
        $this->addForeignKey(
            '{{%fk-items_claim-item_id}}',
            '{{%items_claim}}',
            'item_id',
            '{{%items}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-items_claim-user_id}}',
            '{{%items_claim}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-items_claim-user_id}}',
            '{{%items_claim}}',
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
            '{{%fk-items_claim-item_id}}',
            '{{%items_claim}}'
        );

        // drops index for column `item_id`
        $this->dropIndex(
            '{{%idx-items_claim-item_id}}',
            '{{%items_claim}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-items_claim-user_id}}',
            '{{%items_claim}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-items_claim-user_id}}',
            '{{%items_claim}}'
        );

        $this->dropTable('{{%items_claim}}');
    }
}
