<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tariff_service_discount}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%shops_abonements}}`
 * - `{{%services}}`
 */
class m200328_114056_create_tariff_service_discount_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tariff_service_discount}}', [
            'id' => $this->primaryKey(),
            'abonoment_id' => $this->integer()->comment("Абонемент"),
            'service_id' => $this->integer()->comment("Сервис"),
            'percent' => $this->float()->comment("Скидка"),
        ]);

        // creates index for column `abonoment_id`
        $this->createIndex(
            '{{%idx-tariff_service_discount-abonoment_id}}',
            '{{%tariff_service_discount}}',
            'abonoment_id'
        );

        // add foreign key for table `{{%shops_abonements}}`
        $this->addForeignKey(
            '{{%fk-tariff_service_discount-abonoment_id}}',
            '{{%tariff_service_discount}}',
            'abonoment_id',
            '{{%shops_abonements}}',
            'id',
            'CASCADE'
        );

        // creates index for column `service_id`
        $this->createIndex(
            '{{%idx-tariff_service_discount-service_id}}',
            '{{%tariff_service_discount}}',
            'service_id'
        );

        // add foreign key for table `{{%services}}`
        $this->addForeignKey(
            '{{%fk-tariff_service_discount-service_id}}',
            '{{%tariff_service_discount}}',
            'service_id',
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
        // drops foreign key for table `{{%shops_abonements}}`
        $this->dropForeignKey(
            '{{%fk-tariff_service_discount-abonoment_id}}',
            '{{%tariff_service_discount}}'
        );

        // drops index for column `abonoment_id`
        $this->dropIndex(
            '{{%idx-tariff_service_discount-abonoment_id}}',
            '{{%tariff_service_discount}}'
        );

        // drops foreign key for table `{{%services}}`
        $this->dropForeignKey(
            '{{%fk-tariff_service_discount-service_id}}',
            '{{%tariff_service_discount}}'
        );

        // drops index for column `service_id`
        $this->dropIndex(
            '{{%idx-tariff_service_discount-service_id}}',
            '{{%tariff_service_discount}}'
        );

        $this->dropTable('{{%tariff_service_discount}}');
    }
}
