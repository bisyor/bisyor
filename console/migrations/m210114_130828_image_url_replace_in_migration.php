<?php

use yii\db\Migration;

/**
 * Class m210114_130828_image_url_replace_in_migration
 */
class m210114_130828_image_url_replace_in_migration extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $datas = \backend\models\blogs\BlogPosts::find()->all();
        foreach ($datas as $val){
            $val->text = str_replace("http://img.coding-style.uz", "https://img.bisyor.uz", $val->text);
            $val->save(false);
        }
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
        echo "m210114_130828_image_url_replace_in_migration cannot be reverted.\n";

        return false;
    }
    */
}
