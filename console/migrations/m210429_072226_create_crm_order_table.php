<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_order}}`.
 */
class m210429_072226_create_crm_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_order}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer(),
            'type_order_by' => $this->integer(),
            'client_id' => $this->integer(),
            'phone' => $this->string(),
            'comment' => $this->text(),
            'price' => $this->integer(),
            'prepay' => $this->integer(),
            'marketing_id' => $this->integer(),
            'discount_order' => $this->integer(),
            'status_order' => $this->integer(),
            'quick' => $this->tinyInteger(1),
            'type_client' => $this->tinyInteger(),
            'address' => $this->string(),
            'company_name' => $this->string(255),
            'office_id' => $this->integer(),
            'vin' => $this->string(255),
            'govern_number' => $this->string(),
            'warranty' => $this->dateTime(),
            'return_date' => $this->dateTime(),
            'polis' => $this->string(255),
            'client_gender' => $this->tinyInteger(1),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);

        $this->createIndex(
            '{{%idx-crm_order-shop_id}}',
            '{{%crm_order}}',
            'shop_id'
        );

        $this->addForeignKey(
            '{{%fk-crm_order-shop_id}}',
            '{{%crm_order}}',
            'shop_id',
            '{{%shops}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-crm_order-type_order_by}}',
            '{{%crm_order}}',
            'type_order_by'
        );

        $this->addForeignKey(
            '{{%fk-crm_order-type_order_by}}',
            '{{%crm_order}}',
            'type_order_by',
            '{{%crm_order_type}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-crm_order-client_id}}',
            '{{%crm_order}}',
            'client_id'
        );

        $this->addForeignKey(
            '{{%fk-crm_order-client_id}}',
            '{{%crm_order}}',
            'client_id',
            '{{%crm_clients}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-crm_order-status_order}}',
            '{{%crm_order}}',
            'status_order'
        );

        $this->addForeignKey(
            '{{%fk-crm_order-status_order}}',
            '{{%crm_order}}',
            'status_order',
            '{{%crm_status_order}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-crm_order-marketing_id}}',
            '{{%crm_order}}',
            'marketing_id'
        );

        $this->addForeignKey(
            '{{%fk-crm_order-marketing_id}}',
            '{{%crm_order}}',
            'marketing_id',
            '{{%crm_marketing}}',
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
            '{{%fk-crm_order-shop_id}}',
            '{{%crm_order}}'
        );

        $this->dropIndex(
            '{{%idx-crm_order-shop_id}}',
            '{{%crm_order}}'
        );

        $this->dropForeignKey(
            '{{%fk-crm_order-type_order_by}}',
            '{{%crm_order}}'
        );

        $this->dropIndex(
            '{{%idx-crm_order-type_order_by}}',
            '{{%crm_order}}'
        );

        $this->dropForeignKey(
            '{{%fk-crm_order-client_id}}',
            '{{%crm_order}}'
        );

        $this->dropIndex(
            '{{%idx-crm_order-client_id}}',
            '{{%crm_order}}'
        );

        $this->dropForeignKey(
            '{{%fk-crm_order-status_order}}',
            '{{%crm_order}}'
        );

        $this->dropIndex(
            '{{%idx-crm_order-status_order}}',
            '{{%crm_order}}'
        );

        $this->dropForeignKey(
            '{{%fk-crm_order-marketing_id}}',
            '{{%crm_order}}'
        );

        $this->dropIndex(
            '{{%idx-crm_order-marketing_id}}',
            '{{%crm_order}}'
        );

        $this->dropTable('{{%crm_order}}');
    }
}
