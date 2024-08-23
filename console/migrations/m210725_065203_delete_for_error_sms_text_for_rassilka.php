<?php

use yii\db\Migration;

/**
 * Class m210725_065203_delete_for_error_sms_text_for_rassilka
 */
class m210725_065203_delete_for_error_sms_text_for_rassilka extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \backend\models\mail\SendmailMassendUser::deleteAll(['or',
            ['text' => ''],
            ['text' => null]
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210725_065203_delete_for_error_sms_text_for_rassilka cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210725_065203_delete_for_error_sms_text_for_rassilka cannot be reverted.\n";

        return false;
    }
    */
}
