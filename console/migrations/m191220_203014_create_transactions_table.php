<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transactions}}`.
 */
class m191220_203014_create_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transactions}}', [
            'id' => $this->primaryKey(),
            'paycom_transaction_id' => $this->string(255),
            'param_id' => $this->string(255),
            'order_id' => $this->integer(),
            'paycom_time' => $this->string(255),
            'paycom_time_datetime' => $this->datetime(),
            'create_time' => $this->datetime(),
            'perform_time' => $this->string(255),
            'cancel_time' => $this->string(255),
            'amount' => $this->integer(),
            'state' => $this->integer(),
            'reason' => $this->integer(),
            'receivers' => $this->string(255),
            'transaction_created' => $this->string(50),
            'transaction_canceled' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transactions}}');
    }
}
