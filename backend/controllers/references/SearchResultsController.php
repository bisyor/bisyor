<?php

namespace backend\controllers\references;

use backend\models\users\RoleMethods;
use Yii;
use backend\models\references\SearchResults;
use backend\models\searchs\SearchResultsSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;

/**
 * SearchResultsController implements the CRUD actions for SearchResults model.
 */
class SearchResultsController extends Controller
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
        $bbs = RoleMethods::getAccess($roles , 'bbs', 'bbs');
        $search_results = RoleMethods::getAccess($roles , 'bbs', 'search-results');
        $search_results_setiings = RoleMethods::getAccess($roles , 'bbs', 'search-results-settings');

        if($bbs || $search_results)
        {
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($search_results_setiings)
        {
            if($action->id =='delete' || $action->id =='view')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Lists all SearchResults models.
     * @return mixed
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $searchModel = new SearchResultsSearch();
        $dataProvider = $searchModel->search($request->queryParams);
        $get = $request->get();
//        echo '<pre>';
//        print_r($get); die;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'get' => $get,
        ]);
    }


    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {    
        $searchRes = SearchResults::findOne($id);
        $searchModel = new SearchResultsSearch();
        $dataProvider = $searchModel->searchView(Yii::$app->request->queryParams, $id);

        return $this->render('view', [
            'searchRes' => $searchRes,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @param $id
     * @return string
     */
    public function actionViewDistricts($pid , $region_id)
    {
        $searchRes = SearchResults::find()
            ->andWhere(['id' =>$pid ])
            ->one();

        $searchModel = new SearchResultsSearch();
        $dataProvider = $searchModel->searchViewDistricts(Yii::$app->request->queryParams, $pid ,$region_id);

        return $this->render('view_districts', [
            'searchRes' => $searchRes,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Delete an existing SearchResults model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $childs = SearchResults::find()->where(['pid' => $id])->all();
        foreach ($childs as $child) {
            $child->delete();
        }
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
     * Delete multiple existing SearchResults model.
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
            $childs = SearchResults::find()->where(['pid' => $pk])->all();
            foreach ($childs as $child) {
                $child->delete();
            }
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
     * @param $pid
     * @param $region_id
     * @return array|Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteView($pid , $region_id)
    {
        $request = Yii::$app->request;
        $counter = 0;
        $hits = 0;
        $childs = SearchResults::find()->where(['pid' => $pid , 'region_id' => $region_id])->all();
        foreach ($childs as $child) {
            $counter += $child->counter;
            $hits += $child->hits;
            $child->delete();
        }

        $model = SearchResults::find()->where(['id' => $pid])->one();
        $model->counter =  $model->counter - $counter;
        $model->hits =  $model->hits - $hits;
        $model->save(false);


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
     * @param $pid
     * @param $district_id
     * @return array|Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteDistricts($pid , $district_id)
    {
        $request = Yii::$app->request;
        $counter = 0;
        $hits = 0;
        $childs = SearchResults::find()->where(['pid' => $pid , 'district_id' => $district_id])->all();
        foreach ($childs as $child) {
            $counter += $child->counter;
            $hits += $child->hits;
            $child->delete();
        }

        $model = SearchResults::find()->where(['id' => $pid])->one();
        $model->counter =  $model->counter - $counter;
        $model->hits =  $model->hits - $hits;
        $model->save(false);

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
     * Finds the SearchResults model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SearchResults the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SearchResults::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }
}
