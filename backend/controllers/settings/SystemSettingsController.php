<?php
namespace backend\controllers\settings;

use Yii;
use backend\models\settings\SystemSettings;
use yii\web\HttpException;  
use backend\models\users\RoleMethods;
use yii\filters\VerbFilter;


class SystemSettingsController extends SettingsController
{   
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


    /**
     * shu controllerga tegishli ruxsatlarni tekshirirsh
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $site = RoleMethods::getAccess($roles , 'site', 'site');
        $settings_system = RoleMethods::getAccess($roles , 'site', 'settings-system');
       
        if($site && $settings_system)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($settings_system)
        {   
            if($action->id =='index')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }


        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $post = Yii::$app->request->post();
        $model = new SystemSettings();

        if($model->load($post) && $model->validate()){
            $model->saveModel($post);
            Yii::$app->session->setFlash('success', 'Изменения сохранены.');
            return $this->redirect(['index']);
        }else{
            return $this->render('index',[
                'model' => $model,
            ]);
        }
    }

}

