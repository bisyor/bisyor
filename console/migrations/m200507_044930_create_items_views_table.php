<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items_views}}`.
 */
class m200507_044930_create_items_views_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%items_views}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(),
            'item_views' => $this->integer(),
            'contacts_views' => $this->integer(),
            'period' => $this->date(),
        ]);

        $this->createIndex(
            '{{%idx-items_views-item_id}}',
            '{{%items_views}}',
            'item_id'
        );

        $this->addForeignKey(
            '{{%fk-items_views-item_id}}',
            '{{%items_views}}',
            'item_id',
            '{{%items}}',
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
            '{{%fk-items_views-item_id}}',
            '{{%items_views}}'
        );

        $this->dropIndex(
            '{{%idx-items_views-item_id}}',
            '{{%items_views}}'
        );
        $this->dropTable('{{%items_views}}');
    }
}
