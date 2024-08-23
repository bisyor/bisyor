<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banners}}`.
 */
class m200412_083637_create_banners_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banners}}', [
            'id' => $this->primaryKey(),
            'keyword' => $this->string(255)->comment("Ключ"),
            'title' => $this->string(255)->comment(" Наименование рекламы"),
            'enabled' => $this->boolean()->comment("Статус"),
            'width' => $this->float()->comment("Ширина"),
            'height' => $this->float()->comment("Высота"),
            'filter_auth_users' => $this->boolean()->comment("Скрывать для авторизованных пользов"),
        ]);
        $this->createIndex(
            'idx-banners-keyword',
            'banners',
            'keyword'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-banners-keyword',
            'banners'
        );
        $this->dropTable('{{%banners}}');
    }
}
