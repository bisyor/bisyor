<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_tariff}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%shops_abonements}}`
 * - `{{%shops}}`
 */
class m200314_071631_create_shops_tariff_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_tariff}}', [
            'id' => $this->primaryKey(),
            'abonement_id' => $this->integer()->comment("Абонемент"),
            'shop_id' => $this->integer()->comment("Магазин"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
            'status' => $this->integer()->comment("1 - Активно, 2 - Не активно"),
            'data_access' => $this->date()->comment("Cрок действия"),
            'price' => $this->float()->comment("Общая стоимость"),
            'detail' => $this->text(),
            'preiod_id' => $this->integer(),
        ]);

        // creates index for column `abonement_id`
        $this->createIndex(
            '{{%idx-shops_tariff-abonement_id}}',
            '{{%shops_tariff}}',
            'abonement_id'
        );

        // add foreign key for table `{{%shops_abonements}}`
        $this->addForeignKey(
            '{{%fk-shops_tariff-abonement_id}}',
            '{{%shops_tariff}}',
            'abonement_id',
            '{{%shops_abonements}}',
            'id',
            'CASCADE'
        );

        // creates index for column `shop_id`
        $this->createIndex(
            '{{%idx-shops_tariff-shop_id}}',
            '{{%shops_tariff}}',
            'shop_id'
        );

        // add foreign key for table `{{%shops}}`
        $this->addForeignKey(
            '{{%fk-shops_tariff-shop_id}}',
            '{{%shops_tariff}}',
            'shop_id',
            '{{%shops}}',
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
            '{{%fk-shops_tariff-abonement_id}}',
            '{{%shops_tariff}}'
        );

        // drops index for column `abonement_id`
        $this->dropIndex(
            '{{%idx-shops_tariff-abonement_id}}',
            '{{%shops_tariff}}'
        );

        // drops foreign key for table `{{%shops}}`
        $this->dropForeignKey(
            '{{%fk-shops_tariff-shop_id}}',
            '{{%shops_tariff}}'
        );

        // drops index for column `shop_id`
        $this->dropIndex(
            '{{%idx-shops_tariff-shop_id}}',
            '{{%shops_tariff}}'
        );

        $this->dropTable('{{%shops_tariff}}');
    }
}
