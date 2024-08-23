<?php


namespace backend\controllers\references;


use backend\components\ParserOlx;
use backend\models\users\RoleMethods;
use backend\models\users\Users;
use backend\models\references\CroneOlx;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use backend\components\Parser;
use yii\web\HttpException;

class ParserController extends Controller
{

    public function behaviors()
    {
        return [
            /*'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],*/
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
        $parser = RoleMethods::getAccess($roles , 'parser', 'parser');
        $parser_mexnat_uz = RoleMethods::getAccess($roles , 'parser', 'parser-mexnat-uz');
        $parser_olx = RoleMethods::getAccess($roles , 'parser', 'parser-olx');
        $olx_business = RoleMethods::getAccess($roles , 'parser', 'olx-business');

        if($parser && $parser_mexnat_uz && $parser_olx && $olx_business)
        {
            if($action->id != null)
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($parser_olx)
        {
            if($action->id =='parser-olx')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($parser_mexnat_uz)
        {
            if($action->id =='parser')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        if($olx_business)
        {
            if($action->id =='olx-business')
                throw new HttpException(405,'У вас нет разрешения на доступ к этому действию.');
        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * parser listi
     * @return string
     */
    public function actionIndex()
    {
        $parser = new Parser();
        return $this->render('index', ['categories' => $parser->getUrls()]);
    }


    /**
     * marser qilish
     * @param $category
     * @return string
     */
    public function actionParsing($category)
    {
        header('Content-type: text/html; charset=utf-8');

        $parser = new Parser();
        $url = $parser->getUrls($category);
        $file = $parser->set(CURLOPT_FOLLOWLOCATION, true)->exec($url['url']);
        $result = $parser->getVacancy($file)->saveVacancy($url['category_bisyor']);

        return $this->render('response', ['status' => $result]);
    }


    /**
     * parsing for crone
     * @return string
     */
    public function actionParsingCrone()
    {
        header('Content-type: text/html; charset=utf-8');

        $arrayList = Parser::URLS;
        foreach ($arrayList as $key => $value) {
            $parser = new Parser();
            $parser->setResultNull();
            $url = $parser->getUrls($key);
            $file = $parser->set(CURLOPT_FOLLOWLOCATION, true)->exec($url['url']);
            $result = $parser->getVacancy($file)->saveVacancy($url['category_bisyor']);
        }

        return $this->render('response', ['status' => $result]);
    }

    /**
     * Olxdan userlarning elonlarini ko'chirib o'tkazish
     *
     * @return string
     */
    public function actionOlx(){
        $data = file_get_contents (Yii::$app->basePath. '/components/data/parsing.json');
        $request = Yii::$app->request;
        if($request->isPost){
            header('Content-type: text/html; charset=utf-8');
            $url = $request->getBodyParam('link');
            $parser = new ParserOlx();
            $parser->setResultNull();
            $file = $parser->set(CURLOPT_FOLLOWLOCATION, true)->exec($url);
            $parser->getOfferOlx($file);
            $result  = $this->loadAndSave($request, $parser);
            return $this->render('response_olx', [
                'status' => $result['success'],
                'failed' => $result['failed'],
                'type' => 1]);
        }

        return $this->render('parser_olx', ['attention' => 'Обратите внимание, что ссылка взята с русской страницы!',
            'title' => "Парсинг OLX"]);

    }

    /**
     * Olxda biznes sahifadan elonlarni ko'chirib o'tkazish
     *
     * @return string
     */
    public function actionOlxBusiness(){
        $request = Yii::$app->request;
        if($request->isPost){
            header('Content-type: text/html; charset=utf-8');
            $url = $request->getBodyParam('link');
            $url = str_replace('#items', '', $url);
            $parser = new ParserOlx();
            $parser->setResultNull();
            $file = $parser->set(CURLOPT_FOLLOWLOCATION, true)->exec($url);

            $parser->getOfferOlxBusiness($file, rtrim($url, '/'));
            $result  = $this->loadAndSave($request, $parser);
            return $this->render('response_olx', ['status' => $result['success'], 'failed' => $result['failed'], 'type' => 2]);
        }
        return $this->render('parser_olx',
            [
                'attention' => 'Обратите внимание, что ссылка взята с русской страницы! <br> Пример: https://bekservicecentre.olx.uz',
                'title' => " OLX Бизнес-страница"
            ]
        );
    }

    /**
     * Cron bilan elonlarni oxirigi sanadan bir kun oldin kiritilgan elonlarni yuklab olish
     */
    public function actionCroneOlx(){
        $olx_users = CroneOlx::find()
            ->where(['between', 'today_date', date('Y-m-d 00:00:01'),  date('Y-m-d H:i:s')])
            ->andWhere(['status' => 0])->with('user')->limit(3)
            ->all();

        $data = file_get_contents (Yii::$app->basePath. '/components/data/parsing.json');
        $offers_in_reserve = $json = json_decode($data, true);
        $parser = new ParserOlx();
        $count_reserve = count($offers_in_reserve);
        if( $count_reserve > 0){
            if($count_reserve > ParserOlx::LIMIT_PARSING){
                $pars_data = array_slice($offers_in_reserve, 0, ParserOlx::LIMIT_PARSING);
                array_splice($offers_in_reserve, 0, ParserOlx::LIMIT_PARSING);
            }else{
                $pars_data = $offers_in_reserve;
                $offers_in_reserve = [];
            }
            $fp = fopen(Yii::$app->basePath . '/components/data/parsing.json', 'w');
            fwrite($fp, json_encode($offers_in_reserve));
            fclose($fp);
            $parser->readFromJsonSetToBase($pars_data);
        }elseif($olx_users){
            foreach ($olx_users as $key => $value){
                $parser = new ParserOlx();
                if(is_numeric($value->olx_link)){
                    continue;
                }
                $file = $parser->set(CURLOPT_FOLLOWLOCATION, true)->exec($value->olx_link);
                $parsing_date = date('d', strtotime($value->today_date. '-1 days'));
                if($parser->isShop($value->olx_link)){

                    $value->olx_link = rtrim(str_replace('#items', '', $value->olx_link), '/');
                    $parser->getOfferOlxBusiness($file, $value->olx_link, $parsing_date);
                }else{
                    $parser->getOfferOlx($file, $parsing_date);
                }
                $parser->saveOffer($value->user_id, $value->user->district_id, $value->user->phone, 30);
                $value->status = 1;
                $value->save();
                $parser->setResultNull();
            }
        }
    }

    /**
     * Parser masivga elonlarni yuklab olgandan so'ng bu funksiya bilan uni bazaga saqlashni boshlaymiz
     * Ma'lumotlarni formadan oladi  va userni tekshiradi
     *
     * @param $request
     * @param $parser
     * @return mixed
     */
    protected function loadAndSave($request, $parser){
        $fio = $request->getBodyParam('fio');
        $district_id = $request->getBodyParam('district_id');
        $phone = $request->getBodyParam('phone');
        $url = $request->getBodyParam('link');
        $publicated_period = $request->getBodyParam('publicated_period');
        $user = $this->checkUser($phone, $fio, $district_id, $url);
        return $parser->saveOffer($user->id, $district_id, $user->phone, $publicated_period);
    }

    /**
     * User mavjud yoki yo'qligini tekshiradi
     * Agar mavjud bo'lsa o'sha userni aks xolda yangi user ochib qaytaradi
     *
     * @param $phone
     * @param $fio
     * @param $district_id
     * @param $olx_link
     * @return array|Users|bool|\yii\db\ActiveRecord|null
     */
    protected function checkUser($phone, $fio, $district_id, $olx_link){
        $phone = str_replace("-", "", $phone);
        $user = Users::find()->where(['phone' => $phone])->one();
        if(!$user){
            $user = Users::addUser($phone, $fio, $district_id, $olx_link);
            if(!$user){
                echo "User qo'shishda xatolik chiqdi!";
                die;
            }
        }
        return $user;
    }


}