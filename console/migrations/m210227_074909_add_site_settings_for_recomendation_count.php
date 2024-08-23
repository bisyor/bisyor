<?php

use yii\db\Migration;

/**
 * Class m210227_074909_add_site_settings_for_recomendation_count
 */
class m210227_074909_add_site_settings_for_recomendation_count extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('settings',array(
            'name' => "Количество рекомендаций",
            'value' => "25",
            'key' => "recommendation_count",
            'group' => 'system-settings',
            'type' => "integer",
        ));

        $this->insert('settings',array(
            'name' => "Количество категорий рекомендаций",
            'value' => "7",
            'key' => "recommendation_categories_count",
            'group' => 'system-settings',
            'type' => "integer",
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
        echo "m210227_074909_add_site_settings_for_recomendation_count cannot be reverted.\n";

        return false;
    }
    */
}
