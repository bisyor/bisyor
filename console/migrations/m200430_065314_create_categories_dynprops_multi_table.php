<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories_dynprops_multi}}`.
 */
class m200430_065314_create_categories_dynprops_multi_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories_dynprops_multi}}', [
            'id' => $this->primaryKey(),
            'dynprop_id' => $this->integer()->comment('Динамическое свойства'),
            'name' => $this->string(255)->comment('Наименование'),
            'value' => $this->string(255)->comment('Значение'),
            'num' => $this->integer()->comment('Номер'),
        ]);

        $this->createIndex(
            '{{%idx-categories_dynprops_multi-dynprop_id}}',
            '{{%categories_dynprops_multi}}',
            'dynprop_id'
        );

        // add foreign key for table `{{%promocodes}}`
        $this->addForeignKey(
            '{{%fk-categories_dynprops_multi-dynprop_id}}',
            '{{%categories_dynprops_multi}}',
            'dynprop_id',
            '{{%categories_dynprops}}',
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
            '{{%fk-categories_dynprops_multi-dynprop_id}}',
            '{{%categories_dynprops_multi}}'
        );

        $this->dropIndex(
            '{{%idx-categories_dynprops_multi-dynprop_id}}',
            '{{%categories_dynprops_multi}}'
        );
        $this->dropTable('{{%categories_dynprops_multi}}');
    }
}
