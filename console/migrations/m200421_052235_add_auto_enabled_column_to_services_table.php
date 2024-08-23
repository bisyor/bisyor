<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%services}}`.
 */
class m200421_052235_add_auto_enabled_column_to_services_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%services}}', 'auto_enabled', $this->boolean()->comment("Автоподнятие"));
        $this->addColumn('{{%services}}', 'free_period', $this->integer()->comment("Бесплатное поднятие"));
        $this->addColumn('{{%services}}', 'add_form', $this->boolean()->comment("В форме добавления"));
        $this->addColumn('{{%services}}', 'period_type', $this->integer()->comment("Стоимость услуги")); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%services}}', 'auto_enabled');
        $this->dropColumn('{{%services}}', 'free_period');
        $this->dropColumn('{{%services}}', 'add_form');
        $this->dropColumn('{{%services}}', 'period_type');
    }
}
