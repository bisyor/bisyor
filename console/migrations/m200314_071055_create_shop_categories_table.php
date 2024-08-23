<?php

use yii\db\Migration;
use Cocur\Slugify\Slugify;
/**
 * Handles the creation of table `{{%shop_categories}}`.
 */
class m200314_071055_create_shop_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shop_categories}}', [
            'id' => $this->primaryKey(),
            'sorting' => $this->integer()->comment("Сортировка"),
            'title' => $this->string(255)->comment("Заголовок"),
            'keyword' => $this->string(255)->comment("Ключ"),
            'icon_b' => $this->string(255)->comment("Иконка (большая)"),
            'icon_s' => $this->string(255)->comment("Иконка (малая)"),
            'enabled' => $this->boolean()->comment("Статус"),
            'parent_id' => $this->integer()->comment("Подкатегория"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
        ]);

        // creates index for column `parent_id`
        $this->createIndex(
            '{{%idx-shop_categories-parent_id}}',
            '{{%shop_categories}}',
            'parent_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-shop_categories-parent_id}}',
            '{{%shop_categories}}',
            'parent_id',
            '{{%shop_categories}}',
            'id',
            'CASCADE'
        );

        $slugify = new Slugify();

        $categories = [
            'Недвижимость',     
            'Транспорт',     
            'Детский мир',     
            'Животные',     
            'Электроника',     
            'Услуги',     
            'Мода и стиль',     
            'Дом и сад',     
            'Бизнес',     
            'Работа',     
            'Хобби, отдых и спорт',     
        ];
        $id = 1;
        foreach ($categories as $key=>$value) {
            $id++;
            $keyword = $slugify->slugify($value);
            $this->insert('{{%shop_categories}}',array(
              'id' => $id,
              'title'=> $value,
              'sorting' => $key,
              'keyword' => $keyword,
              'enabled' => 1,
              'icon_s' => $keyword."_s.png",
              'icon_b' => $keyword."_b.png",
              'date_cr'=> date("Y-m-d H:i"),
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-shop_categories-parent_id}}',
            '{{%shop_categories}}'
        );

        // drops index for column `parent_id`
        $this->dropIndex(
            '{{%idx-shop_categories-parent_id}}',
            '{{%shop_categories}}'
        );

        $this->dropTable('{{%shop_categories}}');
    }
}
