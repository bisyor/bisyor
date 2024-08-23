<?php

namespace backend\controllers\references;

use backend\models\references\Lang;
use backend\models\references\Translates;
use Yii;
use backend\models\references\Sitemap;
use backend\models\references\SitemapSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\HttpException;
use backend\models\users\RoleMethods;

/**
 * SitemapController реализует действия CRUD для Sitemap модель.
 */
class SitemapController extends Controller
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
     * shu controllerga tegishli ruxsatlarni tekshirirsh
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $sitemap = RoleMethods::getAccess($roles , 'sitemap', 'sitemap');
        $listing = RoleMethods::getAccess($roles , 'sitemap', 'listing');
        $edit = RoleMethods::getAccess($roles , 'sitemap', 'edit');

        if($sitemap && $listing && $edit)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($listing)
        {   
            if($action->id =='index' || $action->id =='view')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($edit)
        {   
            if($action->id =='create' || $action->id =='update' || $action->id == 'delete')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }


        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * maolar listi
     * @return string
     */
    public function actionIndex()
    {    
        $searchModel = new SitemapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Создает новый Sitemap model.
     * Для ajax-запроса будет возвращен объект json, а для не-ajax-запроса, 
     * если создание будет успешным, браузер будет перенаправлен на страницу просмотра.
     * @return mixed
     */
    public function actionCreate($id = 1)
    {
        $request = Yii::$app->request;
        $model = new Sitemap();
        $post = $request->post();
        $langs = Lang::getLanguages();
        $menu_name = ['name' => $model->getRoot($id)];

        if($request->isAjax){
            /*
            *  Процесс для ajax-запроса
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->validate()){
                $model->sitemap_id = $id;
                $model->save();
                $attr = Sitemap::NeedTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'ru') continue;
                    foreach ($attr as $key => $value) {
                        $t = new Translates();
                        $t->table_name = $model->tableName();
                        $t->field_id = $model->id;
                        $t->field_name = $key;
                        $t->field_value = $post["Sitemap"][$value][$l];
                        $t->language_code = $l;
                        $t->save();
                    }
                }
                return [
                    'forceReload'=>'body',
                    'title'=> "Создать",
                    'forceClose' => true
        
                ];         
            }else{           
                return [
                    'title'=> "Создать",
                    'content'=>$this->renderAjax('create', ['model' => $model,
                        'langs' => $langs,
                        'translation_name' => null,
                        'menu_name' => $menu_name
                        ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Процесс для не-AJAX-запроса
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Обновляет существующий Sitemap модель.
     * Для запроса ajax вернет объект json и для запроса не-ajax, если обновление выполнено успешно, браузер будет 
     * перенаправлен на страницу просмотра.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $langs = Lang::getLanguages();
        $post = $request->post();
        $menu_name = ['name' => $model->getRoot($id)];

        if($request->isAjax){
            /*
            *   Процесс для ajax-запроса
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            $translation_name = Translates::find()->where(['table_name' => $model->tableName(), 'field_id' => $model->id])->all();
            foreach ($translation_name as $key => $value) {
                $translation_name[$value->language_code] = $value->field_value;
            }
            if(!isset($translation_name)) $translation_name = null;
            if($model->load($request->post()) && $model->save()){
                $attr = Sitemap::NeedTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'ru') continue;
                    foreach ($attr as $key => $value) {
                        $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                        if($t->count() == 1) {
                            $tt = $t->one();
                            $tt->field_value = $post["Sitemap"][$value][$l];
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
                    'forceReload'=>'body',
                    'title'=> "Просмотр",
                    'forceClose' => true
                ];    
            }else{
                 return [
                    'title'=> "Изменить",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'translation_name' => $translation_name,
                        'post' => $post,
                        'langs' => $langs,
                        'menu_name' => $menu_name
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Процесс для не-AJAX-запроса
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Удалить существующий Sitemap модель.
     * Для запроса ajax вернет объект json и для запроса не-ajax, если удаление прошло успешно, браузер будет 
     * перенаправлен на страницу «index».
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $sitemap_id = $model->sitemap_id;
        $model->delete();

        if($request->isAjax){
            /*
            *   Процесс для ajax-запроса
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [ 'forceReload'=>'body',
                'forceClose' => true
            ];
        }else{
            /*
            *   Процесс для не-AJAX-запроса
            */
            return $this->redirect(['index']);
        }


    }

    protected function findModel($id)
    {
        if (($model = Sitemap::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }
}
