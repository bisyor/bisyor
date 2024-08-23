<?php

use yii\db\Migration;

/**
 * Class m210313_101714_create_last_item_count_in_new_items_for_settings
 */
class m210313_101714_create_last_item_count_in_new_items_for_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('settings',array(
            'name' => "Количество последних товаров в новых товарах",
            'value' => 10,
            'key' => "last_item_count_in_new_items",
            'group' => 'system-settings',
            'type' => "float",
        ));
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
        echo "m210313_101714_create_last_item_count_in_new_items_for_settings cannot be reverted.\n";

        return false;
    }
    */
}
