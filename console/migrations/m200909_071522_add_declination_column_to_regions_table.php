<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%regions}}`.
 */
class m200909_071522_add_declination_column_to_regions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%regions}}', 'declination', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%regions}}', 'declination');
    }
}
