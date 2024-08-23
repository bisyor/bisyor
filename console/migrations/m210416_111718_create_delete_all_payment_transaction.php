<?php

use yii\db\Migration;

/**
 * Class m210416_111718_create_delete_all_payment_transaction
 */
class m210416_111718_create_delete_all_payment_transaction extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \Yii::$app
            ->db
            ->createCommand()
            ->delete('payment_transactions')
            ->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210416_111718_create_delete_all_payment_transaction cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210416_111718_create_delete_all_payment_transaction cannot be reverted.\n";

        return false;
    }
    */
}
