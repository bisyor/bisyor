<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\widgets\Menu;
use backend\models\shops\Shops;
use backend\models\items\Items;
use backend\components\StaticFunction;
//echo "ff=".$this->context->id;die;
/* @var $methods */
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
                        'url' => ['/site'],
                        'active' => $this->context->id == 'site',
                        'visible' => StaticFunction::checkMenu($methods,'desktop','statistika'),
                    ],
                    [
                        'label' => 'Объявления',
                        'icon' => 'bookmark',
                        'visible' => StaticFunction::dropMenu($methods,'bbs'),
                        'url' => ['/nothealth'],
                        'active' => ($this->context->id == 'items/items-scale' || $this->context->id == 'items/services' || $this->context->id == 'items/packet' || $this->context->id == 'items/items-claim' || $this->context->id == 'items/categories' || $this->context->id == 'references/search-results' || $this->context->id == 'items/settings' || $this->context->id == 'items/items-limits' || $this->context->id == 'items/items'),
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
                                'visible' => StaticFunction::checkMenu($methods,'bbs','items-listing'),
                            ],
                            [
                                'label' => 'Жалобы',
                                'icon' => ' ',
                                'url' => ['/items/items-claim'],
                                'active' => $this->context->id == 'items/items-claim',
                                'visible' =>StaticFunction::checkMenu($methods,'bbs','claims-listing'),
                            ],
                            [
                                'label' => 'Услуги',
                                'icon' => ' ',
                                'url' => ['/items/services'],
                                'active' => $this->context->id == 'items/services',
                                'visible' =>StaticFunction::checkMenu($methods,'bbs','svc'),
                            ],
                            [
                                'label' => 'Результат поиска',
                                'icon' => ' ',
                                'url' => ['/references/search-results'],
                                'active' => $this->context->id == 'references/search-results',
                                'visible' => StaticFunction::checkMenu($methods,'bbs','search-results'),
                            ],
                            [
                                'label' => 'Пакеты услуг',
                                'icon' => ' ',
                                'url' => ['/items/packet'],
                                'active' => $this->context->id == 'items/packet',
                                'visible' =>StaticFunction::checkMenu($methods,'bbs','svc'),
                            ],
                            [
                                'label' => 'Категории',
                                'icon' => ' ',
                                'url' => ['/items/categories'],
                                'active' => $this->context->id == 'items/categories',
                                'visible' =>StaticFunction::checkMenu($methods,'bbs','categories'),
                            ],
                            [
                                'label' => 'Настройки',
                                'icon' => ' ',
                                'url' => ['/items/settings'],
                                'active' => $this->context->id == 'items/settings',
                                'visible' => StaticFunction::checkMenu($methods,'bbs','settings'),
                            ],
                            [
                                'label' => 'Лимиты',
                                'icon' => ' ',
                                'url' => ['/items/items-limits'],
                                'active' => $this->context->id == 'items/items-limits',
                                'visible' => StaticFunction::checkMenu($methods,'bbs','items-limits-payed'),
                            ],
                            [
                                'label' => 'Шкала',
                                'icon' => ' ',
                                'url' => ['/items/items-scale'],
                                'active' => $this->context->id == 'items/items-scale',
                                'visible' => StaticFunction::checkMenu($methods,'bbs','items-scale'),
                            ],
                        ],
                    ],
                    [
                        'label' => 'Магазины',
                        'icon' => 'shopping-cart',
                        'url' => ['/nothealth'],
                        'visible' => StaticFunction::dropMenu($methods,'shops'),
                        'active' => in_array(
                            $this->context->id,
                            [
                                'shops/shop-categories',
                                'shops/shop-categories',
                                'shops/services',
                                'shops/shops',
                                'shops/shops-claims',
                                'shops/requests',
                                'shops/shops-abonements'
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
                                'visible' => StaticFunction::checkMenu($methods,'shops','shops-listing'),
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
                                'visible' => StaticFunction::checkMenu($methods,'shops','shops-requests'),
                            ],
                            [
                                'label' => 'Жалобы',
                                'icon' => ' ',
                                'url' => ['/shops/shops-claims'],
                                'active' => $this->context->id == 'shops/shops-claims',
                                'visible' => StaticFunction::checkMenu($methods,'shops','claims-listing'),
                            ],
                            [
                                'label' => 'Категории',
                                'icon' => ' ',
                                'url' => ['/shops/shop-categories'],
                                'active' => $this->context->id == 'shops/shop-categories',
                                'visible' => StaticFunction::checkMenu($methods,'shops','categories'),
                            ],
                            [
                                'label' => 'Услуги',
                                'icon' => ' ',
                                'url' => ['/shops/services'],
                                'active' => $this->context->id == 'shops/services',
                                'visible' => StaticFunction::checkMenu($methods,'shops','svc'),
                            ],
                            [
                                'label' => 'Абонемент',
                                'icon' => ' ',
                                'url' => ['/shops/shops-abonements'],
                                'active' => $this->context->id == 'shops/shops-abonements',
                                'visible' => StaticFunction::checkMenu($methods,'shops','abonement'),
                            ],
                        ],
                    ],
                    [
                        'label' => 'Промокоды',
                        'icon' => 'ticket',
                        'visible' => StaticFunction::dropMenu($methods,'promocodes'),
                        'url' => [''],
                        'active' => ($this->context->id == 'promocodes/promocodes' || $this->context->id == 'promocodes/promocodes-usage'),
                        'items' => [
                            [
                                'label' => 'Список',
                                'icon' => ' ',
                                'url' => ['/promocodes/promocodes'],
                                'visible' => StaticFunction::checkMenu($methods,'promocodes','promocodes-settings'),
                                'active' => $this->context->id == 'promocodes/promocodes'
                            ],
                            [
                                'label' => 'Статистика',
                                'icon' => ' ',
                                'visible' => StaticFunction::checkMenu($methods,'promocodes','statistika'),
                                'url' => ['/promocodes/promocodes-usage'],
                                'active' => $this->context->id == 'promocodes/promocodes-usage'
                            ],
                        ],
                    ],
                    [
                        'label' => 'Пользователи',
                        'icon' => 'users',
                        'visible' => StaticFunction::dropMenu($methods,'users'),
                        'url' => [''],
                        'active' => ($this->context->route == 'users/moderator' || $this->context->id == 'users/users' && $this->context->route != 'users/profile' && $this->context->route != 'users/change' || $this->context->id == 'users/roles' | $this->context->route == 'users/moderator' || $this->context->id == 'users/users-banlist'),
                        'items' => [
                            [
                                'label' => 'Список пользователей',
                                'icon' => ' ',
                                'url' => ['users/users'],
                                'active' => $this->context->route == 'users/users/index' && $this->context->route != 'users/users/profile' && $this->context->route != 'users/users/change' && $this->context->route != 'users/users/moderator' || $this->context->route == 'users/users/view' || $this->context->route == 'users/users/edit-info',
                                'visible' => StaticFunction::checkMenu($methods,'users','users'),

                            ],
                            [
                                'label' => 'Список модераторов',
                                'icon' => ' ',
                                'url' => ['users/users/moderator'],
                                'active' => $this->context->route == 'users/users/moderator' || $this->context->route == 'users/users/moderator-view' || $this->context->route == 'users/users/edit-moderator',
                                'visible' => StaticFunction::checkMenu($methods,'users','moderator'),
                            ],
                            [
                                'label' => 'Блокировка пользователей',
                                'icon' => ' ',
                                'url' => ['users/users-banlist'],
                                'visible' => StaticFunction::checkMenu($methods,'users','users-banlist'),
                                'active' => $this->context->id == 'users/users-banlist'
                            ],
                            [
                                'label' => 'Группы',
                                'icon' => ' ',
                                'url' => ['/users/roles'],
                                'visible' => StaticFunction::checkMenu($methods,'users','roles'),
                                'active' => $this->context->id == 'users/roles'
                            ],
                        ],
                    ],
                    [
                        'label' => 'Счета',
                        'icon' => 'cubes',
                        'visible' => StaticFunction::dropMenu($methods,'bills'),
                        'url' => [''],
                        'active' => ($this->context->route == 'bills/bills/index' || $this->context->route == 'statistics/bills' || $this->context->route == 'bills/top-users/index'),
                        'items' => [
                            [
                                'label' => 'История',
                                'icon' => ' ',
                                'url' => ['bills/bills'],
                                'active' => $this->context->route == 'bills/bills/index',
                                'visible' => StaticFunction::checkMenu($methods,'bills','listing'),
                            ],
                            [
                                'label' => 'Статистика',
                                'icon' => ' ',
                                'url' => ['statistics/bills'],
                                'active' => $this->context->route == 'statistics/bills',
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
                        'active' => $this->context->id == 'banners/banner',
                        'visible' => StaticFunction::checkMenu($methods,'banners','banners'),
                    ],
                    // ['label' => 'Сообщение.', 'icon' => 'send', 'url' => ['#'], /*'active' => $this->context->id == 'chats'*/],
                    [
                        'label' => 'Сообщение',
                        'icon' => 'send',
                        'url' => ['/chats/index?type=1'],
                        'active' => $this->context->id == 'chats',
                        'visible' => StaticFunction::checkMenu($methods,'internalmail','internalmail'),
                    ],
                    [
                        'label' => 'Блог',
                        'visible' => StaticFunction::dropMenu($methods,'blog'),
                        'icon' => 'fas fa-list-alt',
                        'url' => [''],
                        'active' => ($this->context->id == 'blogs/blog-posts' || $this->context->id == 'blogs/blog-categories' || $this->context->id == 'blogs/blog-tags'),
                        'items' => [
                            [
                                'label' => 'Посты',
                                'icon' => ' ',
                                'url' => ['/blogs/blog-posts'],
                                'active' => $this->context->id == 'blogs/blog-posts',
                                'visible' => StaticFunction::checkMenu($methods,'blog','posts'),
                            ],
                            [
                                'label' => 'Категории',
                                'icon' => ' ',
                                'url' => ['/blogs/blog-categories'],
                                'active' => $this->context->id == 'blogs/blog-categories',
                                'visible' => StaticFunction::checkMenu($methods,'blog','categories'),
                            ],
                            [
                                'label' => 'Теги',
                                'icon' => ' ',
                                'url' => ['/blogs/blog-tags'],
                                'active' => $this->context->id == 'blogs/blog-tags',
                                'visible' => StaticFunction::checkMenu($methods,'blog','tags'),
                            ],
                        ],
                    ],
                    [
                        'label' => 'Помощь',
                        'icon' => 'fas fa-info-circle',
                        'visible' => StaticFunction::dropMenu($methods,'help'),
                        'url' => [''],
                        'active' => ($this->context->id == 'references/helps-categories' || $this->context->id == 'references/helps'),
                        'items' => [
                            [
                                'label' => 'Категория',
                                'icon' => ' ',
                                'url' => ['/references/helps-categories'],
                                'active' => $this->context->id == 'references/helps-categories',
                                'visible' => StaticFunction::checkMenu($methods,'help','categories'),
                            ],
                            [
                                'label' => 'Вопросы',
                                'icon' => ' ',
                                'url' => ['/references/helps'],
                                'active' => $this->context->id == 'references/helps',
                                'visible' => StaticFunction::checkMenu($methods,'help','questions'),
                            ],
                        ],
                    ],
                    [
                        'label' => 'Опросы',
                        'icon' => 'list',
                        'url' => ['/references/polls'],
                        'active' => $this->context->id == 'references/polls',
                        'visible' => StaticFunction::checkMenu($methods,'polls','polls') || StaticFunction::checkMenu($methods,'polls','polls-listing'),
                    ],
                    [
                        'label' => 'Страницы',
                        'icon' => 'file-text-o',
                        'url' => ['/references/pages'],
                        'active' => $this->context->id == 'references/pages',
                        'visible' => StaticFunction::checkMenu($methods,'site-pages','site-pages') || StaticFunction::checkMenu($methods,'site-pages','listing'),
                    ],
                    [
                        'label' => 'Контакты',
                        'icon' => 'bug',
                        'url' => ['/references/contacts'],
                        'active' => $this->context->id == 'references/contacts',
                        'visible' => StaticFunction::checkMenu($methods,'contacts','contacts'),
                    ],
                    [
                        'label' => 'Рассылка',
                        'icon' => 'send',
                        'url' => [''],
                        'visible' => StaticFunction::dropMenu($methods,'sendmail'),
                        'active' => ($this->context->id == 'mail/sendmail-massend' || $this->context->id == 'mail/sendmail-template' || $this->context->id == 'alerts'),
                        'items' => [
                            [
                                'label' => 'Список рассылок',
                                'icon' => ' ',
                                'url' => ['/mail/sendmail-massend'],
                                'active' => $this->context->id == 'mail/sendmail-massend',
                                'visible' => StaticFunction::checkMenu($methods,'sendmail','sendmail'),
                            ],
                            [
                                'label' => 'Шаблоны писем',
                                'icon' => ' ',
                                'url' => ['/mail/sendmail-template'],
                                'active' => $this->context->id == 'mail/sendmail-template',
                                'visible' => StaticFunction::checkMenu($methods,'sendmail','sendmail') || StaticFunction::checkMenu($methods,'sendmail','templates-listing'),
                            ],
                            [
                                'label' => 'Уведомления',
                                'icon' => ' ',
                                'url' => ['/alerts'],
                                'active' => $this->context->id == 'alerts',
                                'visible' => StaticFunction::checkMenu($methods,'alerts','alerts') || StaticFunction::checkMenu($methods,'alerts','alerts-listing'),
                            ],
                        ],
                    ],
                    [
                        'label' => 'Карта сайта и меню',
                        'icon' => 'map',
                        'url' => ['/references/sitemap'],
                        'visible' => StaticFunction::dropMenu($methods,'sitemap'),
                        'active' => $this->context->id == 'references/sitemap'
                    ],
                    [
                        'label' => 'SEO',
                        'visible' => StaticFunction::dropMenu($methods,'seo'),
                        'icon' => 'cloud',
                        'url' => [''],
                        'active' => ($this->context->id == 'references/seo/items' || $this->context->id == 'references/seo' || $this->context->id == 'references/redirects' || $this->context->id == 'references/landing-pages'),
                        'items' => [
                            [
                                'label' => 'Объявления',
                                'icon' => ' ',
                                'url' => ['/references/seo/items'],
                                'active' => $this->context->route == 'references/seo/items',
                                'visible' => StaticFunction::checkMenu($methods,'bbs','seo'),
                            ],
                            [
                                'label' => 'Магазины',
                                'icon' => ' ',
                                'url' => ['/references/seo/shops'],
                                'active' => $this->context->route == 'references/seo/shops',
                                'visible' => StaticFunction::checkMenu($methods,'shops','seo'),
                            ],
                            [
                                'label' => 'Пользователи',
                                'icon' => ' ',
                                'url' => ['/references/seo/users'],
                                'active' => $this->context->route == 'references/seo/users',
                                'visible' => StaticFunction::checkMenu($methods,'users','seo'),
                            ],
                            [
                                'label' => 'Блог',
                                'icon' => ' ',
                                'url' => ['/references/seo/blogs'],
                                'active' => $this->context->route == 'references/seo/blogs',
                                'visible' => StaticFunction::checkMenu($methods,'blog','seo'),
                            ],
                            [
                                'label' => 'Помощь',
                                'icon' => ' ',
                                'url' => ['/references/seo/helps'],
                                'active' => $this->context->route == 'references/seo/helps',
                                'visible' => StaticFunction::checkMenu($methods,'help','seo'),
                            ],
                            [
                                'label' => 'Настройки сайта',
                                'icon' => ' ',
                                'url' => ['/references/seo/settings'],
                                'active' => $this->context->route == 'references/seo/settings',
                                'visible' => StaticFunction::checkMenu($methods,'seo','settings'),
                            ],
                            [
                                'label' => 'Посадочные страницы',
                                'icon' => ' ',
                                'url' => ['/references/landing-pages'],
                                'active' => $this->context->id == 'references/landing-pages',
                                'visible' => StaticFunction::checkMenu($methods,'seo','landingpages'),
                            ],
                            [
                                'label' => 'Редиректы',
                                'icon' => ' ',
                                'url' => ['/references/redirects'],
                                'active' => $this->context->id == 'references/redirects',
                                'visible' => StaticFunction::checkMenu($methods,'seo','redirects'),
                            ],
                            [
                                'label' => 'Настройки',
                                'icon' => ' ',
                                'url' => ['/references/seo/robots'],
                                'active' => $this->context->route == 'references/seo/robots',
                            ],
                        ],
                    ],
                    [
                        'label' => 'Настройки сайта',
                        'icon' => 'cogs',
                        'visible' => StaticFunction::dropMenu($methods,'site'),
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
                                'references/vacancies'
                            ]
                        ),
                        'items' => [
                            [
                                'label' => 'Общие настройки',
                                'icon' => ' ',
                                'url' => ['/settings/site-settings'],
                                'visible' => StaticFunction::checkMenu($methods,'site','settings'),
                                'active' => ($this->context->id . '/' . $this->context->action->id == 'settings/site-settings/index')
                            ],
                            [
                                'label' => 'Страны',
                                'icon' => ' ',
                                'url' => ['/references/countries'],
                                'visible' => StaticFunction::checkMenu($methods,'site','site'),
                                'active' => ($this->context->id == 'references/countries')
                            ],
                            [
                                'label' => 'Системные настройки',
                                'icon' => ' ',
                                'url' => ['/settings/system-settings'],
                                'visible' => StaticFunction::checkMenu($methods,'site','settings-system'),
                                'active' => $this->context->id == 'settings/system-settings',
                            ],
                            [
                                'label' => 'Счетчики и код',
                                'icon' => ' ',
                                'url' => ['/references/counters'],
                                'visible' => StaticFunction::checkMenu($methods,'site','counters'),
                                'active' => $this->context->id == 'references/counters',
                            ],
                            [
                                'label' => 'Валюта',
                                'icon' => ' ',
                                'url' => ['/references/currencies'],
                                'visible' => StaticFunction::checkMenu($methods,'site','currencies'),
                                'active' => $this->context->id == 'references/currencies'
                            ],
                            [
                                'label' => 'Локализация',
                                'icon' => ' ',
                                'url' => ['/references/language'],
                                'visible' => StaticFunction::checkMenu($methods,'site','localization'),
                                'active' => ($this->context->id == 'references/language' || $this->context->id == 'source-message')
                            ],
                            //['label' => 'Google Analytics','icon' => ' ', 'url' => ['#'], 'active' => $this->context->id == '#', ],
                            [
                                'label' => 'Бренды',
                                'icon' => ' ',
                                'url' => ['/references/brands'],
                                'visible' => StaticFunction::checkMenu($methods,'brands','brands'),
                                'active' => $this->context->id == 'references/brands'
                            ],
                            // ['label' => 'Настройки', 'icon' => ' ', 'url' => ['/references/settings'], 'active' => $this->context->id == 'references/settings'],
                            [
                                'label' => 'Подписчики',
                                'icon' => ' ',
                                'url' => ['/references/subscribers'],
                                'visible' => StaticFunction::checkMenu($methods,'subscribers','subscribers-listing'),
                                'active' => ($this->context->id == 'references/subscribers')
                            ],
                            [
                                'label' => 'Cоциальные сети',
                                'icon' => ' ',
                                'url' => ['/references/social-networks'],
                                'visible' => StaticFunction::checkMenu($methods,'social-networks','social-networks-listing'),
                                'active' => ($this->context->id == 'references/social-networks')
                            ],
                            [
                                'label' => 'RSS',
                                'icon' => ' ',
                                'url' => ['/references/rss'],
                                'visible' => StaticFunction::checkMenu($methods,'rss','rss'),
                                'active' => ($this->context->id == 'references/rss')
                            ],
                            [
                                'label' => 'Выгрузки сайта',
                                'icon' => ' ',
                                'visible' => StaticFunction::dropMenu($methods,'site'),
                                'url' => ['/settings/site-settings/button-site'],
                                'active' => ($this->context->id . '/' . $this->context->action->id == 'settings/site-settings/button-site')
                            ],
                            [
                                'label' => 'Черный список',
                                'icon' => ' ',
                                'url' => ['/references/black-list'],
                                'visible' => StaticFunction::checkMenu($methods,'black-list','black-list'),
                                'active' => $this->context->id == 'references/black-list'
                            ],
                        ],
                    ],
                    [
                        'label' => 'Ваканции',
                        'icon' => 'cogs',
                        'url' => ['/nothealth'],
                        'visible' => StaticFunction::dropMenu($methods,'vacancies'),
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
                                'visible' => StaticFunction::checkMenu($methods,'vacancies','vacancy-category'),
                                'url' => ['references/vacancy-category'],
                                'active' => $this->context->route == '/references/vacancy-category'
                            ],
                            [
                                'label' => 'Список',
                                'icon' => ' ',
                                'visible' => StaticFunction::checkMenu($methods,'vacancies','vacancies'),
                                'url' => ['/references/vacancies'],
                                'active' => $this->context->route == '/references/vacancies'
                            ],

                        ]
                    ],
                    [
                        'label' => 'Парсер',
                        'icon' => 'cogs',
                        'url' => ['/nothealth'],
                        'visible' => StaticFunction::dropMenu($methods,'parser'),
                        'active' => in_array($this->context->id,
                            [
                                'references/parser',
                                'references/vacancies',
                                'references/parser/olx-business',
                            ]
                        ),
                        'items' => [
                            [
                                'label' => 'Mexnat.uz',
                                'icon' => ' ',
                                'visible' => StaticFunction::checkMenu($methods,'parser','parser-mexnat-uz'),
                                'url' => ['/references/parser'],
                                'active' => $this->context->route == 'references/parser'
                            ],
                            [
                                'label' => 'Парсер-OLX',
                                'icon' => ' ',
                                'visible' => StaticFunction::checkMenu($methods,'parser','parser-olx'),
                                'url' => ['/references/parser/olx'],
                                'active' => $this->context->route == 'references/parser/olx'
                            ],
                            [
                                'label' => 'OLX Бизнес-страница',
                                'icon' => ' ',
                                'visible' => StaticFunction::checkMenu($methods,'parser','olx-business'),
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