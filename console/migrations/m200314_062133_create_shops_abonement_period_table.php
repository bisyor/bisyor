<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_abonement_period}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%shops_abonements}}`
 */
class m200314_062133_create_shops_abonement_period_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_abonement_period}}', [
            'id' => $this->primaryKey(),
            'abonement_id' => $this->integer()->comment("Абонемент"),
            'month' => $this->integer()->comment("Кол-во Месяцов"),
            'price_for_month' => $this->float()->comment("Цена в месяц"),
            'total_price' => $this->float()->comment("Стоимость"),
        ]);

        // creates index for column `abonement_id`
        $this->createIndex(
            '{{%idx-shops_abonement_period-abonement_id}}',
            '{{%shops_abonement_period}}',
            'abonement_id'
        );

        // add foreign key for table `{{%shops_abonements}}`
        $this->addForeignKey(
            '{{%fk-shops_abonement_period-abonement_id}}',
            '{{%shops_abonement_period}}',
            'abonement_id',
            '{{%shops_abonements}}',
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
            '{{%fk-shops_abonement_period-abonement_id}}',
            '{{%shops_abonement_period}}'
        );

        // drops index for column `abonement_id`
        $this->dropIndex(
            '{{%idx-shops_abonement_period-abonement_id}}',
            '{{%shops_abonement_period}}'
        );

        $this->dropTable('{{%shops_abonement_period}}');
    }
}
