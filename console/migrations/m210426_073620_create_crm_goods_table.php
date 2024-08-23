<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_goods}}`.
 */
class m210426_073620_create_crm_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crm_goods}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer(),
            'name' => $this->string(255),
            'cost' => $this->float(),
        ]);


        $this->createIndex(
            '{{%idx-crm_goods-shop_id}}',
            '{{%crm_goods}}',
            'shop_id'
        );

        $this->addForeignKey(
            '{{%fk-crm_goods-shop_id}}',
            '{{%crm_goods}}',
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
            '{{%fk-crm_goods-shop_id}}',
            '{{%crm_goods}}'
        );

        $this->dropIndex(
            '{{%idx-crm_goods-shop_id}}',
            '{{%crm_goods}}'
        );
        
        $this->dropTable('{{%crm_goods}}');
    }
}
