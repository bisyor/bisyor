<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items_scale}}`.
 */
class m210205_045957_create_items_scale_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%items_scale}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
            'description' => $this->text()->comment("Описание"),
            'key' => $this->string(255)->comment("Ключ"),
            'status' => $this->integer()->comment("Статус"),
            'ball' => $this->float()->comment("Балл"),
            'minimum_value' => $this->string(255)->comment("Минимальная значение"),
        ]);


        $this->insert('items_scale',array(
            'name' => "Заголовок",
            'description' => "E'lonning sarlavhasi 70 ta harfdan ko'p bo'lsa 0.2 ball beriladi",
            'key' => "title",
            'status' => 1,
            'ball' => 0.2,
            'minimum_value' => "70",
        ));


        $this->insert('items_scale',array(
            'name' => "Качество картинки",
            'description' => "E'londagi img_m 15 kb dan ko'p bo'lsa 1 ball beriladi",
            'key' => "image_quality",
            'status' => 1,
            'ball' => 1,
            'minimum_value' => "15",
        ));


        $this->insert('items_scale',array(
            'name' => "Описание",
            'description' => "E'lonning matni 200 ta harfdan ko'p bo'lsa 1 ball beriladi",
            'key' => "description",
            'status' => 1,
            'ball' => 1,
            'minimum_value' => "200",
        ));


        $this->insert('items_scale',array(
            'name' => "Телефон номер",
            'description' => "E'longa telefon nomer kiritilgan bo'lsa 0.2 ball beriladi",
            'key' => "phone",
            'status' => 1,
            'ball' => 0.2,
            'minimum_value' => "1",
        ));

        $this->insert('items_scale',array(
            'name' => "Видео",
            'description' => "E'longa video havola joylagan bo'lsa 2 ball beriladi",
            'key' => "video",
            'status' => 1,
            'ball' => 2,
            'minimum_value' => "1",
        ));

        $this->insert('items_scale',array(
            'name' => "Количество картинки",
            'description' => "E'lonning rasmlari soni 5 ta yoki unda ko'p bo'lsa 2.6 ball beriladi",
            'key' => "image_count",
            'status' => 1,
            'ball' => 2.6,
            'minimum_value' => "5",
        ));


        $this->insert('items_scale',array(
            'name' => "Количество просмотров",
            'description' => "E'lonning ko'rishlari soni 200 tadan ko'p bolsa 2 ball beriladi",
            'key' => "view_count",
            'status' => 1,
            'ball' => 2,
            'minimum_value' => "200",
        ));

        $this->insert('items_scale',array(
            'name' => "Избранный",
            'description' => "E'lon 7 martadan ko'p sevimlilarga qo'shilgan bo'lsa 1 ball beriladi",
            'key' => "favorites",
            'status' => 1,
            'ball' => 1,
            'minimum_value' => "7",
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%items_scale}}');
    }
}
