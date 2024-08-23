<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blogs_posts_likes}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%blog_posts}}`
 * - `{{%users}}`
 */
class m200325_170704_create_blogs_posts_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blogs_posts_likes}}', [
            'id' => $this->primaryKey(),
            'blog_posts_id' => $this->integer()->comment('Блог'),
            'type' => $this->integer()->comment('Тип'),
            'user_id' => $this->integer()->comment('Пользователь'), 
        ]);

        // creates index for column `blog_posts_id`
        $this->createIndex(
            '{{%idx-blogs_posts_likes-blog_posts_id}}',
            '{{%blogs_posts_likes}}',
            'blog_posts_id'
        );

        // add foreign key for table `{{%blog_posts}}`
        $this->addForeignKey(
            '{{%fk-blogs_posts_likes-blog_posts_id}}',
            '{{%blogs_posts_likes}}',
            'blog_posts_id',
            '{{%blog_posts}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-blogs_posts_likes-user_id}}',
            '{{%blogs_posts_likes}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-blogs_posts_likes-user_id}}',
            '{{%blogs_posts_likes}}',
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
        // drops foreign key for table `{{%blog_posts}}`
        $this->dropForeignKey(
            '{{%fk-blogs_posts_likes-blog_posts_id}}',
            '{{%blogs_posts_likes}}'
        );

        // drops index for column `blog_posts_id`
        $this->dropIndex(
            '{{%idx-blogs_posts_likes-blog_posts_id}}',
            '{{%blogs_posts_likes}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-blogs_posts_likes-user_id}}',
            '{{%blogs_posts_likes}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-blogs_posts_likes-user_id}}',
            '{{%blogs_posts_likes}}'
        );

        $this->dropTable('{{%blogs_posts_likes}}');
    }
}
