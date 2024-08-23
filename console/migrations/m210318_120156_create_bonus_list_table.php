<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bonus_list}}`.
 */
class m210318_120156_create_bonus_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bonus_list}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->comment("Заголовок"),
            'description' => $this->text()->comment("Описания"),
            'status' => $this->integer()->comment("Статус"),
            'image' => $this->string(255)->comment("Картинка"),
            'bonus' => $this->float()->comment("Бонус"),
            'keyword' => $this->string(255)->comment("Кей"),
        ]);

        $this->insert('bonus_list',array(
            'title' => "Бонус для пользователя",
            'description' => "Бонус пользователю за вход на платформу один раз в день",
            'status' => 1,
            'bonus' => 50,
            'keyword' => "day-login",
        ));

        $this->insert('bonus_list',array(
            'title' => "Бонус для пользователя",
            'description' => "Бонус для нового зарегистрированного пользователя",
            'status' => 1,
            'bonus' => 500,
            'keyword' => "registration",
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bonus_list}}');
    }
}
