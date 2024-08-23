<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_categories}}`.
 */
class m200325_154135_create_blog_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog_categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment('Наименование'),
            'key' => $this->string(255)->comment('Ключ'),
            'sorting' => $this->integer()->comment('Сортировка'),
            'date_cr' => $this->datetime()->comment('Дата создание'),
            'enabled' => $this->boolean()->comment('Статус'),
       ]);
        $this->createIndex(
            'idx-blog_categories-key',
            'blog_categories',
            'key'
        );
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-blog_categories-key',
            'blog_categories'
        );
        $this->dropTable('{{%blog_categories}}');
    }
}
