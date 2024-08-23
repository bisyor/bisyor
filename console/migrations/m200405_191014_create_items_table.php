<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items}}`.
 */
class m200405_191014_create_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%items}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment('Пользователь'),
            'user_ip' => $this->string(255)->comment('Ip пользователя'),
            'shop_id' => $this->integer()->comment('Магазин'),
            'is_publicated' => $this->boolean()->comment('Опубликован или нет'),
            'is_moderating' => $this->boolean()->comment('Модерировань или нет'),
            'status' => $this->integer()->comment('Статус'),
            'status_prev' => $this->integer()->comment(' Предыдующие статус'),
            'status_changed' => $this->datetime()->comment("Дата изменения статуса"),
            'deleted' => $this->boolean()->comment('Удалено или нет'),
            'cat_id' => $this->integer()->comment('Категория'),
            'owner_type' => $this->integer()->comment('Тип пользователья'),
            'district_id' => $this->integer()->comment('Район'),
            'address' => $this->string(255)->comment('Адрес'),
            'svc_up_activate' => $this->tinyInteger(),
            'svc_up_date' => $this->dateTime(),
            'svc_up_free' => $this->date(),
            'svc_upauto_on' => $this->tinyInteger(),
            'svc_upauto_sett' => $this->text(),
            'svc_upauto_next' => $this->dateTime(),
            'svc_fixed' => $this->tinyInteger(),
            'svc_fixed_to' => $this->dateTime(),
            'svc_fixed_order' => $this->dateTime(),
            'svc_premium' => $this->tinyInteger(),
            'svc_premium_to' => $this->dateTime(),
            'svc_premium_order' => $this->dateTime(),
            'svc_marked_to' => $this->dateTime(),
            'svc_press_status' => $this->tinyInteger(),
            'svc_press_date' => $this->date(),
            'svc_press_date_last' => $this->date(),
            'svc_quick_to' => $this->dateTime(),
            'coordinate_x' => $this->string(255)->comment('Coordinate X'),
            'coordinate_y' => $this->string(255)->comment('Coordinate Y'),
            'title' => $this->string(255)->comment('Заголовок'),
            'keyword' => $this->string(255)->comment('keyword'),
            'link' => $this->string(255)->comment('Ссылка'),
            'description' => $this->text()->comment('Описание'),
            'lang' => $this->string(255)->comment('язык'),
            'img_s' => $this->string(255)->comment('Б картинка'),
            'img_m' => $this->string(255)->comment('M картинка'),
            'images' => $this->text()->comment('Все картинки'),
            'date_cr' => $this->dateTime()->comment('Дата создание'),
            'date_up' => $this->dateTime()->comment('Дата изменение'),
            'price' => $this->float()->comment('Цена'),
            'price_search' => $this->float()->comment('Цена'),
            'currency_id' => $this->integer()->comment('Валюта'),
            'name' => $this->string(255)->comment('Имя'),
            'phones' => $this->text()->comment('Телефон номеры'),
            'publicated' => $this->dateTime()->comment('Дата публикации'),
            'publicated_to' => $this->dateTime()->comment(''),
            'publicated_order' => $this->dateTime()->comment(''),
            'publicated_period' => $this->integer()->comment('Количество дней'),
            'moderated_id' => $this->integer()->comment(' Кто измениль'),
            'moderated_date' => $this->text()->comment(' Кто измениль'),
            'blocked_reason' => $this->text()->comment(' Кто измениль'),
            'f1' => $this->float()->defaultValue(0)->comment(' Допольнителные полей'),
            'f2' => $this->float()->defaultValue(0)->comment(' Допольнителные полей'),
            'f3' => $this->float()->defaultValue(0)->comment(' Допольнителные полей'),
            'f4' => $this->float()->defaultValue(0)->comment(' Допольнителные полей'),
            'f5' => $this->float()->defaultValue(0)->comment(' Допольнителные полей'),
            'f6' => $this->float()->defaultValue(0)->comment(' Допольнителные полей'),
            'f7' => $this->float()->defaultValue(0)->comment(' Допольнителные полей'),
            'f8' => $this->float()->defaultValue(0)->comment(' Допольнителные полей'),
            'f9' => $this->float()->defaultValue(0)->comment(' Допольнителные полей'),
            'f10' => $this->float()->defaultValue(0)->comment(' Допольнителные полей'),
            'f11' => $this->float()->defaultValue(0)->comment(' Допольнителные полей'),
            'f12' => $this->float()->defaultValue(0)->comment(' Допольнителные полей'),
            'f13' => $this->float()->defaultValue(0)->comment(' Допольнителные полей'),
            'f14' => $this->float()->defaultValue(0)->comment(' Допольнителные полей'),
            'f15' => $this->float()->defaultValue(0)->comment(' Допольнителные полей'),
            'f16' => $this->text()->comment(' Допольнителные полей'),
            'f17' => $this->text()->comment(' Допольнителные полей'),
            'f18' => $this->text()->comment(' Допольнителные полей'),
            'f19' => $this->text()->comment(' Допольнителные полей'),
            'f20' => $this->text()->comment(' Допольнителные полей'),
            'f21' => $this->text()->comment(' Допольнителные полей'),
            'f22' => $this->text()->comment(' Допольнителные полей'),
            'f23' => $this->text()->comment(' Допольнителные полей'),
            'f24' => $this->text()->comment(' Допольнителные полей'),
            'f25' => $this->text()->comment(' Допольнителные полей'),
            'img_prefix' => $this->string(255)->comment(' Vaqtinchalik polya'),
            'old_price' => $this->float(),
            'price_ex' => $this->tinyInteger(),
            'cat_type' => $this->tinyInteger(),
            'video' => $this->text()->comment('Video'),
            'video_embed' => $this->text(),
        ]);

        $this->createIndex(
            '{{%idx-items-price_search}}',
            '{{%items}}',
            'price_search'
        );
        $this->createIndex(
            '{{%idx-items-status}}',
            '{{%items}}',
            'status'
        );
        $this->createIndex(
            '{{%idx-items-keyword}}',
            '{{%items}}',
            'keyword'
        );
        $this->createIndex(
            '{{%idx-items-user_id}}',
            '{{%items}}',
            'user_id'
        );
        $this->addForeignKey(
            '{{%fk-items-user_id}}',
            '{{%items}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-items-shop_id}}',
            '{{%items}}',
            'shop_id'
        );
        $this->addForeignKey(
            '{{%fk-items-shop_id}}',
            '{{%items}}',
            'shop_id',
            '{{%shops}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-items-cat_id}}',
            '{{%items}}',
            'cat_id'
        );
        $this->addForeignKey(
            '{{%fk-items-cat_id}}',
            '{{%items}}',
            'cat_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-items-district_id}}',
            '{{%items}}',
            'district_id'
        );
        $this->addForeignKey(
            '{{%fk-items-district_id}}',
            '{{%items}}',
            'district_id',
            '{{%districts}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-items-currency_id}}',
            '{{%items}}',
            'currency_id'
        );
        $this->addForeignKey(
            '{{%fk-items-currency_id}}',
            '{{%items}}',
            'currency_id',
            '{{%currencies}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-items-moderated_id}}',
            '{{%items}}',
            'moderated_id'
        );
        $this->addForeignKey(
            '{{%fk-items-moderated_id}}',
            '{{%items}}',
            'moderated_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-items-is_moderating}}',
            '{{%items}}',
            'is_moderating'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-items-user_id}}',
            '{{%items}}'
        );

        $this->dropIndex(
            '{{%idx-items-user_id}}',
            '{{%items}}'
        );
        $this->dropIndex(
            '{{%idx-items-price_search}}',
            '{{%items}}'
        );
        $this->dropForeignKey(
            '{{%fk-items-shop_id}}',
            '{{%items}}'
        );

        $this->dropIndex(
            '{{%idx-items-shop_id}}',
            '{{%items}}'
        );
        $this->dropForeignKey(
            '{{%fk-items-cat_id}}',
            '{{%items}}'
        );

        $this->dropIndex(
            '{{%idx-items-cat_id}}',
            '{{%items}}'
        );
        $this->dropForeignKey(
            '{{%fk-items-district_id}}',
            '{{%items}}'
        );

        $this->dropIndex(
            '{{%idx-items-district_id}}',
            '{{%items}}'
        );
        $this->dropForeignKey(
            '{{%fk-items-currency_id}}',
            '{{%items}}'
        );

        $this->dropIndex(
            '{{%idx-items-currency_id}}',
            '{{%items}}'
        );
        $this->dropForeignKey(
            '{{%fk-items-moderated_id}}',
            '{{%items}}'
        );

        $this->dropIndex(
            '{{%idx-items-moderated_id}}',
            '{{%items}}'
        );
        $this->dropIndex(
            '{{%idx-items-is_moderating}}',
            '{{%items}}'
        );

        $this->dropTable('{{%items}}');
    }
}
