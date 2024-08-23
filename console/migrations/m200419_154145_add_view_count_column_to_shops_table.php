<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%shops}}`.
 */
class m200419_154145_add_view_count_column_to_shops_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops}}', 'view_count', $this->integer()->comment("Кол-во просмотров"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shops}}', 'view_count');
    }
}
