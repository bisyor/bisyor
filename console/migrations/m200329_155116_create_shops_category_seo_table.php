<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_category_seo}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%shop_categories}}`
 */
class m200329_155116_create_shops_category_seo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_category_seo}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->comment("Заголовок"),
            'keywords' => $this->text()->comment("Ключевые слова"),
            'description' => $this->text()->comment("Описание"),
            'breadcumb' => $this->string(255)->comment("Хлебная крошка"),
            'h1_title' => $this->string(255)->comment("Заголовок H1"),
            'seo_text' => $this->text()->comment("SEO текст"),
            'category_id' => $this->integer()->comment("Категория"),
        ]);

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-shops_category_seo-category_id}}',
            '{{%shops_category_seo}}',
            'category_id'
        );

        // add foreign key for table `{{%shop_categories}}`
        $this->addForeignKey(
            '{{%fk-shops_category_seo-category_id}}',
            '{{%shops_category_seo}}',
            'category_id',
            '{{%shop_categories}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%shop_categories}}`
        $this->dropForeignKey(
            '{{%fk-shops_category_seo-category_id}}',
            '{{%shops_category_seo}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-shops_category_seo-category_id}}',
            '{{%shops_category_seo}}'
        );

        $this->dropTable('{{%shops_category_seo}}');
    }
}
