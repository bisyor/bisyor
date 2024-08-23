<?php

namespace backend\controllers\references;

use Yii;
use backend\models\references\Countries;
use backend\models\searchs\CountriesSearch;
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

/**
 * CountriesController implements the CRUD actions for Countries model.
 */
class CountriesController extends Controller
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
     * Lists all Brands models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new CountriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new Brands model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $model = new Countries();  
        //$model->country_id = $countries_id;
        $langs = Lang::getLanguages();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($post) && $model->save()) {
                $attr = Countries::NeedTranslation();
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
                        $t->field_value = $post["Countries"][$value][$l];
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
     * Updates an existing Brands model.
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
                $attr = Countries::NeedTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'ru') {
                       continue;
                    }
                    foreach ($attr as $key => $value) {
                        $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                        if($t->count() == 1) {
                            $tt = $t->one();
                            $tt->field_value = $post["Countries"][$value][$l];
                            $tt->save();
                        }
                        else{
                            $tt = new Translates();
                            $tt->table_name = $model->tableName();
                            $tt->field_id = $model->id;
                            $tt->field_name = $key;
                            $tt->field_value = $post["Countries"][$value][$l];
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
     * Delete an existing Brands model.
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


    protected function findModel($id)
    {
        if (($model = Countries::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }

}
