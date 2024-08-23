<?php

namespace backend\controllers\references;

use Yii;
use backend\models\references\Helps;
use backend\models\searchs\HelpsSearch;
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
 * HelpsController implements the CRUD actions for Helps model.
 */
class HelpsController extends Controller
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
     * shu controllerga tegishli rusatlarni tekshirish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $help = RoleMethods::getAccess($roles , 'help', 'help');
        $questions = RoleMethods::getAccess($roles , 'help', 'questions');
        
       
        if($help && $questions )
        {   
            if( $action->id =='view' || $action->id =='create' || $action->id =='delete' || $action->id =='update')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($questions)
        {   
            if($action->id =='delete' || $action->id =='update' || $action->id =='create')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * helps lislari
     * @param null $help_id
     * @return string
     */
    public function actionIndex($help_id = null)
    {    
        $searchModel = new HelpsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $help_id);
        //$helpCategory = $this->findCategory($help_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'help_id' => $help_id,
            //'helpCategory' => $helpCategory,
        ]);
    }


    /**
     * Displays a single Helps model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Помощь",
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
     * Creates a new Helps model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Helps();
        //$model->helps_categories_id = $category_id;
        $langs = Lang::getLanguages();
        $post = $request->post();
        $translation_text = [];
        $translation_name = [];

        $translations = Translates::find()->where(['table_name' => $model->tableName(), 'field_id' => $model->id, 'field_name' => 'name'])->all();
        foreach ($translations as $key => $value) {
            $translation_name[$value->language_code] = $value->field_value;
        }

        $translations = Translates::find()->where(['table_name' => $model->tableName(), 'field_id' => $model->id, 'field_name' => 'text'])->all();
        foreach ($translations as $key => $value) {
            $translation_text[$value->language_code] = $value->field_value;
        }

        if ($model->load($request->post()) && $model->save()) {
            $attr = Helps::NeedTranslation();
            foreach ($langs as $lang) {
                $l = $lang->url;
                if($l == 'ru') {
                   continue;
                }
                foreach ($attr as $key => $value) {
                    $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                    if($t->count() == 1) {
                        $tt = $t->one();
                        $tt->field_value = $post["Helps"][$value][$l];
                        $tt->save();
                    }
                    else{
                        $tt = new Translates();
                        $tt->table_name = $model->tableName();
                        $tt->field_id = $model->id;
                        $tt->field_name = $key;
                        $tt->field_value = $post["Helps"][$value][$l];
                        $tt->language_code = $l;
                        $tt->save();
                    }
                }
            }

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'textes' => $translation_text,
                'names' => $translation_name,
                'post' => $post,
                'langs' => $langs,
            ]);
        }
    }


    /**
     * Updates an existing Helps model.
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
        $translation_text = [];
        $translation_name = [];

        $translations = Translates::find()->where(['table_name' => $model->tableName(), 'field_id' => $model->id, 'field_name' => 'name'])->all();
        foreach ($translations as $key => $value) {
            $translation_name[$value->language_code] = $value->field_value;
        }

        $translations = Translates::find()->where(['table_name' => $model->tableName(), 'field_id' => $model->id, 'field_name' => 'text'])->all();
        foreach ($translations as $key => $value) {
            $translation_text[$value->language_code] = $value->field_value;
        }

        if ($model->load($request->post()) && $model->save()) {
            $attr = Helps::NeedTranslation();
            foreach ($langs as $lang) {
                $l = $lang->url;
                if($l == 'ru') {
                   continue;
                }
                foreach ($attr as $key => $value) {
                    $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                    if($t->count() == 1) {
                        $tt = $t->one();
                        $tt->field_value = $post["Helps"][$value][$l];
                        $tt->save();
                    }
                    else{
                        $tt = new Translates();
                        $tt->table_name = $model->tableName();
                        $tt->field_id = $model->id;
                        $tt->field_name = $key;
                        $tt->field_value = $post["Helps"][$value][$l];
                        $tt->language_code = $l;
                        $tt->save();
                    }
                }
            }

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'textes' => $translation_text,
                'names' => $translation_name,
                'post' => $post,
                'langs' => $langs,
            ]);
        }
    }


    /**
     * Delete an existing Helps model.
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
     * Delete multiple existing Helps model.
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
     *
     * @param $id
     * @return Helps|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Helps::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }
}
