<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banners_items}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%banners}}`
 */
class m200412_085834_create_banners_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banners_items}}', [
            'id' => $this->primaryKey(),
            'banner_id' => $this->integer()->comment("Рекламный баннер"),
            'type' => $this->integer()->comment("Тип"),
            'type_data' => $this->text()->comment("Код"),
            'img' => $this->string(255)->comment("Картинка"),
            'sitemap_id' => $this->text()->comment("URL размещения: (относительный UR"),
            'category_id' => $this->text()->comment("Не учитывать вложенные страни"),
            'locale' => $this->text()->comment("locale"),
            'url_match' => $this->text()->comment("url_match"),
            'url_match_exact' => $this->boolean()->comment("url_match_exact"),
            'click_url' => $this->text()->comment("click_url"),
            'url' => $this->string(255)->comment("Ссылка"),
            'show_start' => $this->datetime()->comment("Дата начала"),
            'show_finish' => $this->datetime()->comment("Дата окончани"),
            'show_limit' => $this->integer()->comment("Количество пока"),
            'title' => $this->string(255)->comment("Наименование реклам"),
            'description' => $this->text()->comment("Текст"),
            'alt' => $this->string(255)->comment("Алт"),
            'enabled' => $this->integer()->comment("Показать или н"),
            'date_cr' => $this->datetime()->comment("Дата создани"),
            'list_pos' => $this->integer()->comment("list_pos"),
            'target_blank' => $this->boolean()->comment("Таргет или нет"),
            'sorting_number' => $this->integer()->comment("Порядковый номер"),
            'time' => $this->integer()->comment("Время"),
        ]);

        // creates index for column `banner_id`
        $this->createIndex(
            '{{%idx-banners_items-banner_id}}',
            '{{%banners_items}}',
            'banner_id'
        );

        // add foreign key for table `{{%banners}}`
        $this->addForeignKey(
            '{{%fk-banners_items-banner_id}}',
            '{{%banners_items}}',
            'banner_id',
            '{{%banners}}',
            'id',
            'CASCADE'
        );

        // creates index for column `banner_id`
        $this->createIndex(
            '{{%idx-banners_statistic-banner_id}}',
            '{{%banners_statistic}}',
            'banner_id'
        );

        // add foreign key for table `{{%banners}}`
        $this->addForeignKey(
            '{{%fk-banners_statistic-banner_id}}',
            '{{%banners_statistic}}',
            'banner_id',
            '{{%banners_items}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%banners}}`
        $this->dropForeignKey(
            '{{%fk-banners_items-banner_id}}',
            '{{%banners_items}}'
        );

        // drops index for column `banner_id`
        $this->dropIndex(
            '{{%idx-banners_items-banner_id}}',
            '{{%banners_items}}'
        );
        // drops foreign key for table `{{%banners}}`
        $this->dropForeignKey(
            '{{%fk-banners_statistic-banner_id}}',
            '{{%banners_statistic}}'
        );

        // drops index for column `banner_id`
        $this->dropIndex(
            '{{%idx-banners_statistic-banner_id}}',
            '{{%banners_statistic}}'
        );

        $this->dropTable('{{%banners_items}}');
    }
}
