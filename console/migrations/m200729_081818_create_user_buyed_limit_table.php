<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_buyed_limit}}`.
 */
class m200729_081818_create_user_buyed_limit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_buyed_limit}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment('Ползовател'),
            'active' => $this->boolean()->comment('Статус'),
            'shop' => $this->boolean()->comment('Для магазин'),
            'item_count' => $this->integer()->comment('Количество бесплатных объявлении'),
            'used_count' => $this->integer()->comment('Количество использованных'),
            'category_id' => $this->integer()->comment('Категория'),
            'regions' => $this->text()->comment('Регионы'),
            'summa' => $this->float()->comment('Стоимость'),
            'items' => $this->text()->comment('Лист объявлении'),
            'date_cr' => $this->date()->comment('Дата создание'),
            'date_to' => $this->date()->comment('Дата окончание'),
        ]);

        $this->createIndex(
            '{{%idx-user_buyed_limit-user_id}}',
            '{{%user_buyed_limit}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-user_buyed_limit-user_id}}',
            '{{%user_buyed_limit}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-user_buyed_limit-category_id}}',
            '{{%user_buyed_limit}}',
            'category_id'
        );

        $this->addForeignKey(
            '{{%fk-user_buyed_limit-category_id}}',
            '{{%user_buyed_limit}}',
            'category_id',
            '{{%categories}}',
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
            '{{%fk-user_buyed_limit-user_id}}',
            '{{%user_buyed_limit}}'
        );

        $this->dropIndex(
            '{{%idx-user_buyed_limit-user_id}}',
            '{{%user_buyed_limit}}'
        );

        $this->dropForeignKey(
            '{{%fk-user_buyed_limit-category_id}}',
            '{{%user_buyed_limit}}'
        );

        $this->dropIndex(
            '{{%idx-user_buyed_limit-category_id}}',
            '{{%user_buyed_limit}}'
        );

        $this->dropTable('{{%user_buyed_limit}}');
    }
}
