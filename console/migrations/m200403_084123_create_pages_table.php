<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pages}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m200403_084123_create_pages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pages}}', [
            'id' => $this->primaryKey(),
            'filename' => $this->string(255)->comment("Наименование"),
            'changed_id' => $this->integer()->comment("Заголовок"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
            'date_up' => $this->datetime()->comment("Дата изменение"),
            'noindex' => $this->boolean()->comment("ishlatmasligimiz ham mumkin"),
            'title' => $this->string(255)->comment("Заголовок"),
            'description' => $this->text()->comment("Описание"),
            'mtitle' => $this->text()->comment("Заголовок (title)"),
            'mkeywords' => $this->text()->comment("Ключевые слова (meta keywords)"),
            'mdescription' => $this->text()->comment("Описание (meta desctiption)"),
        ]);

        // creates index for column `changed_id`
        $this->createIndex(
            '{{%idx-pages-changed_id}}',
            '{{%pages}}',
            'changed_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-pages-changed_id}}',
            '{{%pages}}',
            'changed_id',
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
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-pages-changed_id}}',
            '{{%pages}}'
        );

        // drops index for column `changed_id`
        $this->dropIndex(
            '{{%idx-pages-changed_id}}',
            '{{%pages}}'
        );

        $this->dropTable('{{%pages}}');
    }
}
