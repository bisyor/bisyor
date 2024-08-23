<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%click_transactions}}`.
 */
class m200810_050906_create_click_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%click_transactions}}', [
            'id' => $this->primaryKey(),
            'bill_id' => $this->integer(),
            'click_trans_id' => $this->integer(),
            'amount' => $this->float(),
            'click_paydoc_id' => $this->integer(),
            'service_id' => $this->integer(),
            'sign_time' => $this->string(63),
            'status' => $this->integer(),
            'create_time' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%click_transactions}}');
    }
}
