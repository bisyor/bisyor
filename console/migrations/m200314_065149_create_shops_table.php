<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%districts}}`
 */
class m200314_065149_create_shops_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment("Пользователь"),
            'name' => $this->string(255)->comment("Название магазина"),
            'logo' => $this->string(255)->comment("Логотип"),
            'keyword' => $this->string(255)->comment("Слуг url"),
            'status' => $this->integer()->comment("0-Активные, 1-Неактивные, 2-На модерации, 3-Заблокированные"),
            'description' => $this->text()->comment("Описание"),
            'district_id' => $this->integer()->comment("Регион, Район"),
            'address' => $this->text()->comment("Адрес"),
            'coordinate_x' => $this->string(255)->comment("Coordinate X"),
            'coordinate_y' => $this->string(255)->comment("Coordinate Y"),
            'phone' => $this->string(255)->comment("Телефон номер"),
            'phones' => $this->text()->comment("Телефон номеры"),
            'site' => $this->string(255)->comment("Ссылка сайта"),
            'blocked_reason' => $this->text()->comment("Причина блокировки"),
            'admin_comment' => $this->text()->comment("Комментария админа"),
            'social_networks' => $this->text()->comment("Социальные сети"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
            'date_up' => $this->datetime()->comment("Дата изменение"),
            'svc_fixed' => $this->boolean()->defaultValue(false)->comment("Статус сервиса Закрепление"),
            'svc_fixed_to' => $this->datetime()->comment("Дата окончение сервиса Закрепление"),
            'svc_fixed_order' => $this->datetime()->comment("Дата активации сервиса Закрепление"),
            'svc_marked_to' => $this->datetime()->comment("Дата окончение сервиса Выделение"),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-shops-user_id}}',
            '{{%shops}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-shops-user_id}}',
            '{{%shops}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `district_id`
        $this->createIndex(
            '{{%idx-shops-district_id}}',
            '{{%shops}}',
            'district_id'
        );

        // add foreign key for table `{{%districts}}`
        $this->addForeignKey(
            '{{%fk-shops-district_id}}',
            '{{%shops}}',
            'district_id',
            '{{%districts}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-shops-user_id}}',
            '{{%shops}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-shops-user_id}}',
            '{{%shops}}'
        );

        // drops foreign key for table `{{%districts}}`
        $this->dropForeignKey(
            '{{%fk-shops-district_id}}',
            '{{%shops}}'
        );

        // drops index for column `district_id`
        $this->dropIndex(
            '{{%idx-shops-district_id}}',
            '{{%shops}}'
        );

        $this->dropTable('{{%shops}}');
    }
}
