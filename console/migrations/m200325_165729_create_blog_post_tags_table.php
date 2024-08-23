<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_post_tags}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%blog_posts}}`
 * - `{{%blog_tags}}`
 */
class m200325_165729_create_blog_post_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog_post_tags}}', [
            'id' => $this->primaryKey(),
            'blog_posts_id' => $this->integer()->comment('Блог'),
            'tag_id' => $this->integer()->comment('Тег'),
        ]);

        // creates index for column `blog_posts_id`
        $this->createIndex(
            '{{%idx-blog_post_tags-blog_posts_id}}',
            '{{%blog_post_tags}}',
            'blog_posts_id'
        );

        // add foreign key for table `{{%blog_posts}}`
        $this->addForeignKey(
            '{{%fk-blog_post_tags-blog_posts_id}}',
            '{{%blog_post_tags}}',
            'blog_posts_id',
            '{{%blog_posts}}',
            'id',
            'CASCADE'
        );

        // creates index for column `tag_id`
        $this->createIndex(
            '{{%idx-blog_post_tags-tag_id}}',
            '{{%blog_post_tags}}',
            'tag_id'
        );

        // add foreign key for table `{{%blog_tags}}`
        $this->addForeignKey(
            '{{%fk-blog_post_tags-tag_id}}',
            '{{%blog_post_tags}}',
            'tag_id',
            '{{%blog_tags}}',
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
            '{{%fk-blog_post_tags-blog_posts_id}}',
            '{{%blog_post_tags}}'
        );

        // drops index for column `blog_posts_id`
        $this->dropIndex(
            '{{%idx-blog_post_tags-blog_posts_id}}',
            '{{%blog_post_tags}}'
        );

        // drops foreign key for table `{{%blog_tags}}`
        $this->dropForeignKey(
            '{{%fk-blog_post_tags-tag_id}}',
            '{{%blog_post_tags}}'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            '{{%idx-blog_post_tags-tag_id}}',
            '{{%blog_post_tags}}'
        );

        $this->dropTable('{{%blog_post_tags}}');
    }
}
