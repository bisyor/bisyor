<?php

use yii\db\Migration;

/**
 * Class m210621_090936_olx_chamge_text_for_text
 */
class m210621_090936_olx_chamge_text_for_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $text_1 = "909 - показать телефон -";
        $text_2 = "900 - показать телефон -";
        $text_3 = "на OLX";
        $text_4 = "olx.uz";

        $items = \backend\models\items\Items::find()
            ->orWhere(['like' , 'title' , $text_1])
            ->orWhere(['like' , 'description' , $text_1])

            ->orWhere(['like' , 'title' , $text_2])
            ->orWhere(['like' , 'description' , $text_2])

            ->orWhere(['like' , 'title' , $text_3])
            ->orWhere(  ['like' , 'description' , $text_3])

            ->orWhere(['like' , 'title' , $text_4])
            ->orWhere(['like' , 'description' , $text_4])
            ->all();

        foreach ($items as $value){
            $value->title = str_replace($text_1 , "" , $value->title);
            $value->description = str_replace($text_1 , "" , $value->description);

            $value->title = str_replace($text_2 , "" , $value->title);
            $value->description = str_replace($text_2 , "" , $value->description);

            $value->title = str_replace($text_3 , "" , $value->title);
            $value->description = str_replace($text_3 , "" , $value->description);

            $value->title = str_replace($text_4 , "" , $value->title);
            $value->description = str_replace($text_4 , "" , $value->description);

            $value->save(false);
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
        echo "m210621_090936_olx_chamge_text_for_text cannot be reverted.\n";

        return false;
    }
    */
}
