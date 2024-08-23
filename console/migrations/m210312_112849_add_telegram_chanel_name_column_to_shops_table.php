<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%shops}}`.
 */
class m210312_112849_add_telegram_chanel_name_column_to_shops_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops}}', 'telegram_channel', $this->string(255)->comment("название канала в телеграмме магазинов"));

        $this->addColumn('{{%items}}', 'is_publicated_shops_telegram', $this->boolean()->comment('Telegram канал магазинов'));

        Yii::$app->db->createCommand()->update('items', ['is_publicated_shops_telegram' => false])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shops}}', 'telegram_channel');
        $this->dropColumn('{{%items}}', 'is_publicated_shops_telegram');
    }
}
