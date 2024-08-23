<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%site_requests}}`.
 */
class m200510_080717_create_site_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%site_requests}}', [
            'id' => $this->primaryKey(),
            'user_action' => $this->string(255),
            'user_id' => $this->integer(),
            'user_ip' => $this->string(50),
            'date_cr' => $this->dateTime(),
            'counter' => $this->integer(),
        ]);

        $this->createIndex(
            '{{%idx-site_requests-user_id}}',
            '{{%site_requests}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-site_requests-user_id}}',
            '{{%site_requests}}',
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
        $this->dropForeignKey(
            '{{%fk-site_requests-user_id}}',
            '{{%site_requests}}'
        );

        $this->dropIndex(
            '{{%idx-site_requests-user_id}}',
            '{{%site_requests}}'
        );

        $this->dropTable('{{%site_requests}}');
    }
}
