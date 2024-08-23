<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_posts}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%blog_tags}}`
 * - `{{%users}}`
 */
class m200325_164642_create_blog_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog_posts}}', [
            'id' => $this->primaryKey(),
            'blog_categories_id' => $this->integer()->comment('Категория'), 
            'title' => $this->string(255)->comment('Наименование'),
            'slug' => $this->string(255)->comment('Слуг'),
            'image' => $this->string(255)->comment('Картинка'),
            'status' => $this->integer()->comment('Статус'),
            'short_text' => $this->text()->comment('Короткое Описание'),
            'text' => $this->text()->comment('Текст'), 
            'date_cr' => $this->datetime()->comment('Дата создании'),
            'view_count' => $this->integer()->comment('Количество просмотров'),
            'user_id' => $this->integer()->comment('Пользователь'), 
        ]);

        // creates index for column `blog_categories_id`
        $this->createIndex(
            '{{%idx-blog_posts-blog_categories_id}}',
            '{{%blog_posts}}',
            'blog_categories_id'
        );

        // add foreign key for table `{{%blog_categories}}`
        $this->addForeignKey(
            '{{%fk-blog_posts-blog_categories_id}}',
            '{{%blog_posts}}',
            'blog_categories_id',
            '{{%blog_categories}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-blog_posts-user_id}}',
            '{{%blog_posts}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-blog_posts-user_id}}',
            '{{%blog_posts}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%blog_categories}}`
        $this->dropForeignKey(
            '{{%fk-blog_posts-blog_categories_id}}',
            '{{%blog_posts}}'
        );

        // drops index for column `blog_categories_id`
        $this->dropIndex(
            '{{%idx-blog_posts-blog_categories_id}}',
            '{{%blog_posts}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-blog_posts-user_id}}',
            '{{%blog_posts}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-blog_posts-user_id}}',
            '{{%blog_posts}}'
        );

        $this->dropTable('{{%blog_posts}}');
    }
}
