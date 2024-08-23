<?php

use yii\db\Migration;

/**
 * Class m210331_063239_create_index_for_item_views
 */
class m210331_063239_create_index_for_item_views extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-items_views_period',
            'items_views',
            ['period'],
        );

        $this->createIndex(
            'idx-items_views_period_contact_views',
            'items_views',
            ['period','contacts_views'],
        );


        $this->createIndex(
            'idx-items_date_cr_index',
            'items',
            ['date_cr'],
        );
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
        echo "m210331_063239_create_index_for_item_views cannot be reverted.\n";

        return false;
    }
    */
}
