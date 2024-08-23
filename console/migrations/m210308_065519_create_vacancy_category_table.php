<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vacancy_category}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%vacancy_category}}`
 */
class m210308_065519_create_vacancy_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vacancy_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
            'parent_id' => $this->integer()->comment("Категория вакансии"),
            'is_parent' => $this->boolean(),
            'status' => $this->integer()->comment("Статус"),
        ]);

        // creates index for column `parent_id`
        $this->createIndex(
            '{{%idx-vacancy_category-parent_id}}',
            '{{%vacancy_category}}',
            'parent_id'
        );

        // add foreign key for table `{{%vacancy_category}}`
        $this->addForeignKey(
            '{{%fk-vacancy_category-parent_id}}',
            '{{%vacancy_category}}',
            'parent_id',
            '{{%vacancy_category}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%vacancy_category}}`
        $this->dropForeignKey(
            '{{%fk-vacancy_category-parent_id}}',
            '{{%vacancy_category}}'
        );

        // drops index for column `parent_id`
        $this->dropIndex(
            '{{%idx-vacancy_category-parent_id}}',
            '{{%vacancy_category}}'
        );

        $this->dropTable('{{%vacancy_category}}');
    }
}
