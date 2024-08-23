<?php

use yii\db\Migration;

/**
 * Class m201109_064031_create_popular_for_value_in_seo
 */
class m201109_064031_create_popular_for_value_in_seo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \backend\models\seobase\SiteSettings::setPupular();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201109_064031_create_popular_for_value_in_seo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201109_064031_create_popular_for_value_in_seo cannot be reverted.\n";

        return false;
    }
    */
}
