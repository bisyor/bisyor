<?php


use common\models\User;

return [
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'allow' => true,
                'roles' => ['@'],
            ]
        ],
    ],
];