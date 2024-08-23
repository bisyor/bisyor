<?php

namespace backend\controllers\shops;
use Yii;
use backend\models\shops\ShopsAbonements;
use backend\models\shops\TariffServiceDiscount;
use backend\models\shops\ShopsAbonementPeriod;
use backend\models\shops\ShopsAbonementsSearch;
use backend\models\shops\ShopModels;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use backend\models\references\Lang;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use backend\models\users\RoleMethods;


/**
 * ShopsAbonementsController implements the CRUD actions for ShopsAbonements model.
 */
class ShopsAbonementsController extends Controller
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
     * shu controllerga tegishli ruxsatlarni tekshirrish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $shops = RoleMethods::getAccess($roles , 'shops', 'shops');
        $abonement = RoleMethods::getAccess($roles , 'shops', 'abonement');
       
        if($shops && $abonement )
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($abonement)
        {   
           if($action->id =='create' || $action->id =='update' || $action->id =='delete' || $action->id =='bulk-delete' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * shops abonements lists
     * @return string
     */
    public function actionIndex()
    {    
        $searchModel = new ShopsAbonementsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionTest()
    {
        $request = Yii::$app->request;
        if($request->post()){
            return $this->render('test',['post' => $_POST]);            
        }else{
            return $this->render('test');
        }
    }


    /**
     * @return mixed|string|null
     * @throws NotFoundHttpException
     */
    public function actionSetValue()
    {
        $id = $_POST['id'];
        $field = $_POST['field'];
        $value = $_POST['value'];
        $model = $this->findModel($id);
        if($model){
            $model->$field = $value;
            $model->save(false);
            return $model->$field;
        }
        return "not found";
    }


    /**
     * Displays a single ShopsAbonements model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $langs = Lang::getLanguages();
        $model->getTranslations($langs);   

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Просмотр",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'langs' => $langs
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Редактыровать',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $model,
                'langs' => $langs
            ]);
        }
    }


    /**
     * Creates a new ShopsAbonements model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $langs = Lang::getLanguages();

        $model = new ShopsAbonements;
        $model->is_free = 0;
        $model->price_free_period = 1;
        $modelsPeriods = [new ShopsAbonementPeriod];
        $modelsDisconts = $model->getDiscountModels();
        
        if ($model->load($post)) {
        
            $modelsPeriods = ShopModels::createMultiple(ShopsAbonementPeriod::classname());
            ShopModels::loadMultiple($modelsPeriods, $post);
            TariffServiceDiscount::loadMultiple($modelsDisconts, $post);

            // validate all models
            $valid = $model->validate();
            $valid = TariffServiceDiscount::validateMultiple($modelsDisconts) && $valid;

            if($model->is_free == 0){
                $valid = ShopModels::validateMultiple($modelsPeriods) && $valid;
                
            }elseif($valid){
                $model->save(false);
                $model->UploadImage();
                $model->saveDiscountModels($modelsDisconts);
                $model->SaveTranslates($post,$langs);
                return $this->redirect(['index']);
            }
            
            if ($valid && $model->is_free == 0) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        $model->UploadImage();
                        $model->saveDiscountModels($modelsDisconts);
                        $model->SaveTranslates($post,$langs);
                        
                        foreach ($modelsPeriods as $modelPeriod) {
                            $modelPeriod->abonement_id = $model->id;
                            if (! ($flag = $modelPeriod->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['index']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'titles' => null,
            'langs' => $langs,
            'modelsDisconts' => $modelsDisconts,
            'modelsPeriods' => (empty($modelsPeriods)) ? [new ShopsAbonementPeriod] : $modelsPeriods
        ]);
    }


    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $post = $request->post();

        $model = $this->findModel($id);
        $langs = Lang::getLanguages();
        $model->getTranslations($langs);   
        
        $modelsDisconts = $model->getDiscountModels();
        $modelsPeriods = $model->shopsAbonementPeriods;

        if ($model->load($post)) {
            $oldIDs = ArrayHelper::map($modelsPeriods, 'id', 'id');
            $modelsPeriods = ShopModels::createMultiple(ShopsAbonementPeriod::classname(), $modelsPeriods);
            ShopModels::loadMultiple($modelsPeriods, $post);
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsPeriods, 'id', 'id')));
            TariffServiceDiscount::loadMultiple($modelsDisconts, $post);

            // validate all models
            $valid = $model->validate();
            $valid = TariffServiceDiscount::validateMultiple($modelsDisconts) && $valid;

            if($model->is_free == 0){
                $valid = ShopModels::validateMultiple($modelsPeriods) && $valid;
            }elseif($valid){
                $model->save(false);
                $model->UploadImage();
                $model->saveDiscountModels($modelsDisconts);
                $model->SaveTranslates($post,$langs);
                return $this->redirect(['index']);
            }
            
            if ($valid && $model->is_free == 0) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        $model->UploadImage();
                        $model->saveDiscountModels($modelsDisconts);
                        $model->SaveTranslates($post,$langs);
                        if (! empty($deletedIDs)) {
                            ShopsAbonementPeriod::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsPeriods as $modelPeriod) {
                            $modelPeriod->abonement_id = $model->id;
                            if (! ($flag = $modelPeriod->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['index']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsDisconts' => $modelsDisconts,
            'langs' => $langs,
            'modelsPeriods' => (empty($modelsPeriods)) ? [new ShopsAbonementPeriod] : $modelsPeriods
        ]);
    }


    /**
     * Delete an existing ShopsAbonements model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->delete();

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
     * Delete multiple existing ShopsAbonements model.
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
     * Finds the ShopsAbonements model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopsAbonements the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopsAbonements::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
