<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%items}}`.
 */
class m201027_040134_add_is_publicated_telegram_column_to_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%items}}', 'is_publicated_telegram', $this->boolean()->comment('Публикации телеграммы канала'));

        Yii::$app->db->createCommand()->update('items', ['is_publicated_telegram' => true])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%items}}', 'is_publicated_telegram');
    }
}
