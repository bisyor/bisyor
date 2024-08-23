<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_roles}}`.
 */
class m200310_153402_create_user_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_roles}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment("Пользователь"),
            'role_id' => $this->integer()->comment("Роль"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
        ]);
        $this->createIndex(
            'idx-user_roles-user_id',
            'user_roles',
            'user_id'
        );


        // add foreign key for table `user_roles`
        $this->addForeignKey(
            'fk-user_roles-user_id',
            'user_roles',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-user_roles-role_id',
            'user_roles',
            'role_id'
        );


        // add foreign key for table `user_roles`
        $this->addForeignKey(
            'fk-user_roles-role_id',
            'user_roles',
            'role_id',
            'roles',
            'id',
            'CASCADE'
        );

        // $this->insert('user_roles',array(
        //   'user_id'=> 1,
        //   'role_id' => 1,
        //   'date_cr'=> date("Y-m-d"),
        // ));
        // $this->insert('user_roles',array(
        //   'user_id'=> 1,
        //   'role_id' => 2,
        //   'date_cr'=> date("Y-m-d"),
        // ));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_roles-user_id', 'user_roles');
        $this->dropIndex(
            '{{%idx-user_roles-user_id}}',
            '{{%user_roles}}'
        );
        $this->dropForeignKey('fk-user_roles-role_id', 'user_roles');
        $this->dropIndex(
            '{{%idx-user_roles-role_id}}',
            '{{%user_roles}}'
        );
        $this->dropTable('{{%user_roles}}');
    }
}
