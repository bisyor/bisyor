<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_marketing}}`.
 */
class m210423_092224_create_crm_marketing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_marketing}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'show_in_indicators' => $this->tinyInteger(1),
            'plan_month' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->insert('crm_marketing',array(
            'name' => 'Газета',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crm_marketing}}');
    }
}
