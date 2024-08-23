<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%promocodes_statistics}}`.
 */
class m200430_063917_create_promocodes_statistics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%promocodes_statistics}}', [
            'id' => $this->primaryKey(),
            'prmocode_id' => $this->integer()->comment('Промокод'),
            'active_from' => $this->dateTime()->comment('Дата активации'),
            'active_to' => $this->dateTime()->comment('Дата окончание'),
            'used' => $this->integer()->comment(' Кол-во использовании')
        ]);

        $this->createIndex(
            '{{%idx-promocodes_statistics-prmocode_id}}',
            '{{%promocodes_statistics}}',
            'prmocode_id'
        );

        // add foreign key for table `{{%promocodes}}`
        $this->addForeignKey(
            '{{%fk-promocodes_statistics-prmocode_id}}',
            '{{%promocodes_statistics}}',
            'prmocode_id',
            '{{%promocodes}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%promocodes}}`
        $this->dropForeignKey(
            '{{%fk-promocodes_statistics-prmocode_id}}',
            '{{%promocodes_statistics}}'
        );

        // drops index for column `prmocode_id`
        $this->dropIndex(
            '{{%idx-promocodes_statistics-prmocode_id}}',
            '{{%promocodes_statistics}}'
        );
        $this->dropTable('{{%promocodes_statistics}}');
    }
}
