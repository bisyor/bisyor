<?php

namespace backend\controllers\references;

use backend\models\users\RoleMethods;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\HttpException;

/**
 * ContactsController implements the CRUD actions for Contacts model.
 */
class RssController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $rss = RoleMethods::getAccess($roles , 'rss', 'rss');

        if($rss)
        {
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');

    }

    public function actionSalom()
    {
       echo '<pre>';
       print_r('salom actioni');
       die;
        
    }

   
}
