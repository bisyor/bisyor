<?php

namespace backend\controllers\items;

use Yii;
use backend\models\items\Items;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \yii\web\Response;
use yii\helpers\Html;
use backend\models\items\ItemsSettings;
use backend\models\searchs\BlackListSearch;
use backend\models\settings\Settings;
use backend\models\searchs\WordformsSearch;
use backend\models\users\RoleMethods;
use yii\web\HttpException;

/**
 * ItemsController реализует действия CRUD для Items модель.
 */
class SettingsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
        $bbs = RoleMethods::getAccess($roles , 'bbs', 'bbs');
        $settings = RoleMethods::getAccess($roles , 'bbs', 'settings');
       
        
        if($bbs && $settings)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);

    }


    /**
     * Lists all Items models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $request = Yii::$app->request;
        
        $model = new ItemsSettings();
        $model->getValueSettingis();

        $share = Settings::find()->where(['key' =>'code_for_the_page_view_ads'])->one();
        if(!$share){
            $share = new Settings();
            $share->key = 'code_for_the_page_view_ads';
            $share->save(false);
        }

        $searchModel = new BlackListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $wordSearchModel = new WordformsSearch();
        $wordDataProvider = $wordSearchModel->search(Yii::$app->request->queryParams);

        if ($model->load($request->post())) {
            $model->setSaveSettings();
            return $this->redirect(['index']);
        }

        if ($share->load($request->post()) && $share->save()) {
            return $this->redirect(['index']);
        }
            

        return $this->render('index', [
            'model' => $model,
            // 'renewal_period' => $renewal_period,
            'share' => $share,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'wordSearchModel' => $wordSearchModel,
            'wordDataProvider' => $wordDataProvider,
        ]);
    }


    /**
     * @param $tab
     * @param $value
     */
    public function actionSetTab($tab, $value)
    {
        $session =  Yii::$app->session;
        $session[$tab] = $value;
    }
}
