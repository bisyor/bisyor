<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_available}}`.
 */
class m210426_081208_create_crm_available_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_available}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer(),
            'count' => $this->integer(),
            'type_parts_by' => $this->integer(),
            'comment' => $this->text(),
            'storage_id' => $this->integer(),
            'good_id' => $this->integer(),
            'number' => $this->integer(),
            'price' => $this->float(),
            'residue' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createIndex(
            '{{%idx-crm_available-shop_id}}',
            '{{%crm_available}}',
            'shop_id'
        );

        $this->addForeignKey(
            '{{%fk-crm_available-shop_id}}',
            '{{%crm_available}}',
            'shop_id',
            '{{%shops}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-crm_available-storage_id}}',
            '{{%crm_available}}',
            'storage_id'
        );

        $this->addForeignKey(
            '{{%fk-crm_available-storage_id}}',
            '{{%crm_available}}',
            'storage_id',
            '{{%crm_storage}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-crm_available-good_id}}',
            '{{%crm_available}}',
            'good_id'
        );

        $this->addForeignKey(
            '{{%fk-crm_available-good_id}}',
            '{{%crm_available}}',
            'good_id',
            '{{%crm_goods}}',
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
            '{{%fk-crm_available-shop_id}}',
            '{{%crm_available}}'
        );

        $this->dropIndex(
            '{{%idx-crm_available-shop_id}}',
            '{{%crm_available}}'
        );

        $this->dropForeignKey(
            '{{%fk-crm_available-storage_id}}',
            '{{%crm_available}}'
        );

        $this->dropIndex(
            '{{%idx-crm_available-storage_id}}',
            '{{%crm_available}}'
        );

        $this->dropForeignKey(
            '{{%fk-crm_available-good_id}}',
            '{{%crm_available}}'
        );

        $this->dropIndex(
            '{{%idx-crm_available-good_id}}',
            '{{%crm_available}}'
        );

        $this->dropTable('{{%crm_available}}');
    }
}
