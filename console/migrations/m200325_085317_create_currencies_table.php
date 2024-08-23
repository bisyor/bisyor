<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currencies}}`.
 */
class m200325_085317_create_currencies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%currencies}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(255)->comment('Код валюты'),
            'short_name' => $this->string(255)->comment('Короткое название'),
            'name' => $this->string(255)->comment('Наименование'),
            'rate' => $this->float()->comment('Курс валюты'),
            'sorting' => $this->integer()->comment('Сортировка'),
            'enabled' => $this->boolean()->comment('Вкл/Отк'),
            'default' => $this->boolean()->comment('По умолчанию'),
        ]);

         $this->insert('currencies',array(
            'code' => 'UZS',
            'short_name' => 'So\'m',
            'name' => 'Сум',
            'rate' => 1,
            'sorting' => 1,
            'enabled' => 1,
            'default' => 1,
        ));
          $this->insert('currencies',array(
            'code' => 'RUB',
            'short_name' => 'Rubl',
            'name' => 'Рубль',
            'rate' => 141,
            'sorting' => 2,
            'enabled' => 0,
            'default' => 0,
            
        ));
           $this->insert('currencies',array(
            'code' => 'USD',
            'short_name' => 'y.e',
            'name' => 'y.e',
            'rate' => 10200,
            'sorting' => 3,
            'enabled' => 1,
            'default' => 0,
            
        ));
            $this->insert('currencies',array(
            'code' => 'EUR',
            'short_name' => 'Evro',
            'name' => 'Евро',
            'rate' => 11000,
            'sorting' => 4,
            'enabled' => 0,
            'default' => 0,
            
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%currencies}}');
    }
}
