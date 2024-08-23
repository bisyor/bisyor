<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%favorites}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%items}}`
 * - `{{%users}}`
 */
class m200422_164124_create_favorites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%favorites}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->comment("Объявление"),
            'user_id' => $this->integer()->comment("Пользователья"),
            'default_price' => $this->float()->comment("Первоначальная Цена"),
            'price' => $this->float()->comment("Текущая цена"),
            'changed_date' => $this->datetime()->comment("Дата изменение цены"),
            'type' => $this->integer(),
        ]);

        // creates index for column `item_id`
        $this->createIndex(
            '{{%idx-favorites-item_id}}',
            '{{%favorites}}',
            'item_id'
        );

        // add foreign key for table `{{%items}}`
        $this->addForeignKey(
            '{{%fk-favorites-item_id}}',
            '{{%favorites}}',
            'item_id',
            '{{%items}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-favorites-user_id}}',
            '{{%favorites}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-favorites-user_id}}',
            '{{%favorites}}',
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
            '{{%fk-favorites-item_id}}',
            '{{%favorites}}'
        );

        // drops index for column `item_id`
        $this->dropIndex(
            '{{%idx-favorites-item_id}}',
            '{{%favorites}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-favorites-user_id}}',
            '{{%favorites}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-favorites-user_id}}',
            '{{%favorites}}'
        );

        $this->dropTable('{{%favorites}}');
    }
}
