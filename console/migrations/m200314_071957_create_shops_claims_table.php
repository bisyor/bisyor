<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_claims}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%shops}}`
 * - `{{%users}}`
 */
class m200314_071957_create_shops_claims_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_claims}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer()->comment("Магазин"),
            'user_id' => $this->integer()->comment("Пользователь"),
            'user_ip' => $this->string(255)->comment("Ip пользователья"),
            'reason' => $this->integer()->comment("Причина"),
            'message' => $this->text()->comment("Сообщение (текст)"),
            'viewed' => $this->boolean()->defaultValue('0')->comment("Просмотрено да или Нет"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
        ]);

        // creates index for column `shop_id`
        $this->createIndex(
            '{{%idx-shops_claims-shop_id}}',
            '{{%shops_claims}}',
            'shop_id'
        );

        // add foreign key for table `{{%shops}}`
        $this->addForeignKey(
            '{{%fk-shops_claims-shop_id}}',
            '{{%shops_claims}}',
            'shop_id',
            '{{%shops}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-shops_claims-user_id}}',
            '{{%shops_claims}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-shops_claims-user_id}}',
            '{{%shops_claims}}',
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
        // drops foreign key for table `{{%shops}}`
        $this->dropForeignKey(
            '{{%fk-shops_claims-shop_id}}',
            '{{%shops_claims}}'
        );

        // drops index for column `shop_id`
        $this->dropIndex(
            '{{%idx-shops_claims-shop_id}}',
            '{{%shops_claims}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-shops_claims-user_id}}',
            '{{%shops_claims}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-shops_claims-user_id}}',
            '{{%shops_claims}}'
        );

        $this->dropTable('{{%shops_claims}}');
    }
}
