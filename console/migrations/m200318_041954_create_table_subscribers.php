<?php

use yii\db\Migration;

/**
 * Class m200318_041954_create_table_subscribers
 */
class m200318_041954_create_table_subscribers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscribers}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->comment("E-mail"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200318_041954_create_table_subscribers cannot be reverted.\n";

        return false;
    }

}
