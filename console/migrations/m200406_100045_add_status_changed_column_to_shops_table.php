<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%shops}}`.
 */
class m200406_100045_add_status_changed_column_to_shops_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops}}', 'status_changed', $this->datetime()->comment("Дата изменения статуса"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shops}}', 'status_changed');
    }
}
