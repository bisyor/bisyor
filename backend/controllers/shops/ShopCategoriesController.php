<?php

namespace backend\controllers\shops;

use Yii;
use backend\models\shops\ShopCategories;
use backend\models\shops\ShopCategoriesSearch;
use backend\models\shops\ShopsCategorySeo;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use backend\models\references\Lang;
use yii\helpers\Html;
use yii\web\HttpException;
use backend\models\users\RoleMethods;

/**
 * ShopCategoriesController implements the CRUD actions for ShopCategories model.
 */
class ShopCategoriesController extends Controller
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
     * shu controllerga tegishli ruxsatlarni tekshiradi
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $shops = RoleMethods::getAccess($roles , 'shops', 'shops');
        $categories = RoleMethods::getAccess($roles , 'shops', 'categories');

        if($shops && $categories )
        {
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($categories)
        {
           if($action->id =='create' || $action->id =='update' || $action->id =='delete' || $action->id =='bulk-delete' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * shop categorieslar listi
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ShopCategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single ShopCategories model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $langs = Lang::getLanguages();
        $post = $request->post();
        $translation_title = null;
        $model->getTranslations($langs);

        if($model->shopsCategorySeo){
            $modelSeo = $model->shopsCategorySeo;
        }else{
            $modelSeo = new ShopsCategorySeo();
            $modelSeo->category_id = $id;
        }

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                    'title'=> "Просмотр",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'titles' => $translation_title,
                        'langs' => $langs
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                            Html::a('Редактировать',['updatee','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
        }else{

            if($modelSeo->load($post) && $modelSeo->validate()){
                $modelSeo->save();
                return $this->redirect(['view','id' => $model->id]);
            }
            return $this->render('view', [
                'model' => $this->findModel($id),
                'modelSeo' => $modelSeo,
                'langs' => $langs
            ]);
        }
    }


    /**
     * @param $id
     * @return array|Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     */
    public function actionUpdatee($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $langs = Lang::getLanguages();
        $post = $request->post();
        $parentCategory = null;
        if($model->parent_id){
            $parentCategory = $model->parent;
        }
        $model->getTranslations($langs);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()) {
                $model->UploadImage();
                $model->SaveTranslates($post,$langs);
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'forceClose' => true,
                ];

            }else{
                 return [
                    'title'=> ($parentCategory == null) ? "Изменить категория" : "Изменить суб-категория для <b>" . $parentCategory->title . "</b>",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'langs' => $langs,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                        Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
        return $this->redirect('index');
    }


    /**
     * @param $id
     * @return string
     */
    public function actionChangeActiveCat($id)
    {
        $categories = Yii::$app->session['categories'];
        if(isset($categories) && $categories != ""){
            $arr = explode(",", $categories);
            if(in_array($id, $arr)){
               foreach ($arr as $key => $value) {
                    if($value == $id){
                        unset($arr[$key]);
                    }
                }
                $result = "deleted";
            }else{
                $arr[] = $id;
                $result = "added";
            }
        }else{
            $arr = [];
            $arr[] = $id;
                $result = "added";
        }

        $categories = implode(",", $arr);
        $session = Yii::$app->session;
        $session['categories'] =  $categories;
        return $result;
    }


    /**
     * Creates a new ShopCategories model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = null)
    {
        $request = Yii::$app->request;
        $model = new ShopCategories();
        $parentCategory = null;
        if($id){
           $model->parent_id = $id;
           $parentCategory = $model->parent;
        }
        $post = $request->post();
        $langs = Lang::getLanguages();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                $model->UploadImage();
                $model->SaveTranslates($post,$langs);

                return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'forceClose' => true,
                    ];
            }else{
                return [
                    'title'=> ($parentCategory == null) ? "Создать категория" : "Добавить суб-категория для <b>" . $parentCategory->title . "</b>",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'langs' => $langs,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'langs' => $langs,

                ]);
            }
        }
    }


    /**
     * Delete an existing ShopCategories model.
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
     * vaqtincha yuklangan rasmlarni saqlash actioni
     * @return string
     */
    public function actionUploadImage()
    {
        $dir = '/web/uploads/trash/';
        $uploadDir = $_POST['dir_name'];

        $host = Yii::$app->params['host'];
        //host
        $name = $host['name'];
        $usr = $host['username'];
        $pwd = $host['password'];

        // connect to FTP server (port 21)
        $conn_id = ftp_connect($name, 21) or die ("Cannot connect to host");

        // send access parameters
        if(ftp_login($conn_id, $usr, $pwd)){
            ftp_pasv($conn_id, true);
        }

        ShopCategories::deleteIcon($uploadDir,$_POST['old_image'],$conn_id);

        for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
            $ext = "";
            $ext = substr(strrchr($_FILES['file']['name'][$i], "."), 1);
            $fPath = $_POST['names'][$i];
            if($ext != ""){
                $ftp_path = $dir.$fPath;
                $ret = ftp_nb_put($conn_id, $ftp_path, $_FILES['file']['tmp_name'][$i], FTP_BINARY);
                while ($ret == FTP_MOREDATA) {
                   $ret = ftp_nb_continue($conn_id);
                }
                return Yii::$app->params['image_site'] . $ftp_path;
                if ($ret != FTP_FINISHED) {
                   echo "При загрузке файла произошла ошибка...";
                }
            }
        }
    }


    /**
     * sortirovka
     * @param null $id
     * @return string|Response
     */
    public function actionSorting($id = null)
    {
        $request = Yii::$app->request;
        $list = ShopCategories::getColumnsList($id);

        if($request->post()){
            $i = 0;
            $result = [];
            $string = $request->post()['sort'];
            if($string != null && !is_array($string)){
                $result = explode(',', $string);
            }

            foreach ($result as $value) {
                if(!$value) continue;
                $i++;
                $subCategories = ShopCategories::findOne($value);
                $subCategories->sorting = $i;
                $subCategories->save(false);
            }
            return $this->redirect(['index']);
        }else{
            return $this->render('_sorting_form', [
                'list' => $list,
            ]);
        }
    }


    /**
     * statusini o'zgartirish uchun
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionChangeStatus($id)
    {
        $model = $this->findModel($id);
        $i = $model->enabled;
        $i = ($i + 1)% 2;
        $model->enabled = $i;
        $model->save(false);
    }


     /**
     * Delete multiple existing ShopCategories model.
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
     * Finds the ShopCategories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopCategories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopCategories::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }





}
