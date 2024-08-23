<?php

namespace common\modules\translations\modules\admin;

/**
 * translations module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'common\modules\translations\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        \Yii::configure($this, require __DIR__ . '/config.php');

        // custom initialization code goes here
    }
}
