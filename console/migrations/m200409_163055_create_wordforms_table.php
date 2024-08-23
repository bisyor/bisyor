<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%wordforms}}`.
 */
class m200409_163055_create_wordforms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%wordforms}}', [
            'id' => $this->primaryKey(),
            'sinonim' => $this->string(255)->comment("Синоним"),
            'original' => $this->string(255)->comment("Оригинал"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%wordforms}}');
    }
}
