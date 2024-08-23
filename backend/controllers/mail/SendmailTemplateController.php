<?php

namespace backend\controllers\mail;

use backend\models\references\Lang;
use backend\models\references\Translates;
use Yii;
use backend\models\mail\SendmailTemplate;
use backend\models\mail\SendmailTemplateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\HttpException;  
use backend\models\users\RoleMethods;

/**
 * SendmailTemplateController реализует действия CRUD для SendmailTemplate модель.
 */
class SendmailTemplateController extends Controller
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
     * shu controllerga tegishli ruxsatlarni tekshirish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
     public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $sendmail = RoleMethods::getAccess($roles , 'sendmail', 'sendmail');
        $templates_listing = RoleMethods::getAccess($roles , 'sendmail', 'templates-listing');
        $templates_edit = RoleMethods::getAccess($roles , 'sendmail', 'templates-edit');
        
        if($sendmail && $templates_listing && $templates_edit)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($templates_listing)
        {   
            if($action->id =='index' ||  $action->id =='view')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($templates_edit)
        {   
            if($action->id =='create' || $action->id =='update' || $action->id =='delete' || $action->id =='bulk-delete')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * templatelar listi olish
     * @return string
     */
    public function actionIndex()
    {    
        $searchModel = new SendmailTemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * ayni bir templateni korish
     * @param $id
     * @return array|string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Просмотр",
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
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Создает новый SendmailTemplate model.
     * Для ajax-запроса будет возвращен объект json, а для не-ajax-запроса, 
     * если создание будет успешным, браузер будет перенаправлен на страницу просмотра.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new SendmailTemplate();
        $langs = Lang::getLanguages();
        $post = $request->post();
        $translation_title = null;
        $translation_content = null;
        if($request->isAjax){
            /*
            *  Процесс для ajax-запроса
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                $attr = SendmailTemplate::needTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'ru') continue;
                    foreach ($attr as $key => $value) {
                        $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                        if($t->count() == 1) {
                            $tt = $t->one();
                            $tt->field_value = $post["SendmailTemplate"][$value][$l];
                            $tt->save();
                        }
                        else{
                            $tt = new Translates();
                            $tt->table_name = $model->tableName();
                            $tt->field_id = $model->id;
                            $tt->field_name = $key;
                            $tt->field_value = $post["SendmailTemplate"][$value][$l];
                            $tt->language_code = $l;
                            $tt->save();
                        }
                    }
                }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Создать",
                    'content'=>'<span class="text-success">Успешно выполнено</span>',
                    'footer'=> Html::button('Ок',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                            Html::a('Создать ещё',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Создать",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'translation_title' => $translation_title,
                        'translation_content' => $translation_content,
                        'langs' => $langs,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Процесс для не-AJAX-запроса
            */
            if($model->load($request->post()) && $model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Обновляет существующий SendmailTemplate модель.
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
        $translation_title = null;
        $translation_content = null;

        if($request->isAjax){
            /*
            *   Процесс для ajax-запроса
            */
            $translations = Translates::find()->where(['table_name' => $model->tableName(), 'field_id' => $model->id])->all();
            foreach ($translations as $key => $value) {
                if($value->field_name == 'title') $translation_title[$value->language_code] = $value->field_value;
                if($value->field_name == 'content') $translation_content[$value->language_code] = $value->field_value;
            }
            Yii::$app->response->format = Response::FORMAT_JSON; 
            if($model->load($request->post()) && $model->save()){
                $attr = SendmailTemplate::needTranslation();
                foreach ($langs as $lang) {
                    $l = $lang->url;
                    if($l == 'ru') continue;
                    foreach ($attr as $key => $value) {
                        $t = Translates::find()->where(['table_name' => $model->tableName(),'field_id' => $model->id, 'language_code' => $l,'field_name' => $key]);
                        if($t->count() == 1) {
                            $tt = $t->one();
                            $tt->field_value = $post["SendmailTemplate"][$value][$l];
                            $tt->save();
                        }
                        else{
                            $tt = new Translates();
                            $tt->table_name = $model->tableName();
                            $tt->field_id = $model->id;
                            $tt->field_name = $key;
                            $tt->field_value = $post["SendmailTemplate"][$value][$l];
                            $tt->language_code = $l;
                            $tt->save();
                        }
                    }
                }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Просмотр",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                            Html::a('Изменить',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Изменить",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'translation_title' => $translation_title,
                        'translation_content' => $translation_content,
                        'langs' => $langs,
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
     * Удалить существующий SendmailTemplate модель.
     * Для запроса ajax вернет объект json и для запроса не-ajax, если удаление прошло успешно, браузер будет 
     * перенаправлен на страницу «index».
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Процесс для ajax-запроса
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Процесс для не-AJAX-запроса
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Удалить несколько существующих SendmailTemplate модель.
     * Для запроса ajax вернет объект json и для запроса не-ajax, если удаление прошло успешно, браузер будет 
     * перенаправлен на страницу «index».
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' ));
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Процесс для ajax-запроса
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Процесс для не-AJAX-запроса
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Находит модель SendmailTemplate На основе значения ее первичного ключа.
     * Если модель не найдена, будет выдано исключение 404 HTTP.
     * @param integer $id
     * @return SendmailTemplate загруженная модель
     * @throws NotFoundHttpException если модель не может быть найдена
     */
    protected function findModel($id)
    {
        if (($model = SendmailTemplate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }
}
