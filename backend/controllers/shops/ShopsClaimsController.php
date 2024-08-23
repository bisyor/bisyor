<?php

namespace backend\controllers\shops;

use Yii;
use backend\models\shops\ShopsClaims;
use backend\models\shops\ShopsClaimsSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\HttpException;
use backend\models\users\RoleMethods;

/**
 * ShopsController implements the CRUD actions for Shops model.
 */
class ShopsClaimsController extends Controller
{
    /**
     * {@inheritdoc}
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * shu controlerga tegishli ruxatlarni tekshirish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $shops = RoleMethods::getAccess($roles , 'shops', 'shops');
        $claims_listing = RoleMethods::getAccess($roles , 'shops', 'claims-listing');
        $claims_edit = RoleMethods::getAccess($roles , 'shops', 'claims-edit');
       
        if($shops && $claims_listing && $claims_edit)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($claims_listing)
        {   
           if($action->id =='index' || $action->id =='view' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($claims_edit)
        {   
           if($action->id =='create' || $action->id =='update' || $action->id =='delete' || $action->id =='bulk-delete' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * shops claims lists
     * @return string
     */
    public function actionIndex()
    {
        $searchModelActive = new SHopsClaimsSearch();
        $dataProviderActive = $searchModelActive->search(Yii::$app->request->queryParams,false);

        $searchModelInactive = new SHopsClaimsSearch();
        $dataProviderInactive = $searchModelInactive->search(Yii::$app->request->queryParams,true);

        return $this->render('index', [
            'searchModelActive' => $searchModelActive,
            'dataProviderActive' => $dataProviderActive,
            'searchModelInactive' => $searchModelInactive,
            'dataProviderInactive' => $dataProviderInactive
        ]);
    }


    /**
     * Displays a single Shops model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Жалобы №".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }


    /**
     * Creates a new Shops model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopsClaims();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Shops model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * @param $id
     * @param null $tab
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionCheck($id, $tab = null)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->viewed = 1;
        $model->save(false);
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            $pjaxId = isset($tab) ? "$tab-pjax" : "pjax";

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-claims-'.$pjaxId];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }


    /**
     * Deletes an existing Shops model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
        if (($model = ShopsClaims::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
