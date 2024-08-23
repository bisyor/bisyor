<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%regional_prices}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%services}}`
 */
class m200328_114111_create_regional_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%regional_prices}}', [
            'id' => $this->primaryKey(),
            'service_id' => $this->integer()->comment("Сервис"),
            'price' => $this->float()->comment("Цена"),
            'regions' => $this->text()->comment("Выбранные регионы"),
            'sections' => $this->text()->comment("Выбранные разделы"),
        ]);

        // creates index for column `service_id`
        $this->createIndex(
            '{{%idx-regional_prices-service_id}}',
            '{{%regional_prices}}',
            'service_id'
        );

        // add foreign key for table `{{%services}}`
        $this->addForeignKey(
            '{{%fk-regional_prices-service_id}}',
            '{{%regional_prices}}',
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
        // drops foreign key for table `{{%services}}`
        $this->dropForeignKey(
            '{{%fk-regional_prices-service_id}}',
            '{{%regional_prices}}'
        );

        // drops index for column `service_id`
        $this->dropIndex(
            '{{%idx-regional_prices-service_id}}',
            '{{%regional_prices}}'
        );

        $this->dropTable('{{%regional_prices}}');
    }
}
