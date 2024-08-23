<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_status_services}}`.
 */
class m210423_094119_create_crm_status_services_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_status_services}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer(),
            'name' => $this->string(255),
            'price' => $this->float(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createIndex(
            '{{%idx-crm_status_services-shop_id}}',
            '{{%crm_status_services}}',
            'shop_id'
        );

        $this->addForeignKey(
            '{{%fk-crm_status_services-shop_id}}',
            '{{%crm_status_services}}',
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
            '{{%fk-crm_status_services-shop_id}}',
            '{{%crm_status_services}}'
        );

        $this->dropIndex(
            '{{%idx-crm_status_services-shop_id}}',
            '{{%crm_status_services}}'
        );

        $this->dropTable('{{%crm_status_services}}');
    }
}
