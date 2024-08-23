<?php

namespace backend\controllers\promocodes;

use backend\models\users\RoleMethods;
use Yii;
use backend\models\promocodes\Promocodes;
use backend\models\promocodes\PromocodesSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * PromocodesController implements the CRUD actions for Promocodes model.
 */
class PromocodesController extends Controller
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
        $promocodes_settings = RoleMethods::getAccess($roles , 'promocodes', 'promocodes-settings');

        if($promocodes && $promocodes_settings)
        {
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($promocodes_settings)
        {
            if($action->id =='index' || $action->id =='view' || $action->id =='create' || $action->id =='update')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * Lists all Promocodes models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new PromocodesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataActive = $searchModel->search(Yii::$app->request->queryParams, 'active');
        $dataDeactive = $searchModel->search(Yii::$app->request->queryParams, 'deactive');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataActive' => $dataActive,
            'dataDeactive' => $dataDeactive,
        ]);
    }


    /**
     * Creates a new Promocodes model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Promocodes();
        $model->code = $model->codeGenerate();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=> '#crud-datatable-pjax',
                    'forceClose' => true
                ];         
            }else{           
                return [
                    'title'=> "Создать",
                    'size' => 'large',
                    'content'=>$this->renderAjax('create', ['model' => $model]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }


    /**
     * Updates an existing Promocodes model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'forceClose' => true
                ];    
            }else{
                 return [
                    'title'=> "Изменить",
                     'size' => 'large',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }


    /**
     * statusini ozgartirish
     * @return bool|int|null
     * @throws NotFoundHttpException
     */
    public function actionActiveChange(){
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        if($model->active == 1) {
            $model->active = 0;
        }
        else {
            $model->active = 1;
        }
        $model->save(false);
        return $model->active;
    }


    /**
     * Finds the Promocodes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Promocodes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Promocodes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
