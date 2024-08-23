<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_storage}}`.
 */
class m210426_073310_create_crm_storage_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_storage}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'shop_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'is_main' => $this->boolean(),
        ]);

        $this->createIndex(
            '{{%idx-crm_storage-shop_id}}',
            '{{%crm_storage}}',
            'shop_id'
        );

        $this->addForeignKey(
            '{{%fk-crm_storage-shop_id}}',
            '{{%crm_storage}}',
            'shop_id',
            '{{%shops}}',
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
            '{{%fk-crm_storage-shop_id}}',
            '{{%crm_storage}}'
        );

        $this->dropIndex(
            '{{%idx-crm_storage-shop_id}}',
            '{{%crm_storage}}'
        );
        
        $this->dropTable('{{%crm_storage}}');
    }
}
