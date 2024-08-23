<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' =>'ru',
    'sourceLanguage'=>'ru-RU',
    'name' => 'Bisyor.uz',
    'timeZone' =>'Asia/Tashkent',
    'defaultRoute' =>'ads',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
        'translations' => [
            'class' => 'common\modules\translations\modules\admin\Module'
        ]
    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                        'js'=>[],   
                    ],
                'yii\web\JqueryAsset' => [
                        'js'=>[]
                    ],
                'yii\bootstrap\BootstrapAsset' => [
                        'css' => [],
                    ],
                  
            ],
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
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '',
            
        ],
         'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
            ],
            // 'class' => 'codemix\localeurls\UrlManager',
            // 'languages' => ['kr','uz', 'ru'],
            // 'on languageChanged' => '\common\models\PreferenceBooks::onLanguageChanged',
        ],
        'yandexMapsApi' => [
            'class' => 'backend\components\YandexMapsApi',
        ],
        'zipper' => [
            'class' => 'Victor78\Zipper\Zipper', //required
            'type' => '7zip', //or 'zip' (default), 'tar', 'tar.gz', 'tar.bz2'
            'password' => '', //optional, only for 7zip type
        ],
        'mailer' => [ 
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'bisyorrobot@gmail.com',
                'password' => 'flgyagntalabdpsx',
                'port' => '465',
                'encryption' => 'ssl',
                'streamOptions' => [ 
                    'ssl' => [ 
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ]
            ],
        ],
        

        
    ],
    'params' => $params,
];
