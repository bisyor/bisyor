<?php

use yii\db\Migration;

/**
 * Class m201201_065003_create_seo_all_categories
 */
class m201201_065003_create_seo_all_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \backend\models\seobase\SiteSettings::setSeoCategoryAll();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m201201_065003_create_seo_all_categories cannot be reverted.\n";
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
        echo "m201201_065003_create_seo_all_categories cannot be reverted.\n";

        return false;
    }
    */
}
