<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pakets_service}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%services}}`
 * - `{{%services}}`
 */
class m200420_104830_create_pakets_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pakets_service}}', [
            'id' => $this->primaryKey(),
            'service_id' => $this->integer()->comment("Сервис"),
            'paket_id' => $this->integer()->comment("Пакет"),
            'status' => $this->boolean()->comment("Статус"),
            'value' => $this->float()->comment("Значение"),
        ]);

        // creates index for column `service_id`
        $this->createIndex(
            '{{%idx-pakets_service-service_id}}',
            '{{%pakets_service}}',
            'service_id'
        );

        // add foreign key for table `{{%services}}`
        $this->addForeignKey(
            '{{%fk-pakets_service-service_id}}',
            '{{%pakets_service}}',
            'service_id',
            '{{%services}}',
            'id',
            'CASCADE'
        );

        // creates index for column `paket_id`
        $this->createIndex(
            '{{%idx-pakets_service-paket_id}}',
            '{{%pakets_service}}',
            'paket_id'
        );

        // add foreign key for table `{{%services}}`
        $this->addForeignKey(
            '{{%fk-pakets_service-paket_id}}',
            '{{%pakets_service}}',
            'paket_id',
            '{{%services}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%services}}`
        $this->dropForeignKey(
            '{{%fk-pakets_service-service_id}}',
            '{{%pakets_service}}'
        );

        // drops index for column `service_id`
        $this->dropIndex(
            '{{%idx-pakets_service-service_id}}',
            '{{%pakets_service}}'
        );

        // drops foreign key for table `{{%services}}`
        $this->dropForeignKey(
            '{{%fk-pakets_service-paket_id}}',
            '{{%pakets_service}}'
        );

        // drops index for column `paket_id`
        $this->dropIndex(
            '{{%idx-pakets_service-paket_id}}',
            '{{%pakets_service}}'
        );

        $this->dropTable('{{%pakets_service}}');
    }
}
