<?php

namespace backend\controllers\references;

use Yii;
use backend\models\references\Lang;
use backend\models\searchs\LangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\web\HttpException;
use common\modules\translations\models\SourceMessage;
use backend\models\users\RoleMethods;
use backend\models\references\LangMessages;


/**
 * LanguageController implements the CRUD actions for Lang model.
 */
class LanguageController extends Controller
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
     * shu controlerga tegishli ruxsatlarni tekshirish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $site = RoleMethods::getAccess($roles , 'site', 'site');
        $localization = RoleMethods::getAccess($roles , 'site', 'localization');
       
        if($site && $localization)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($localization)
        {   
            if($action->id =='index' || $action->id =='view' || $action->id =='create' || $action->id =='update' || $action->id == 'delete' || $action->id == 'bulk-delete')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * language listini olish
     * @return string
     */
    public function actionIndex()
    {    
        $searchModel = new LangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionChange($id)
    {
        $model=$this->findModel($id);
        if($model->status==1)
            {
                $status=0;
                Yii::$app->language='ru';
            }
        if($model->status==0)
            {
                $status=1;
            }

        if(Yii::$app->language==$model->url)
            Yii::$app->language='ru';
        
        Yii::$app->db->createCommand()->update('lang', ['status' => $status], [ 'id' => $model->id ])->execute();
        return $this->redirect(['index']);
    }


    /**
     * statusini ozgartirish
     */
    public function actionChangeValues()
    {
        $id = $_POST['id'];
        $model = Lang::findOne($id);
        if($model->status == 0) {$model->status = 1;}
        else {$model->status = 0;}
        $model->save();
    }
    /**
     * Displays a single Lang model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> Yii::t('app','Language'),
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button(Yii::t('app','Close'),['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                            Html::a(Yii::t('app','Edit'),['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }


    /**
     * Creates a new Lang model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       $request = Yii::$app->request;
       $model = new Lang(); 
       if($request->isAjax){
           /*
           *  Process for ajax request
           */
           Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                $model->defaultLang();
                $src = \common\modules\translations\models\SourceMessage::find()->all();
                foreach ($src as $value) {
                   Yii::$app->db->createCommand()->insert('message', ['id' => $value->id,'language'=>$model->url])->execute();
                }
                $model->flag = UploadedFile::getInstance($model,'flag');
                $model->upload();
               return [
                   'forceReload'=>'#crud-datatable-pjax',
                   'title'=> 'Создать',
                   'content'=>'<span class="text-success">Успешно выполнено</span>',
                   'footer'=> Html::button('Закрыть', ['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                           Html::a('Создать ещё', ['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
               ];       
            }else{         
                return [
                    'title'=> "Создать",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                              Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];    
            }
        }else{
           /*
           *  Process for non-ajax request
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
     * Updates an existing Lang model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                $model->defaultLang();
                $model->flag = UploadedFile::getInstance($model,'flag');
                $model->upload();
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> 'Изменить',
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                            Html::a('Изменить',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                return [
                    'title'=> 'Изменить',
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->saveCounters()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }


    /**
     * @return array|string
     */
    public function actionTranslate()
    {
        $request = Yii::$app->request;
        $langs = Lang::find()->all();
        $model = new LangMessages();
        $post = $request->post();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->validate()){
                $model->saveTranslate();
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
            }else{           
                return [
                    'title'=> "Создать",
                    'content'=>$this->renderAjax('translation', [
                        'model' => $model,
                        'langs' => $langs,
                        'post' => $post,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }
        }
        return $this->render('index');
    }


    /**
     * tarjimalarni faylga yozish
     * @return array|Response
     */
    public function actionDownloadLanguageFile()
    {   
        $request = Yii::$app->request;
        $langs = Lang::find()->all();
        $sources = SourceMessage::find()->messages()->all();
        $result = "";
        foreach ($langs as $key => $value) {
            $my_file =  'uploads/php_file/';
            $result = "";
            foreach ($sources as $source) { 
                $messages = $source->messages;
                foreach ($messages as $key => $message) {
                    if($message->language == $value->url)
                    $result .= "    '".$source->message."'".'=>'."'".str_replace("'","\'" ,$message->translation)."',\n";
                }
                $handle = fopen($my_file.$value->url.".php", 'w+') or die('Fayl hosil qila olmadi.');
                fwrite($handle, "<?php");
                fwrite($handle, "\n return [\n");
                fwrite($handle, $result);
                fwrite($handle, "\n];\n");
                fwrite($handle, "?>\n");
                fclose($handle);
            }
        }

        $homepage = $this->file_get_contents_curl(Yii::$app->params['settingsUrl']);
        $homepage = json_decode($homepage);

        if($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> "Уведомления",
                'content'=>$this->renderAjax('success', [
                    'homepage' => $homepage,
                ])
            ];
        }
        else {
            return $this->redirect(['/settings/site-settings/button-site']);
        }
    }


    /**
     * fayldagi tarjimani bazaga insert qilish
     * @return array|Response
     */
    public function actionInsertTranslate()
    {   
        $request = Yii::$app->request;
                if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            Lang::setInsertFile();
            $success = "Успешно выполнено";
            return [
                'title'=> "Уведомления",
                    'content'=>$this->renderAjax('insert', [
                        'success' => $success,
                ])];
        }
        return $this->redirect(['index']);
    }


    /**
     * @param $id
     * @return array|Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        Yii::$app->db->createCommand()->delete('message', ['language'=>$model->url])->execute();
        $model->delete();
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
     * Delete multiple existing Lang model.
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
            $this->findModel($pk)->delete();
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
     * Finds the Lang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * curl function
     **/
    public function file_get_contents_curl($url){
        $arrContextOptions = stream_context_create([
            "ssl"=>[
                "verify_peer"   =>  false,
                "verify_peer_name"  =>  false,
            ],
        ]); 
        return file_get_contents($url , false , $arrContextOptions);
    }
    
}

