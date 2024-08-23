<?php
namespace backend\controllers;

use backend\components\StaticFunction;
use backend\models\bills\Bills;
use backend\models\items\Items;
use backend\models\items\ItemsViews;
use backend\models\shops\Services;
use backend\models\shops\Shops;
use backend\models\users\RoleMethods;
use backend\models\users\Users;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\HttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login','register','reset-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'avtorizatsiya','error','register','reset-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
   public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    /**
     * Displays homepage.
     *
     * @return string
     * @throws \yii\db\Exception
     */
    public function beforeAction($action)
    {
        $roles = RoleMethods::getUsersRole();
        $listing = RoleMethods::getAccess($roles , 'desktop', 'statistika');

        if($listing)
        {
            if($action->id =='index')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }


        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);

    }


    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }
        $end = date("Y-m-d", strtotime("+1 days", strtotime(date("Y-m-d"))));
        $begin_old = date("Y-m-d", strtotime("-14 days", strtotime($end)));
        $begin = date("Y-m-d", strtotime("-7 days", strtotime($end)));
        $items_count = Items::find()->select('id')->asArray()->count('*');
        $service_count = Services::find()->count('*');

        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql'){
            $array_date = StaticFunction::items_dateBy(Items::find()->select(['to_char(date_cr,  \'YYYY-MM-DD\') as date_cr', 'COUNT(*) AS count'])->where(['between', 'to_char(date_cr,  \'YYYY-MM-DD\')', $begin, $end])->groupBy(['to_char(date_cr,  \'YYYY-MM-DD\')'])
                ->orderBy('date_cr ASC')->asArray()->all(), $begin, $end);
            $items = Items::circleChart();
            $items_labels = Items::laelPie(Items::getStatusLabel(), $items);

            $users = [ Users::find()->count('*'), Users::find()->where(['between', 'to_char(last_seen,  \'YYYY-MM-DD\')',date("Y-m-d", strtotime("-1 month", strtotime($end))), $end])
                ->count('*')];
            $shops = [ Shops::find()->count('*'), Shops::find()->join('INNER JOIN', 'items', 'shops.id = items.shop_id')
                ->where(['between', 'to_char(items.date_cr,  \'YYYY-MM-DD\')', date("Y-m-d", strtotime("-1 month", strtotime($end))), $end])
                ->count('*')];

            $user_array = StaticFunction::percent_dateBy(Users::find()->select(['to_char(registry_date,  \'YYYY-MM-DD\') as date_cr', 'COUNT(*) AS count'])
                ->where(['between', 'registry_date', $begin, $end])
                ->groupBy(['to_char(registry_date,  \'YYYY-MM-DD\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin, $end);

            $old_user_array = StaticFunction::percent_dateBy(Users::find()->select(['to_char(registry_date,  \'YYYY-MM-DD\') as date_cr', 'COUNT(*) AS count'])
                ->where(['between', 'registry_date', $begin_old, $begin])
                ->groupBy(['to_char(registry_date,  \'YYYY-MM-DD\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin_old, $begin);

            $contact_array = StaticFunction::percent_dateBy(ItemsViews::find()->select(['to_char(period,  \'YYYY-MM-DD\') as date_cr', 'SUM(contacts_views) AS count'])
                ->andWhere(['between', 'period', $begin, $end])
                ->andWhere(['!=','contacts_views',0])
                ->groupBy(['to_char(period,  \'YYYY-MM-DD\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin, $end);

            $old_contact_array = StaticFunction::percent_dateBy(ItemsViews::find()->select(['to_char(period,  \'YYYY-MM-DD\') as date_cr', 'SUM(contacts_views) AS count'])
                ->andWhere(['between', 'period', $begin_old, $begin])
                ->andWhere(['!=','contacts_views',0])
                ->groupBy(['to_char(period,  \'YYYY-MM-DD\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin_old, $begin);

            $payment_array = StaticFunction::percent_dateBy(Bills::find()->select(['to_char(date_cr,  \'YYYY-MM-DD\') as date_cr', 'SUM(2000) AS count'])
                ->andWhere(['between', 'date_cr', $begin, $end])
                ->andWhere(['status' => 2,'type' =>1])
                ->groupBy(['to_char(date_cr,  \'YYYY-MM-DD\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin, $end);

            $old_payment_array = StaticFunction::percent_dateBy(Bills::find()->select(['to_char(date_cr,  \'YYYY-MM-DD\') as date_cr', 'SUM(2000) AS count'])
                ->andWhere(['between', 'date_cr', $begin_old, $begin])
                ->andWhere(['status' => 2,'type' =>1])
                ->groupBy(['to_char(date_cr,  \'YYYY-MM-DD\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin_old, $begin);

            $user_percent = StaticFunction::getPercentStatistic($old_user_array ,$user_array);

            $user_contact = StaticFunction::getPercentStatistic($old_contact_array ,$contact_array);

            $user_payment = StaticFunction::getPercentStatistic($old_payment_array ,$payment_array);


            $array_shops = StaticFunction::items_dateBy(Shops::find()->select(['to_char(date_cr,  \'YYYY-MM-DD\') as date_cr', 'COUNT(*) AS count'])
                ->where(['between', 'to_char(date_cr,  \'YYYY-MM-DD\')', $begin, $end])->groupBy(['to_char(date_cr,  \'YYYY-MM-DD\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin, $end);
        }else{
            $array_date = StaticFunction::items_dateBy(Items::find()->select(['convert(date_cr, DATE) as date_cr', 'COUNT(*) AS count'])->where(['between', 'convert(date_cr, DATE)', $begin, $end])->groupBy(['convert(date_cr, DATE)'])
                ->asArray()->all(), $begin, $end);
            $items = Items::circleChart();
            $items_labels = Items::laelPie(Items::getStatusLabel(), $items);
            $users = [ Users::find()->asArray()->count(), Users::find()->where(['between', 'convert(last_seen, DATE)', date("Y-m-d", strtotime("-1 month", strtotime($end))), $end])
                ->count('*')];
            $shops = [ Shops::find()->asArray()->count(), Shops::find()->join('INNER JOIN', 'items', 'shops.id = items.shop_id')
                ->where(['between', 'convert(items.date_cr, DATE)', date("Y-m-d", strtotime("-1 month", strtotime($end))), $end])
                ->count('
                *')];
            $user_array = StaticFunction::items_dateBy(Users::find()->select(['convert(registry_date, DATE) as date_cr', 'COUNT(*) AS count'])
                ->where(['between', 'convert(registry_date, DATE)', $begin, $end])
                ->groupBy(['convert(registry_date, DATE)'])
                ->asArray()->all(), $begin, $end);
            $array_shops = StaticFunction::items_dateBy(Shops::find()->select(['convert(date_cr, DATE) as date_cr', 'COUNT(*) AS count'])
                ->where(['between', 'convert(date_cr, DATE)', $begin, $end])->groupBy(['convert(date_cr, DATE)'])
                ->asArray()->all(), $begin, $end);
        }

        return $this->render('index', compact(['user_payment','user_contact','user_percent','items', 'items_labels', 'array_date', 'users', 'user_array', 'shops', 'array_shops','items_count', 'service_count']));
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }


    /**
     * @return string|\yii\web\Response
     */
    public function actionRegister()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();

        if($model->load(Yii::$app->request->post()) && $model->register())
        {

            $login_model = new LoginForm();
            $login_model->username = $model->login;
            $login_model->password = $model->password;
            if ($login_model->login()) {
                return $this->goBack();
            }
            else return $this->redirect(['login']);
        } else {
            return $this->render('register', [
                'model' => $model,
            ]);
        }
    }


    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function actionResetPassword()
    {
        $model = new ResetPassword();
        if ($model->load(Yii::$app->request->post())) {
          
                $user = Users::findOne(['email' => $model->email]);
                $newpassword = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
                $message = Yii::$app->mailer->compose();
                $message->setFrom('itake1110@gmail.com');
                $message->setTo($model->email)
                    ->setSubject('Восстановление пароля')
                    ->setHtmlBody('Уважаемый(ая)' . $user->fio . ' !' . ' Ваш пароль был успешно восстановлен.' . ', ваш пароль:' . $newpassword . '. Для того, чтобы пройти авторизацию, войдите ниже указанному ссылку: ' . 'http://' . $_SERVER['SERVER_NAME'])
                    ->send();
                Yii::$app->db->createCommand()->update('users', ['password' => Yii::$app->security->generatePasswordHash($newpassword)], ['id' => $user->id])->execute();
                Yii::$app->session->setFlash('success','Успешно завершено. Мы отправили информацию на почту');
                return $this->goHome();
           
        }
        else {
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }
        return $this->render('reset-password', [
            'model' => $model,
        ]);
        
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['login']);
    }


    /**
     * @return string
     */
    public function actionAvtorizatsiya()
    {
      if(isset(Yii::$app->user->identity->id))
      {
        return $this->render('error');
      }        
       else
        {
            Yii::$app->user->logout();
            $this->redirect(['login']);
        }

    }


    public function actionSetThemeValues()
    {
        $session = Yii::$app->session;
        if (isset($_POST['sd_position'])) $session['sd_position'] = $_POST['sd_position'];

        if (isset($_POST['header_styling'])) $session['header_styling'] = $_POST['header_styling'];

        if (isset($_POST['sd_styling'])) $session['sd_styling'] = $_POST['sd_styling'];

        if (isset($_POST['cn_gradiyent'])) $session['cn_gradiyent'] = $_POST['cn_gradiyent'];

        if (isset($_POST['cn_style'])) $session['cn_style'] = $_POST['cn_style'];

        if (isset($_POST['boxed'])) $session['boxed'] = $_POST['boxed'];

    }


    /**
     * @return int|mixed
     */
    public function actionSdPosition()
    {
        $session = Yii::$app->session;
        if($session['sd_position'] != null) return $session['sd_position'];
        else return 1;
    }


    /**
     * @return int|mixed
     */
    public function actionHeaderStyling()
    {
        $session = Yii::$app->session;
        if($session['header_styling'] != null) return $session['header_styling'];
        else return 1;
    }


    /**
     * @return int|mixed
     */
    public function actionSdStyling()
    {
        $session = Yii::$app->session;
        if($session['sd_styling'] != null) return $session['sd_styling'];
        else return 1;
    }


    /**
     * @return int|mixed
     */
    public function actionCnGradiyent()
    {
        $session = Yii::$app->session;
        if($session['cn_gradiyent'] != null) return $session['cn_gradiyent'];
        else return 1;
    }


    /**
     * @return int|mixed
     */
    public function actionCnStyle()
    {
        $session = Yii::$app->session;
        if($session['cn_style'] != null) return $session['cn_style'];
        else return 1;
    }


    /**
     * @return int|mixed
     */
    public function actionBoxed()
    {
        $session = Yii::$app->session;
        if($session['boxed'] != null) return $session['boxed'];
        else return 1;
    } 

}

