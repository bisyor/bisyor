<?php

namespace backend\controllers\references;

use Yii;
use backend\models\seobase\Landingpages;
use backend\models\searchs\LandingpagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use backend\models\references\Lang;
use backend\models\references\Translates;
use yii\web\HttpException;
use backend\models\users\RoleMethods;

/**
 * SocialNetworksController implements the CRUD actions for SocialNetworks model.
 */
class LandingPagesController extends Controller
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
     * shu controlelrga tegishli ruxsatlarni tekshirirsh
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
     public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $seo = RoleMethods::getAccess($roles , 'seo', 'seo');
        $landingpages = RoleMethods::getAccess($roles , 'seo', 'landingpages');
       
        if($seo && $landingpages)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($landingpages)
        {   
           if($action->id =='index' || $action->id =='view' || $action->id =='create' || $action->id =='update' || $action->id == 'delete')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);

    }


    /**
     * landing pages listi
     * @return string
     */
    public function actionIndex()
    {    
        $searchModel = new LandingpagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single SocialNetworks model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Cоциальные сети",
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
     * Creates a new SocialNetworks model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Landingpages();  

        $langs = Lang::getLanguages();
        $post = $request->post();
        $translation_title  = null;   
        $translation_mkeywords = null;
        $translation_mdescription = null;
        $translation_titleh1 = null;
        $translation_mtitle = null;
        $translation_seotext = null;

        if ($model->load($request->post()) && $model->save()) {
            $attr = Landingpages::NeedTranslation();
            foreach ($langs as $lang) {
                $l = $lang->url;
                if($l == 'ru') continue;
                foreach ($attr as $key => $value) {
                    
                    $tt = new Translates();
                    $tt->table_name = $model->tableName();
                    $tt->field_id = $model->id;
                    $tt->field_name = $key;
                    $tt->field_value = $post["Landingpages"][$value][$l];
                    $tt->language_code = $l;
                    $tt->save();
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('_form', [
                'model' => $model,
                'langs' => $langs,
                'translation_title' => $translation_title,
                'translation_mkeywords' => $translation_mkeywords,            
                'translation_mdescription' => $translation_mdescription,            
                'translation_titleh1' => $translation_titleh1,            
                'translation_mtitle' => $translation_mtitle,            
                'translation_seotext' => $translation_seotext,
                'trans_title' => null,
                'trans_mkeywords' => null,
                'trans_mdescription' => null,
                'trans_titleh1' => null,
                'trans_mtitle' => null,
                'trans_seotext' => null,        
            ]);
        }
    }


    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id); 
        $langs = Lang::getLanguages();
        $post = $request->post();      
        $translation_title  = null;   
        $translation_mkeywords = null;
        $translation_mdescription = null;
        $translation_titleh1 = null;
        $translation_mtitle = null;
        $translation_seotext = null;
        
        $translations = Translates::find()->where(['table_name' => $model->tableName(), 'field_id' => $model->id])->all();
        foreach ($translations as $key => $value) {
            if($value->field_name == 'title') $translation_title[$value->language_code] = $value->field_value;
            if($value->field_name == 'mkeywords') $translation_mkeywords[$value->language_code] = $value->field_value;
            if($value->field_name == 'mdescription') $translation_mdescription[$value->language_code] = $value->field_value;
            if($value->field_name == 'titleh1') $translation_titleh1[$value->language_code] = $value->field_value;
            if($value->field_name == 'mtitle') $translation_mtitle[$value->language_code] = $value->field_value;
            if($value->field_name == 'seotext') $translation_seotext[$value->language_code] = $value->field_value;
        }

        if ($model->load($request->post()) && $model->save()) {
            $attr = Landingpages::NeedTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'ru') continue;
                    foreach ($attr as $key => $value) {
                        $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                        if($t->count() == 1) {
                            $tt = $t->one();
                            $tt->field_value = $post["Landingpages"][$value][$l];
                            $tt->save();
                        }
                        else{
                            $tt = new Translates();
                            $tt->table_name = $model->tableName();
                            $tt->field_id = $model->id;
                            $tt->field_name = $key;
                            $tt->field_value = $post["Landingpages"][$value][$l];
                            $tt->language_code = $l;
                            $tt->save();
                        }
                    }
                }
            return $this->redirect(['index']);
        } else {
            return $this->render('_form', [
                'model' => $model,
                'trans_title' => $translation_title,
                'trans_mkeywords' => $translation_mkeywords,            
                'trans_mdescription' => $translation_mdescription,            
                'trans_titleh1' => $translation_titleh1,            
                'trans_mtitle' => $translation_mtitle,            
                'trans_seotext' => $translation_seotext,
                'langs' => $langs,
            ]);
        }
    }


    /**
     * @throws NotFoundHttpException
     */
    public function actionChangeValues()
    {   
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        if($model->enabled == 1) $model->enabled = 0;
        else $model->enabled = 1;
        $model->save();
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
     * @return array|Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
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
     * @param $id
     * @return Landingpages|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Landingpages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }
 
}
