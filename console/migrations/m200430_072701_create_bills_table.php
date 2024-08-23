<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bills}}`.
 */
class m200430_072701_create_bills_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bills}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment('Пользователь'),
            'user_balance' => $this->float()->comment('Баланс пользователя'),
            'service_id' => $this->integer()->comment('Сервиз'),
            'svc_activate' => $this->boolean()->comment('Статус активации сервиса'),
            'svc_settings' => $this->text()->comment('Настройки сервиса'),
            'item_id' => $this->integer()->comment('Объявление/Магазин'),
            'type' => $this->integer()->comment('Тип'),
            'psystem' => $this->integer()->comment('Система оплаты'),
            'amount' => $this->float()->comment('Сумма'),
            'money' => $this->float()->comment('Денги'),
            'currency_id' => $this->integer()->comment('Валюта'),
            'date_cr' => $this->dateTime()->comment('Дата создание'),
            'date_pay' => $this->dateTime()->comment('Дата оплаты'),
            'status' => $this->integer()->comment('Статус'),
            'description' => $this->text()->comment('Описание'),
            'details' => $this->text()->comment('Деталь'),
            'ip' => $this->string()->comment('Ip Пользователя'),
            'promocode_id' => $this->integer()->comment('Промо код'),
        ]);

        $this->createIndex(
            '{{%idx-bills-user_id}}',
            '{{%bills}}',
            'user_id'
        );

        // add foreign key for table `{{%promocodes}}`
        $this->addForeignKey(
            '{{%fk-bills-user_id}}',
            '{{%bills}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-bills-service_id}}',
            '{{%bills}}',
            'service_id'
        );

        // add foreign key for table `{{%promocodes}}`
        $this->addForeignKey(
            '{{%fk-bills-service_id}}',
            '{{%bills}}',
            'service_id',
            '{{%services}}',
            'id',
            'CASCADE'
        );
        /*$this->createIndex(
            '{{%idx-bills-item_id}}',
            '{{%bills}}',
            'item_id'
        );

        // add foreign key for table `{{%promocodes}}`
        $this->addForeignKey(
            '{{%fk-bills-item_id}}',
            '{{%bills}}',
            'item_id',
            '{{%items}}',
            'id',
            'CASCADE'
        );*/
        $this->createIndex(
            '{{%idx-bills-currency_id}}',
            '{{%bills}}',
            'currency_id'
        );

        // add foreign key for table `{{%promocodes}}`
        $this->addForeignKey(
            '{{%fk-bills-currency_id}}',
            '{{%bills}}',
            'currency_id',
            '{{%currencies}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-bills-promocode_id}}',
            '{{%bills}}',
            'promocode_id'
        );

        // add foreign key for table `{{%promocodes}}`
        $this->addForeignKey(
            '{{%fk-bills-promocode_id}}',
            '{{%bills}}',
            'promocode_id',
            '{{%promocodes}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-bills-user_id}}',
            '{{%bills}}'
        );
        $this->dropIndex(
            '{{%idx-bills-user_id}}',
            '{{%bills}}'
        );
        $this->dropForeignKey(
            '{{%fk-bills-service_id}}',
            '{{%bills}}'
        );
        $this->dropIndex(
            '{{%idx-bills-service_id}}',
            '{{%bills}}'
        );
        /*$this->dropForeignKey(
            '{{%fk-bills-item_id}}',
            '{{%bills}}'
        );
        $this->dropIndex(
            '{{%idx-bills-item_id}}',
            '{{%bills}}'
        );*/
        $this->dropForeignKey(
            '{{%fk-bills-currency_id}}',
            '{{%bills}}'
        );
        $this->dropIndex(
            '{{%idx-bills-currency_id}}',
            '{{%bills}}'
        );
        $this->dropForeignKey(
            '{{%fk-bills-promocode_id}}',
            '{{%bills}}'
        );
        $this->dropIndex(
            '{{%idx-bills-promocode_id}}',
            '{{%bills}}'
        );
        $this->dropTable('{{%bills}}');
    }
}
