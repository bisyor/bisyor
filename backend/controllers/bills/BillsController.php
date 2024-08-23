<?php

namespace backend\controllers\bills;

use backend\models\alerts\Alerts;
use Yii;
use backend\models\bills\Bills;
use backend\models\users\Users;
use backend\models\bills\Payment;
use backend\models\bills\Operation;
use backend\models\bills\BillsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \yii\web\Response;
use yii\helpers\Html;
use backend\models\users\RoleMethods;
use yii\web\HttpException;
use backend\components\StaticFunction;

/**
 * BillsController реализует действия CRUD для Bills модель.
 */
class BillsController extends Controller
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
     * permission berish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $bills = RoleMethods::getAccess($roles , 'bills', 'bills');
        $listing = RoleMethods::getAccess($roles , 'bills', 'listing');
        $manage = RoleMethods::getAccess($roles , 'bills', 'manage');
        $payways = RoleMethods::getAccess($roles , 'bills', 'payways');

        if($bills && $listing && $manage && $payways)
        {   
            if($action->id =='index' || $action->id =='view' || $action->id =='create' || $action->id =='delete' || $action->id =='update')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($listing)
        {   
            if($action->id =='index' || $action->id =='view' )
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($manage)
        {   
            if($action->id =='delete' || $action->id =='update' || $action->id =='create')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * billsni listini olish
     * @param null $item_id
     * @return string
     */
    public function actionIndex($item_id = null)
    {
        /////
        if($item_id){
            Yii::$app->request->setQueryParams(
                    [
                            'BillsSearch' => [
                                    'item_id' => $item_id
                            ],
                    ]
            );   
            $item_id = null;
        }
        /////
        
        $request = Yii::$app->request;
        $get = $request->get();
        $searchModel = new BillsSearch();
        $dataProvider = $searchModel->search($request->queryParams, '');
        $dataZavershen = $searchModel->search($request->queryParams, Bills::STATUS_ZAVERSHEN);
        $dataNezavershen = $searchModel->search($request->queryParams, Bills::STATUS_NEZAVERSHEN);
        $dataOtmenen = $searchModel->search($request->queryParams, Bills::STATUS_OTMEN);
        $dataObrabat = $searchModel->search($request->queryParams, Bills::STATUS_OBRABOT);

        return $this->render('index', compact(['get','searchModel', 'dataProvider', 'dataZavershen', 'dataNezavershen', 'dataOtmenen', 'dataObrabat']));
    }


    /**
     * tolov qilgan userni korish
     * @param $id
     * @return array|string
     * @throws NotFoundHttpException
     */
    public function actionUserInfo($id)
    {
        $user = $this->findModel($id)->user;
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "<p class='text-center'><b>Информация о пользователе</b></p>",
                    'size' => 'large',
                    'content'=>$this->renderAjax('user-info', [
                        'model' => $user,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-sm btn-inverse pull-left','data-dismiss'=>"modal"]).
                            Html::a('Редактировать #' . $user->id,['/users/users/edit-info','id'=>$user->id],['class'=>'btn btn-sm btn-primary','data-pjax' => 0])
                ];    
        }else{
            return $this->render('user-info', [
                'model' => $user,
            ]);
        }
    }


    /**
     * userni statusini ozgartish
     * @param $id
     * @param $status
     * @return array
     * @throws \yii\db\Exception
     */
    public function actionChangeStatusUser($id,$status)
    {
        $request = Yii::$app->request;
        Yii::$app->db->createCommand()
             ->update('users', ['status' => $status], ['id' => $id])
             ->execute();
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'crud-datatable-pjax2'];
        }
    }


    /**
     * xisobni toldirish
     * @param $user_id
     * @return string|Response
     */
    public function actionOperation($user_id)
    {
        $request = Yii::$app->request;
        $model = new Payment();
        $operation = new Operation();

        $user = null;
        $user = Users::find()->where(['id' => $user_id])->one();
        if($user->email != null){
            $model->user_id = $user->email;
            $operation->user_id = $user->email;
        }
        else {
            $model->user_id = $user->phone;
            $operation->user_id = $user->phone;
        }

        if ($model->load($request->post()) && $model->validate() && $user != null ) {
            $model->price = str_replace(' ','', $model->price);
            $bill_api = StaticFunction::file_get_contents_curl('https://api.bisyor.uz/api/v1/additional/create-bill?user_id='.$user->id.'&type=2&amount='.$model->price.'&description='.str_replace(' ','+',$model->description));
            $bill_api = json_decode($bill_api);
            if(true){
                if($model->notification){
                    Alerts::sendUserBalanceAdminPlus($model->price , $model->getUserBalanse($user_id) , $user_id);
                }
                Yii::$app->session->setFlash('success',$bill_api->message);
                return $this->redirect(['bills/bills?BillsSearch[user_id]='.$user_id.'']);
            }
            else {
                Yii::$app->session->setFlash('error',$bill_api->message);
                    return $this->render('operation', [
                        'model' => $model,
                        'operation' => $operation,
                        'user_id' => $user_id,
                ]);
            }
        }

        if ($operation->load($request->post()) && $operation->validate() && $user != null ) {
            $operation->price = str_replace(' ','', $operation->price);
            $bill_api = StaticFunction::file_get_contents_curl('https://api.bisyor.uz/api/v1/additional/create-bill?user_id='.$user->id.'&type=3&amount='.$operation->price.'&description='.str_replace(' ','+',$operation->description));
            $bill_api = json_decode($bill_api);
            if($bill_api->status){
                Yii::$app->session->setFlash('success',$bill_api->message);
                return $this->redirect(['bills/bills?BillsSearch[user_id]='.$user_id.'']);
            }
            else {  
                    Yii::$app->session->setFlash('error',$bill_api->message);
                    return $this->render('operation', [
                        'model' => $model,
                        'operation' => $operation,
                        'user_id' => $user_id,
                    ]);
            }
        }
        
        return $this->render('operation', [
                'model' => $model,
                'operation' => $operation,
                 'user_id' => $user_id,
        ]);
    }

    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Находит модель Bills На основе значения ее первичного ключа.
     * Если модель не найдена, будет выдано исключение 404 HTTP.
     * @param integer $id
     * @return Bills загруженная модель
     * @throws NotFoundHttpException если модель не может быть найдена
     */
    protected function findModel($id)
    {
        if (($model = Bills::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }
}
