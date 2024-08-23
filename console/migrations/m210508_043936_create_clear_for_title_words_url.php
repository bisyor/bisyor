<?php

use yii\db\Migration;

/**
 * Class m210508_043936_create_clear_for_title_words_url
 */
class m210508_043936_create_clear_for_title_words_url extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $items = \backend\models\items\Items::find()
                    ->andWhere(['like', 'title','(Domtexno.uz)'])
                    ->all();
        foreach ($items as $value) {
            $value->title = str_replace("(Domtexno.uz)" , "",$value->title);
            $value->save(false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210508_043936_create_clear_for_title_words_url cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210508_043936_create_clear_for_title_words_url cannot be reverted.\n";

        return false;
    }
    */
}
