<?php

namespace backend\controllers\users;

use backend\models\bills\BillsSearch;
use backend\models\items\ItemsSearch;
use backend\models\references\Settings;
use backend\models\searchs\BonusHistorySearch;
use Yii;
use backend\models\users\Users;
use backend\models\users\UsersSearch;
use backend\models\searchs\OrdersSearch;
use backend\models\shops\ShopsSearch;
use backend\models\shops\Shops;
use backend\models\users\UserHistorySearch;
use backend\models\users\UserHistory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\UploadedFile;
use backend\models\items\UserBuyedLimit;
use backend\services\UserService;
use backend\models\references\Districts;
use backend\models\users\RoleMethods;
use backend\models\items\FavoritesSearch;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
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

    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $users = RoleMethods::getAccess($roles , 'users', 'users');
        $profile = RoleMethods::getAccess($roles , 'users', 'profile');
        $admins_listing = RoleMethods::getAccess($roles , 'users', 'admins-listing');
        $members_listing = RoleMethods::getAccess($roles , 'users', 'members-listing');
        $users_edit = RoleMethods::getAccess($roles , 'users', 'users-edit');
       
        if($users && $profile && $admins_listing && $members_listing)
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($profile)
        {   
            if($action->id =='profile')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($admins_listing)
        {   
            if($action->id =='moderator')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($members_listing)
        {   
            if($action->id =='index')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($users_edit)
        {   
            if($action->id =='create' || $action->id =='update' || $action->id =='delete' || $action->id =='bulk-delete')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }


        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {    
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'user');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
    * Moderatorlar ro'yxatini qytarish uchun action
    * Developer t.me/Zoxidovuz
    */
    public function actionModerator()
    {    
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'moderator');
        return $this->render('moderator/moderator', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $searchModel = new UserHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        $searchBalance = new BillsSearch();
        $dataBalance = $searchBalance->searchByUser(Yii::$app->request->queryParams, $id);
        $searchShops = new ShopsSearch();
        $dataShops = $searchShops->searchShops(Yii::$app->request->queryParams);
        $searchItems = new ItemsSearch();
        $dataItems = $searchItems->searchByUser($request->queryParams, $id);
        $dataLimits = UserBuyedLimit::search($id);

        $searchModelFavorites = new FavoritesSearch();
        $dataFavorites = $searchModelFavorites->search(Yii::$app->request->queryParams ,$id);

        $searchModelBonus = new BonusHistorySearch();
        $dataBonus = $searchModelBonus->search(Yii::$app->request->queryParams ,$id);

        $model = $this->findModel($id);
        $userAuth = Yii::$app->params['userAuth'] . '?login=' . $model->login;
        return $this->render('view', compact('model', 'dataBonus','dataProvider', 'searchBalance', 'dataBalance', 'searchShops', 'dataShops', 'searchItems', 'dataItems', 'userAuth', 'dataLimits','dataFavorites'));
    }
    /**
    * Moderatorlar view oynasi uchun action
    * Developer t.me/zoxidovuz
    * @return mixed
    */
    public function actionModeratorView($id)
    {   
        $request = Yii::$app->request;
        $searchModel = new UserHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        $searchBalance = new BillsSearch();
        $dataBalance = $searchBalance->searchByUser(Yii::$app->request->queryParams, $id);
        $searchShops = new ShopsSearch();
        $dataShops = $searchShops->searchShops(Yii::$app->request->queryParams);
        $searchItems = new ItemsSearch();
        $dataItems = $searchItems->searchByUser($request->queryParams, $id);
        $model = $this->findModel($id);
        return $this->render('moderator/_moderator_view', compact('model', 'dataProvider', 'searchBalance', 'dataBalance', 'searchShops', 'dataShops', 'searchItems', 'dataItems'));
    }
    /**
    * Foydalanuvhilar shaxsiy profil oynasini ko'rishi uchun action
    * Developer t.me/zoxidovuz
    * @return mixed
    */
    public function actionProfile()
    {
        $request = Yii::$app->request;
        $model = Users::findOne(Yii::$app->user->identity->id);
        return $this->render('profile', ['model' => $model]);        
    }
    /**
    * Foydalanuvhilar shaxsiy profil oynasini tahrirlash uchun action
    * Developer t.me/zoxidovuz
    * @return mixed
    */
    public function actionChange()
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $id = Yii::$app->user->identity->id;
        $model = $this->findModel($id);       
        if($model->load($request->post()) && $model->save()){
            $model->image = UploadedFile::getInstance($model, 'image');
            $model->resume = UploadedFile::getInstance($model, 'resume');
            $model->upload();
            $model->uploadResume();
            $model->phones($post);
             return $this->redirect('profile');
        }
        else{
            $model->phones = json_decode($model->phones);
            return $this->render('_change', ['model' => $model,'limit' => Settings::find()->where(['key' => 'users_profile_phones'])->asArray()->one()['value']]);
        }
    }

    /**
     * Creates a new Users model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Users();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                $model->image = UploadedFile::getInstance($model, 'image');
                $model->upload();
                $model->setType($model->id);
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Создать",
                    'forceClose' => true,
                ];
            }else{           
                return [
                    'title'=> "Создать",
                    'size' => 'large',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить ',['class'=>'btn btn-primary','type'=>"submit"])
        
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
                ]);
            }
        }
       
    }
    /**
    * Yangi moderatorlar qo'shish uchun action
    * Developer t.me/zoxidovuz
    * @param Qabul qilmaydi
    * @return mixed
    */
    public function actionCreateModerator()
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $model = new Users();  

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->validate() && isset($post['roles'])){
                $model->save();
                $model->image = UploadedFile::getInstance($model, 'image');
                $model->upload();
                $model->setRoles($post);
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Создать",
                    'forceClose' => true,
        
                ];         
            }else{           
                return [
                    'title'=> "Создать",
                    'size' => 'large',
                    'content'=>$this->renderAjax('moderator/create-moderator', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить ',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }
       
    }
    /**
    * Admin foydalanuvchi malumotlarini tahrirlash uchun oyna
    * Developer t.me/zoxidovuz
    * @param integer turidagi id qabul qiladi
    * @return mixed
    */
    public function actionEditInfo($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       
            if ($model->load($request->post()) && $model->save()) {
                $model->image = UploadedFile::getInstance($model, 'image');
                $model->resume = UploadedFile::getInstance($model, 'resume');
                $model->upload();
                $model->uploadResume();
                $post = $request->post();
                $model->phones($post);

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                if ($model->birthday != null) {
                    $model->birthday = date("d.m.Y", strtotime($model->birthday));
                }
                $model->phones =json_decode($model->phones);
                return $this->render('_edit-info', [
                    'model' => $model,
                    'limit' => Settings::find()->where(['key' => 'users_profile_phones'])->asArray()->one()['value']
                ]);
            }
    }
    /**
    * Developer t.me/zoxidovuz
    * Moderatorlarni izmenit qilish uchun action
    * Ajax so'rov orqali chaqiriladi
    * @param Integer turidagi id qabul qiladi
    * @return mixed
    */
    public function actionEditModerator($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       
            if ($model->load($request->post()) && $model->save()) {
                $model->image = UploadedFile::getInstance($model, 'image');
                $model->resume = UploadedFile::getInstance($model, 'resume');
                $model->upload();
                $model->uploadResume();
                $post = $request->post();
                $model->phones($post);
                $model->setRoles($post);

                return $this->redirect(['moderator-view', 'id' => $model->id]);
            } else {
                if ($model->birthday != null) {
                    $model->birthday = date("d.m.Y", strtotime($model->birthday));
                }
                $model->phones =json_decode($model->phones);
                return $this->render('moderator/_edit_moderator', [
                    'model' => $model,
                    'limit' => Settings::find()->where(['key' => 'users_profile_phones'])->asArray()->one()['value']
                ]);
            }
    }
    /**
    * Developer t.me/zoxidovuz
    * Admin biron user profiliga kirishi va unga kommnet biriktirishi uchun action
    * Ajax so'rov orqali chaqiriladi
    * @param Integer turidagi id qabul qiladi
    * @return mixed
    */
    public function actionAddComment($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'forceClose' => true,        
                ];         
            }else{           
                return [
                    'title'=> "Комментарии",
                    'content'=>$this->renderAjax('add-comment', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить ',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }
    }

    /**
    * Developer Umidjon Zoxidov t.me/zoxidovuz
    * Admin foydalanuvchi statusini o'zgartirishi mumkun.
    * Ajax so'rov orqali chaqiriladi
    * @param Integer turidagi id qabul qiladi
    * @return mixed
    */
    public function actionChangeStatus($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'forceClose' => true,        
                ];         
            }else{           
                return [
                    'title'=> "Изменить статус",
                    'content'=>$this->renderAjax('change-status', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить ',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }


    }
    /**
     * Delete an existing Users model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->delete();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            return $this->redirect(['index']);
        }


    }
    /**
    * Developer Umidjon Zoxidov t.me/zoxidovuz
    * Admin panel orqali usrning malumotlari tahrirlanayotganda 
    * check orqali qiymatlarini o'zgartirish mumkun
    * Ajax so'rov orqali chaqiriladi
    * @param Integer turidagi id qabul qiladi
    * @return mixed
    */
    public function actionChangeValues(){
        $request = Yii::$app->request;
        $id = $request->post('id');
        $name = $request->post('name');
        $value = Yii::$app->db->createCommand("SELECT ".$name ." FROM users WHERE id='".$id."'")->queryOne();
        if ($value[$name] == 1) {
            Yii::$app->db->createCommand()->update('users', [$name => 0], ['id' => $id])->execute();
        }else{
            Yii::$app->db->createCommand()->update('users', [$name => 1], ['id' => $id])->execute();
        }
    }

    public function actionChangeIsVerifyValues()
    {
        $id = $_POST['id'];
        $model = Users::findOne($id);
        if($model->is_verify == 0) {$model->is_verify = 1;}
        else {$model->is_verify = 0;}
        $model->save(false);
    }
    /**
    * Developer Umidjon Zoxidov t.me/zoxidovuz
    * Foydalanuvchi o'z do'konini ko'rish uchun action
    * Ajax so'rov orqali chaqiriladi
    * @param Integer turidagi id qabul qiladi
    * @return mixed
    */
    public function actionViewShops($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            // Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('view_shops', [
                'model' => Shops::findOne($id),
            ]);
        }else{
            return $this->render('view_shops', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    /**
    * Developer Umidjon Zoxidov t.me/zoxidovuz
    * Do'konni o'chirish
    * Ajax so'rov orqali chaqiriladi
    * @param Integer turidagi id qabul qiladi
    * @return mixed
    */
    public function actionDeleteShops($id)
    {
        $request = Yii::$app->request;
        $model = Shops::findOne($id);
        $model->delete();
    }
     /**
     * Delete multiple existing Users model.
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
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }
    /**
    * Regionlar nomi uchun
    * Developer t.me/zoxidovuz
    * @param Qabul qilmaydi
    * @return mixed
    */
    public function actionDistricts()
    {  
        $request = Yii::$app->request;
        $id = $request->post('id');
        $district = Districts::find()->where(['region_id' => $id])->all();
        echo "<option disable >Выберите</option>" ;  
        foreach ($district as $value) { 
            echo "<option value = '".$value->id."'>".$value->name."</option>" ;            
        }
    }
    /**
    * Resyume faylini yuklash olib uchun fayl
    * Developer t.me/zoxidovuz
    * @param String turidagi fayl nomini qabul qiladi
    * @return fayl qaytarad
    */
    public function actionSendFile($file)
    {  
        $image_site = Yii::$app->params['image_site'];
        return Yii::$app->response->xSendFile($image_site.'/web/uploads/resume/'.$file)->send();
    }
}
