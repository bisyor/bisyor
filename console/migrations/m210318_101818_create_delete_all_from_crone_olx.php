<?php

use yii\db\Migration;

/**
 * Class m210318_101818_create_delete_all_from_crone_olx
 */
class m210318_101818_create_delete_all_from_crone_olx extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \backend\models\references\CroneOlx::deleteAll([]);
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
        echo "m210318_101818_create_delete_all_from_crone_olx cannot be reverted.\n";

        return false;
    }
    */
}
