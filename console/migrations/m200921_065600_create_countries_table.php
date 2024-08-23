<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%countries}}`.
 */
class m200921_065600_create_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%countries}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'keyword' => $this->string(255),
            'declination' => $this->string(255),
        ]);

        $this->insert('countries',array('name' => 'Узбекистан', 'keyword' => 'Uzbekistan', 'declination' => 'в Узбекистане'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%countries}}');
    }
}
