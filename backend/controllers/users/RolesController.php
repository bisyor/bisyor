<?php

namespace backend\controllers\users;

use backend\models\users\RoleMethods;
use Yii;
use backend\models\users\Roles;
use backend\models\searchs\RolesSearch;
use backend\models\users\UserRoles;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\web\HttpException;

/**
 * RolesController implements the CRUD actions for Roles model.
 */
class RolesController extends Controller
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
        $groups_listing = RoleMethods::getAccess($roles , 'users', 'groups-listing');
        $groups_edit = RoleMethods::getAccess($roles , 'users', 'groups-edit');
       
        if($users && $groups_listing && $groups_edit )
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($groups_listing)
        {   
            if($action->id =='index' || $action->id =='view')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($groups_edit)
        {   
            if($action->id =='create' || $action->id =='update' || $action->id =='delete' || $action->id =='methods')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {    
        $searchModel = new RolesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Roles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Группы",
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Отмена',['class'=>'btn btn-inverse pull-left','data-dismiss'=>"modal"]).
                            Html::a('Изменить',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Roles model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Roles();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'body',
                    'forceClose' => true,        
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
     * Updates an existing Roles model.
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
                return [
                    'forceReload'=>'body',
                    'forceClose' => true,
                ];    
            }else{
                 return [
                    'title'=> "Изменить",
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
     * Developer t.me/zoxidovuz
     * Rolllarni admin huduqularni almashtirish
     * Ajax so'rov orqali bajariladi
     * @param post qabul qiladi
     * @return qaytarmaydi
     */

    public function actionChangeValues(){
        $request = Yii::$app->request;
        $id = $request->post('id');
        $model = $this->findModel($id); 
        if($model->admin_access == 1){
            $model->admin_access = 0;
        }else{
            $model->admin_access = 1;
        }
        $model->save();
    }

    /**
     * Delete an existing Roles model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $userRoles = UserRoles::find()->where(['role_id' => $id])->all();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(!empty($userRoles)){
                return [
                    'title'=> "Внимание !!!",
                    'content'=>"Прикрепленных к этому ролью пользователей перенося к другому ролью, потом удаляйте.",
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-right','data-dismiss'=>"modal"]),
                ];        
            }else{
                $this->findModel($id)->delete();
                return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
            }
        }
    }
    /*
     * Dasturchi Zoxidov Umidjon t.me/zoxidovuz
     * Rollarni metodlar berish uchun action
     * Rol idsini qabul qilib oladi va shu rolning metodlarini qaytaradi.
     * Agar formada malumotlar kelsa uni mos ravishda saqlaydi
     * */
    public function actionMethods($id){
        $request = Yii::$app->request;
        $post = $request->post();
        $methods = RoleMethods::find()->join("LEFT JOIN", "module_methods", 'role_methods.method_id = module_methods.id')
            ->select(['role_methods.id', 'module_methods.title', 'module_methods.module',  'module_methods.method', 'role_methods.value'])
            ->where(['role_id' => $id])->orderBy(['role_methods.id' =>SORT_ASC])->asArray()->all();
        if ($post){
            Roles::saveMethods($methods, $post);
           return $this->redirect('index');
        }else{
            return $this->render('role_methods', Roles::itemsMethods($methods, $id));
        }
    }

    /**
     * Finds the Roles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Roles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Roles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
