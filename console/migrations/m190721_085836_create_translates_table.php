<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%translates}}`.
 */
class m190721_085836_create_translates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%translates}}', [
            'id' => $this->primaryKey(),
            'table_name' => $this->string(255)->comment("Наименование таблицы"),
            'field_id' => $this->integer()->comment("ID строка"),
            'field_name' => $this->string(255)->comment("Наименование строка"),
             'field_value' => $this->text()->comment("Значение"),
            'language_code' => $this->string(255)->comment("Код языка"),
        ]);
        $this->createIndex(
            'idx-translates-field_id',
            'translates',
            'field_id'
        );
        $this->createIndex(
            'idx-translates-table_name',
            'translates',
            'table_name'
        );$this->createIndex(
            'idx-translates-field_name',
            'translates',
            'field_name'
        );$this->createIndex(
            'idx-translates-language_code',
            'translates',
            'language_code'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%translates}}');
    }
}
