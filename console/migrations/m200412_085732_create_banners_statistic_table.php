<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%banners_statistic}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%banners}}`
 */
class m200412_085732_create_banners_statistic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banners_statistic}}', [
            'id' => $this->primaryKey(),
            'banner_id' => $this->integer()->comment("Рекламный баннер"),
            'date' => $this->date()->comment("Дата"),
            'clicks' => $this->integer()->comment("Количество кликов"),
            'shows' => $this->integer()->comment("Количество просмотров"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%banners_statistic}}');
    }
}
