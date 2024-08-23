<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%alerts}}`.
 */
class m200613_113044_add_subscription_column_to_alerts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%alerts}}', 'subscription', $this->string(255));
        $this->addColumn('{{%alerts}}', 'extra', $this->text());

        $alerts = [
            //type = 'item'
            //1
            [
                'key' => 'bbs_item_activate',
                'email' => 1,
                'sms' => 0,
                'title' => 'Активация объявления',
                'text' => 'Ув. {name}!

                            Для активации объявления перейдите по ссылке:
                            <a href="{activate_link}">{activate_link}</a>',
                'key' => 'bbs_item_activate',
                'key_title' => 'Объявления: активация объявления',
                'key_text' => 'Уведомление, отправляемое незарегистрированному пользователю после добавления объявления',
                'type' => 'item',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{activate_link}',
                        'title' => 'Ссылка активации объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ],
            ],
            //2
            [
                'key' => 'plugin_bbs_item_callback',
                'email' => 1,
                'sms' => 0,
                'title' => '',
                'text' => '',
                'key_title' => 'Объявления: запрос на обратный звонок',
                'key_text' => 'Уведомление, отправляемое автору объявления с просьбой перезвонить на указанный номер',
                'type' => 'item',
                'subscription' => 'Получать уведомления о новых сообщениях',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_id}',
                        'title' => 'ID объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_title}',
                        'title' => 'Заголовок объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_link}',
                        'title' => 'Ссылка на объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{link}',
                        'title' => 'Ссылка на сообщение',
                        'hint' =>''
                    ],
                    [
                        'link' => '{callback_name}',
                        'title' => 'Имя автора запроса',
                        'hint' =>''
                    ],
                    [
                        'link' => '{callback_phone}',
                        'title' => 'Номер телефона',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ],
            ],
            //3
            [
                'key' => 'bbs_item_sendfriend',
                'email' => 1,
                'sms' => 0,
                'title' => 'Интересное объявление!',
                'text' => 'Вот ссылка:
                            <a href="{item_link}">{item_title}</a>',
                'key_title' => 'Объявления: отправить другу',
                'key_text' => 'Уведомление, отправляемое по указенному email адресу',
                'type' => 'item',
                'subscription' => '',
                'extra' => [
                    [
                        'link' => '{item_id}',
                        'title' => 'ID объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_title}',
                        'title' => 'Заголовок объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_link}',
                        'title' => 'Ссылка на объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ],
            ],
            //4
            [
                'key' => 'plugin_bbs_item_price_suggest',
                'email' => 1,
                'sms' => 0,
                'title' => '',
                'text' => '',
                'key_title' => 'Объявления: предложение покупателем своей цены',
                'key_text' => 'Уведомление, отправляемое автору объявления с предложенной ценой от покупателя',
                'type' => 'item',
                'subscription' => 'Получать уведомления о новых сообщениях',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_id}',
                        'title' => 'ID объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_title}',
                        'title' => 'Заголовок объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_link}',
                        'title' => 'Ссылка на объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{link}',
                        'title' => 'Ссылка на сообщение',
                        'hint' =>''
                    ],
                    [
                        'link' => '{price}',
                        'title' => 'Предлагаема цена',
                        'hint' =>''
                    ],
                    [
                        'link' => '{phone_number}',
                        'title' => 'Номер телефона',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ],
            ],
            //5
            [
                'key' => 'bbs_item_deleted',
                'email' => 1,
                'sms' => 0,
                'title' => 'Объявления {item_id} удалено модератером',
                'text' => 'Ваше a< href="{item_link}"> объявления №  {item_id} </a> было удалено модератером',
                'key_title' => 'Объявления: удаление объявления',
                'key_text' => 'Уведомление, отправляемое пользователю в случае удаления объявления модератером',
                'type' => 'item',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_id}',
                        'title' => 'ID объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_title}',
                        'title' => 'Заголовок объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_link}',
                        'title' => 'Ссылка на объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ],
            ],
            //6
            [
                'key' => 'bbs_item_photo_deleted',
                'email' => 1,
                'sms' => 0,
                'title' => 'Фотография объявления {item_id} удалено модератером',
                'text' => 'Фотография a< href="{item_link}"> объявления №  {item_id} </a> было удалено модератером',
                'key_title' => 'Объявления: удаления фотографии объявления',
                'key_text' => 'Уведомление, отправляемое пользователю в случае удаления фотографии объявления модератером',
                'type' => 'item',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_id}',
                        'title' => 'ID объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_title}',
                        'title' => 'Заголовок объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_link}',
                        'title' => 'Ссылка на объявления',
                        'hint' =>''
                    ],
                    
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ],
            ],
            //7
            [
                'key' => 'bbs_item_blocked',
                'email' => 1,
                'sms' => 0,
                'title' => 'Ваше объявление № {item_id} заблокировано',
                'text' => 'Ваше a< href="{item_link}"> объявления №  {item_id} </a> было заблокировано модератером по причине:
                <b> {blocked_reason} </b>',
                'key_title' => 'Объявления: блокировка объявления',
                'key_text' => 'Уведомление, отправляемое пользователю в случае блокировки объявления модератером',
                'type' => 'item',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_id}',
                        'title' => 'ID объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_title}',
                        'title' => 'Заголовок объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_link}',
                        'title' => 'Ссылка на объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{blocked_reason}',
                        'title' => 'Причина блокировки',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ],
            ],
            //8
            [
                'key' => 'bbs_item_unpublicated_soon',
                'email' => 1,
                'sms' => 0,
                'title' => 'Заканчивается срок публикации вашего объявления № {item_id}',
                'text' => 'Через <strong>{days_in}</strong> заканчивается срок публикации вашего объявления <a href="{item_link}">{item_title}</a> , вы можете продлить его в своем кабинете.

                <a href="{publicate_link}">Опубликовать</a>
                ',
                'key_title' => 'Объявления: уведомление о завершении публикации одного объявления',
                'key_text' => 'Уведомление, отправляемое пользователю с оповещением о завершении его объявления',
                'type' => 'item',
                'subscription' => 'Получать рассылку о новостях Bisyor.uz',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_id}',
                        'title' => 'ID объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_title}',
                        'title' => 'Заголовок объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_link}',
                        'title' => 'Ссылка на объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{days_in}',
                        'title' => 'Кол-во дней до завершения публикации',
                        'hint' =>''
                    ],
                    [
                        'link' => '{publicate_link}',
                        'title' => 'Ссылка продления публикации',
                        'hint' =>''
                    ],
                    [
                        'link' => '{edit_link}',
                        'title' => 'Ссылка редактирования объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{svc_up}',
                        'title' => 'Ссылка "поднять"',
                        'hint' =>''
                    ],
                    [
                        'link' => '{svc_quick}',
                        'title' => 'Ссылка "сделать срочным"',
                        'hint' =>''
                    ],
                    [
                        'link' => '{svc_fix}',
                        'title' => 'Ссылка "закрепить"',
                        'hint' =>''
                    ],
                    [
                        'link' => '{svc_mark}',
                        'title' => 'Ссылка "выделить"',
                        'hint' =>''
                    ],
                    [
                        'link' => '{svc_press}',
                        'title' => 'Ссылка "печать в прессе"',
                        'hint' =>''
                    ],
                    [
                        'link' => '{svc_premium}',
                        'title' => 'Ссылка "премиум"',
                        'hint' =>''
                    ],
                    [
                        'link' => '{pack_simple}',
                        'title' => 'Ссылка пакета "Обычная продажа"',
                        'hint' =>''
                    ],
                    [
                        'link' => '{pack_import}',
                        'title' => 'Ссылка пакета "Быстрая продажа"',
                        'hint' =>''
                    ],
                    [
                        'link' => '{pack_turbo}',
                        'title' => 'Ссылка пакета "Турбо продажа"',
                        'hint' =>''
                    ],

                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ],
            ],
            //9
            [
                'key' => 'bbs_item_unpublicated_soon_group',
                'email' => 1,
                'sms' => 0,
                'title' => 'Заканчивается срок публикации ваших объявлений',
                'text' => 'Через <strong>{days_in}</strong> заканчивается срок публикации{count_items}. Вы можете <a href="{publicate_link}"> продлить их в своем кабинете.</a>',
                'key_title' => 'Объявления: уведомление о завершении публикации нескольких объявлений',
                'key_text' => 'Уведомление, отправляемое пользователю с оповещением о завершении его объявлений',
                'type' => 'item',
                'subscription' => 'Получать рассылку о новостях Bisyor.uz',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{count}',
                        'title' => 'Кол-во объявлений',
                        'hint' =>'например - 10'
                    ],
                    [
                        'link' => '{count_items}',
                        'title' => 'Кол-во объявлений',
                        'hint' =>'например - 10 объявлений'
                    ],
                    
                    [
                        'link' => '{days_in}',
                        'title' => 'Кол-во дней до завершения публикации',
                        'hint' =>''
                    ],
                    [
                        'link' => '{publicate_link}',
                        'title' => 'Ссылка продления публикации',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ],
            ],
            //10
            [
                'key' => 'bbs_item_upfree',
                'email' => 1,
                'sms' => 0,
                'title' => 'Доступно бесплатное поднятия для вашего объявления',
                'text' => 'Добрый день, {name} !
                    Для вашего объявления <a href="{item_link}"</a> доступно бесплатное поднятия. Поднять объявление вы можете перейдя по следующей <a href="{item_link_up}">ссылке</a>
                ',
                'key_title' => 'Объявления: уведомление о возможности бесплатного поднятия объявления',
                'key_text' => 'Уведомление, отправляемое пользователю в случае доступности  бесплатного поднятия его объявления',
                'type' => 'item',
                'subscription' => 'Получать рассылку о новостях Bisyor.uz',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_id}',
                        'title' => 'ID объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_title}',
                        'title' => 'Заголовок объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_link}',
                        'title' => 'Ссылка на объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_link_up}',
                        'title' => 'Ссылка бесплатного поднятия объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ],
            ],
            //11
            [
                'key' => 'bbs_item_upfree_group',
                'email' => 1,
                'sms' => 0,
                'title' => 'Доступно бесплатное поднятия для вашего объявления',
                'text' => 'Добрый день, {name} !
                    Для {count} ваших объявления доступно бесплатное поднятия. Поднять объявление вы можете перейдя по следующей <a href="{items_link_up}">ссылке</a>
                ',
                'key_title' => 'Объявления: уведомление о возможности бесплатного поднятия нескольких объявлений',
                'key_text' => 'Уведомление, отправляемое пользователю в случае доступности  бесплатного поднятия нескольких его объявлений',
                'type' => 'item',
                'subscription' => 'Получать рассылку о новостях Bisyor.uz',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{count}',
                        'title' => 'Кол-во объявлений',
                        'hint' =>'например - 10'
                    ],
                    [
                        'link' => '{count_items}',
                        'title' => 'Кол-во объявлений',
                        'hint' =>'например - 10 объявлений'
                    ],
                    [
                        'link' => '{items_link_up}',
                        'title' => 'Ссылка бесплатного поднятия объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ],
            ],
            //12
            [
                'key' => 'bbs_item_price_drop_one',
                'email' => 1,
                'sms' => 0,
                'title' => '',
                'text' => '',
                'key_title' => 'Объявления: снижение цены',
                'key_text' => 'Уведомление, отправляемое пользователю в случае снижение цены в одном объявлении',
                'type' => 'item',
                'subscription' => 'Получать уведомления об изменении цены в избранных объявлениях',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_id}',
                        'title' => 'ID объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_title}',
                        'title' => 'Заголовок объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{item_link}',
                        'title' => 'Ссылка на объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{price_old}',
                        'title' => 'Предыдущая цена',
                        'hint' =>''
                    ],
                    [
                        'link' => '{price_new}',
                        'title' => 'Текущая цена',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ],
            ],
            //13
            [
                'key' => 'bbs_item_price_drop_many',
                'email' => 1,
                'sms' => 0,
                'title' => '',
                'text' => '',
                'key_title' => 'Объявления: снижение цены в нескольких объявлениях',
                'key_text' => 'Уведомление, отправляемое пользователю в случае снижение цены в нескольких объявлениях',
                'type' => 'item',
                'subscription' => 'Получать уведомления об изменении цены в избранных объявлениях',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{items_link}',
                        'title' => 'Ссылка на объявления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ],
            ],
            //type = 'shop'
            //1
            [
                'key' => 'shops_shop_sendfriend',
                'email' => 1,
                'sms' => 0,
                'title' => 'Интересный магазин!',
                'text' => 'Вот ссылка:
                            <a href="{shop_link}">{shop_link}</a>',
                'key_title' => 'Магазины: отправить другу',
                'key_text' => 'Уведомление, отправляемое по указенному email адресу',
                'type' => 'shop',
                'subscription' => '',
                'extra' => [
                    [
                        'link' => '{shop_title}',
                        'title' => 'Название магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{shop_link}',
                        'title' => 'Ссылка на страницу магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //2
            [
                'key' => 'shops_open_success',
                'email' => 1,
                'sms' => 0,
                'title' => 'Ваш Магазин на {site.host} был активирован!',
                'text' => 'Поздравляем!
                Тепер добавлятть новые объявления Вы можете как "Частное лицо" или как как "Магазин".
                Также Вы можете перенести добавленные ранее объявления в свой Магазин, для чего врежиме редактирования объявления выберите кнопку Магазин, Все объявления Вашего Магазина будут размещены в общей ленте объявлений, а также собраны на странице Вашего Магазина с контактами, логотипом, ссылками на сайт и страницы в социалных сетях.
                Успешных продаж!
                ',
                'key_title' => 'Магазины: уведомления об активации магазина',
                'key_text' => 'Уведомление, отправляемое с оповещением об успешном отрытии магазина (после проверки модератором)',
                'type' => 'shop',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{shop_id}',
                        'title' => 'ID магазина',
                        'hint' =>''
                    ],
                    [
                        'link' => '{shop_title}',
                        'title' => 'Название магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{shop_link}',
                        'title' => 'Ссылка на страницу магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //3
            [
                'key' => 'shops_abonement_activated',
                'email' => 1,
                'sms' => 0,
                'title' => 'Был активирован тариф "{tariff_title}" для магазина "{shop_title}"',
                'text' => 'Вы активировали тариф "{tariff_title}" для магазина "{shop_title}". Срок действия тарифа актуален {tariff_expire}',
                'key_title' => 'Магазины: уведомления об активации тарифа',
                'key_text' => 'Тариф был активирован (в момент первой активации либо продления)',
                'type' => 'shop',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{shop_id}',
                        'title' => 'ID магазина',
                        'hint' =>''
                    ],
                    [
                        'link' => '{shop_title}',
                        'title' => 'Название магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{shop_link}',
                        'title' => 'Ссылка на страницу магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{tariff_title}',
                        'title' => 'Название тарифа',
                        'hint' => '',
                    ],
                    [
                        'link' => '{tariff_expire}',
                        'title' => 'Окончания действия тарифа',
                        'hint' => 'до ДАТА или бессрочно',
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //4
            [
                'key' => 'shops_abonement_finish_soon',
                'email' => 1,
                'sms' => 0,
                'title' => 'Срок действия тарифа "{tariff_title}" для магазина "{shop_title}" подходит к концу',
                'text' => 'Хотим вам сообщить, что срок действия тарифа для вашего магазина <a href="{shop_link}">{shop_title}</a> заканчивается через 3 дня.
                Вы можете продлить срок размещения вашего магазина с использованнием данного тарифа <a href="{promote_link}">перейдя по ссылке в кабинет</a>.',
                'key_title' => 'Магазины: предупреждение об окончании срока действия тарифа',
                'key_text' => 'Срок действия тарифа заканчивается через 3 дня',
                'type' => 'shop',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{shop_id}',
                        'title' => 'ID магазина',
                        'hint' =>''
                    ],
                    [
                        'link' => '{shop_title}',
                        'title' => 'Название магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{shop_link}',
                        'title' => 'Ссылка на страницу магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{tariff_title}',
                        'title' => 'Название тарифа',
                        'hint' => '',
                    ],
                    [
                        'link' => '{tariff_price}',
                        'title' => 'Стоимост тарифа (1 месяц - 10 грн.)',
                        'hint' => '',
                    ],
                    [
                        'link' => '{promote_link}',
                        'title' => 'Ссылка на продления',
                        'hint' => '',
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //5
            [
                'key' => 'shops_abonement_finish_soon_onetime',
                'email' => 1,
                'sms' => 0,
                'title' => 'Срок действия тарифа "{tariff_title}" для магазина "{shop_title}" подходит к концу',
                'text' => 'Хотим вам сообщить, что срок действия тарифа для вашего магазина <a href="{shop_link}">{shop_title}</a> заканчивается через 3 дня.
                Вам необходимо выбрать новый тариф <a href="{promote_link}">перейдя по ссылке в кабинет</a>.',
                'key_title' => 'Магазины: предупреждение об окончании срока действия единоразового тарифа',
                'key_text' => 'Срок действия единоразового тарифа заканчивается через 3 дня',
                'type' => 'shop',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{shop_id}',
                        'title' => 'ID магазина',
                        'hint' =>''
                    ],
                    [
                        'link' => '{shop_title}',
                        'title' => 'Название магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{shop_link}',
                        'title' => 'Ссылка на страницу магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{tariff_title}',
                        'title' => 'Название тарифа',
                        'hint' => '',
                    ],
                    [
                        'link' => '{tariff_price}',
                        'title' => 'Стоимост тарифа (1 месяц - 10 грн.)',
                        'hint' => '',
                    ],
                    [
                        'link' => '{promote_link}',
                        'title' => 'Ссылка на продления',
                        'hint' => '',
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //6
            [
                'key' => 'shops_abonement_finished',
                'email' => 1,
                'sms' => 0,
                'title' => 'Окончен срок действия тарифа "{tariff_title}" для магазина "{shop_title}"',
                'text' => 'Хотим вам сообщить, что срок действия тарифа для вашего магазина <a href="{shop_link}">{shop_title}</a> подошел к концу.
                Вы можете продлить срок размещения вашего магазина с использованнием данного тарифа <a href="{promote_link}">перейдя по ссылке в кабинет</a>.',
                'key_title' => 'Магазины: уведомления об окончании срока действия тарифа',
                'key_text' => 'Срок действия тарифа закончился',
                'type' => 'shop',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{shop_id}',
                        'title' => 'ID магазина',
                        'hint' =>''
                    ],
                    [
                        'link' => '{shop_title}',
                        'title' => 'Название магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{shop_link}',
                        'title' => 'Ссылка на страницу магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{tariff_title}',
                        'title' => 'Название тарифа',
                        'hint' => '',
                    ],
                    [
                        'link' => '{tariff_price}',
                        'title' => 'Стоимост тарифа (1 месяц - 10 грн.)',
                        'hint' => '',
                    ],
                    [
                        'link' => '{promote_link}',
                        'title' => 'Ссылка на продления',
                        'hint' => '',
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //7
            [
                'key' => 'shops_abonement_finished_onetime',
                'email' => 1,
                'sms' => 0,
                'title' => 'Окончен срок действия тарифа "{tariff_title}" для магазина "{shop_title}"',
                'text' => 'Хотим вам сообщить, что срок действия тарифа для вашего магазина <a href="{shop_link}">{shop_title}</a> подошел к концу.
                Вы можете продлить срок размещения вашего магазина выбрав любой из доступных <a href="{promote_link}">перейдя по ссылке в кабинет</a>.',
                'key_title' => 'Магазины: уведомления об окончании срока действия единоразового тарифа',
                'key_text' => 'Срок действия единоразового тарифа закончился',
                'type' => 'shop',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{shop_id}',
                        'title' => 'ID магазина',
                        'hint' =>''
                    ],
                    [
                        'link' => '{shop_title}',
                        'title' => 'Название магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{shop_link}',
                        'title' => 'Ссылка на страницу магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{tariff_title}',
                        'title' => 'Название тарифа',
                        'hint' => '',
                    ],
                    [
                        'link' => '{promote_link}',
                        'title' => 'Ссылка на продления',
                        'hint' => '',
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //8
            [
                'key' => 'shops_abonement_period_no_money',
                'email' => 1,
                'sms' => 0,
                'title' => 'Недостаточное количество среств для автоматического продления подписки',
                'text' => 'На вашем счету недостаточное среств для автоматического продления подписки по тарифу "{tariff_title}" для магазина "{shop_title}". Пожалуйста, пополните счет или отметите услугу автоматического продления',
                'key_title' => 'Магазины: уведомления о недостаточном количестве среств для автоматического продления действия тарифа',
                'key_text' => 'Недостаточное количество среств для автоматического продления тарифа(за 5 дней до окончания срока действия)',
                'type' => 'shop',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{shop_id}',
                        'title' => 'ID магазина',
                        'hint' =>''
                    ],
                    [
                        'link' => '{shop_title}',
                        'title' => 'Название магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{shop_link}',
                        'title' => 'Ссылка на страницу магазина',
                        'hint' => '',
                    ],
                    [
                        'link' => '{tariff_title}',
                        'title' => 'Название тарифа',
                        'hint' => '',
                    ],
                    [
                        'link' => '{tariff_price}',
                        'title' => 'Стоимост тарифа (1 месяц - 10 грн.)',
                        'hint' => '',
                    ],
                    [
                        'link' => '{promote_link}',
                        'title' => 'Ссылка на продления',
                        'hint' => '',
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //type = 'user'
            //1
            [
                'key' => 'users_register',
                'email' => 1,
                'sms' => 0,
                'title' => 'Регистрация на {site.title}',
                'text' => 'Здраствуйте!

                    При регистрации своего аккаунта вы указали этот адрес: {email}
                    Для продолжения регистрации необходимо активировать аккаунт, сделать это можно перейдя по ссылке <a href="{activate_link}">{activate_link}</a> 

                    Ваш пароль: {password}

                    (если ссылка не открывается по нажатию, скопируйте её и вставьте в адресную строку своево браузера)

                    Спасибо.
                    Команда {site.title}

                    ***Это письмо сформировано автоматически, отвечать на не него не нужно ***',
                'key_title' => 'Пользователи: уведомление о регистрации',
                'key_text' => 'Уведомление, отправляемое пользователю после регистрации, с указенниями об активации аккаунта',
                'type' => 'user',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{password}',
                        'title' => 'Пароль',
                        'hint' =>''
                    ],
                    [
                        'link' => '{activate_link}',
                        'title' => 'Ссылка активации аккаунта',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //2
            [
                'key' => 'users_register_phone',
                'email' => 1,
                'sms' => 0,
                'title' => 'Регистрация на {site.title}',
                'text' => 'Здраствуйте!

                    Вы успешно зарегистрировались.
                    Для входа в личный кабинет используйте:

                    Логин : {email}
                    Пароль: {password}

                    Спасибо,
                    Команда {site.title}

                    ***Это письмо сформировано автоматически, отвечать на не него не нужно ***',
                'key_title' => 'Пользователи: уведомления о регистрации (с вводом номера телефона)',
                'key_text' => 'Шаблон письма, отправляемого пользователю после успешной регистрации с подверждением номера телефона ',
                'type' => 'user',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{password}',
                        'title' => 'Пароль',
                        'hint' =>''
                    ],
                    [
                        'link' => '{phone}',
                        'title' => 'Номер телефона',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //3
            [
                'key' => 'users_register_auto',
                'email' => 1,
                'sms' => 0,
                'title' => 'Регистрация на {site.title}',
                'text' => 'Здраствуйте!

                    Вы успешно зарегистрировались.
                    Пароль: {password}
                ',
                'key_title' => 'Пользователи: уведомлений об успешной автоматической регистрации',
                'key_text' => 'Уведомления, отправляемое пользователю в случае автоматической регистрации.
                        Активация объявления / переход по ссылке "продолжить переписку"',
                'type' => 'user',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{password}',
                        'title' => 'Пароль',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //4
            [
                'key' => 'users_forgot_start',
                'email' => 1,
                'sms' => 0,
                'title' => 'Восстановления пароля на {site.title}',
                'text' => 'Уважаемый {name}!
                    Для восстановления пароля, вам необходимо перейти по ссылке
                    <a href="{link}">{link}</a>
                ',
                'key_title' => 'Пользователи: восстановления пароля',
                'key_text' => 'Уведомления, отправляемое пользователю в случае запроса на восстановление пароля',
                'type' => 'user',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{link}',
                        'title' => 'Ссылка восстановления',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //5
            [
                'key' => 'users_blocked',
                'email' => 1,
                'sms' => 0,
                'title' => 'Ваш аккаунт был заблокирован модератором',
                'text' => 'Уважаемый {name}!

                    Ваш аккаунт был заблокирован. 
                    Причина блокировки:
                    {blocked_reason}
                ',
                'key_title' => 'Пользователи: уведомления о блокировки аккаунта',
                'key_text' => 'Уведомления, отправляемое пользователю в случае блокировки аккаунта',
                'type' => 'user',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{blocked_reason}',
                        'title' => 'Причина блокировки',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //6
            [
                'key' => 'users_unblocked',
                'email' => 1,
                'sms' => 0,
                'title' => 'Ваш аккаунт был разблокирован модератором',
                'text' => 'Уважаемый {name}!
                    Ваш аккаунт был разблокирован модератором. 
                ',
                'key_title' => 'Пользователи: уведомления о разблокировке аккаунта',
                'key_text' => 'Уведомления, отправляемое пользователю в случае разблокировки аккаунта',
                'type' => 'user',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //7
            [
                'key' => 'users_email_change',
                'email' => 1,
                'sms' => 0,
                'title' => 'Был изменен основной email для вашего аккаунта',
                'text' => 'Был изменен основной емейл для вашего аккаунта на <a href="{site.host}">{site.title}</a> на {email} . Чтобы активировать этот email <a href="{activate_link}"> перейдите по ссылке</a>.',
                'key_title' => 'Пользователи: изменения e-mail адреса',
                'key_text' => 'Уведомления, отправляемое пользователю при изменении e-mail адреса',
                'type' => 'user',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{activate_link}',
                        'title' => 'Ссылка активации',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //type = 'other'
            //1
            [
                'key' => 'user_balance_plus',
                'email' => 1,
                'sms' => 0,
                'title' => 'Ваш счет на {site.title} успешно пополнен.',
                'text' => 'Ваш счет успешно пополнен на {amount}. Текущий баланс равен {balance}.',
                'key_title' => 'Пополнения счета',
                'key_text' => 'Уведомление, отправляемое пользователю в случае успешного пополнения счета',
                'type' => 'other',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя пользователя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{amount}',
                        'title' => 'Сумма пополнения',
                        'hint' =>'100 сум'
                    ],
                    [
                        'link' => '{balance}',
                        'title' => 'Текущий баланс',
                        'hint' =>'100 сум'
                    ],
                    [
                        'link' => '{auth_link}',
                        'title' => 'Ссылка для авторизации',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //2
            [
                'key' => 'user_balance_admin_plus',
                'email' => 1,
                'sms' => 0,
                'title' => 'Ваш счет был пополнен администратором.',
                'text' => 'Добрый день!

                        Ваш счет был пополнен администратором на {amount}. Текущий баланс составляет {balance}. {description}',
                'key_title' => 'Пополнения счета администратором',
                'key_text' => 'Уведомление, отправляемое пользователю в случае успешного пополнения счета администратором',
                'type' => 'other',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя пользователя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{amount}',
                        'title' => 'Сумма пополнения',
                        'hint' =>'100 сум'
                    ],
                    [
                        'link' => '{balance}',
                        'title' => 'Текущий баланс',
                        'hint' =>'100 сум'
                    ],
                    [
                        'link' => '{description}',
                        'title' => 'Описание',
                        'hint' =>''
                    ],
                    [
                        'link' => '{auth_link}',
                        'title' => 'Ссылка для авторизации',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //3
            [
                'key' => 'users_balande_admin_minus',
                'email' => 1,
                'sms' => 0,
                'title' => 'С вашего счета были списаны средства.',
                'text' => 'Добрый день!

                        С вашего счета администратором были списаны средства, в размере {amount}. Текущий баланс составляет {balance}. {description}',
                'key_title' => 'Списания со счета администратором',
                'key_text' => 'Уведомление, отправляемое пользователю в случае списания средств со счета администратором',
                'type' => 'other',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя пользователя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{amount}',
                        'title' => 'Сумма пополнения',
                        'hint' =>'100 сум'
                    ],
                    [
                        'link' => '{balance}',
                        'title' => 'Текущий баланс',
                        'hint' =>'100 сум'
                    ],
                    [
                        'link' => '{description}',
                        'title' => 'Описание',
                        'hint' =>''
                    ],
                    [
                        'link' => '{auth_link}',
                        'title' => 'Ссылка для авторизации',
                        'hint' =>''
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //4
            [
                'key' => 'internalmail_new_message',
                'email' => 1,
                'sms' => 0,
                'title' => 'Новое сообщение на сайте {site.title}',
                'text' => 'Для вас новое сообщение.
                    Перейдите по <a href="{link}">ссылке</a> для его прочтения',
                'key_title' => 'Сообщения: новое сообщение',
                'key_text' => 'Уведомление, отправляемое пользователю при получения новое сообщения',
                'type' => 'other',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя пользователя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{link}',
                        'title' => 'Ссылка для прочтения',
                    ],
                    [
                        'link' => '{message}',
                        'title' => 'Текст сообщения',
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //5
            [
                'key' => 'internalmail_new_message_new_user',
                'email' => 1,
                'sms' => 0,
                'title' => 'Новое сообщение на сайте {site.title}',
                'text' => 'Здраствуйте!

                        Вы получили новое сообщение:
                        "{message}"

                        Нажмите <a href="{link_activate}">здесь</a>, чтобы прочесть и ответить.',
                'key_title' => 'Сообщения: новое сообщение для неактивированного пользователя ',
                'key_text' => 'Уведомление, отправляемое неактивированному пользователю',
                'type' => 'other',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{link_activate}',
                        'title' => 'Ссылка на переписку и активацию',
                        'hint' =>''
                    ],
                    [
                        'link' => '{message}',
                        'title' => 'Текст сообщения',
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //6
            [
                'key' => 'contacts_admin',
                'email' => 1,
                'sms' => 0,
                'title' => 'Новое сообщение на сайте {site.title}',
                'text' => 'Новое сообщение:

                Имя:    {name}
                E-mail: {email}
                Сообщения:
                {message}
                ',
                'key_title' => 'Форма контактов: уведомления о новом сообщении',
                'key_text' => 'Уведомление, отправляемое админстратору(admin@bisyor.uz) после отправки сообщения через форму контактов ',
                'type' => 'other',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{name}',
                        'title' => 'Имя',
                        'hint' =>''
                    ],
                    [
                        'link' => '{email}',
                        'title' => 'Email',
                        'hint' =>''
                    ],
                    [
                        'link' => '{message}',
                        'title' => 'Текст сообщения',
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
            //7
            [
                'key' => 'sendmail_massend',
                'email' => 1,
                'sms' => 0,
                'title' => '',
                'text' => '{msg}',
                'key_title' => 'Почта: массовая рассылка писем',
                'key_text' => 'Уведомление, отправляемое при массовой рассылке',
                'type' => 'other',
                'subscription' => 'Всегда',
                'extra' => [
                    [
                        'link' => '{msg}',
                        'title' => 'Текст письма',
                    ],
                    [
                        'link' => '{site.title}',
                        'title' => 'Название сайта',
                        'hint' =>'Bisyor.uz'
                    ],
                    [
                        'link' => '{site.host}',
                        'title' => 'Домен сайта',
                        'hint' =>'bisyor.uz'
                    ],
                ]
            ],
        ];

        foreach ($alerts as $key => $value) {
            $this->insert('{{%alerts}}',array(
                'email' => $value['email'],
                'sms' => $value['sms'],
                'title' => $value['title'],
                'text' => $value['text'],
                'key' => $value['key'],
                'key_title' => $value['key_title'],
                'key_text' => $value['key_text'],
                'type' => $value['type'],
                'subscription' => $value['subscription'],
                'extra' => serialize($value['extra'])
            ));
        }
        ////----------------------------Общие настройки-----------------------
        $site_settings = [
            [
                'name' => 'Coordinate X',
                'value' => '',
                'key' => 'coordinate_x',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Coordinate Y',
                'value' => '',
                'key' => 'coordinate_y',
                'group' => 'site-settings',
                'type' => 'string'
            ],
        ];
        ////------------------------------------------------------------------

        foreach ($site_settings as $key => $value) {
            $this->insert('{{%settings}}',array(
                    'name' => $value['name'],
                    'value' => $value['value'],
                    'key' => $value['key'],
                    'group' => $value['group'],
                    'type' => $value['type']
                ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%alerts}}', 'subscription');
    }
}
