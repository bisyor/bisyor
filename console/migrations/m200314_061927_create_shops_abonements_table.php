<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_abonements}}`.
 */
class m200314_061927_create_shops_abonements_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_abonements}}', [
            'id' => $this->primaryKey(),
            'enabled' => $this->boolean()->comment("Статус"),
            'title' => $this->string(255)->comment("Заголовок"),
            'is_free' => $this->boolean()->comment("Бесплатно"),
            'price_free_period' => $this->integer()->comment(""),
            'ads_count' => $this->integer()->comment("Количество объявлении"),
            'import' => $this->boolean()->comment("мпорт объявлении"),
            'mark' => $this->boolean()->comment("Выделение"),
            'fix' => $this->boolean()->comment("Закрепление"),
            'icon_b' => $this->string(255)->comment("Иконка (большая)"),
            'icon_s' => $this->string(255)->comment("Иконка (малая)"),
            'num' => $this->integer()->comment("Номер сортировки"),
            'one_time' => $this->boolean()->comment("Единоразовый"),
            'is_default' => $this->boolean()->comment("По умолчанию"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shops_abonements}}');
    }
}
