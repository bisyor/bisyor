<?php

namespace backend\controllers\references;

use Yii;
use backend\models\references\HelpsCategories;
use backend\models\searchs\HelpsCategoriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\HttpException;
use backend\models\references\Lang;
use backend\models\references\Translates;
use backend\models\references\Districts;
use backend\models\users\RoleMethods;

/**
 * HelpsCategoriesController implements the CRUD actions for HelpsCategories model.
 */
class HelpsCategoriesController extends Controller
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
     * shu controllerga tegishli ruxsatlarni tekshirish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $help = RoleMethods::getAccess($roles , 'help', 'help');
        $categories = RoleMethods::getAccess($roles , 'help', 'categories');
        
       
        if($help && $categories )
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($categories)
        {   
            if($action->id =='delete' || $action->id =='update' || $action->id =='create')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * help categoriesni listini olish
     * @return string
     */
    public function actionIndex()
    {    
        $searchModel = new HelpsCategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single HelpsCategories model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Помошь Категории",
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
     * Creates a new HelpsCategories model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $model = new HelpsCategories();  
        $langs = Lang::getLanguages();

        if($request->isAjax){
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($post) && $model->save()) {
                $attr = HelpsCategories::NeedTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'ru') {
                        if(!$model->save()) {
                            return [
                                'title'=> "Создать",
                                'content'=>$this->renderAjax('create', [
                                    'model' => $model,
                                    'post' => $post,
                                    'langs' => $langs, 
                                ]),
                                'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
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
                        $t->field_value = $post["HelpsCategories"][$value][$l];
                        $t->language_code = $l;
                        $t->save();
                    }
                }
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];         
            }else{           
                return [
                    'title'=>"Создать",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'titles' => null,
                        'post' => $post,
                        'langs' => $langs,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }
        }
    }


    /**
     * Updates an existing HelpsCategories model.
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
        $translation_name = [];

        if($request->isAjax) {
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            $translations = Translates::find()->where(['table_name' => $model->tableName(), 'field_id' => $model->id])->all();
            foreach ($translations as $key => $value) {
                $translation_name[$value->language_code] = $value->field_value;
            }

            if($model->load($request->post()) && $model->save()) {
                $attr = HelpsCategories::NeedTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'ru') {
                        continue;
                    }
                    foreach ($attr as $key => $value) {
                        $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                        if($t->count() == 1) {
                            $tt = $t->one();
                            $tt->field_value = $post["HelpsCategories"][$value][$l];
                            $tt->save();
                        }
                        else{
                            $tt = new Translates();
                            $tt->table_name = $model->tableName();
                            $tt->field_id = $model->id;
                            $tt->field_name = $key;
                            $tt->field_value = $post["HelpsCategories"][$value][$l];
                            $tt->language_code = $l;
                            $tt->save();
                        }
                    }
                }
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'forceClose' => true,
                ];
            }else{
                return [
                    'title'=> "Изменить",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'titles' => $translation_name,
                        'post' => $post,
                        'langs' => $langs,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                        Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }


    /**
     * Delete an existing HelpsCategories model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionAddDistrict($id)
    {
        $request = Yii::$app->request;
        $model = new Districts();
        $model->region_id = $id;
        $post = $request->post();
        $langs = Lang::getLanguages();

        Yii::$app->response->format = Response::FORMAT_JSON;
        if($model->load($request->post()) && $model->save()){
            $attr = Districts::NeedTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'ru') {
                        if(!$model->save()) {
                            return [
                                'title'=> 'Создать',
                                'content'=>$this->renderAjax('_form
                                    ', [
                                'model' => $model,
                                'titles' => null,
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
                        $t->field_value = $post["Districts"][$value][$l];
                        $t->language_code = $l;
                        $t->save();
                    }
                }
        
            return [
                'forceReload'=>'#crud-datatable-pjax',
                'title'=> "Район",
                'content'=>'<span class="text-success">Успешно выпольнено</span>',
                'forceClose'=>true,
            ];         
        }else{           
            return [
                'title'=> 'Создать',
                'content'=>$this->renderAjax('_form
                    ', [
                    'model' => $model,
                    'titles' => null,
                    'langs' => $langs,
                ]),
                'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                            Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
            ];
        }
    }


    /**
     * @param $id
     * @return array|Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
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
     * Delete multiple existing HelpsCategories model.
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
     * Finds the HelpsCategories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HelpsCategories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HelpsCategories::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }
}
