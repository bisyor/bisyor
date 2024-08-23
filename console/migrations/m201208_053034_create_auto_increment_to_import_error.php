<?php

use yii\db\Migration;

/**
 * Class m201208_053034_create_auto_increment_to_import_error
 */
class m201208_053034_create_auto_increment_to_import_error extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand("SELECT setval('shop_categories_id_seq', (SELECT MAX(id) FROM shop_categories));")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m201208_053034_create_auto_increment_to_import_error cannot be reverted.\n";
//
//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201208_053034_create_auto_increment_to_import_error cannot be reverted.\n";

        return false;
    }
    */
}
