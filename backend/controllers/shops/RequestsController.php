<?php

namespace backend\controllers\shops;

use backend\models\alerts\Alerts;
use Yii;
use backend\models\shops\Shops;
use backend\models\shops\ShopsSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\HttpException;
use backend\models\users\RoleMethods;

/**
 * ShopsController implements the CRUD actions for Shops model.
 */
class RequestsController extends Controller
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
     * ruxsatlarni tekshirirsh
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
     public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $shops = RoleMethods::getAccess($roles , 'shops', 'shops');
        $shops_requests = RoleMethods::getAccess($roles , 'shops', 'shops-requests');
        
        if($shops && $shops_requests)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($shops_requests)
        {   
           if($action->id =='index' || $action->id =='view' || $action->id =='create' || $action->id =='update' || $action->id =='delete' || $action->id =='bulk-delete' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * @return string
     */
    public function actionIndex()
    {    
        $searchModel = new ShopsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'requests');
       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Shops model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $model = $this->findModel($id);
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> "Просмотрь",
                'size' => 'large',
                'content'=>$this->renderAjax('view', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a('Редактыровать',['/shops/shops/update','id'=>$id],['class'=>'btn btn-primary','data-pjax' => 0])
            ];
        }
        else
        {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }


    /**
     * @param $id
     * @param $tab
     * @return array|Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id, $tab)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            $pjaxId = "$tab-pjax";

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-requests-'.$pjaxId];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }


    /**
     * statusini o'zgartirish uchun
     * @param $id
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionChangeStatus($id)
    {
        $model = $this->findModel($id);
        if($model != null)
            Yii::$app->db->createCommand()
                ->update('shops', ['status' => 1, 'status_changed' => date('Y-m-d H:i:s')], [ 'id' => $model->id ])->execute();
        Alerts::shopsOpenSuccess($model->user_id , $model->keyword);
    }

    public function actionChange($id)
    {
        $model = $this->findModel($id);
        $request = Yii::$app->request;

        if($request->isAjax){
            if($model->load($request->post()) && $model->save()){
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-requests-'.$pjaxId];
            }else{
                return [
                    'title'=> "Изменить",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'langs' => $langs
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Редактыровать',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }
        }
    }


    /**
     * @param $id
     * @return Shops|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Shops::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
