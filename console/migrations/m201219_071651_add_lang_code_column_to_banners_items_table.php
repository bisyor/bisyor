<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%banners_items}}`.
 */
class m201219_071651_add_lang_code_column_to_banners_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%banners_items}}', 'lang_code', $this->string(10));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%banners_items}}', 'lang_code');
    }
}
