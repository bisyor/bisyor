<?php

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/main.php',
    require __DIR__ . '/main-local.php',
    require __DIR__ . '/test.php',
    require __DIR__ . '/test-local.php',
    [
        'components' => [
            'request' => [
                // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
<<<<<<< HEAD
                'cookieValidationKey' => 'SLr_fE5DFH1GUFcvxhaocP7sPDnZXhZx',
=======
                'cookieValidationKey' => '9UkssqopCQM_V-AEQnaPWeQQr1UQgKtT',
>>>>>>> 1ac6b7ba988d8179e7a8ef7233b4b57430bf3263
            ],
        ],
    ]
);
