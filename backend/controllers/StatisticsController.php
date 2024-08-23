<?php
/**
 * Created by PhpStorm.
 * Project: bisyor.loc
 * User: Umidjon <t.me/zoxidovuz>
 * Date: 13.04.2020
 * Time: 22:01
 */

namespace backend\controllers;

use backend\components\StaticFunction;
use backend\models\bills\Bills;
use backend\models\items\Categories;
use backend\models\items\Items;
use backend\models\items\ItemsViews;
use backend\models\shops\Shops;
use backend\models\users\Users;
use backend\models\users\UsersSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class StatisticsController extends Controller
{
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
     * Elonlarni 4 xil tip bo'yciha statistikasini qaytaradi
     * @return string
     * Ajax file qaytartadi
     */
    public function actionItemsChart()
    {
        $end = date("Y-m-d");
        $type = Yii::$app->request->post('type');
        switch ($type){
            case 'month' : $begin = date("Y-m-d", strtotime("-1 month", strtotime($end)));
                break;
            case 'kvartal' : $begin = date("Y-m-d", strtotime("-3 month", strtotime($end)));
                break;
            case 'year' : $begin = date("Y-m-d", strtotime("-1 year", strtotime($end)));
                break;
            default: $begin = date("Y-m-d", strtotime("-6 day", strtotime($end)));
        }
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            $array_date = Items::find()->select(['to_char(date_cr,  \'YYYY-MM-DD\') as date_cr', 'COUNT(*) AS count'])->where(['between', 'date_cr', $begin, $end])->groupBy(['to_char(date_cr,  \'YYYY-MM-DD\')'])
                ->orderBy('date_cr ASC')->asArray()->all();
        }else{
            $array_date = Items::find()->select(['convert(date_cr,  DATE) as date_cr', 'COUNT(*) AS count'])->where(['between', 'convert(date_cr,  DATE)', $begin, $end])->groupBy(['convert(date_cr,  DATE)'])
                ->orderBy('date_cr ASC')->asArray()->all();
        }
        $array_date = StaticFunction::items_dateBy($array_date, $begin, $end);

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('/site/chart_items',[
                'label_line_chart' => $array_date['label'],
                'count_line_chart' => $array_date['count'],
            ]);
        }else{
            return $this->render('/site/index', compact(['items', 'items_labels', 'label_line_chart', 'count_line_chart']));

        }
    }


    /**
     * Userlarni 4 xil tip bo'yciha statistikasini qaytaradi
     * @return string
     * Ajax file qaytartadi
     */
    public function actionUsersChart()
    {
        $end = date("Y-m-d");
        $type = Yii::$app->request->post('type');
        switch ($type){
            case 'month' : $begin = date("Y-m-d", strtotime("-1 month", strtotime($end)));
                break;
            case 'kvartal' : $begin = date("Y-m-d", strtotime("-3 month", strtotime($end)));
                break;
            case 'year' : $begin = date("Y-m-d", strtotime("-1 year", strtotime($end)));
                break;
            default: $begin = date("Y-m-d", strtotime("-6 day", strtotime($end)));
        }
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            $array_date = Users::find()->select(['to_char(registry_date,  \'YYYY-MM-DD\') as date_cr', 'COUNT(*) AS count'])
                ->where(['between', 'registry_date', $begin, $end])
                ->groupBy(['to_char(registry_date,  \'YYYY-MM-DD\')'])->orderBy('date_cr ASC')
                ->asArray()->all();
        }else{
            $array_date = Users::find()->select(['convert(registry_date,  DATE) as date_cr', 'COUNT(*) AS count'])
                ->where(['between', 'convert(registry_date,  DATE)', $begin, $end])
                ->groupBy(['convert(registry_date,  DATE)'])->orderBy('date_cr ASC')
                ->asArray()->all();
        }
        $array_date = StaticFunction::items_dateBy($array_date, $begin, $end);

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('/site/chart_user',[
                'label_user_chart' => $array_date['label'],
                'count_user_chart' => $array_date['count'],
            ]);
        }
    }


    /**
     * Magazinlarni 4 xil tip bo'yciha statistikasini qaytaradi
     * @return string
     * Ajax file qaytartadi
     */
    public function actionShopsChart()
    {
        $end = date("Y-m-d");
        $type = Yii::$app->request->post('type');
        switch ($type){
            case 'month' : $begin = date("Y-m-d", strtotime("-1 month", strtotime($end)));
                break;
            case 'kvartal' : $begin = date("Y-m-d", strtotime("-3 month", strtotime($end)));
                break;
            case 'year' : $begin = date("Y-m-d", strtotime("-1 year", strtotime($end)));
                break;
            default: $begin = date("Y-m-d", strtotime("-6 day", strtotime($end)));
        }
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            $array_date = Shops::find()->select(['to_char(date_cr,  \'YYYY-MM-DD\') as date_cr', 'COUNT(*) AS count'])
                ->where(['between', 'to_char(date_cr,  \'YYYY-MM-DD\')', $begin, $end])->groupBy(['to_char(date_cr,  \'YYYY-MM-DD\')'])->orderBy('date_cr ASC')
                ->asArray()->all();
        }else{
            $array_date = Shops::find()->select(['convert(date_cr,  DATE) as date_cr', 'COUNT(*) AS count'])
                ->where(['between', 'convert(date_cr,  DATE)', $begin, $end])->groupBy(['convert(date_cr,  DATE)'])->orderBy('date_cr ASC')
                ->asArray()->all();
        }
        $array_date = StaticFunction::items_dateBy($array_date, $begin, $end);

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('/site/chart_shops',[
                'label_shops_chart' => $array_date['label'],
                'count_shops_chart' => $array_date['count'],
            ]);
        }
    }


    /**
     * userlarni royxatdan o'tishi prosentlarda
     * @return string
     */
    public function actionPercentChart()
    {
        $end = date("Y-m-d");
        $type = Yii::$app->request->post('type');
        switch ($type){
            case 'month' : $begin = date("Y-m-d", strtotime("-1 month", strtotime($end)));
                $begin_old = date("Y-m-d", strtotime("-2 month", strtotime($end)));
                break;
            case 'kvartal' : $begin = date("Y-m", strtotime("-3 month", strtotime($end)));
                $begin_old = date("Y-m", strtotime("-6 month", strtotime($end)));
                break;
            case 'year' : $begin = date("Y-m", strtotime("-1 year", strtotime($end)));
                $begin_old = date("Y-m", strtotime("-2 year", strtotime($end)));
                break;
            default: {
                $begin = date("Y-m-d", strtotime("-7 day", strtotime($end)));
                $begin_old = date("Y-m-d", strtotime("-14 day", strtotime($end)));
            }
        }
        if(!in_array($type , ['kvartal','year']))
        {
            $user_array = StaticFunction::percent_dateBy(Users::find()->select(['to_char(registry_date,  \'YYYY-MM-DD\') as date_cr', 'COUNT(*) AS count'])
                ->where(['between', 'registry_date', $begin, $end])
                ->groupBy(['to_char(registry_date,  \'YYYY-MM-DD\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin, $end);

            $old_user_array = StaticFunction::percent_dateBy(Users::find()->select(['to_char(registry_date,  \'YYYY-MM-DD\') as date_cr', 'COUNT(*) AS count'])
                ->where(['between', 'registry_date', $begin_old, $begin])
                ->groupBy(['to_char(registry_date,  \'YYYY-MM-DD\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin_old, $begin);
            $user_percent = StaticFunction::getPercentStatistic($old_user_array ,$user_array);
        }else {
            $end = date("Y-m");
            $user_array = StaticFunction::percent_MonthBy(Users::find()->select(['to_char(registry_date,  \'YYYY-MM\') as date_cr', 'COUNT(*) AS count'])
                ->andWhere(['and',['>=','to_char(registry_date,  \'YYYY-MM\')',$begin],['<=','to_char(registry_date,  \'YYYY-MM\')',$end]])
                ->groupBy(['to_char(registry_date,  \'YYYY-MM\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin, $end);

            $old_user_array = StaticFunction::percent_MonthBy(Users::find()->select(['to_char(registry_date,  \'YYYY-MM\') as date_cr', 'COUNT(*) AS count'])
                ->andWhere(['and',['>=','to_char(registry_date,  \'YYYY-MM\')',$begin_old],['<=','to_char(registry_date,  \'YYYY-MM\')',$begin]])
                ->groupBy(['to_char(registry_date,  \'YYYY-MM\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin_old, $begin);
            $user_percent = StaticFunction::getPercentStatistic($old_user_array ,$user_array);
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('/site/percent/chart_percent',[
                'label_percent_chart' => $user_percent['label'],
                'count_percent_chart' => $user_percent['count'],
            ]);
        }
    }

    /**
     * contactlarni ko'rish sonini chiqarish foizlarda
     * @return string
     */
    public function actionContactChart()
    {
        $end = date("Y-m-d");
        $type = Yii::$app->request->post('type');
        switch ($type){
            case 'month' : $begin = date("Y-m-d", strtotime("-1 month", strtotime($end)));
                $begin_old = date("Y-m-d", strtotime("-2 month", strtotime($end)));
                break;
            case 'kvartal' : $begin = date("Y-m", strtotime("-3 month", strtotime($end)));
                $begin_old = date("Y-m", strtotime("-6 month", strtotime($end)));
                break;
            case 'year' : $begin = date("Y-m", strtotime("-1 year", strtotime($end)));
                $begin_old = date("Y-m", strtotime("-2 year", strtotime($end)));
                break;
            default: {
                $begin = date("Y-m-d", strtotime("-7 day", strtotime($end)));
                $begin_old = date("Y-m-d", strtotime("-14 day", strtotime($end)));
            }
        }
        if(!in_array($type , ['kvartal','year']))
        {
            $contact_array = StaticFunction::percent_dateBy(ItemsViews::find()->select(['to_char(period,  \'YYYY-MM-DD\') as date_cr', 'SUM(contacts_views) AS count'])
                ->where(['between', 'period', $begin, $end])
                ->andWhere(['!=','contacts_views',0])
                ->groupBy(['to_char(period,  \'YYYY-MM-DD\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin, $end);

            $old_contact_array = StaticFunction::percent_dateBy(ItemsViews::find()->select(['to_char(period,  \'YYYY-MM-DD\') as date_cr', 'SUM(contacts_views) AS count'])
                ->where(['between', 'period', $begin_old, $begin])
                ->andWhere(['!=','contacts_views',0])
                ->groupBy(['to_char(period,  \'YYYY-MM-DD\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin_old, $begin);
            $contact_percent = StaticFunction::getPercentStatistic($old_contact_array ,$contact_array);
        }else {
            $end = date("Y-m");

            $contact_array = StaticFunction::percent_MonthBy(ItemsViews::find()->select(['to_char(period,  \'YYYY-MM\') as date_cr', 'SUM(contacts_views) AS count'])
                ->andWhere(['and',['>=','to_char(period,  \'YYYY-MM\')',$begin],['<=','to_char(period,  \'YYYY-MM\')',$end]])
                ->andWhere(['!=','contacts_views',0])
                ->groupBy(['to_char(period,  \'YYYY-MM\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin, $end);

            $old_contact_array = StaticFunction::percent_MonthBy(ItemsViews::find()->select(['to_char(period,  \'YYYY-MM\') as date_cr', 'SUM(contacts_views) AS count'])
                ->andWhere(['and',['>=','to_char(period,  \'YYYY-MM\')',$begin_old],['<=','to_char(period,  \'YYYY-MM\')',$begin]])
                ->andWhere(['!=','contacts_views',0])
                ->groupBy(['to_char(period,  \'YYYY-MM\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin_old, $begin);
            $contact_percent = StaticFunction::getPercentStatistic($old_contact_array ,$contact_array);
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('/site/contacts/chart_contact',[
                'label_contact_chart' => $contact_percent['label'],
                'count_contact_chart' => $contact_percent['count'],
            ]);
        }
    }


    /**
     * payment tolangan pullar fozida
     * @return string
     */
    public function actionPaymentChart()
    {
        $end = date("Y-m-d");
        $type = Yii::$app->request->post('type');
        switch ($type){
            case 'month' : $begin = date("Y-m-d", strtotime("-1 month", strtotime($end)));
                $begin_old = date("Y-m-d", strtotime("-2 month", strtotime($end)));
                break;
            case 'kvartal' : $begin = date("Y-m", strtotime("-3 month", strtotime($end)));
                $begin_old = date("Y-m", strtotime("-6 month", strtotime($end)));
                break;
            case 'year' : $begin = date("Y-m", strtotime("-1 year", strtotime($end)));
                $begin_old = date("Y-m", strtotime("-2 year", strtotime($end)));
                break;
            default: {
                $begin = date("Y-m-d", strtotime("-7 day", strtotime($end)));
                $begin_old = date("Y-m-d", strtotime("-14 day", strtotime($end)));
            }
        }

        if(!in_array($type , ['kvartal','year']))
        {
            $payment_array = StaticFunction::percent_dateBy(Bills::find()->select(['to_char(date_cr,  \'YYYY-MM-DD\') as date_cr', 'SUM(amount) AS count'])
                ->where(['between', 'date_cr', $begin, $end])
                ->andWhere(['status' => 2,'type' =>1])
                ->groupBy(['to_char(date_cr,  \'YYYY-MM-DD\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin, $end);

            $old_payment_array = StaticFunction::percent_dateBy(Bills::find()->select(['to_char(date_cr,  \'YYYY-MM-DD\') as date_cr', 'SUM(amount) AS count'])
                ->where(['between', 'date_cr', $begin_old, $begin])
                ->andWhere(['status' => 2,'type' =>1])
                ->groupBy(['to_char(date_cr,  \'YYYY-MM-DD\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin_old, $begin);
            $payment_percent = StaticFunction::getPercentStatistic($old_payment_array ,$payment_array);
        }else {
            $end = date("Y-m");

            $payment_array = StaticFunction::percent_MonthBy(Bills::find()->select(['to_char(date_cr,  \'YYYY-MM\') as date_cr', 'SUM(amount) AS count'])
                ->andWhere(['and',['>=','to_char(date_cr,  \'YYYY-MM\')',$begin],['<=','to_char(date_cr,  \'YYYY-MM\')',$end]])
                ->andWhere(['status' => 2,'type' =>1])
                ->groupBy(['to_char(date_cr,  \'YYYY-MM\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin, $end);

            $old_payment_array = StaticFunction::percent_MonthBy(Bills::find()->select(['to_char(date_cr,  \'YYYY-MM\') as date_cr', 'SUM(amount) AS count'])
                ->andWhere(['and',['>=','to_char(date_cr,  \'YYYY-MM\')',$begin_old],['<=','to_char(date_cr,  \'YYYY-MM\')',$begin]])
                ->andWhere(['status' => 2,'type' =>1])
                ->groupBy(['to_char(date_cr,  \'YYYY-MM\')'])->orderBy('date_cr ASC')
                ->asArray()->all(), $begin_old, $begin);
            $payment_percent = StaticFunction::getPercentStatistic($old_payment_array ,$payment_array);
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('/site/payments/chart_payment',[
                'label_payment_chart' => $payment_percent['label'],
                'count_payment_chart' => $payment_percent['count'],
            ]);
        }
    }

    /**
     * bills haqida otchet chiqarib olish
     * @return string
     */
    public function actionBills()
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $result_old = [];
        $result_last = [];
        $result = [];
        $label_1 = 'Сегодня';
        $label_2 ='Вчера';
        $type = isset($post['type']) ? $post['type'] : 1;
        switch ($type){
            case 6: {
                $label_1 = 'текущий год';
                $label_2 ='предыдущей год';
                $date_old_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 24 month'));
                $date_old_to = date('Y-m-d' ,strtotime(date('Y-m-d').' - 12 month'));
                $date_last_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 12 month'));
                $date_last_to = date('Y-m-d' ,strtotime(date('Y-m-d')));

                $bills_old = Bills::find()->select(['to_char(date_cr,  \'YYYY-MM\') as date_cr', 'SUM(amount) AS summ'])
                    ->where(['type' =>1,'status'=>2])
                    ->andWhere(['and',['>','date_cr',$date_old_from],['<','date_cr',$date_old_to]])
                    ->groupBy(['to_char(date_cr,  \'YYYY-MM\')'])
                    ->orderBy(['date_cr' => SORT_ASC])
                    ->asArray()->all();
                $bills_last = Bills::find()->select(['to_char(date_cr,  \'YYYY-MM\') as date_cr', 'SUM(amount) AS summ'])
                    ->where(['type' =>1,'status'=>2])
                    ->andWhere(['and',['>','date_cr',$date_last_from],['<','date_cr',$date_last_to]])
                    ->groupBy(['to_char(date_cr,  \'YYYY-MM\')'])
                    ->orderBy(['date_cr' => SORT_ASC])
                    ->asArray()->all();



                if($bills_last){
                    foreach ($bills_last as $value){
                        $result_last[$value['date_cr']] = $value['summ'];
                    }
                }
                if($bills_old){
                    foreach ($bills_old as $value){
                        $result_old[$value['date_cr']] = $value['summ'];
                    }
                }

                $date_old_from = date('Y-m' ,strtotime(date('Y-m-d').' - 24 month'));
                for ($i = 1; $i<13; $i++){
                    $date_old_from = date('Y-m' ,strtotime($date_old_from.' +1 month'));
                    $result['old_sum'][] = array_key_exists($date_old_from,$result_old) ? $result_old[$date_old_from]:0;
                }

                $date_last_from = date('Y-m' ,strtotime(date('Y-m-d').' - 12 month'));
                $date_old_from = date('Y-m' ,strtotime(date('Y-m-d').' - 24 month'));
                for ($i = 1; $i<13; $i++){
                    $date_last_from = date('Y-m' ,strtotime($date_last_from.' +1 month'));
                    $date_old_from = date('Y-m' ,strtotime($date_old_from.' +1 month'));
                    $result['label'] []=  date('Y' ,strtotime($date_old_from)).'-'.StaticFunction::getMonthName($date_old_from).' | '.
                        date('Y' ,strtotime($date_last_from)).'-'.StaticFunction::getMonthName(($date_last_from));
                    $result['last_sum'][] = array_key_exists($date_last_from,$result_last) ? $result_last[$date_last_from]:0;
                }
                break;
            }
            case 5: {
                $label_1 = 'Последный 90 дней';
                $label_2 ='предыдущей 90 дней';
                $date_old_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 180 days')).' 00:00:00';
                $date_old_to = date('Y-m-d' ,strtotime(date('Y-m-d').' - 90 days')).' '.'23:59:59';
                $date_last_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 90 days')).' 00:00:00';
                $date_last_to = date('Y-m-d' ,strtotime(date('Y-m-d'))).' '.'23:59:59';

                $bills_old = Bills::find()->select(['to_char(date_cr,  \'YYYY-MM-DD\') as date_cr', 'SUM(amount) AS summ'])
                    ->where(['type' =>1,'status'=>2])
                    ->andWhere(['and',['>','date_cr',$date_old_from],['<','date_cr',$date_old_to]])
                    ->groupBy(['to_char(date_cr,  \'YYYY-MM-DD\')'])
                    ->orderBy(['date_cr' => SORT_ASC])
                    ->asArray()->all();
                $bills_last = Bills::find()->select(['to_char(date_cr,  \'YYYY-MM-DD\') as date_cr', 'SUM(amount) AS summ'])
                    ->where(['type' =>1,'status'=>2])
                    ->andWhere(['and',['>','date_cr',$date_last_from],['<','date_cr',$date_last_to]])
                    ->groupBy(['to_char(date_cr,  \'YYYY-MM-DD\')'])
                    ->orderBy(['date_cr' => SORT_ASC])
                    ->asArray()->all();
                if($bills_last){
                    foreach ($bills_last as $value){
                        $result_last[$value['date_cr']] = $value['summ'];
                    }
                }
                if($bills_old){
                    foreach ($bills_old as $value){
                        $result_old[$value['date_cr']] = $value['summ'];
                    }
                }

                $date_old_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 180 days'));
                for ($i = 1; $i<91; $i++){
                    $date_old_from = date('Y-m-d' ,strtotime($date_old_from.' +1 days'));
                    $result['old_sum'][] = array_key_exists($date_old_from,$result_old) ? $result_old[$date_old_from]:0;
                }

                $date_last_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 90 days'));
                $date_old_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 180 days'));
                for ($i = 1; $i<91; $i++){
                    $date_last_from = date('Y-m-d' ,strtotime($date_last_from.' +1 days'));
                    $date_old_from = date('Y-m-d' ,strtotime($date_old_from.' +1 days'));
                    $result['label'] []= (int)date('d',strtotime($date_old_from)).'-'.StaticFunction::getMonthName($date_old_from).' | '.
                        (int)date('d',strtotime($date_last_from)).'-'.StaticFunction::getMonthName(($date_last_from));
                    $result['last_sum'][] = array_key_exists($date_last_from,$result_last) ? $result_last[$date_last_from]:0;
                }
                break;
            }

            case 4: {
                $label_1 = 'Последный 30 дней';
                $label_2 ='предыдущей 30 дней';
                $date_old_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 60 days')).' 00:00:00';
                $date_old_to = date('Y-m-d' ,strtotime(date('Y-m-d').' - 30 days')).' '.'23:59:59';
                $date_last_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 30 days')).' 00:00:00';
                $date_last_to = date('Y-m-d' ,strtotime(date('Y-m-d'))).' '.'23:59:59';

                $bills_old = Bills::find()->select(['to_char(date_cr,  \'YYYY-MM-DD\') as date_cr', 'SUM(amount) AS summ'])
                    ->where(['type' =>1,'status'=>2])
                    ->andWhere(['and',['>','date_cr',$date_old_from],['<','date_cr',$date_old_to]])
                    ->groupBy(['to_char(date_cr,  \'YYYY-MM-DD\')'])
                    ->orderBy(['date_cr' => SORT_ASC])
                    ->asArray()->all();
                $bills_last = Bills::find()->select(['to_char(date_cr,  \'YYYY-MM-DD\') as date_cr', 'SUM(amount) AS summ'])
                    ->where(['type' =>1,'status'=>2])
                    ->andWhere(['and',['>','date_cr',$date_last_from],['<','date_cr',$date_last_to]])
                    ->groupBy(['to_char(date_cr,  \'YYYY-MM-DD\')'])
                    ->orderBy(['date_cr' => SORT_ASC])
                    ->asArray()->all();
                if($bills_last){
                    foreach ($bills_last as $value){
                        $result_last[$value['date_cr']] = $value['summ'];
                    }
                }
                if($bills_old){
                    foreach ($bills_old as $value){
                        $result_old[$value['date_cr']] = $value['summ'];
                    }
                }

                $date_old_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 60 days'));
                for ($i = 1; $i<30; $i++){
                    $date_old_from = date('Y-m-d' ,strtotime($date_old_from.' +1 days'));
                    $result['old_sum'][] = array_key_exists($date_old_from,$result_old) ? $result_old[$date_old_from]:0;
                }

                $date_last_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 30 days'));
                $date_old_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 60 days'));
                for ($i = 1; $i<30; $i++){
                    $date_last_from = date('Y-m-d' ,strtotime($date_last_from.' +1 days'));
                    $date_old_from = date('Y-m-d' ,strtotime($date_old_from.' +1 days'));
                    $result['label'] []= (int)date('d',strtotime($date_old_from)).'-'.StaticFunction::getMonthName($date_old_from).' | '.
                        (int)date('d',strtotime($date_last_from)).'-'.StaticFunction::getMonthName(($date_last_from));
                    $result['last_sum'][] = array_key_exists($date_last_from,$result_last) ? $result_last[$date_last_from]:0;

                }
                break;
            }
            case 3: {
                $label_1 = 'Последный 7 дней';
                $label_2 ='предыдущей 7 дней';
                $date_old_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 14 days')).' 00:00:00';
                $date_old_to = date('Y-m-d' ,strtotime(date('Y-m-d').' - 7 days')).' '.'23:59:59';
                $date_last_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 7 days')).' 00:00:00';
                $date_last_to = date('Y-m-d' ,strtotime(date('Y-m-d'))).' '.'23:59:59';

                $bills_old = Bills::find()->select(['to_char(date_cr,  \'YYYY-MM-DD\') as date_cr', 'SUM(amount) AS summ'])
                    ->where(['type' =>1,'status'=>2])
                    ->andWhere(['and',['>','date_cr',$date_old_from],['<','date_cr',$date_old_to]])
                    ->groupBy(['to_char(date_cr,  \'YYYY-MM-DD\')'])
                    ->orderBy(['date_cr' => SORT_ASC])
                    ->asArray()->all();
                $bills_last = Bills::find()->select(['to_char(date_cr,  \'YYYY-MM-DD\') as date_cr', 'SUM(amount) AS summ'])
                    ->where(['type' =>1,'status'=>2])
                    ->andWhere(['and',['>','date_cr',$date_last_from],['<','date_cr',$date_last_to]])
                    ->groupBy(['to_char(date_cr,  \'YYYY-MM-DD\')'])
                    ->orderBy(['date_cr' => SORT_ASC])
                    ->asArray()->all();
                if($bills_last){
                    foreach ($bills_last as $value){
                        $result_last[$value['date_cr']] = $value['summ'];
                    }
                }
                if($bills_old){
                    foreach ($bills_old as $value){
                        $result_old[$value['date_cr']] = $value['summ'];
                    }
                }

                $date_old_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 14 days'));
                for ($i = 1; $i<8; $i++){
                    $date_old_from = date('Y-m-d' ,strtotime($date_old_from.' +1 days'));
                    $result['old_sum'][] = array_key_exists($date_old_from,$result_old) ? $result_old[$date_old_from]:0;
                }

                $date_last_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 7 days'));
                $date_old_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 14 days'));
                for ($i = 1; $i<8; $i++){
                    $date_last_from = date('Y-m-d' ,strtotime($date_last_from.' +1 days'));
                    $date_old_from = date('Y-m-d' ,strtotime($date_old_from.' +1 days'));
                    $result['label'] []= (int)date('d',strtotime($date_old_from)).'-'.StaticFunction::getMonthName($date_old_from).' | '.
                        (int)date('d',strtotime($date_last_from)).'-'.StaticFunction::getMonthName(($date_last_from));
                    $result['last_sum'][] = array_key_exists($date_last_from,$result_last) ? $result_last[$date_last_from]:0;

                }
                break;
            }
            case 2: {
                $label_1 = 'Вчера';
                $label_2 ='предыдущей вчера';
                $date_old_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 2 days')).' 00:00:00';
                $date_old_to = date('Y-m-d' ,strtotime(date('Y-m-d').' - 2 days')).' '.'23:59:59';
                $date_last_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 1 days')).' 00:00:00';
                $date_last_to = date('Y-m-d' ,strtotime(date('Y-m-d').' - 1 days')).' '.'23:59:59';

                $bills_old = Bills::find()->select(['date_cr', 'SUM(amount) AS summ'])
                    ->where(['type' =>1,'status'=>2])
                    ->andWhere(['and',['>','date_cr',$date_old_from],['<','date_cr',$date_old_to]])
                    ->groupBy(['date_cr'])
                    ->orderBy(['date_cr' => SORT_ASC])
                    ->asArray()->all();
                $bills_last = Bills::find()->select(['date_cr', 'SUM(amount) AS summ'])
                    ->where(['type' =>1,'status'=>2])
                    ->andWhere(['and',['>','date_cr',$date_last_from],['<','date_cr',$date_last_to]])
                    ->groupBy(['date_cr'])
                    ->orderBy(['date_cr' => SORT_ASC])
                    ->asArray()->all();
                if($bills_old){
                    foreach ($bills_old as $element) {
                        $resul_old[(int)(date('H',strtotime($element['date_cr'])))][] = $element['summ'];
                    }
                }
                if($bills_last){
                    foreach ($bills_last as $element) {
                        $result_last[(int)(date('H',strtotime($element['date_cr'])))][] = $element['summ'];
                    }
                }
                for ($i=0; $i<=23; $i++){
                    $result['label'] []='в '.$i.':00';
                    $result['old_sum'] []= isset($resul_old[$i]) ? array_sum($resul_old[$i]) : 0;
                    $result['last_sum'] []= isset($result_last[$i]) ? array_sum($result_last[$i]) : 0;
                }
                break;
            }
            default : {
                $date_old_from = date('Y-m-d' ,strtotime(date('Y-m-d').' - 1 days')).' 00:00:00';
                $date_old_to = date('Y-m-d' ,strtotime(date('Y-m-d').' - 1 days')).' '.date('H:i:s');
                $date_last_from = date('Y-m-d').' 00:00:00';
                $date_last_to = date('Y-m-d H:i:s');

                $bills_old = Bills::find()->select(['date_cr', 'SUM(amount) AS summ'])
                    ->where(['type' =>1,'status'=>2])
                    ->andWhere(['and',['>','date_cr',$date_old_from],['<','date_cr',$date_old_to]])
                    ->groupBy(['date_cr'])
                    ->orderBy(['date_cr' => SORT_ASC])
                    ->asArray()->all();
                $bills_last = Bills::find()->select(['to_char(date_cr,  \'YYYY-MM-DD HH\') as date_cr', 'SUM(amount) AS summ'])
                    ->where(['type' =>1,'status'=>2])
                    ->andWhere(['and',['>','date_cr',$date_last_from],['<','date_cr',$date_last_to]])
                    ->groupBy(['to_char(date_cr,  \'YYYY-MM-DD HH\')'])
                    ->orderBy(['date_cr' => SORT_ASC])
                    ->asArray()->all();
                if($bills_old){
                    foreach ($bills_old as $element) {
                        $resul_old[(int)(date('H',strtotime($element['date_cr'])))][] = $element['summ'];
                    }
                }
                if($bills_last){
                    foreach ($bills_last as $element) {
                        $result_last[(int)(date('H',strtotime($element['date_cr'])))][] = $element['summ'];
                    }
                }
                for ($i=0; $i<=(int)date('H'); $i++){
                    $result['label'] []='в '.$i.':00';
                    $result['old_sum'] []= isset($resul_old[$i]) ? array_sum($resul_old[$i]) : 0;
                    $result['last_sum'] []= isset($result_last[$i]) ? array_sum($result_last[$i]) : 0;
                }
            }
        }

        return $this->render('bills', [
            'post' =>$post,
            'result' => $result,
            'label_1' => $label_1,
            'label_2' => $label_2,
        ]);
    }

    public function actionModerator()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->moderator(Yii::$app->request->queryParams, 'moderator');
        return $this->render('moderator', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionItemsViews($parent_id = 1)
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->moderator(Yii::$app->request->queryParams, 'moderator');
        $get = Yii::$app->request->get();
        if (isset($get['UsersSearch']['reg_from']) && isset($get['UsersSearch']['reg_to'])) {
            $start_reg = date("Y-m-d", strtotime($get['UsersSearch']['reg_from']));
            $end_reg = date("Y-m-d", strtotime("+1 day", strtotime($get['UsersSearch']['reg_to'])));
        } elseif(isset($get['UsersSearch']['reg_from'])){
            $start_reg = date("Y-m-d", strtotime($get['UsersSearch']['reg_from']));
            $end_reg = date('Y-m-d' ,strtotime(date('Y-m-d'))).' '.'23:59:59';
        } else {
            $start_reg = date('Y-m-d' ,strtotime(date('Y-m-d').' - 7 days')).' 00:00:00';
            $end_reg = date('Y-m-d' ,strtotime(date('Y-m-d'))).' '.'23:59:59';
            $searchModel->reg_from = date("d.m.Y",strtotime($start_reg));
            $searchModel->reg_to =  date("d.m.Y",strtotime($end_reg));
        }


        $result = [];
        $categories = Categories::find()
            ->with(['children'])
            ->where(['parent_id' => $parent_id ,'enabled' =>1])
            ->select(['id','parent_id','sorting','enabled','title'])
            ->orderBy('sorting asc')
            ->asArray()
            ->all();
        foreach ($categories as $key => $value) {
            $categoryId = Categories::buildTree($value['children'], $value['id']);
            $categoryId[] = $value['id'];

            $views = (new \yii\db\Query())
                ->select([
                    'SUM(items_views.item_views) as item_views',
                    'SUM(items_views.contacts_views) as contacts_views',
                ])
                ->from('items_views')
                ->join('LEFT JOIN', 'items', 'items.id = items_views.item_id')
                ->andWhere(['between','items_views.period',$start_reg,$end_reg])
                ->andWhere(['items.cat_id' => $categoryId])
                ->all();

            $result []= [
                'id' => $value['id'],
                'title' => $value['title'],
                'item_views' =>  $views[0]['item_views'],
                'contacts_views' => $views[0]['contacts_views'],
            ];
        }

        return $this->render('item-views', [
            'result' => $result,
            'parent_id' => $parent_id,
            'searchModel' =>$searchModel,
        ]);
    }

}