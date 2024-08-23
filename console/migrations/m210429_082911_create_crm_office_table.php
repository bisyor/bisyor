<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_office}}`.
 */
class m210429_082911_create_crm_office_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_office}}', [
            'id' => $this->primaryKey(),
            'name' => $this->integer()
        ]);

        $this->createIndex(
            '{{%idx-crm_order-office_id}}',
            '{{%crm_order}}',
            'office_id'
        );

        $this->addForeignKey(
            '{{%fk-crm_order-office_id}}',
            '{{%crm_order}}',
            'office_id',
            '{{%crm_office}}',
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
            '{{%fk-crm_order-office_id}}',
            '{{%crm_order}}'
        );

        $this->dropIndex(
            '{{%idx-crm_order-office_id}}',
            '{{%crm_order}}'
        );

        $this->dropTable('{{%crm_office}}');
    }
}
