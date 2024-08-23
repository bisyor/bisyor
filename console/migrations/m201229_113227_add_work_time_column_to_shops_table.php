<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%shops}}`.
 */
class m201229_113227_add_work_time_column_to_shops_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops}}', 'work_time', $this->string(40));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shops}}', 'work_time');
    }
}
