<?php

use yii\db\Migration;

/**
 * Class m210226_114440_add_user_olx_link_field
 */
class m210226_114440_add_user_olx_link_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'olx_link', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210226_114440_add_user_olx_link_field cannot be reverted.\n";

        return false;
    }

}
