<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%blog_posts}}`.
 */
class m201218_091035_add_image_m_column_to_blog_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%blog_posts}}', 'image_m', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%blog_posts}}', 'image_m');
    }
}
