<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_status_order}}`.
 */
class m210423_093730_create_crm_status_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_status_order}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'push' => $this->tinyInteger(1),
            'text' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crm_status_order}}');
    }
}
