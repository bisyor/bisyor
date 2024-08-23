<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%users}}`.
 */
class m210331_072623_add_verifiy_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	$this->addColumn('{{%shops}}', 'is_verify', $this->boolean()->comment("Признак надежности"));
    	$this->addColumn('{{%users}}', 'is_verify', $this->boolean()->comment("Признак надежности"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    	 $this->dropColumn('{{%shops}}', 'is_verify');
    	 $this->dropColumn('{{%users}}', 'is_verify');
    }
}
