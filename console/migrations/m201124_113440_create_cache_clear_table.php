<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cache_clear}}`.
 */
class m201124_113440_create_cache_clear_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cache_clear}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment('Наимование'),
            'minutes' => $this->integer()->comment('Минут'),
            'key' => $this->string(255)->comment('Ключ'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cache_clear}}');
    }
}
