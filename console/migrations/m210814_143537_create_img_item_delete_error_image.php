<?php

use yii\db\Migration;

/**
 * Class m210814_143537_create_img_item_delete_error_image
 */
class m210814_143537_create_img_item_delete_error_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $images = \backend\models\items\ItemsImages::find()->where(['like','extstor_img_o','www'])->all();
        foreach ($images as $value){
            $value->extstor_img_o = null;
            $value->save(false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210814_143537_create_img_item_delete_error_image cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210814_143537_create_img_item_delete_error_image cannot be reverted.\n";

        return false;
    }
    */
}
