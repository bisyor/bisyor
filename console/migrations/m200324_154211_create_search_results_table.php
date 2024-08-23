<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%search_results}}`.
 */
class m200324_154211_create_search_results_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%search_results}}', [
            'id' => $this->primaryKey(),
            'pid' => $this->integer(),
            'region_id' => $this->integer(),
            'query' => $this->string(255)->comment("Поисковые запросы"),
            'counter' => $this->integer()->comment("Всего"),
            'hits' => $this->integer()->comment("Успешные"),
            'last_time' => $this->datetime()->comment("Последний поиск"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%search_results}}');
    }
}
