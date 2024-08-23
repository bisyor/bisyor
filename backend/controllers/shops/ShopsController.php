<?php

namespace backend\controllers\shops;

use backend\models\shops\ShopsCommentSearch;
use backend\models\shops\ShopsRatingSearch;
use backend\models\shops\ShopsSubscribersSearch;
use Yii;
use backend\models\shops\Shops;
use backend\models\shops\ShopModels;
use backend\models\shops\ShopSocialNetworks;
use backend\models\shops\ShopsSearch;
use backend\models\shops\ShopsClaimsSearch;
use backend\models\shops\ShopsTariffSearch;
use backend\models\items\ItemsSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\ArrayHelper;
use backend\models\shops\ShopSliderSearch;
use yii\bootstrap\ActiveForm;
use yii\web\HttpException;
use backend\models\users\RoleMethods;

/**
 * ShopsController implements the CRUD actions for Shops model.
 */
class ShopsController extends Controller
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
     * shu controllerga tegishli ruxsatlarni tekshirish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $shops = RoleMethods::getAccess($roles , 'shops', 'shops');
        $shops_listing = RoleMethods::getAccess($roles , 'shops', 'shops-listing');
        $shops_edit = RoleMethods::getAccess($roles , 'shops', 'shops-edit');
       
        if($shops && $shops_listing && $shops_edit)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($shops_listing)
        {   
           if($action->id =='index' || $action->id =='view' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($shops_edit)
        {   
           if($action->id =='create' || $action->id =='update' || $action->id =='delete' || $action->id =='bulk-delete' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);

    }


    /**
     * Lists all Shops models.
     * @return mixed
     */
    public function actionIndex($id = null,$user_id = null)
    {    
 
        if($id){
            Yii::$app->request->setQueryParams(
                    [
                            'ShopsSearch' => [
                                    'sections' => $id
                            ],
                    ]
            );   
            $id = null;
        }

        if($user_id){
            Yii::$app->request->setQueryParams(
                    [
                            'ShopsSearch' => [
                                    'user_id' => $user_id
                            ],
                    ]
            );   
            $user_id = null;
        }
        


        $searchModel = new ShopsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @return string
     */
    public function actionRequests()
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
    public function actionView($id,$items = 0)
    {   
        $queryParams = Yii::$app->request->queryParams;
        //tab 1
        $model = $this->findModel($id);

        //tab 2
        $searchModelClaims = new SHopsClaimsSearch();
        $dataProviderClaims = $searchModelClaims->search($queryParams,$id);

        //tab4
        $searchModelTarifs = new ShopsTariffSearch();
        $dataProviderTarifs = $searchModelTarifs->search($queryParams,$id);

        //tab 5
        $itemsSearchModel = new ItemsSearch();
        $itemsDataProvider= $itemsSearchModel->searchShopItem($queryParams,$id);

        //tab 6
        $searchModelSlider = new ShopSliderSearch();
        $dataProviderSlider = $searchModelSlider->search($queryParams,$id);

        //tab 7
        $searchModelComment = new ShopsCommentSearch();
        $dataProviderComment = $searchModelComment->search($queryParams,$id);

        //tab 8
        $searchModelRating = new ShopsRatingSearch();
        $dataProviderRating = $searchModelRating->search($queryParams,$id);

        //tab 9
        $searchModelSubscribers = new ShopsSubscribersSearch();
        $dataProviderSubscribers = $searchModelSubscribers->search($queryParams,$id);
    
        return $this->render('view', [
            'model' => $model,

            'searchModelClaims' => $searchModelClaims,
            'dataProviderClaims' => $dataProviderClaims,

            'searchModelTarifs' => $searchModelTarifs,
            'dataProviderTarifs' => $dataProviderTarifs,
            
            'itemsSearchModel' => $itemsSearchModel,
            'itemsDataProvider' => $itemsDataProvider,

            'searchModelSlider' => $searchModelSlider,
            'dataProviderSlider' => $dataProviderSlider,

            'searchModelComment' => $searchModelComment,
            'dataProviderComment' => $dataProviderComment,

            'searchModelRating' => $searchModelRating,
            'dataProviderRating' => $dataProviderRating,

            'searchModelSubscribers' => $searchModelSubscribers,
            'dataProviderSubscribers' => $dataProviderSubscribers,

            'active_tab' => ($items == 1) ? 'tab-5' : '',
        ]);
        
    }


    /**
     * Creates a new Shops model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($user_id = null)
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $model = new Shops;
        $modelNetworks = [new ShopSocialNetworks];
        
        if($user_id) { 
            $model->user_id = $user_id;
        }

        if ($model->load($post)) {

            $modelNetworks = ShopModels::createMultiple(ShopSocialNetworks::classname());
            ShopModels::loadMultiple($modelNetworks, $post);

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelNetworks),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = ShopModels::validateMultiple($modelNetworks) && $valid;
            $model->SavePhones();
            if ($valid) {
                if ($model->save(false)) {
                    $model->saveSections();
                    $model->saveNetworks($modelNetworks);
                    $model->UploadImage();
                    return $this->redirect(['view','id' => $model->id]);
                }else{
                    return $this->render('create', [
                        'model' => $model,
                        'modelNetworks' => (empty($modelNetworks)) ? [new ShopSocialNetworks] : $modelNetworks
                    ]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelNetworks' => (empty($modelNetworks)) ? [new ShopSocialNetworks] : $modelNetworks
        ]);
    }


    /**
     * Updates an existing Shops model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $model = $this->findModel($id);
        
        $modelNetworks = $model->getNetworks();
        $model->getPhones();

        if ($model->load($post)) {
            $oldIDs = ArrayHelper::map($modelNetworks, 'id', 'id');
            $modelNetworks = ShopModels::createMultiple(ShopSocialNetworks::classname(), $modelNetworks);
            ShopModels::loadMultiple($modelNetworks, $post);
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelNetworks, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelNetworks),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = ShopModels::validateMultiple($modelNetworks) && $valid;
            $model->SavePhones();
            if ($valid) {
                if ($model->save(false)) {
                    $model->saveSections();
                    $model->saveNetworks($modelNetworks);
                    $model->UploadImage();
                    return $this->redirect(['view','id' => $model->id]);
                }else{
                    return $this->render('create', [
                        'model' => $model,
                        'modelNetworks' => (empty($modelNetworks)) ? [new ShopSocialNetworks] : $modelNetworks
                    ]);
                }
            }           
        }

        return $this->render('update', [
            'model' => $model,
            'modelNetworks' => (empty($modelNetworks)) ? [new ShopSocialNetworks] : $modelNetworks
        ]);
    }

    public function actionChangeValues()
    {
        $id = $_POST['id'];
        $model = Shops::findOne($id);
        if($model->is_verify == 0) {$model->is_verify = 1;}
        else {$model->is_verify = 0;}
        $model->save(false);
    }


    /**
     * Delete an existing Shops model.
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
     * Delete multiple existing Shops model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

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
     * Finds the Shops model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shops the loaded model
     * @throws NotFoundHttpException if the model cannot be found
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
