<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m200405_185155_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'sorting' => $this->integer()->comment('Сортировка'),
            'numlevel' => $this->integer()->comment('Уровень'),
            'icon_b' => $this->string(255)->comment('Иконка (большая)'),
            'icon_s' => $this->string(255)->comment('Иконка (малая)'),
            'keyword' => $this->string(255)->comment('Ключ'),
            'enabled' => $this->boolean()->comment('Статус'),
            'date_cr' => $this->datetime()->comment('Дата создание'),
            'date_up' => $this->datetime()->comment('Дата изменение'),
            'parent_id' => $this->integer()->comment('Подкатегория'),
            'title' => $this->string(255)->comment('Заголовок'),
            'type_offer_form' => $this->string(255)->comment('Предлагаю'),
            'type_offer_search' => $this->string(255)->comment('Объявления'),
            'type_seek_form' => $this->string(255)->comment('Ищу'),
            'type_seek_search' => $this->string(255)->comment('Объявления'),
            'seek' => $this->boolean()->comment('Задействовать'),
            'price' => $this->boolean()->comment('Цена'),
            'price_sett' => $this->text()->comment('Элементы цены'),
            'photos' => $this->integer()->comment('Фотографии'),
            'owner_business' => $this->boolean()->comment('Представитель'),
            'owner_private_form' => $this->string(255)->comment('Частное лицо'),
            'owner_private_search' => $this->string(255)->comment('От частных лиц'),
            'owner_business_form' => $this->string(255)->comment('Бизнес'),
            'owner_business_search' => $this->string(255)->comment('Только бизнес объявления'),
            'owner_search' => $this->boolean()->comment('Галочка'),
            'owner_search_business' => $this->boolean()->comment('Галочка'),
            'address' => $this->boolean()->comment('Адрес'),
            'metro' => $this->boolean()->comment('Метро'),
            'regions_delivery' => $this->boolean()->comment('Доступна возможность указать доставку в регионы'),
            'list_type' => $this->integer()->comment(' Вид списка по умолчанию'),
            'keyword_edit' => $this->string(255)->comment('URL Keyword'),
            'search_exrta_keywords' => $this->text()->comment('Подсказки быстрого поиска'),
            'items' => $this->integer(),
            'shops' => $this->integer(),
            'subs_filter_level' => $this->integer(),
            'subs_filter_title' => $this->text(),
            //----------------------Шаблоны-------------------
            'tpl_title_enabled' => $this->text()->comment('Автоматическая генерация заголовка'),
            'tpl_title_view' => $this->text()->comment('Шаблон для просмотра объявления'),
            'tpl_title_list' => $this->text()->comment('Шаблон для списка объявлений'),
            'tpl_descr_list' => $this->text()->comment('Шаблон для описания объявления (список)'),
            //----------------------SEO------------------------
            //--------------------Поиск в категории------------
            'mtitle' => $this->string(255)->comment("Заголовок"),
            'mkeywords' => $this->text()->comment("Ключевые слова"),
            'mdescription' => $this->text()->comment("Описание"),
            'breadcrumb' => $this->string(255)->comment("Хлебная крошка"),
            'titleh1' => $this->string(255)->comment("Заголовок H1"),
            'seotext' => $this->text()->comment(" SEO текст"),
            'landing_id' => $this->integer(),
            'landing_url' => $this->text()->comment("Посадочный URL"),
            'mtemplate'=> $this->boolean()->comment("Использовать общий шаблон"),
            //------------------Просмотр объявления------------
            'view_mtitle'=> $this->string(255)->comment("Заголовок (title )"),
            'view_mkeywords'=> $this->string(255)->comment(" Ключевые слова (meta keywords)"),
            'view_mdescription'=> $this->text()->comment("Описание (meta description)"),
            'view_share_title'=> $this->string(255)->comment("Заголовок (поделиться в соц. сетях)"),
            'view_share_description'=> $this->text()->comment("Описание (поделиться в соц. сетях)"),
            'view_share_sitename'=> $this->string(255)->comment("Название сайта (поделиться в соц. сетях)"),
            'view_mtemplate'=> $this->string(255)->comment("использовать общий шаблон"),
        ]);
        $this->createIndex(
            'idx-categories-keyword',
            'categories',
            'keyword'
        );
        $this->createIndex(
            'idx-categories-keyword_edit',
            'categories',
            'keyword_edit'
        );
        $this->createIndex(
            '{{%idx-categories-parent_id}}',
            '{{%categories}}',
            'parent_id'
        );

        // add foreign key for table `{{%roles}}`
        $this->addForeignKey(
            '{{%fk-categories-parent_id}}',
            '{{%categories}}',
            'parent_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-categories-keyword',
            'categories'
        );
        $this->dropIndex(
            'idx-categories-keyword_edit',
            'categories'
        );
        $this->dropForeignKey(
            '{{%fk-categories-parent_id}}',
            '{{%categories}}'
        );

        // drops index for column `role_id`
        $this->dropIndex(
            '{{%idx-categories-parent_id}}',
            '{{%categories}}'
        );

        $this->dropTable('{{%categories}}');
    }
}
