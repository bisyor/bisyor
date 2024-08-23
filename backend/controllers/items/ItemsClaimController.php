<?php

namespace backend\controllers\items;

use Yii;
use backend\models\items\ItemsClaim;
use backend\models\items\ItemsClaimSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use backend\models\users\RoleMethods;
use yii\web\HttpException;
use yii\filters\AccessControl;

/**
 * ItemsClaimController implements the CRUD actions for ItemsClaim model.
 */
class ItemsClaimController extends Controller
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
     * shu controllerga ruxsatni tekshirish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $bbs = RoleMethods::getAccess($roles , 'bbs', 'bbs');
        $claims_listing = RoleMethods::getAccess($roles , 'bbs', 'claims-listing');
        $claims_edit = RoleMethods::getAccess($roles , 'bbs', 'claims-edit');
        
        if($bbs && $claims_listing && $claims_edit )
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($claims_edit)
        {   
            if($action->id =='create' || $action->id =='update' || $action->id =='delete')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($claims_listing)
        {   
            if($action->id =='view' || $action->id =='index' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);

    }


    /**
     * jalbalar listi
     * @return string
     */
    public function actionIndex()
    {    
        $searchModelAll = new ItemsClaimSearch();
        $dataProviderAll = $searchModelAll->search(Yii::$app->request->queryParams);

        $searchModelActive = new ItemsClaimSearch();
        $dataProviderActive = $searchModelActive->searchActive(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModelAll' => $searchModelAll,
            'dataProviderAll' => $dataProviderAll,

            'searchModelActive' => $searchModelActive,
            'dataProviderActive' => $dataProviderActive,
        ]);
    }


    /**
     * Displays a single ItemsClaim model.
     * @param integer $id
     * @return mixed
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
     * @param $id
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionCheck($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->viewed = 1;
        $model->save(false);
        
        $tab = isset($_COOKIE["tab-item-claims"]) && $_COOKIE["tab-item-claims"] != 'undefined' ? $_COOKIE["tab-item-claims"] : 'tab-1';
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-items-'.$tab];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }


    /**
     * Delete an existing ItemsClaim model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        $tab = isset($_COOKIE["tab-item-claims"]) && $_COOKIE["tab-item-claims"] != 'undefined' ? $_COOKIE["tab-item-claims"] : 'tab-1';
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-items-'.$tab];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

     /**
     * Delete multiple existing ItemsClaim model.
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
        $tab = isset($_COOKIE["tab-item-claims"]) && $_COOKIE["tab-item-claims"] != 'undefined' ? $_COOKIE["tab-item-claims"] : 'tab-1';
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-items-'.$tab];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the ItemsClaim model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ItemsClaim the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ItemsClaim::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
