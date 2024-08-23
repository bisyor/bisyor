<?php

use yii\db\Migration;

/**
 * Class m210330_113026_add_old_title_and_old_description_to_items_table
 */
class m210330_113026_add_old_title_and_old_description_to_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%items}}', 'old_title', $this->string(255)->comment("Старое название"));

        $this->addColumn('{{%items}}', 'old_description', $this->text()->comment('Старое описание'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%items}}', 'old_title');
        $this->dropColumn('{{%items}}', 'old_description');
    }
}
