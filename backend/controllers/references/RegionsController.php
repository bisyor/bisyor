<?php

namespace backend\controllers\references;

use Yii;
use backend\models\references\Regions;
use backend\models\searchs\RegionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\HttpException;
use backend\models\references\Lang;
use yii\web\UploadedFile;
use backend\models\references\Translates;
use backend\models\references\Districts;
use backend\models\users\RoleMethods;

class RegionsController extends Controller
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
        $site = RoleMethods::getAccess($roles , 'site', 'site');
        $regions = RoleMethods::getAccess($roles , 'site', 'regions');
       
        if($site && $regions)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($regions)
        {   
            if($action->id =='index' || $action->id =='view' || $action->id =='create' || $action->id =='update' ||$action->id =='add-district'  ||$action->id =='update-sub')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * region list
     * @param $countries_id
     * @return string
     */
    public function actionIndex($countries_id)
    {    
        $searchModel = new RegionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $countries_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'countries_id' => $countries_id,
        ]);
    }


    /**
     * Displays a single Regions model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Регионы",
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
     * Creates a new Regions model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($countries_id)
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $model = new Regions();  
        $model->country_id = $countries_id;
        $langs = Lang::getLanguages();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($post) && $model->save()) {
                $attr = Regions::NeedTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'ru') {
                        if(!$model->save()) {
                            return [
                                'title'=> "Создать",
                                'content'=>$this->renderAjax('create', [
                                    'model' => $model,
                                    'titles' => null,
                                    'declination' => null,
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
                        $t->field_value = $post["Regions"][$value][$l];
                        $t->language_code = $l;
                        $t->save();
                    }
                }
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];         
            }else{           
                return [
                    'title'=> "Создать",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'titles' => null,
                        'declination' => null,
                        'langs' => $langs,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }
        }       
    }


    /**
     * Updates an existing Regions model.
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
        $translation_declination = null;
        $translation_title = null;

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $translations = Translates::find()->where(['table_name' => $model->tableName(), 'field_id' => $model->id])->all();
            foreach ($translations as $key => $value) {
                //$translation_title[$value->language_code] = $value->field_value;
                if($value->field_name == 'name') $translation_title[$value->language_code] = $value->field_value;
                if($value->field_name == 'declination') $translation_declination[$value->language_code] = $value->field_value;
            }

            if($model->load($request->post()) && $model->save()) {
                $attr = Regions::NeedTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'ru') {
                       continue;
                    }
                    foreach ($attr as $key => $value) {
                        $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                        if($t->count() == 1) {
                            $tt = $t->one();
                            $tt->field_value = $post["Regions"][$value][$l];
                            $tt->save();
                        }
                        else{
                            $tt = new Translates();
                            $tt->table_name = $model->tableName();
                            $tt->field_id = $model->id;
                            $tt->field_name = $key;
                            $tt->field_value = $post["Regions"][$value][$l];
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
                        'titles' => $translation_title,
                        'declination' => $translation_declination,
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
     * Finds the Regions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Regions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Regions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }

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
                                'content'=>$this->renderAjax('_sub_form', [
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
                'content'=>$this->renderAjax('_sub_form', [
                    'model' => $model,
                    'titles' => null,
                    'langs' => $langs,

                ]),
                'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                            Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
            ];
        }
    }

    public function actionUpdateSub($id)
    {
        $request = Yii::$app->request;
        $model = Districts::findOne($id); 
        $langs = Lang::getLanguages();
        $post = $request->post();
        $translation_title = null;
        $translation_declination = null;

        if($request->isAjax){
            $translations = Translates::find()->where(['table_name' => $model->tableName(), 'field_id' => $model->id])->all();
            foreach ($translations as $key => $value) {
                if($value->field_name == 'name') $translation_title[$value->language_code] = $value->field_value;
                if($value->field_name == 'declination') $translation_declination[$value->language_code] = $value->field_value;
            }
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                $attr = Districts::NeedTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'ru') {
                       continue;
                    }
                    foreach ($attr as $key => $value) {
                        $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                        if($t->count() == 1) {
                            $tt = $t->one();
                            $tt->field_value = $post["Districts"][$value][$l];
                            $tt->save();
                        }
                        else{
                            $tt = new Translates();
                            $tt->table_name = $model->tableName();
                            $tt->field_id = $model->id;
                            $tt->field_name = $key;
                            $tt->field_value = $post["Districts"][$value][$l];
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
                    'content'=>$this->renderAjax('_sub_form', [
                        'model' => $model,
                        'titles' => $translation_title,
                        'declination' => $translation_declination,
                        'post' => $post,
                        'langs' => $langs,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('_sub_form', [
                    'model' => $model,
                ]);
            }
        }
    }
}
