<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%helps_categories}}`.
 */
class m200321_092124_create_helps_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%helps_categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
            'sorting' => $this->integer()->comment("Сортировка"),
        ]);
        
        $this->insert('helps_categories',array(
            'name' => 'Объявления', 
            'sorting' => '1',
        ));
        $this->insert('helps_categories',array(
            'name' => 'Bisyor для бизнеса', 
            'sorting' => '2',
        ));
        $this->insert('helps_categories',array(
            'name' => 'Продвижение объявлений', 
            'sorting' => '3',
        ));
        $this->insert('helps_categories',array(
            'name' => 'Технические вопросы', 
            'sorting' => '4',
        ));
        $this->insert('helps_categories',array(
            'name' => 'Доставка на Bisyor', 
            'sorting' => '5',
        ));
        $this->insert('helps_categories',array(
            'name' => 'Безопастность на Bisyor', 
            'sorting' => '6',
        ));
        $this->insert('helps_categories',array(
            'name' => 'Профиль', 
            'sorting' => '7',
        ));
        $this->insert('helps_categories',array(
            'name' => 'Способы оплаты', 
            'sorting' => '8',
        ));
        $this->insert('helps_categories',array(
            'name' => 'Платное размешение', 
            'sorting' => '9',
        ));
        $this->insert('helps_categories',array(
            'name' => 'Мобильный Bisyor', 
            'sorting' => '10',
        ));
        $this->insert('helps_categories',array(
            'name' => 'Правила сайта', 
            'sorting' => '11',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%helps_categories}}');
    }
}
