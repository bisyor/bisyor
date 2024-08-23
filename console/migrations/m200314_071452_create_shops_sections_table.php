<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_sections}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%shops}}`
 * - `{{%shops_categories}}`
 */
class m200314_071452_create_shops_sections_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_sections}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer()->comment("Магазин"),
            'section_id' => $this->integer()->comment("Раздел"),
        ]);

        // creates index for column `shop_id`
        $this->createIndex(
            '{{%idx-shops_sections-shop_id}}',
            '{{%shops_sections}}',
            'shop_id'
        );

        // add foreign key for table `{{%shops}}`
        $this->addForeignKey(
            '{{%fk-shops_sections-shop_id}}',
            '{{%shops_sections}}',
            'shop_id',
            '{{%shops}}',
            'id',
            'CASCADE'
        );

        // creates index for column `section_id`
        $this->createIndex(
            '{{%idx-shops_sections-section_id}}',
            '{{%shops_sections}}',
            'section_id'
        );

        // add foreign key for table `{{%shop_categories}}`
        $this->addForeignKey(
            '{{%fk-shops_sections-section_id}}',
            '{{%shops_sections}}',
            'section_id',
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
        // drops foreign key for table `{{%shops}}`
        $this->dropForeignKey(
            '{{%fk-shops_sections-shop_id}}',
            '{{%shops_sections}}'
        );

        // drops index for column `shop_id`
        $this->dropIndex(
            '{{%idx-shops_sections-shop_id}}',
            '{{%shops_sections}}'
        );

        // drops foreign key for table `{{%shop_categories}}`
        $this->dropForeignKey(
            '{{%fk-shops_sections-section_id}}',
            '{{%shops_sections}}'
        );

        // drops index for column `section_id`
        $this->dropIndex(
            '{{%idx-shops_sections-section_id}}',
            '{{%shops_sections}}'
        );

        $this->dropTable('{{%shops_sections}}');
    }
}
