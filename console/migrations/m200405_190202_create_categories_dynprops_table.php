<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories_dynprops}}`.
 */
class m200405_190202_create_categories_dynprops_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories_dynprops}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->comment('Категория'),
            'title' => $this->string(255)->comment('Заголовок'),
            'description' => $this->string(255)->comment('Описание'),
            'type' => $this->integer()->comment('Тип'),
            'default_value' => $this->string(255)->comment('Первоначалная значения'),
            'enabled' => $this->boolean()->comment('Статус'),
            //qushdim
            'cache_key' => $this->string(255)->comment("Кеш ключ"),
            'req' => $this->boolean()->comment("обязательное (для ввода)"),
            'in_search' => $this->boolean()->comment("поле поиска"),
            'in_seek' => $this->boolean()->comment("заполнять в объявлениях типа 'Ищу'"),
            'num_first' => $this->boolean()->comment("отображать перед наследуемыми (первым)"),
            'is_cache' => $this->integer()->comment(""),
            'extra' => $this->text()->comment(""),
            'parent' => $this->integer()->comment("с прикреплением"),
            'parent_value' => $this->integer()->comment("Значение Наследование"),
            'data_field' => $this->integer()->comment(""),
            'num' => $this->integer()->comment("Сортировка"),
            'txt' => $this->boolean()->comment(""),
            'in_table' => $this->boolean()->comment(""),
            'search_hidden' => $this->boolean()->comment(""),
        ]);

        $this->createIndex(
            '{{%idx-categories_dynprops-category_id}}',
            '{{%categories_dynprops}}',
            'category_id'
        );

        // add foreign key for table `{{%categories_dynprops}}`
        $this->addForeignKey(
            '{{%fk-categories_dynprops-parent_id}}',
            '{{%categories_dynprops}}',
            'category_id',
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
            '{{%fk-categories_dynprops-category_id}}',
            '{{%categories_dynprops}}'
        );

        $this->dropIndex(
            '{{%idx-categories_dynprops-category_id}}',
            '{{%categories_dynprops}}'
        );
        $this->dropTable('{{%categories_dynprops}}');
    }
}
