<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bot_users}}`.
 */
class m200624_093547_create_bot_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bot_users}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'is_bot' => $this->boolean(),
            'telegram_user_id' => $this->string(255),
            'username' => $this->string(255),
            'first_name' => $this->string(255),
            'last_name' => $this->string(255),
            'lang_code' => $this->string(255),
            'date_cr' => $this->date(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bot_users}}');
    }
}
