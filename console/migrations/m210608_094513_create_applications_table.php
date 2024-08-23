<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%applications}}`.
 */
class m210608_094513_create_applications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%applications}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(),
            'phone' => $this->string(255),
            'status' => $this->tinyInteger(1),
            'fullname' => $this->string(255),
            'address' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);

        $this->createIndex(
            '{{%idx-applications-item_id}}',
            '{{%applications}}',
            'item_id'
        );

        $this->addForeignKey(
            '{{%fk-applications-item_id}}',
            '{{%applications}}',
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
            '{{%fk-applications-item_id}}',
            '{{%applications}}'
        );

        $this->dropIndex(
            '{{%idx-applications-item_id}}',
            '{{%applications}}'
        );

        $this->dropTable('{{%applications}}');
    }
}
