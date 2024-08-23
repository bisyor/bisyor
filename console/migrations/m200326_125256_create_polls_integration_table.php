<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%polls_integration}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%polls}}`
 * - `{{%lang}}`
 */
class m200326_125256_create_polls_integration_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%polls_integration}}', [
            'id' => $this->primaryKey(),
            'poll_id' => $this->integer()->comment('Опроса'),
            'type' => $this->integer()->comment('Отобразить'),
            'frame' => $this->boolean()->comment('Цвет рамки'),
            'frame_color' => $this->string(255)->comment('Цвет'),
            'background' => $this->boolean()->comment('Цвет фона'),
            'background_color' => $this->string(255)->comment('Цвет'),
            'language_id' => $this->integer()->comment('Язык'),
            'result' => $this->boolean()->comment('Цвет результата'),
            'result_color' => $this->string(255)->comment('Цвет'),
            'code' => $this->text()->comment('Код для вставки'),
        ]);

        // creates index for column `poll_id`
        $this->createIndex(
            '{{%idx-polls_integration-poll_id}}',
            '{{%polls_integration}}',
            'poll_id'
        );

        // add foreign key for table `{{%polls}}`
        $this->addForeignKey(
            '{{%fk-polls_integration-poll_id}}',
            '{{%polls_integration}}',
            'poll_id',
            '{{%polls}}',
            'id',
            'CASCADE'
        );

        // creates index for column `language_id`
        $this->createIndex(
            '{{%idx-polls_integration-language_id}}',
            '{{%polls_integration}}',
            'language_id'
        );

        // add foreign key for table `{{%lang}}`
        $this->addForeignKey(
            '{{%fk-polls_integration-language_id}}',
            '{{%polls_integration}}',
            'language_id',
            '{{%lang}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%polls}}`
        $this->dropForeignKey(
            '{{%fk-polls_integration-poll_id}}',
            '{{%polls_integration}}'
        );

        // drops index for column `poll_id`
        $this->dropIndex(
            '{{%idx-polls_integration-poll_id}}',
            '{{%polls_integration}}'
        );

        // drops foreign key for table `{{%lang}}`
        $this->dropForeignKey(
            '{{%fk-polls_integration-language_id}}',
            '{{%polls_integration}}'
        );

        // drops index for column `language_id`
        $this->dropIndex(
            '{{%idx-polls_integration-language_id}}',
            '{{%polls_integration}}'
        );

        $this->dropTable('{{%polls_integration}}');
    }
}
