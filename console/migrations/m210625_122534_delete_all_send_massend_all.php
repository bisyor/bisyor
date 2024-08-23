<?php

use yii\db\Migration;

/**
 * Class m210625_122534_delete_all_send_massend_all
 */
class m210625_122534_delete_all_send_massend_all extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \backend\models\mail\SendmailMassendUser::deleteAll();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210625_122534_delete_all_send_massend_all cannot be reverted.\n";

        return false;
    }
    */
}
