<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%black_list}}`.
 */
class m200409_162909_create_black_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%black_list}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
            'enabled' => $this->boolean()->comment("Статус"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%black_list}}');
    }
}
