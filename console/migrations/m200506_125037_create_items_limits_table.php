<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items_limits}}`.
 */
class m200506_125037_create_items_limits_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%items_limits}}', [
            'id' => $this->primaryKey(),
            'cat_id' => $this->integer(),
            'district_id' => $this->integer(),
            'shop' => $this->tinyInteger(),
            'free' => $this->tinyInteger(),
            'items' => $this->integer(),
            'settings' => $this->text(),
            'enabled' => $this->tinyInteger(),
            'group_id' => $this->integer(),
            'title' => $this->text(),
        ]);

        // $this->createIndex(
        //     '{{%idx-items_limits-cat_id}}',
        //     '{{%items_limits}}',
        //     'cat_id'
        // );

        // $this->addForeignKey(
        //     '{{%fk-items_limits-cat_id}}',
        //     '{{%items_limits}}',
        //     'cat_id',
        //     '{{%categories}}',
        //     'id',
        //     'CASCADE'
        // );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // $this->dropForeignKey(
        //     '{{%fk-items_limits-cat_id}}',
        //     '{{%items_limits}}'
        // );

        // $this->dropIndex(
        //     '{{%idx-items_limits-cat_id}}',
        //     '{{%items_limits}}'
        // );

        $this->dropTable('{{%items_limits}}');
    }
}
