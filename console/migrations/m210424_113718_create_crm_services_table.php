<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_services}}`.
 */
class m210424_113718_create_crm_services_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_services}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer(),
            'name' => $this->string(255),
            'price' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createIndex(
            '{{%idx-crm_services-shop_id}}',
            '{{%crm_services}}',
            'shop_id'
        );

        $this->addForeignKey(
            '{{%fk-crm_services-shop_id}}',
            '{{%crm_services}}',
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
            '{{%fk-crm_services-shop_id}}',
            '{{%crm_services}}'
        );

        $this->dropIndex(
            '{{%idx-crm_services-shop_id}}',
            '{{%crm_services}}'
        );
        
        $this->dropTable('{{%crm_services}}');
    }
}
