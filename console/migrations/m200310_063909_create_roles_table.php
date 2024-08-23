<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%roles}}`.
 */
class m200310_063909_create_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%roles}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
            'color' => $this->string(255)->comment("Цветь"),
            'key' => $this->string(255)->comment("Ключ"),
            'admin_access' => $this->boolean()->comment("Доступ к админ панелю"),
        ]);

        // $this->insert('roles',array(
        //     'name' => 'Супер админ', 
        //     'color' => '#000000', 
        //     'key' => 'superadmin', 
        //     'admin_access' => 1
        // ));
        // $this->insert('roles',array(
        //     'name' => 'Главный администратор', 
        //     'color' => '#19d13e', 
        //     'key' => 'admin',
        //     'admin_access' => 1
        // ));
        // $this->insert('roles',array(
        //     'name' => 'SEO-Специалист',
        //     'color' => '#c98402',
        //     'key' => 'seo',
        //     'admin_access' => 1
        // ));
        // $this->insert('roles',array(
        //     'name' => 'Модератор',
        //     'color' => '#c90226',
        //     'key' => 'moderator',
        //     'admin_access' => 1
        // ));
        // $this->insert('roles',array(
        //     'name' => 'Пользователь',
        //     'color' => '#6e6e6e',
        //     'key' => 'user',
        //     'admin_access' => 0
        // ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%roles}}');
    }
}
