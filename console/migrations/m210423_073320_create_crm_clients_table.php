<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_clients}}`.
 */
class m210423_073320_create_crm_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_clients}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer(),
            'type' => $this->string(100),
            'phone' => $this->string(20),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'inn' => $this->string(30),
            'fio' => $this->string(255),
            'company_name' => $this->string(255),
            'address' => $this->string(255),
            'email' => $this->string(255),
            'telegram_id' => $this->integer(),
            'gender' => $this->tinyInteger(1)
        ]);

        $this->createIndex(
            '{{%idx-crm_clients-shop_id}}',
            '{{%crm_clients}}',
            'shop_id'
        );

        $this->addForeignKey(
            '{{%fk-crm_clients-shop_id}}',
            '{{%crm_clients}}',
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
            '{{%fk-crm_clients-shop_id}}',
            '{{%crm_clients}}'
        );

        $this->dropIndex(
            '{{%idx-crm_clients-shop_id}}',
            '{{%crm_clients}}'
        );

        $this->dropTable('{{%crm_clients}}');
    }
}
