<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%brands}}`.
 */
class m200320_134019_create_brands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%brands}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
            'sorting' => $this->integer()->comment("Сортировка"),
            'enabled' => $this->boolean()->comment("Вкл/Откл"),
            'image' => $this->string(255)->comment("Картинка")
        ]);


        $this->insert('brands',array(
            'name' => 'Samsung', 
            'image' =>'samsung.png',
            'sorting' => 1, 
            'enabled' => 1, 
        ));

        $this->insert('brands',array(
            'name' => 'Elektrolux', 
            'image' =>'elektrolux.png',
            'sorting' => 2, 
            'enabled' => 1, 
        ));

          $this->insert('brands',array(
            'name' => 'Philips',  
            'image' =>'philips.png',
            'sorting' => 3, 
            'enabled' => 1, 
        ));

          $this->insert('brands',array(
            'name' => 'Acer', 
            'image' =>'acer.png',
            'sorting' => 4, 
            'enabled' => 1, 
        ));
        
          $this->insert('brands',array(
            'name' => 'Adidas', 
            'image' =>'adidas.png',
            'sorting' => 5, 
            'enabled' => 1, 
        ));

          $this->insert('brands',array(
            'name' => 'Asus', 
            'image' =>'asus.png',
            'sorting' => 6, 
            'enabled' => 1, 
        ));

          $this->insert('brands',array(
            'name' => 'Apple', 
            'image' =>'apple.png',
            'sorting' => 7, 
            'enabled' => 1, 
        ));  

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%brands}}');
    }
}
