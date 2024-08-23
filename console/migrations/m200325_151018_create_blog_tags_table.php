<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_tags}}`.
 */
class m200325_151018_create_blog_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog_tags}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment('Наименование'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog_tags}}');
    }
}
