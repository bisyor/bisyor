<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%helps}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%helps_categories}}`
 */
class m200321_122647_create_helps_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%helps}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
            'helps_categories_id' => $this->integer(255)->comment("Категория"),
            'sorting' => $this->integer()->comment("Сортировка"),
            'text' => $this->text()->comment("Текст"),
            'usefull_count' => $this->integer()->comment("Полезно"),
            'nousefull_count' => $this->integer()->comment("Неполезно"),
        ]);

        $this->insert('helps',array(
            'name' => 'Как подать объявление', 
            'sorting' => '1',
            'helps_categories_id' => 1,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Как отредактировать объявление', 
            'sorting' => '2',
            'helps_categories_id' => 1,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Чем различаются отклонение и блокировка', 
            'sorting' => '3',
            'helps_categories_id' => 1,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Как зарегистроваться юридическому лицу', 
            'sorting' => '4',
            'helps_categories_id' => 2,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
         $this->insert('helps',array(
            'name' => 'Изменить реквизиты при реорганизации', 
            'sorting' => '5',
            'helps_categories_id' => 2,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Подключить тариф', 
            'sorting' => '6',
            'helps_categories_id' => 2,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Премиум-размещение', 
            'sorting' => '7',
            'helps_categories_id' => 3,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Поднятие в поиске', 
            'sorting' => '8',
            'helps_categories_id' => 3,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'На сайте что-то не работает', 
            'sorting' => '9',
            'helps_categories_id' => 4,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Не работает приложение', 
            'sorting' => '10',
            'helps_categories_id' => 4,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Очистить кеш и удалить куки в браузере', 
            'sorting' => '11',
            'helps_categories_id' => 4,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Общие рекомендации по безопасности', 
            'sorting' => '12',
            'helps_categories_id' => 6,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Как выглядит писмо от Bisyor', 
            'sorting' => '13',
            'helps_categories_id' => 6,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Популярные способы мошенничества', 
            'sorting' => '14',
            'helps_categories_id' => 6,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Восстановить пароль', 
            'sorting' => '15',
            'helps_categories_id' => 7,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Не вижу свой отзыв в профиле продавца', 
            'sorting' => '16',
            'helps_categories_id' => 7,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Изменить электронную почту', 
            'sorting' => '17',
            'helps_categories_id' => 7,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
         $this->insert('helps',array(
            'name' => 'Не откываются сообщения', 
            'sorting' => '18',
            'helps_categories_id' => 7,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Что такое кошелек на Bisyor', 
            'sorting' => '19',
            'helps_categories_id' => 8,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Денги за смс списались но услуга не', 
            'sorting' => '20',
            'helps_categories_id' => 8,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Применилась.Что делать?', 
            'sorting' => '21',
            'helps_categories_id' => 8,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Оплатить услугу через Xalq Bank Онлайн', 
            'sorting' => '22',
            'helps_categories_id' => 8,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'На сайте что-то не работает', 
            'sorting' => '23',
            'helps_categories_id' => 9,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Не работает приложение', 
            'sorting' => '24',
            'helps_categories_id' => 9,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));
        $this->insert('helps',array(
            'name' => 'Очистить кеш и удалить куки в браузере', 
            'sorting' => '25',
            'helps_categories_id' => 9,
            'text' => 'Текст',
            'usefull_count' => 0,
            'nousefull_count' => 0,
        ));

        // creates index for column `helps_categories_id`
        $this->createIndex(
            '{{%idx-helps-helps_categories_id}}',
            '{{%helps}}',
            'helps_categories_id'
        );

        // add foreign key for table `{{%helps_categories}}`
        $this->addForeignKey(
            '{{%fk-helps-helps_categories_id}}',
            '{{%helps}}',
            'helps_categories_id',
            '{{%helps_categories}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%helps_categories}}`
        $this->dropForeignKey(
            '{{%fk-helps-helps_categories_id}}',
            '{{%helps}}'
        );

        // drops index for column `helps_categories_id`
        $this->dropIndex(
            '{{%idx-helps-helps_categories_id}}',
            '{{%helps}}'
        );

        $this->dropTable('{{%helps}}');
    }
}
