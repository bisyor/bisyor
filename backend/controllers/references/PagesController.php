<?php

namespace backend\controllers\references;

use Yii;
use backend\models\references\Pages;
use backend\models\searchs\PagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\HttpException;
use backend\models\references\Lang;
use backend\models\references\Translates;
use backend\models\users\RoleMethods;


/**
 * PagesController implements the CRUD actions for Pages model.
 */
class PagesController extends Controller
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
     * shu controllerga tegishli ruxsatlarni tekshirirsh
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $site_pages = RoleMethods::getAccess($roles , 'site-pages', 'site-pages');
        $listing = RoleMethods::getAccess($roles , 'site-pages', 'listing');
        $manage = RoleMethods::getAccess($roles , 'site-pages', 'manage');
       
        if($site_pages && $listing && $manage)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($listing)
        {   
            if($action->id =='index' || $action->id =='view' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($manage)
        {   
            if($action->id =='delete' || $action->id =='update' || $action->id =='create' | $action->id =='bulk-delete')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * pages listi
     * @return string
     */
    public function actionIndex()
    {    
        $searchModel = new PagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Pages model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=>"Категория",
                    'content'=>$this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                            Html::a('Изменить',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];   
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }


    /**
     * Creates a new Pages model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Pages();
        $langs = Lang::getLanguages();
        $post = $request->post();
        $translation_description = null;
        $translation_mkeywords = null;
        $translation_mdescription = null;
        $translation_mtitle = null;
        $translation_title = null;

        if ($model->load($request->post()) && $model->save()) {
            $attr = Pages::NeedTranslation();
            foreach ($langs as $lang) {
                $l = $lang->url;
                if($l == 'ru') continue;
                foreach ($attr as $key => $value) {
                    $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                    if($t->count() == 1) {
                        $tt = $t->one();
                        $tt->field_value = $post["Pages"][$value][$l];
                        $tt->save();
                    }
                    else{
                        $tt = new Translates();
                        $tt->table_name = $model->tableName();
                        $tt->field_id = $model->id;
                        $tt->field_name = $key;
                        $tt->field_value = $post["Pages"][$value][$l];
                        $tt->language_code = $l;
                        $tt->save();
                    }
                }
            }

            return $this->redirect(['index']);
        } 
        else {
            return $this->render('create', [
                'model' => $model,
                'description' => $translation_description,
                'langs' => $langs,
                'mkeywords' => $translation_mkeywords,
                'mdescription' => $translation_mdescription,
                'mtitle' => $translation_mtitle,
                'title' => $translation_title,
            ]);
        }
    }


    /**
     * Updates an existing Pages model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $langs = Lang::getLanguages();
        $post = $request->post();
        $translation_description = null;
        $translation_mkeywords = null;
        $translation_mdescription = null;
        $translation_mtitle = null;
        $translation_title = null;

            $translations = Translates::find()->where(['table_name' => $model->tableName(), 'field_id' => $model->id])->all();
            foreach ($translations as $key => $value) {
                if($value->field_name == 'title') $translation_title[$value->language_code] = $value->field_value;
                if($value->field_name == 'mkeywords') $translation_mkeywords[$value->language_code] = $value->field_value;
                if($value->field_name == 'mdescription') $translation_mdescription[$value->language_code] = $value->field_value;
                if($value->field_name == 'mtitle') $translation_mtitle[$value->language_code] = $value->field_value;
                if($value->field_name == 'description') {
                    $translation_description[$value->language_code] = $value->field_value;
                    $model->translation_description[$value->language_code] = $value->field_value;
                }
            }

            if($model->load($request->post()) && $model->save()) {
                $attr = Pages::NeedTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'ru') {
                       continue;
                    }
                    foreach ($attr as $key => $value) {
                        $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                        if($t->count() == 1) {
                            $tt = $t->one();
                            $tt->field_value = $post["Pages"][$value][$l];
                            $tt->save();
                        }
                        else{
                            $tt = new Translates();
                            $tt->table_name = $model->tableName();
                            $tt->field_id = $model->id;
                            $tt->field_name = $key;
                            $tt->field_value = $post["Pages"][$value][$l];
                            $tt->language_code = $l;
                            $tt->save();
                        }
                    }
                }
                return $this->redirect(['index']);
            }else{

               return $this->render('update', [
                'model' => $model,
                'description' => $translation_description,
                'langs' => $langs,
                'mkeywords' => $translation_mkeywords,
                'mdescription' => $translation_mdescription,
                'mtitle' => $translation_mtitle,
                'title' => $translation_title,
            ]);
        }
    }


    /**
     * Delete an existing Pages model.
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
     * Delete multiple existing Pages model.
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
     * Finds the Pages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * statusni ozgartitish
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
}
