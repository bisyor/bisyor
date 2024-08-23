<?php

namespace backend\controllers\references;

use Yii;
use backend\models\references\Currencies;
use backend\models\searchs\CurrenciesSearch;
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
 * CurrenciesController implements the CRUD actions for Currencies model.
 */
class CurrenciesController extends Controller
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
     * shucontrollerga tegishli ruxsatlarni tekshirish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $site = RoleMethods::getAccess($roles , 'site', 'site');
        $currencies = RoleMethods::getAccess($roles , 'site', 'currencies');
       
        if($site && $currencies)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($currencies)
        {   
            if($action->id =='index' || $action->id =='view' || $action->id =='create' || $action->id =='update' || $action->id == 'delete')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }


        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * currencylar lisitini olish
     * @return string
     */
    public function actionIndex()
    {    
        $searchModel = new CurrenciesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Currencies model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=>'Валюта',
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Изменить',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Currencies model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Currencies();  
        $post = $request->post();
        $langs = Lang::getLanguages();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($post) && $model->save()) {
                $attr = Currencies::NeedTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'ru') {
                        if(!$model->save()) {
                            return [
                                'title'=> "Создать",
                                'content'=>$this->renderAjax('create', [
                                    'model' => $model,
                                    'titles' => null,
                                    // 'post' => $post,
                                    'langs' => $langs,
                                ]),
                                'footer'=> Html::button("Отмена",['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                            ];
                        }
                        else continue;
                    }
                    foreach ($attr as $key => $value) {
                        $t = new Translates();
                        $t->table_name = $model->tableName();
                        $t->field_id = $model->id;
                        $t->field_name = $key;
                        $t->field_value = $post["Currencies"][$value][$l];
                        $t->language_code = $l;
                        $t->save();
                    }
                }
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];         
            }
            else {           
                return [
                    'title'=> "Создать",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'titles' => null,
                        'names' => null,
                        'langs' => $langs,
                    ]),
                     'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }
        }       
    }

    /**
     * Updates an existing Currencies model.
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
        $translation_title = null;
        $translation_short_name = null;

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $translations = Translates::find()->where(['table_name' => $model->tableName(), 'field_id' => $model->id])->all();
            foreach ($translations as $key => $value) {
                if($value->field_name == 'name') $translation_title[$value->language_code] = $value->field_value;
                else $translation_short_name[$value->language_code] = $value->field_value;
            }
            if($model->load($request->post()) && $model->save()) {
                $attr = Currencies::NeedTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'ru') continue;
                    foreach ($attr as $key => $value) {
                        $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                        if($t->count() == 1) {
                            $tt = $t->one();
                            $tt->field_value = $post["Currencies"][$value][$l];
                            $tt->save();
                        }
                        else{
                            $tt = new Translates();
                            $tt->table_name = $model->tableName();
                            $tt->field_id = $model->id;
                            $tt->field_name = $key;
                            $tt->field_value = $post["Currencies"][$value][$l];
                            $tt->language_code = $l;
                            $tt->save();
                        }
                    }
                }
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'forceClose' => true,
                ];
            } else {
                return [
                    'title'=> "Изменить",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'titles' => $translation_title,
                        'names' => $translation_short_name,
                        'post' => $post,
                        'langs' => $langs,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                        Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }

    public function actionUpdateCourse()
    {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        Currencies::changeRate();
        return $this->redirect('index');
    }

    /**
     * Delete an existing Currencies model.
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
     * Delete multiple existing Currencies model.
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
     * Finds the Currencies model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Currencies the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Currencies::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }

    protected function findCategory($id)
    {
        if (($model = Currencies::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }


    /**
     * statusni ozgartirish
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
