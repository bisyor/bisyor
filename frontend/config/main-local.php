<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
<<<<<<< HEAD
            'cookieValidationKey' => 'QqiJocroDwU5rIkAIFl6i16ncEqhRrG4',
=======
            'cookieValidationKey' => 'bHZFf_dt9Yd0KRKi15TAkiSGQZu51g8-',
>>>>>>> 1ac6b7ba988d8179e7a8ef7233b4b57430bf3263
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
