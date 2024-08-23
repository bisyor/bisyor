<?php

use yii\db\Migration;

/**
 * Class m201212_053003_add_categories_update_for_seo
 */
class m201212_053003_add_categories_update_for_seo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \backend\models\items\Categories::updateAll(['mtitle'=>null ,'mkeywords'=>null ,'mdescription'=>null,'breadcrumb'=>null,'titleh1'=>null, 'seotext'=>null]);

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
        echo "m201212_053003_add_categories_update_for_seo cannot be reverted.\n";

        return false;
    }
    */
}
