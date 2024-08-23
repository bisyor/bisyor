<?php

namespace backend\controllers\promocodes;

use backend\models\users\RoleMethods;
use backend\models\users\Users;
use Yii;
use backend\models\promocodes\PromocodesUsage;
use backend\models\promocodes\PromocodesUsageSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * PromocodesUsageController implements the CRUD actions for PromocodesUsage model.
 */
class PromocodesUsageController extends Controller
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


    /**
     * shu controllerga tegishli ruxsatlarni tekshirrish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $promocodes = RoleMethods::getAccess($roles , 'promocodes', 'promocodes');
        $statistika = RoleMethods::getAccess($roles , 'promocodes', 'statistika');

        if($promocodes && $statistika)
        {
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($statistika)
        {
            if($action->id =='index' || $action->id =='view' || $action->id =='create' || $action->id =='update')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * Lists all and skidka and popolneniya PromocodesUsage models.
     * @return mixed
     */
    public function actionIndex($code=null)
    {    
        $searchModel = new PromocodesUsageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '0', $code);
        $dataSkidka = $searchModel->search(Yii::$app->request->queryParams, '1', $code);
        $dataPopolneniya = $searchModel->search(Yii::$app->request->queryParams, '2', $code);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataSkidka' => $dataSkidka,
            'dataPopolneniya' => $dataPopolneniya,
        ]);
    }


    /**
     * Finds the PromocodesUsage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PromocodesUsage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PromocodesUsage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Информация о пользователе
     * @param $id
     * @return array
     */
    public function actionUsers($id){
        $request = Yii::$app->request;
        if ($request->isAjax){
            $model = Users::findOne($id);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
//                'forceReload'=>'#crud-datatable-pjax',
                'title'=> "Информация о пользователе",
                'content'=>$this->renderAjax('view', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"])
            ];
        }
    }

}
