<?php

use yii\db\Migration;

/**
 * Class m210225_051806_delete_redundant_data_from_the_database_from_multi_dymprop_column
 */
class m210225_051806_delete_redundant_data_from_the_database_from_multi_dymprop_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \backend\models\items\CategoriesDynpropsMulti::deleteAll(['like','name','Выбрать']);
        \backend\models\items\CategoriesDynpropsMulti::deleteAll(['like','name','Выберите']);
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
        echo "m210225_051806_delete_redundant_data_from_the_database_from_multi_dymprop_column cannot be reverted.\n";

        return false;
    }
    */
}
