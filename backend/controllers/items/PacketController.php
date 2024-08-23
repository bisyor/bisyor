<?php

namespace backend\controllers\items;

use Yii;
use backend\models\shops\Services;
use backend\models\shops\ShopModels;
use backend\models\shops\RegionalPrices;
use backend\models\shops\ServicesSearch;
use backend\models\items\PaketsService;
use backend\models\references\Lang;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use Cocur\Slugify\Slugify;
use backend\models\users\RoleMethods;
use yii\web\HttpException;
/**
 * ServicesController implements the CRUD actions for Services model.
 */
class PacketController extends Controller
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
        $bbs = RoleMethods::getAccess($roles , 'bbs', 'bbs');
        $svc  = RoleMethods::getAccess($roles , 'bbs', 'svc');
        
        if($bbs && $svc)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($svc)
        {   
            if($action->id =='create' || $action->id =='update' || $action->id =='delete')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }
       
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);

    }

    /**
     * Lists all Services models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new ServicesSearch();
        $dataProvider = $searchModel->searchAdsPackets(Yii::$app->request->queryParams);
       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Services model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Services model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $langs = Lang::getLanguages();

        $model = new Services();

        $model->type = 2;
        $model->module = Services::MODULE_BBS;

        $modelsRegionalPrices = [new RegionalPrices];
        $serviceModels = $model->getServices();


        if ($model->load($post)) {
            $modelsRegionalPrices = ShopModels::createMultiple(RegionalPrices::classname(), $modelsRegionalPrices);
            ShopModels::loadMultiple($modelsRegionalPrices, $post);
            PaketsService::loadMultiple($serviceModels, $post);
           
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsRegionalPrices),
                    ActiveForm::validateMultiple($serviceModels),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = ShopModels::validateMultiple($modelsRegionalPrices) && $valid;
            $valid = PaketsService::validateMultiple($serviceModels) && $valid;
                        
            if ($valid) {
                $slugify = new Slugify();
                $model->keyword = $slugify->slugify($model->title);
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        $model->UploadImage();
                        $model->SaveTranslates($post,$langs);
                        $model->saveServices($serviceModels);

                        foreach ($modelsRegionalPrices as $modelRegionalPrice) {
                            $modelRegionalPrice->service_id = $model->id;
                            if (! ($flag = $modelRegionalPrice->save(false))) {
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
            'langs' => $langs,
            'serviceModels' => $serviceModels,
            'modelsRegionalPrices' => (empty($modelsRegionalPrices)) ? [new RegionalPrices] : $modelsRegionalPrices
        ]);
    }
    /**
     * Updates an existing Services model.
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
        $langs = Lang::getLanguages();
        $model->getTranslations($langs);   
        
        $modelsRegionalPrices = $model->regionalPrices;
        $serviceModels = $model->getServices();

        if ($model->load($post)) {

            $oldIDs = ArrayHelper::map($modelsRegionalPrices, 'id', 'id');
            $modelsRegionalPrices = ShopModels::createMultiple(RegionalPrices::classname(), $modelsRegionalPrices);
            ShopModels::loadMultiple($modelsRegionalPrices, $post);
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsRegionalPrices, 'id', 'id')));

            PaketsService::loadMultiple($serviceModels, $post);
           
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsRegionalPrices),
                    ActiveForm::validateMultiple($serviceModels),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = ShopModels::validateMultiple($modelsRegionalPrices) && $valid;
            $valid = PaketsService::validateMultiple($serviceModels) && $valid;
                        
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        $model->UploadImage();
                        $model->SaveTranslates($post,$langs);
                        $model->saveServices($serviceModels);
                        if (! empty($deletedIDs)) {
                            RegionalPrices::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsRegionalPrices as $modelRegionalPrice) {
                            $modelRegionalPrice->service_id = $model->id;
                            if (! ($flag = $modelRegionalPrice->save(false))) {
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
            'langs' => $langs,
            'serviceModels' => $serviceModels,
            'modelsRegionalPrices' => (empty($modelsRegionalPrices)) ? [new RegionalPrices] : $modelsRegionalPrices
        ]);
    }

    /**
     * Delete an existing Services model.
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
     * Delete multiple existing Services model.
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
     * Finds the Services model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Services the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Services::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCkeditor_image_upload()
    {       
        $funcNum = $_REQUEST['CKEditorFuncNum'];

        if($_FILES['upload']) {

        if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name']))) {
          $message = Yii::t('app', "Please Upload an image.");
        }

          else if ($_FILES['upload']["size"] == 0 OR $_FILES['upload']["size"] > 5*1024*1024)
          {
          $message = Yii::t('app', "The image should not exceed 5MB.");
          }

          else if ( ($_FILES['upload']["type"] != "image/jpg") 
                    AND ($_FILES['upload']["type"] != "image/jpeg") 
                    AND ($_FILES['upload']["type"] != "image/png"))
          {
          $message = Yii::t('app', "The image type should be JPG , JPEG Or PNG.");
          }

          else if (!is_uploaded_file($_FILES['upload']["tmp_name"])){

          $message = Yii::t('app', "Upload Error, Please try again.");
          }

          else {
            //you need this (use yii\db\Expression;) for RAND() method 
            //$random = rand(0123456789, 9876543210);
            $random = 1232;

            $extension = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);

            //Rename the image here the way you want
            $name = date("m-d-Y-h-i-s", time())."-".$random.'.'.$extension; 

            // Here is the folder where you will save the images
            $folder = 'uploads/ckeditor_images/';  

            // $url = Yii::$app->urlManager->createAbsoluteUrl($folder.$name);
            $url =  $path = 'http://' . $_SERVER['SERVER_NAME'].'/uploads/ckeditor_images/'.$name;
            move_uploaded_file( $_FILES['upload']['tmp_name'], $folder.$name );

          }

          echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'
               .$funcNum.'", "'.$url.'", "'.$message.'" );</script>';

        }
    }
}
