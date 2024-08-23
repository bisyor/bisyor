<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_slider}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%shops}}`
 */
class m200314_071809_create_shop_slider_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shop_slider}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer()->comment("Магазин"),
            'title' => $this->string(255)->comment("Заголовок"),
            'text' => $this->text()->comment("Текст"),
            'image' => $this->string(255)->comment("Картинка"),
            'link' => $this->string(255)->comment("Ссылка"),
        ]);

        // creates index for column `shop_id`
        $this->createIndex(
            '{{%idx-shop_slider-shop_id}}',
            '{{%shop_slider}}',
            'shop_id'
        );

        // add foreign key for table `{{%shops}}`
        $this->addForeignKey(
            '{{%fk-shop_slider-shop_id}}',
            '{{%shop_slider}}',
            'shop_id',
            '{{%shops}}',
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
            '{{%fk-shop_slider-shop_id}}',
            '{{%shop_slider}}'
        );

        // drops index for column `shop_id`
        $this->dropIndex(
            '{{%idx-shop_slider-shop_id}}',
            '{{%shop_slider}}'
        );

        $this->dropTable('{{%shop_slider}}');
    }
}
