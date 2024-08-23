<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'sourceLanguage'=>'ru-RU',
    'language' => 'ru',
    'timeZone' => 'Asia/Tashkent',
    'name' => 'Bisyor.uz',
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
            'translations' => [
                'class' => 'common\modules\translations\modules\admin\Module'
            ]
    ],
    'components' => [
        'request' => [
            'baseUrl' => '/admin',
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'i18n' => [
            'translations' => [
                 'app' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable'=>'{{%source_message}}',
                    'messageTable'=>'{{%message}}',
                    'sourceLanguage' => 'ru',
                    'forceTranslation' => true,
                ],
            ],
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableLanguageDetection' => false,
            'enableDefaultLanguageUrlCode' => true,
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['af','en', 'ar', 'az', 'be', 'bg', 'bs', 'cs', 'da', 'de', 'el', 'es', 'et', 'fa', 'fi', 'fr', 'he', 'hr', 'hu', 'hy', 'id', 'it', 'ja', 'ka', 'kk', 'ko', 'kz',  'lv', 'ms', 'nb-NO', 'nl', 'pl', 'pt', 'pt-BR', 'ro', 'ru', 'sk', 'sl', 'sr', 'sr-Latn', 'sv', 'tg', 'th', 'tr', 'uk', 'uz', 'vi', 'zh-CN', 'zh-TW','kr'],
            // 'on languageChanged' => '\common\models\PreferenceBooks::onLanguageChanged',
            'enableDefaultLanguageUrlCode' => false,
            'rules'=>[
                '/' => 'site/index',
                '<controller:\w+>/<action:\w+>/'=>'<controller>/<action>',

            ],        ],
        
    ],
    'params' => $params,
];
 
