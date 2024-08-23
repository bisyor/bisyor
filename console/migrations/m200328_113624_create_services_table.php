<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%services}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m200328_113624_create_services_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%services}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->comment("Тип"),
            'changed_id' => $this->integer()->comment("Кто изменил"),
            'keyword' => $this->string(255)->comment("Уникальный Клю"),
            'module' => $this->string(255)->comment("Модуль"),
            'module_title' => $this->string(255)->comment("Заголовок Модула"),
            'title' => $this->string(255)->comment("Заголовок"),
            'price' => $this->float()->comment("Стоимость"),
            'short_description' => $this->text()->comment("Короткое Описание"),
            'description' => $this->text()->comment("Описание"),
            'day' => $this->integer()->comment("Количество дней"),
            'sorting' => $this->integer()->comment("Сортировка"),
            'icon_b' => $this->string(255)->comment("Иконка (большая)"),
            'icon_s' => $this->string(255)->comment("Иконка (малая)"),
            'enabled' => $this->boolean()->comment("Статус"),
            'color' => $this->string(255)->comment("Цвет"),
            'date_cr' => $this->datetime()->comment("Дата создания"),
            'date_up' => $this->datetime()->comment("Дата изменение"),
        ]);


        // creates index for column `changed_id`
        $this->createIndex(
            '{{%idx-services-changed_id}}',
            '{{%services}}',
            'changed_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-services-changed_id}}',
            '{{%services}}',
            'changed_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        $values = [
            [
                1,1,'up','bbs','Объявления','Поднятие',855.0,
            ],
            [
                1,1,'quick','bbs','Объявления','Срочно',855.0,
            ],
            [
                1,1,'mark','bbs','Объявления','Выделение',855.0,
            ],
            [
                1,1,'fix','bbs','Объявления','Закрепление',855.0,
            ],
            [
                1,1,'premium','bbs','Объявления','Премиум Объявления',855.0,
            ],
            [
                1,1,'press','bbs','Объявления','Публикация в прессе',855.0,
            ],
            [
                2,1,'simple','bbs','Объявления','Обычная продажа',855.0,
            ],
            [
                2,1,'import','bbs','Объявления','Быстрая продажа',855.0,
            ],
            [
                2,1,'turbo','bbs','Объявления','Турбо продажа',855.0,
            ],
            [
                1,1,'fix_shop','shops','Магазины','Закрепление',855.0,
            ],
            [
                1,1,'mark_shop','shops','Магазины','Выделение',855.0,
            ]
        ];

        // foreach ($values as $key => $value) {
        //     $this->insert('{{%services}}',[
        //         'type'=>$value[0],
        //         'changed_id'=> $value[1],
        //         'keyword'=> $value[2],
        //         'module'=> $value[3],
        //         'icon_b' => ($value[0] == 2) ? 'paket_b.png' : $value[2].'_b.png',
        //         'icon_s' => ($value[0] == 2) ? 'paket_s.png' : $value[2].'_s.png',
        //         'module_title'=> $value[4],
        //         'title'=> $value[5],
        //         'price'=>$value[6],
        //         'enabled' => 0,
        //         'date_cr' => Yii::$app->formatter->asDate(time(),'php:Y-m-d H:i')
        //     ]);
        // }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-services-changed_id}}',
            '{{%services}}'
        );

        // drops index for column `changed_id`
        $this->dropIndex(
            '{{%idx-services-changed_id}}',
            '{{%services}}'
        );

        $this->dropTable('{{%services}}');
    }
}
