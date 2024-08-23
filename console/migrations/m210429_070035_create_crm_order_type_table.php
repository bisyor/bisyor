<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_order_type}}`.
 */
class m210429_070035_create_crm_order_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_order_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crm_order_type}}');
    }
}
