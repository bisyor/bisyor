<?php

use yii\db\Migration;

/**
 * Class m210322_092236_create_seo_value_for_favorites_items
 */
class m210322_092236_create_seo_value_for_favorites_items extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \backend\models\seobase\Items::setSeoForFavoritesAds();
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
        echo "m210322_092236_create_seo_value_for_favorites_items cannot be reverted.\n";

        return false;
    }
    */
}
