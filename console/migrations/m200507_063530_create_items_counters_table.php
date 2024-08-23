<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items_counters}}`.
 */
class m200507_063530_create_items_counters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%items_counters}}', [
            'id' => $this->primaryKey(),
            'cat_id' => $this->integer(),
            'district_id' => $this->integer(),
            'delivery' => $this->tinyInteger(),
            'items' => $this->integer(),
        ]);

        $this->createIndex(
            '{{%idx-items_counters-cat_id}}',
            '{{%items_counters}}',
            'cat_id'
        );

        $this->addForeignKey(
            '{{%fk-items_counters-cat_id}}',
            '{{%items_counters}}',
            'cat_id',
            '{{%categories}}',
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
            '{{%fk-items_counters-cat_id}}',
            '{{%items_counters}}'
        );

        $this->dropIndex(
            '{{%idx-items_counters-cat_id}}',
            '{{%items_counters}}'
        );

        $this->dropTable('{{%items_counters}}');
    }
}
