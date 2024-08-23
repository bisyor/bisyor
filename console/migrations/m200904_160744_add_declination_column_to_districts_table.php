<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%districts}}`.
 */
class m200904_160744_add_declination_column_to_districts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%districts}}', 'declination', $this->string(255)->comment('Склонение (где)'));
        $this->addColumn('{{%districts}}', 'coordinate_x', $this->string(255)->comment('Кордината х'));
        $this->addColumn('{{%districts}}', 'coordinate_y', $this->string(255)->comment('Кордината у'));
        $this->addColumn('{{%districts}}', 'metro', $this->boolean()->comment('Есть метро'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%districts}}', 'declination');
        $this->dropColumn('{{%districts}}', 'coordinate_x');
        $this->dropColumn('{{%districts}}', 'coordinate_y');
        $this->dropColumn('{{%districts}}', 'metro');
    }
}
