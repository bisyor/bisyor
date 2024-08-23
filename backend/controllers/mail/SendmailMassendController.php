<?php

namespace backend\controllers\mail;

use backend\models\bills\Bills;
use backend\models\mail\SendmailMassendUser;
use backend\models\users\Users;
use Yii;
use yii\web\HttpException;  
use backend\models\mail\SendmailMassend;
use backend\models\mail\SendmailMassendSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \yii\web\Response;
use yii\helpers\Html;
use backend\models\users\RoleMethods;

/**
 * SendmailMassendController реализует действия CRUD для SendmailMassend модель.
 */
class SendmailMassendController extends Controller
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


    public function actionIndexTest($text = null){
        $msg = $text ?? 'Kitob o‘qib turibsizmi? Robert Kiyosakidan: Yollanma ishchining tadbirkorga aylanishi va kichik biznesdan katta biznesga deb nomlangan kitobni xoziroq xarid qiling. Onlayn buyurtma berish uchun 👉https://cutt.ly/mT2s7Fn';
        $model = new SendmailMassendUser();
        return $model->sendOurSmsServiceData('+998935079724' , $msg);
    }

    /**
     * shu controllerga tegishli ruxsatlarni tekshrish
     * @param \yii\base\Action $action
     * @return bool
     * @throws HttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $sendmail = RoleMethods::getAccess($roles , 'sendmail', 'sendmail');
        $massend = RoleMethods::getAccess($roles , 'sendmail', 'massend');
       
        if($sendmail && $massend )
        {   
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($massend)
        {   
            if($action->id =='create' ||  $action->id =='resend')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $searchModel = new SendmailMassendSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Отображает один SendmailMassend model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $dataProvider = SendmailMassendUser::search(Yii::$app->request->queryParams, $id);
        return $this->render('view', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * ketmay qolgan messageni yana junatvorish
     * @param $id
     * @return array
     */

    public function actionResend($id){
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = SendmailMassendUser::find()->where(['sendmail_massend_user.id' => $id])->joinWith('user')->one();
            $phone = $model->user->phone ?? $model->phone;
            $phone = str_replace('-','',$phone);
            $phone = str_replace(' ','',$phone);
            if($model->to_phone && $model->validateNumber($phone)){
                if($model->service_id == 1 && $model->sendSms($phone, $model->text, $model->getSmsAccessToken())){
                    $model->status = 1;
                    $model->save();
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Сообщение",
                        'content'=> 'Успешно отправлен',
                        'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-right','data-dismiss'=>"modal"])
                    ];
                }elseif($model->service_id == 2 && $model->sendOurSmsServiceData($phone, $model->text)){
                    $model->status = 1;
                    $model->save();
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Сообщение",
                        'content'=> 'Успешно отправлен',
                        'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-right','data-dismiss'=>"modal"])
                    ];
                }
                else{
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Сообщение",
                        'content'=> 'Неудачная отправка',
                        'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-right','data-dismiss'=>"modal"])
                    ];
                }
            }else{
                if ($model->sendEmail()){
                    $model->status = 1;
                    $model->save();
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Сообщение",
                        'content'=> 'Успешно отправлен',
                        'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-right','data-dismiss'=>"modal"])
                    ];
                }else{
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Сообщение",
                        'content'=> 'Неудачная отправка',
                        'footer'=> Html::button('Закрыть',['class'=>'btn btn-inverse pull-right','data-dismiss'=>"modal"])
                    ];
                }
            }
        }
    }



    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Создает новый SendmailMassend model.
     * Для ajax-запроса будет возвращен объект json, а для не-ajax-запроса, 
     * если создание будет успешным, браузер будет перенаправлен на страницу просмотра.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new SendmailMassend();  

        if($request->isAjax){
            /*
            *  Процесс для ajax-запроса
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'forceClose' => true
        
                ];         
            }else{
                $model->from = 'noreply@bisyor.uz';
                $model->name = 'Bisyor.uz';
                $model->to_phone = 0;
                return [
                    'title'=> "Создать",
                    'size' => 'large',
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
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
                return $this->redirect(['index']);
            } else {
                $model->from = 'noreply@bisyor.uz';
                $model->name = 'Bisyor.uz';
                $model->to_phone = 0;
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Разработчик: Umidjon Zoxidov <t.me/zoxidovuz>
     * Находит модель SendmailMassend На основе значения ее первичного ключа.
     * Если модель не найдена, будет выдано исключение 404 HTTP.
     * @param integer $id
     * @return SendmailMassend загруженная модель
     * @throws NotFoundHttpException если модель не может быть найдена
     */
    protected function findModel($id)
    {
        if (($model = SendmailMassend::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }
}
