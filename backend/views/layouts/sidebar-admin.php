<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\widgets\Menu;
use backend\models\shops\Shops;
use backend\models\items\Items;

//echo "ff=".$this->context->id;die;
$shopsCountModeration = Shops::find()->where(['status' => Shops::STATUS_CHECKING])->count();
$itemsCountModeration = Items::find()->where(['is_moderating' => 1])->andFilterWhere(
    ['user_id' => Yii::$app->getRequest()->getQueryParam('user_id')]
)->count();
$shopsCountOther = Shops::find()->where(['!=', 'status', Shops::STATUS_CHECKING])->count();
?>

<div id="sidebar" class="sidebar">
    <div data-scrollbar="true" data-height="100%">
        <ul class="nav">
            <li>
                <ul class="nav nav-profile">
                    <li><?= Html::a('<i class="fa fa-cogs"></i> Изменит Профиль', ['/users/profile'], []); ?></li>
                    <li>
                        <?= Html::a(
                            '<i class="fa fa-sign-out"></i>Выйти',
                            ['/site/logout'],
                            ['data-method' => 'post',]
                        ) ?>
                    </li>
                </ul>
            </li>
        </ul>
        <?= Menu::widget(
            [
                'options' => ['class' => 'nav'],
                'encodeLabels' => false,
                'items' => [
                    [
                        'label' => 'Статистика',
                        'icon' => 'dashboard',
                        'url' => [''],
                        'active' => (
                            $this->context->id == 'site'
                            || $this->context->route  == 'statistics/moderator'
                            || $this->context->route  == 'statistics/items-views'
                        ),
                        'items' => [
                            [
                                'label' => 'Рабочий стол',
                                'icon' => ' ',
                                'url' => ['/site'],
                                'active' => $this->context->id == 'site'
                            ],
                            [
                                'label' => 'Статистика модераторов',
                                'icon' => ' ',
                                'url' => ['/statistics/moderator'],
                                'active' => $this->context->route  == 'statistics/moderator'
                            ],
                            [
                                'label' => 'Статистика просмотров',
                                'icon' => ' ',
                                'url' => ['/statistics/items-views'],
                                'active' => $this->context->route  == 'statistics/items-views'
                            ],
                        ],
                    ],
                    [
                        'label' => 'Объявления',
                        'icon' => 'bookmark',
                        'url' => ['/nothealth'],
                        'active' => (
                            $this->context->id == 'items/items-scale'
                            || $this->context->id == 'items/services'
                            || $this->context->id == 'items/packet'
                            || $this->context->id == 'items/items-claim'
                            || $this->context->id == 'items/categories'
                            || $this->context->id == 'references/search-results'
                            || $this->context->id == 'items/settings'
                            || $this->context->id == 'items/items-limits'
                            || $this->context->id == 'items/items'
                            || $this->context->id == 'items/applications'


                        ),
                        'items' => [
                            [
                                'label' => 'Список' . Html::tag(
                                        'span',
                                        $itemsCountModeration,
                                        [
                                            'class' => 'pull-right badge badge-danger',
                                            'style' => 'background: green !important;'
                                        ]
                                    ),
                                'icon' => ' ',
                                'url' => ['/items/items'],
                                'active' => $this->context->id == 'items/items',
                            ],
                            [
                                'label' => 'Жалобы',
                                'icon' => ' ',
                                'url' => ['/items/items-claim'],
                                'active' => $this->context->id == 'items/items-claim',
                            ],
                            [
                                'label' => 'Услуги',
                                'icon' => ' ',
                                'url' => ['/items/services'],
                                'active' => $this->context->id == 'items/services',
                            ],
                            [
                                'label' => 'Результат поиска',
                                'icon' => ' ',
                                'url' => ['/references/search-results'],
                                'active' => $this->context->id == 'references/search-results'
                            ],
                            [
                                'label' => 'Пакеты услуг',
                                'icon' => ' ',
                                'url' => ['/items/packet'],
                                'active' => $this->context->id == 'items/packet',
                            ],
                            [
                                'label' => 'Категории',
                                'icon' => ' ',
                                'url' => ['/items/categories'],
                                'active' => $this->context->id == 'items/categories',
                            ],
                            [
                                'label' => 'Настройки',
                                'icon' => ' ',
                                'url' => ['/items/settings'],
                                'active' => $this->context->id == 'items/settings',
                            ],
                            [
                                'label' => 'Лимиты',
                                'icon' => ' ',
                                'url' => ['/items/items-limits'],
                                'active' => $this->context->id == 'items/items-limits'
                            ],
                            [
                                'label' => 'Шкала',
                                'icon' => ' ',
                                'url' => ['/items/items-scale'],
                                'active' => $this->context->id == 'items/items-scale'
                            ],
                            [
                                'label' => 'Заявка',
                                'icon' => ' ',
                                'url' => ['/items/applications'],
                                'active' => $this->context->id == 'items/applications'
                            ],
                            
                        ],
                    ],
                    [
                        'label' => 'Магазины',
                        'icon' => 'shopping-cart',
                        'url' => ['/nothealth'],
                        'active' => in_array(
                            $this->context->id,
                            [
                                'shops/shop-categories',
                                'shops/shop-categories',
                                'shops/services',
                                'shops/shops',
                                'shops/shops-claims',
                                'shops/requests',
                                'shops/shops-abonements',
                            ]
                        ),
                        'items' => [
                            [
                                'label' => 'Магазины' . Html::tag(
                                        'span',
                                        $shopsCountOther,
                                        [
                                            'class' => 'pull-right badge badge-danger',
                                            'style' => 'background: green !important;'
                                        ]
                                    ),
                                'icon' => ' ',
                                'url' => ['/shops/shops'],
                                'active' => $this->context->id == 'shops/shops',
                            ],
                            [
                                'label' => 'Заявки' . Html::tag(
                                        'span',
                                        $shopsCountModeration,
                                        [
                                            'class' => 'pull-right badge badge-danger',
                                            'style' => 'background: #ff5b57 !important;'
                                        ]
                                    ),
                                'icon' => ' ',
                                'url' => ['/shops/requests'],
                                'active' => $this->context->id == 'shops/requests',
                            ],
                            [
                                'label' => 'Жалобы',
                                'icon' => ' ',
                                'url' => ['/shops/shops-claims'],
                                'active' => $this->context->id == 'shops/shops-claims',
                            ],
                            [
                                'label' => 'Категории',
                                'icon' => ' ',
                                'url' => ['/shops/shop-categories'],
                                'active' => $this->context->id == 'shops/shop-categories',
                            ],
                            [
                                'label' => 'Услуги',
                                'icon' => ' ',
                                'url' => ['/shops/services'],
                                'active' => $this->context->id == 'shops/services',
                            ],
                            [
                                'label' => 'Абонемент',
                                'icon' => ' ',
                                'url' => ['/shops/shops-abonements'],
                                'active' => $this->context->id == 'shops/shops-abonements',
                            ]
                        ],
                    ],
                    [
                        'label' => 'Промокоды',
                        'icon' => 'ticket',
                        'url' => [''],
                        'active' => ($this->context->id == 'promocodes/promocodes' || $this->context->id == 'promocodes/promocodes-usage'),
                        'items' => [
                            [
                                'label' => 'Список',
                                'icon' => ' ',
                                'url' => ['/promocodes/promocodes'],
                                'active' => $this->context->id == 'promocodes/promocodes'
                            ],
                            [
                                'label' => 'Статистика',
                                'icon' => ' ',
                                'url' => ['/promocodes/promocodes-usage'],
                                'active' => $this->context->id == 'promocodes/promocodes-usage'
                            ],
                        ],
                    ],
                    [
                        'label' => 'Пользователи',
                        'icon' => 'users',
                        'url' => [''],
                        'active' => ($this->context->route == 'users/moderator' || $this->context->id == 'users/users' && $this->context->route != 'users/profile' && $this->context->route != 'users/change' || $this->context->id == 'users/roles' | $this->context->route == 'users/moderator' || $this->context->id == 'users/users-banlist'),
                        'items' => [
                            [
                                'label' => 'Список пользователей',
                                'icon' => ' ',
                                'url' => ['users/users'],
                                'active' => $this->context->route == 'users/users/index' && $this->context->route != 'users/users/profile' && $this->context->route != 'users/users/change' && $this->context->route != 'users/users/moderator' || $this->context->route == 'users/users/view' || $this->context->route == 'users/users/edit-info'
                            ],
                            [
                                'label' => 'Список модераторов',
                                'icon' => ' ',
                                'url' => ['users/users/moderator'],
                                'active' => $this->context->route == 'users/users/moderator' || $this->context->route == 'users/users/moderator-view' || $this->context->route == 'users/users/edit-moderator'
                            ],
                            [
                                'label' => 'Блокировка пользователей',
                                'icon' => ' ',
                                'url' => ['users/users-banlist'],
                                'active' => $this->context->id == 'users/users-banlist'
                            ],
                            [
                                'label' => 'Группы',
                                'icon' => ' ',
                                'url' => ['/users/roles'],
                                'active' => $this->context->id == 'users/roles'
                            ],
                        ],
                    ],
                    [
                        'label' => 'Счета',
                        'icon' => 'cubes',
                        'url' => [''],
                        'active' => ($this->context->route == 'bills/bills/index' || $this->context->route == 'statistics/bills' || $this->context->route == 'bills/top-users/index'),
                        'items' => [
                            [
                                'label' => 'История',
                                'icon' => ' ',
                                'url' => ['bills/bills'],
                                'active' => $this->context->route == 'bills/bills/index'
                            ],
                            [
                                'label' => 'Статистика',
                                'icon' => ' ',
                                'url' => ['statistics/bills'],
                                'active' => $this->context->route == 'statistics/bills'
                            ],
                            [
                                'label' => 'Активные пользователи',
                                'icon' => ' ',
                                'url' => ['bills/top-users/index'],
                                'active' => $this->context->route == 'bills/top-users/index'
                            ],

                        ],
                    ],
//                ['label' => 'Счета', 'icon' => 'cubes', 'url' => ['/bills/bills'], 'active' => $this->context->id == 'bills/bills'],
                    [
                        'label' => 'Баннеры',
                        'icon' => 'camera-retro',
                        'url' => ['banners/banner'],
                        'active' => $this->context->id == 'banners/banner'
                    ],
                    // ['label' => 'Сообщение.', 'icon' => 'send', 'url' => ['#'], /*'active' => $this->context->id == 'chats'*/],
                    [
                        'label' => 'Сообщение',
                        'icon' => 'send',
                        'url' => ['/chats/index?type=1'],
                        'active' => $this->context->id == 'chats'
                    ],
                    [
                        'label' => 'Блог',
                        'icon' => 'fas fa-list-alt',
                        'url' => [''],
                        'active' => ($this->context->id == 'blogs/blog-posts' || $this->context->id == 'blogs/blog-categories' || $this->context->id == 'blogs/blog-tags'),
                        'items' => [
                            [
                                'label' => 'Посты',
                                'icon' => ' ',
                                'url' => ['/blogs/blog-posts'],
                                'active' => $this->context->id == 'blogs/blog-posts'
                            ],
                            [
                                'label' => 'Категории',
                                'icon' => ' ',
                                'url' => ['/blogs/blog-categories'],
                                'active' => $this->context->id == 'blogs/blog-categories'
                            ],
                            [
                                'label' => 'Теги',
                                'icon' => ' ',
                                'url' => ['/blogs/blog-tags'],
                                'active' => $this->context->id == 'blogs/blog-tags'
                            ],
                        ],
                    ],
                    [
                        'label' => 'Помощь',
                        'icon' => 'fas fa-info-circle',
                        'url' => [''],
                        'active' => ($this->context->id == 'references/helps-categories' || $this->context->id == 'references/helps'),
                        'items' => [
                            [
                                'label' => 'Категория',
                                'icon' => ' ',
                                'url' => ['/references/helps-categories'],
                                'active' => $this->context->id == 'references/helps-categories'
                            ],
                            [
                                'label' => 'Вопросы',
                                'icon' => ' ',
                                'url' => ['/references/helps'],
                                'active' => $this->context->id == 'references/helps'
                            ],
                        ],
                    ],
                    [
                        'label' => 'Опросы',
                        'icon' => 'list',
                        'url' => ['/references/polls'],
                        'active' => $this->context->id == 'references/polls'
                    ],
                    [
                        'label' => 'Страницы',
                        'icon' => 'file-text-o',
                        'url' => ['/references/pages'],
                        'active' => $this->context->id == 'references/pages'
                    ],
                    [
                        'label' => 'Контакты',
                        'icon' => 'bug',
                        'url' => ['/references/contacts'],
                        'active' => $this->context->id == 'references/contacts'
                    ],
                    [
                        'label' => 'Рассылка',
                        'icon' => 'send',
                        'url' => [''],
                        'active' => ($this->context->id == 'mail/sendmail-massend' || $this->context->id == 'mail/sendmail-template' || $this->context->id == 'alerts'),
                        'items' => [
                            [
                                'label' => 'Список рассылок',
                                'icon' => ' ',
                                'url' => ['/mail/sendmail-massend'],
                                'active' => $this->context->id == 'mail/sendmail-massend'
                            ],
                            [
                                'label' => 'Шаблоны писем',
                                'icon' => ' ',
                                'url' => ['/mail/sendmail-template'],
                                'active' => $this->context->id == 'mail/sendmail-template'
                            ],
                            [
                                'label' => 'Уведомления',
                                'icon' => ' ',
                                'url' => ['/alerts'],
                                'active' => $this->context->id == 'alerts'
                            ],
                        ],
                    ],
                    [
                        'label' => 'Карта сайта и меню',
                        'icon' => 'map',
                        'url' => ['/references/sitemap'],
                        'active' => $this->context->id == 'references/sitemap'
                    ],
                    [
                        'label' => 'SEO',
                        'icon' => 'cloud',
                        'url' => [''],
                        'active' => ($this->context->id == 'references/seo/items' || $this->context->id == 'references/seo' || $this->context->id == 'references/redirects' || $this->context->id == 'references/landing-pages'),
                        'items' => [
                            [
                                'label' => 'Объявления',
                                'icon' => ' ',
                                'url' => ['/references/seo/items'],
                                'active' => $this->context->route == 'references/seo/items'
                            ],
                            [
                                'label' => 'Магазины',
                                'icon' => ' ',
                                'url' => ['/references/seo/shops'],
                                'active' => $this->context->route == 'references/seo/shops'
                            ],
                            [
                                'label' => 'Пользователи',
                                'icon' => ' ',
                                'url' => ['/references/seo/users'],
                                'active' => $this->context->route == 'references/seo/users'
                            ],
                            [
                                'label' => 'Блог',
                                'icon' => ' ',
                                'url' => ['/references/seo/blogs'],
                                'active' => $this->context->route == 'references/seo/blogs'
                            ],
                            [
                                'label' => 'Помощь',
                                'icon' => ' ',
                                'url' => ['/references/seo/helps'],
                                'active' => $this->context->route == 'references/seo/helps'
                            ],
                            [
                                'label' => 'Настройки сайта',
                                'icon' => ' ',
                                'url' => ['/references/seo/settings'],
                                'active' => $this->context->route == 'references/seo/settings'
                            ],
                            [
                                'label' => 'Посадочные страницы',
                                'icon' => ' ',
                                'url' => ['/references/landing-pages'],
                                'active' => $this->context->id == 'references/landing-pages'
                            ],
                            [
                                'label' => 'Редиректы',
                                'icon' => ' ',
                                'url' => ['/references/redirects'],
                                'active' => $this->context->id == 'references/redirects'
                            ],
                            [
                                'label' => 'Настройки',
                                'icon' => ' ',
                                'url' => ['/references/seo/robots'],
                                'active' => $this->context->route == 'references/seo/robots'
                            ],
                        ],
                    ],
                    [
                        'label' => 'Настройки сайта',
                        'icon' => 'cogs',
                        'url' => ['/nothealth'],
                        'active' => in_array($this->context->id,
                                             [
                                                 'source-message',
                                                 'references/subscribers',
                                                 'references/social-network',
                                                 'references/settings',
                                                 'references/brands',
                                                 'references/countries',
                                                 'references/language',
                                                 'settings/site-settings',
                                                 'settings/system-settings',
                                                 'references/currencies',
                                                 'references/cache-clear',
                                                 'references/counters',
                                                 'references/rss',
                                                 'references/black-list',
                                                 'references/bonus-list',
                                             ]
                        ),
                        'items' => [
                            [
                                'label' => 'Общие настройки',
                                'icon' => ' ',
                                'url' => ['/settings/site-settings'],
                                'active' => ($this->context->id . '/' . $this->context->action->id == 'settings/site-settings/index')
                            ],
                            [
                                'label' => 'Страны',
                                'icon' => ' ',
                                'url' => ['/references/countries'],
                                'active' => ($this->context->id == 'references/countries')
                            ],
                            [
                                'label' => 'Системные настройки',
                                'icon' => ' ',
                                'url' => ['/settings/system-settings'],
                                'active' => $this->context->id == 'settings/system-settings',
                            ],
                            [
                                'label' => 'Счетчики и код',
                                'icon' => ' ',
                                'url' => ['/references/counters'],
                                'active' => $this->context->id == 'references/counters',
                            ],
                            [
                                'label' => 'Валюта',
                                'icon' => ' ',
                                'url' => ['/references/currencies'],
                                'active' => $this->context->id == 'references/currencies'
                            ],
                            [
                                'label' => 'Локализация',
                                'icon' => ' ',
                                'url' => ['/references/language'],
                                'active' => ($this->context->id == 'references/language' || $this->context->id == 'source-message')
                            ],
                            //['label' => 'Google Analytics','icon' => ' ', 'url' => ['#'], 'active' => $this->context->id == '#', ],
                            [
                                'label' => 'Бренды',
                                'icon' => ' ',
                                'url' => ['/references/brands'],
                                'active' => $this->context->id == 'references/brands'
                            ],
                            [
                                'label' => 'Бонусы',
                                'icon' => ' ',
                                'url' => ['/references/bonus-list'],
                                'active' => $this->context->id == 'references/bonus-list'
                            ],
                            // ['label' => 'Настройки', 'icon' => ' ', 'url' => ['/references/settings'], 'active' => $this->context->id == 'references/settings'],
                            [
                                'label' => 'Подписчики',
                                'icon' => ' ',
                                'url' => ['/references/subscribers'],
                                'active' => ($this->context->id == 'references/subscribers')
                            ],
                            [
                                'label' => 'Cоциальные сети',
                                'icon' => ' ',
                                'url' => ['/references/social-networks'],
                                'active' => ($this->context->id == 'references/social-networks')
                            ],
                            [
                                'label' => 'RSS',
                                'icon' => ' ',
                                'url' => ['/references/rss'],
                                'active' => ($this->context->id == 'references/rss')
                            ],
                            [
                                'label' => 'Выгрузки сайта',
                                'icon' => ' ',
                                'url' => ['/settings/site-settings/button-site'],
                                'active' => ($this->context->id . '/' . $this->context->action->id == 'settings/site-settings/button-site')
                            ],
                            [
                                'label' => 'Очистить кэш',
                                'icon' => ' ',
                                'url' => ['/references/cache-clear/index'],
                                'active' => ($this->context->id . '/' . $this->context->action->id == 'references/cache-clear/index')
                            ],
                            [
                                'label' => 'Черный список',
                                'icon' => ' ',
                                'url' => ['/references/black-list'],
                                'active' => $this->context->id == 'references/black-list'
                            ],

                        ],
                    ],
                    [
                        'label' => 'Ваканции',
                        'icon' => 'cogs',
                        'url' => ['/nothealth'],
                        'active' => in_array($this->context->id,
                            [
                                'references/vacancy-category',
                                'references/vacancies',
                            ]
                        ),
                        'items' => [
                            [
                                'label' => 'Категория',
                                'icon' => ' ',
                                'url' => ['references/vacancy-category'],
                                'active' => $this->context->id == 'references/vacancy-category'
                            ],
                            [
                                'label' => 'Список',
                                'icon' => ' ',
                                'url' => ['/references/vacancies'],
                                'active' => $this->context->id == 'references/vacancies'
                            ],
                            
                        ]
                    ],
                    [
                        'label' => 'Парсер',
                        'icon' => 'cogs',
                        'url' => ['/nothealth'],
                        'active' => in_array($this->context->id,
                            [
                                'references/parser',
                                'references/parser/olx',
                                'references/parser/olx-business',
                            ]
                        ),
                        'items' => [
                            [
                                'label' => 'Mexnat.uz',
                                'icon' => ' ',
                                'url' => ['/references/parser'],
                                'active' => $this->context->route == 'references/parser'
                            ],
                            [
                                'label' => 'Парсер-OLX',
                                'icon' => ' ',
                                'url' => ['/references/parser/olx'],
                                'active' => $this->context->route == 'references/parser/olx'
                            ],
                            [
                                'label' => 'OLX Бизнес-страница',
                                'icon' => ' ',
                                'url' => ['/references/parser/olx-business'],
                                'active' => $this->context->route == 'references/parser/olx-business'
                            ],
                        ]
                    ],
                    [
                        'label' => 'Инструкция',
                        'icon' => 'dedent',
                        'url' => ['/references/instruction'],
                        'active' => $this->context->id == 'references/instruction'
                    ],
                ],
            ]
        ) ?>
        <li style="list-style: none;">
            <a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i
                        class="fa fa-angle-double-left"></i></a>
        </li>
    </div>
</div>
<div class="sidebar-bg"></div>