<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%landingpages}}`.
 */
class m200508_130608_create_landingpages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%landingpages}}', [
            'id' => $this->primaryKey(),
            'landing_uri' => $this->text()->comment('Посадочный URL'),
            'original_uri' => $this->text()->comment('Оригинальный URL'),
            'title' => $this->text()->comment('Заголовок'),
            'date_cr' => $this->dateTime()->comment('Дата создание'),
            'modified' => $this->dateTime()->comment('Дата изменение'),
            'user_id' => $this->integer()->comment('Пользовател'),
            'user_ip' => $this->string(255)->comment('Ip Адрес'),
            'enabled' => $this->tinyInteger()->comment('Статус'),
            'is_relative' => $this->tinyInteger()->comment('is_relative'),
            'joined' => $this->integer()->comment('joined'),
            'joined_module' => $this->text()->comment('Joined Module'),
            'titleh1' => $this->text()->comment('Заголовок H1'),
            'mtitle' => $this->text()->comment('Ключевые заголовок'),
            'mkeywords' => $this->text()->comment('Ключевые слова'),
            'mdescription' => $this->text()->comment('Описание'),
            'seotext' => $this->text()->comment('SEO текст'),
        ]);

        $this->createIndex(
            '{{%idx-landingpages-user_id}}',
            '{{%landingpages}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-landingpages-user_id}}',
            '{{%landingpages}}',
            'user_id',
            '{{%users}}',
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
            '{{%fk-landingpages-user_id}}',
            '{{%landingpages}}'
        );

        $this->dropIndex(
            '{{%idx-landingpages-user_id}}',
            '{{%landingpages}}'
        );
        $this->dropTable('{{%landingpages}}');
    }
}
