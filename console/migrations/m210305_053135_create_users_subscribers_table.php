<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_subscribers}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%users}}`
 */
class m210305_053135_create_users_subscribers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_subscribers}}', [
            'id' => $this->primaryKey(),
            'from_user_id' => $this->integer(),
            'to_user_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-shops_subscribers_user_id_with_shop_id',
            'shops_subscribers',
            ['user_id','shop_id'],
        );

        // creates index for column `from_user_id`
        $this->createIndex(
            '{{%idx-users_subscribers-from_user_id}}',
            '{{%users_subscribers}}',
            'from_user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users_subscribers-from_user_id}}',
            '{{%users_subscribers}}',
            'from_user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `to_user_id`
        $this->createIndex(
            '{{%idx-users_subscribers-to_user_id}}',
            '{{%users_subscribers}}',
            'to_user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users_subscribers-to_user_id}}',
            '{{%users_subscribers}}',
            'to_user_id',
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
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-users_subscribers-from_user_id}}',
            '{{%users_subscribers}}'
        );

        // drops index for column `from_user_id`
        $this->dropIndex(
            '{{%idx-users_subscribers-from_user_id}}',
            '{{%users_subscribers}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-users_subscribers-to_user_id}}',
            '{{%users_subscribers}}'
        );

        // drops index for column `to_user_id`
        $this->dropIndex(
            '{{%idx-users_subscribers-to_user_id}}',
            '{{%users_subscribers}}'
        );

        $this->dropTable('{{%users_subscribers}}');
    }
}
