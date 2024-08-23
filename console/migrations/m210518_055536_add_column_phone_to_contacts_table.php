<?php

use yii\db\Migration;

/**
 * Class m210518_055536_add_column_phone_to_contacts_table
 */
class m210518_055536_add_column_phone_to_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contacts}}', 'phone', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210518_055536_add_column_phone_to_contacts_table cannot be reverted.\n";

        return false;
    }
}
