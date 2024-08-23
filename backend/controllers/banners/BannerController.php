<?php

namespace backend\controllers\banners;

use Yii;
use backend\models\banners\Banners;
use backend\models\banners\BannersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\HttpException;  
use backend\models\banners\BannersItems;
use backend\models\banners\BannersStatistic;
use backend\models\users\RoleMethods;

/**
 * BannersController implements the CRUD actions for Banners model.
 */
class BannerController extends Controller
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
                ],
            ],
        ];
    }


    /**
     * check permission
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $banners = RoleMethods::getAccess($roles , 'banners', 'banners');
        $listing = RoleMethods::getAccess($roles , 'banners', 'listing');
        $edit = RoleMethods::getAccess($roles , 'banners', 'edit');
       
        if($banners && $edit && $listing)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($listing)
        {   
            if($action->id =='index' || $action->id =='view' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($edit)
        {   
            if($action->id =='delete' || $action->id =='update')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * banner index
     * @return string
     */
    public function actionIndex()
    {    
        $searchModel = new BannersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * banner details
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;

        $itemsSearchModel = new BannersItems();
        $itemsDataProvider = $itemsSearchModel->search(Yii::$app->request->queryParams, $id);

        $statisticSearchModel = new BannersStatistic();
        $statisticDataProvider = $statisticSearchModel->search(Yii::$app->request->queryParams, $id);        

        return $this->render('view', [
            'model' => $this->findModel($id),
            'itemsDataProvider' => $itemsDataProvider,
            'statisticDataProvider' => $statisticDataProvider,
        ]);
    } 

    /**
     * Creates a new Banners model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Banners();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Создать",
                    'content'=>'<span class="text-success">Успешно выполнено</span>',
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Создать',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Создать",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
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
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Banners model.
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
            if($model->load($request->post()) && $model->save()) {
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];       
            } else {
                 return [
                    'title'=> "Изменить",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                echo '<pre>';
                print_r($request->post());
                die;
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Banners model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Banners model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banners the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banners::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }


    /**
     * statusini o'zgartirish
     * @throws NotFoundHttpException
     */
    public function actionChangeEnabled()
    {
        $request = Yii::$app->request;
        $id = $request->post('id');

        $model = $this->findModel($id);
        if($model->enabled == 0){
            $model->enabled = 1;
        }else{
            $model->enabled = 0;
        }
        $model->save();     
    }


    /**
     * tablarni ozgartirishda eslab qolish
     * @param $tab
     * @param $value
     */
    public function actionSetTab($tab, $value)
    {
        $session = Yii::$app->session;
        $session[$tab] = $value;
    }
}
