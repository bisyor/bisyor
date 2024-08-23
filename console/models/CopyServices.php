<?php
/**
 * Created by PhpStorm.
 * Project: bisyor.loc
 * User: Umidjon <t.me/zoxidovuz>
 * Date: 20.04.2020
 * Time: 11:53
 */
namespace console\models;

use Yii;
use yii\base\Model;
use backend\models\shops\Services;
use backend\models\shops\RegionalPrices;
use backend\models\references\Districts;
use backend\models\references\Regions;
/**
 * Class Move
 * @package console\modelsl
 */
class CopyServices extends Model
{
    public static function copy()
    {
        $values = [
            'up' => [
                'title' => 'Поднятие',
                'short_description' => 'Повышая приоритет вашего объявления вы поднимаете его в начало списка объявлений схожей тематики. 
                    Это удобный способ для привлечения внимания посетителей портала к вашему предложению. 
                    Станьте первыми в списке и будете лидером по числу просмотров.
                    ',
                'description' => 'Повышая приоритет вашего объявления вы поднимаете его в начало списка объявлений схожей тематики. 
                    Это удобный способ для привлечения внимания посетителей портала к вашему предложению. 
                    Станьте первыми в списке и будете лидером по числу просмотров.
                    ',
                'add_form' => 0,
                'auto_enabled' => 1,
                'free_period' => 0,
                'day' => 0,
                'period_type' => 0,
                'enabled' => 1
            ],
            'quick' => [
                'title' => 'Срочно',
                'short_description' => 'Пометьте объявление как срочное на 7 дней. 
                    - Вы привлекаете больше внимания, а значит получаете больше откликов 
                    - Ваше объявление становится более заметным среди других предложений
                    ',
                'description' => 'Пометьте объявление как срочное на 7 дней. 
                    - Вы привлекаете больше внимания, а значит получаете больше откликов 
                    - Ваше объявление становится более заметным среди других предложений
                    ',
                'add_form' => 1,
                'day' => 7,
                'enabled' => 1,
                'auto_enabled' => 0,
                'free_period' => 0,
                'period_type' => 0,
            ],
            'mark' => [
                'title' => 'Выделение',
                'short_description' => 'Объявление выделяется жёлтой рамкой на 7 дней. 
                Выделение объявления — отличный способ сделать ваше объявление более ярким и заметным на фоне соседних.
                ',
                'description' => 'Объявление выделяется жёлтой рамкой на 7 дней. 
                Выделение объявления — отличный способ сделать ваше объявление более ярким и заметным на фоне соседних.
                ',
                'add_form' => 1,
                'day' => 7,
                'enabled' => 1,
                'auto_enabled' => 0,
                'free_period' => 0,
                'period_type' => 0,
            ],
           'fix' => [
                'title' => 'Закрепление',
                'short_description' => 'Закрепив объявление вы поднимаете его в начало списка объявлений схожей тематики на 7 дней. 
                - В 10 раз больше просмотров 
                - В 5 раз больше откликов 
                - Продажа совершается гораздо быстрее
                ',
                'description' => 'Закрепив объявление вы поднимаете его в начало списка объявлений схожей тематики на 7 дней. 
                - В 10 раз больше просмотров 
                - В 5 раз больше откликов 
                - Продажа совершается гораздо быстрее
                ',
                'add_form' => 1,
                'day' => 7,
                'enabled' => 1,
                'auto_enabled' => 0,
                'free_period' => 0,
                'period_type' => 1,
            ],
            'premium' => [
                'title' => 'Премиум объявления',
                'short_description' => 'Сделайте ваше объявление ещё заметнее разместив его на главной странице сайта.
                - Вы привлекаете больше внимания, а значит получаете больше откликов 
                - Ваше объявление становится более заметным среди других предложений 
                Стоимость: 15 576 сум за 7 дней.
                ',
                'description' => 'Сделайте ваше объявление ещё заметнее разместив его на главной странице сайта.
                - Вы привлекаете больше внимания, а значит получаете больше откликов 
                - Ваше объявление становится более заметным среди других предложений 
                Стоимость: 15 576 сум за 7 дней.
                ',
                'add_form' => 1,
                'day' => 7,
                'enabled' => 1,
                'auto_enabled' => 0,
                'free_period' => 0,
                'period_type' => 0,
            ],
            'press' => [
                'title' => 'Публикация в прессе',
                'short_description' => 'Вы можете сделать ваше объявление более заметным, опубликовав его в прессе. Объявления публикуются в городской газете города. Газета выходит каждую среду, продается во всех газетных ',
                'description' => 'Вы можете сделать ваше объявление более заметным, опубликовав его в прессе. Объявления публикуются в городской газете города. Газета выходит каждую среду, продается во всех газетных ',
                'add_form' => 0,
                'day' => 0,
                'enabled' => 0,
                'auto_enabled' => 0,
                'free_period' => 0,
                'period_type' => 0,
            ],
            'simple' => [
                'title' => 'Обычная продажа',
                'short_description' => 'Хотите продать свой товар/услугу максимально быстро? Тогда это предложение именно для вас: 
                    - 1 поднятия в верх списка 
                    - Закрепление объявления на 7 дней 
                    - Выделение объявления на 7 дней 
                    - Пометка “Срочно” на 7 дней
                    ',
                'description' => 'Хотите продать свой товар/услугу максимально быстро? Тогда это предложение именно для вас: 
                    - 1 поднятия в верх списка 
                    - Закрепление объявления на 7 дней 
                    - Выделение объявления на 7 дней 
                    - Пометка “Срочно” на 7 дней
                    ',
                'add_form' => 1,
                'day' => 0,
                'enabled' => 1,
                'auto_enabled' => 0,
                'free_period' => 0,
                'period_type' => 0,
                'sorting' => 1,
                
                'services' => [
                    'up' => 1,
                    'quick' => 7,
                    'mark' => 7,
                    'fix' => 7,
                    'premium' => 0,
                ]
            ],
            'import' => [
                'title' => 'Быстрая продажа',
                'short_description' => 'Хотите продать свой товар/услугу максимально быстро? Тогда это предложение именно для вас:
                    - 3 поднятия в верх списка 
                    - Закрепление объявления на 14 дней 
                    - Выделение объявления на 14 дней 
                    - Пометка “Срочно” на 14 дней
                    - Премиум объявления на 3 дней
                    Стоимость: 43 395 сум
                    ',
                'description' => 'Хотите продать свой товар/услугу максимально быстро? Тогда это предложение именно для вас:
                    - 3 поднятия в верх списка 
                    - Закрепление объявления на 14 дней 
                    - Выделение объявления на 14 дней 
                    - Пометка “Срочно” на 14 дней
                    - Премиум объявления на 3 дней
                    Стоимость: 43 395 сум
                    ',
                'add_form' => 1,
                'day' => 0,
                'enabled' => 1,
                'auto_enabled' => 0,
                'free_period' => 0,
                'period_type' => 0,
                'sorting' => 2,

                'services' => [
                    'up' => 3,
                    'quick' => 14,
                    'mark' => 14,
                    'fix' => 14,
                    'premium' => 3,
                ]
            ],
            'turbo' => [
                'title' => 'Турбо продажа',
                'short_description' => 'Хотите продать свой товар/услугу максимально быстро? Тогда это предложение именно для вас: 
                    - 9 поднятия в верх списка
                    - Закрепление объявления на 28 дней 
                    - Выделение объявления на 28 дней 
                    - Пометка “Срочно” на 28 дней
                    - Премиум объявления на 7 дней
                    ',
                'description' => 'Хотите продать свой товар/услугу максимально быстро? Тогда это предложение именно для вас: 
                    - 9 поднятия в верх списка
                    - Закрепление объявления на 28 дней 
                    - Выделение объявления на 28 дней 
                    - Пометка “Срочно” на 28 дней
                    - Премиум объявления на 7 дней
                    ',
                'add_form' => 1,
                'day' => 0,
                'enabled' => 1,
                'auto_enabled' => 0,
                'free_period' => 0,
                'period_type' => 0,
                'sorting' => 3,

                'services' => [
                    'up' => 9,
                    'quick' => 28,
                    'mark' => 28,
                    'fix' => 28,
                    'premium' => 7,
                ]
            ],
            'fix_shop' => [
                'title' => 'Закрепление',
                'short_description' => 'Закрепив магазин вы поднимаете его в начало списка магазинов на 7 дней.
                     - в 10 раз больше просмотров
                    - в 5 раз больше откликов
                    ',
                'description' => 'Закрепив магазин вы поднимаете его в начало списка магазинов на 7 дней.
                     - в 10 раз больше просмотров
                    - в 5 раз больше откликов
                    ',
                'add_form' => 0,
                'day' => 7,
                'enabled' => 1,
                'auto_enabled' => 0,
                'free_period' => 0,
                'period_type' => 0,
            ],
            'mark_shop' => [
                'title' => 'Выделение',
                'short_description' => 'Магазин выделяется желтым фоном на период 7 дней. 
                    Выделение магазина — отличный способ сделать ваш магазин более ярким и заметным на фоне соседних.
                    ',
                'description' => 'Магазин выделяется желтым фоном на период 7 дней. 
                    Выделение магазина — отличный способ сделать ваш магазин более ярким и заметным на фоне соседних.
                    ',
                'add_form' => 0,
                'day' => 7,
                'enabled' => 1,
                'auto_enabled' => 0,
                'free_period' => 0,
                'period_type' => 0,
            ],
        ];
        $arr = [];
        $models = [];
        $sql = "SELECT * FROM bff_svc";
        $result = Yii::$app->dbmy->createCommand($sql)->queryAll();
        foreach ($result as $value){
            $keyword = $value['keyword'];  
            if($keyword == 'abonement' || $keyword == 'limit' || $keyword == '') continue;
            $model = new Services();
            $model->id = $value['id'];
            $model->type = $value['type'];
            $model->changed_id = $value['modified_uid'];
            $model->keyword = $value['keyword'];
            $model->module = $value['module'];
            $model->module_title = $value['module_title'];
            $model->title = $value['title'];
            $model->price = $value['price'];
            $model->sorting = $value['num'];
            $model->icon_b = $keyword . '_b.png';
            $model->icon_s = $keyword . '_s.png';
            // $model->color = $value['color'];
            $model->date_cr = $value['modified'];
            $model->date_up = $value['modified'];
            $model->enabled = $values[$keyword]['enabled'];
            $model->description = $values[$keyword]['description'];
            $model->short_description = $values[$keyword]['short_description'];
            $model->add_form = $values[$keyword]['add_form'];
            $model->auto_enabled = $values[$keyword]['auto_enabled'];
            $model->free_period = (int)$values[$keyword]['free_period'];
            $model->day = (int)$values[$keyword]['day'];
            $model->period_type = (int)$values[$keyword]['period_type'];
            
            if(Yii::$app->db->createCommand()->insert('services', [
                'id' => $model->id,
                'type' => $model->type,
                'changed_id' => $model->changed_id,
                'keyword' => $model->keyword,
                'module' => $model->module,
                'module_title' => $model->module_title,
                'title' => $model->title,
                'price' => $model->price,
                'sorting' => $model->sorting,
                'icon_s' => $model->icon_s,
                'icon_b' => $model->icon_b,
                // 'color' => $model->color,
                'date_cr' => $model->date_cr,
                'date_up' => $model->date_up,
                'enabled' => $model->enabled,
                'description' => $model->description,
                'short_description' => $model->short_description,
                'add_form' => $model->add_form,
                'auto_enabled' => $model->auto_enabled,
                'free_period' => $model->free_period,
                'day' => $model->day,
                'period_type' => $model->period_type,
            ])->execute()){

                $arr [$model->keyword] = $model->id;
                $models [] = $model;
//                if(!empty($model->icon_s) && $value->type != 2) self::uploadImage($model->icon_s, $model->keyword);
//                if(!empty($model->icon_b) && $value->type != 2) self::uploadImage($model->icon_b, $model->keyword);
                
                fwrite(\STDOUT, "Successful copy ". $value['id'] ." rows\n");
            }else{
                fwrite(\STDOUT, "Failed copy ". $value['id'] ." rows\n");
            }
        }
        foreach ($models as $model) {
            if($model->type == Services::TYPE_PACKET){
                $services = $values[$model->keyword]['services'];
                foreach ($services as $key=>$service) {
                    Yii::$app->db->createCommand()->insert('pakets_service', [
                        'service_id' => $arr[$key],
                        'paket_id' => $model->id,
                        'status' => ($service != 0),
                        'value' => $service,
                    ])->execute();
                } 
            }
            if($model->module == Services::MODULE_BBS){
                $sql = "SELECT bff_bbs_svc_price.svc_id as service_id,bff_bbs_svc_price.price as price, GROUP_CONCAT(bff_bbs_svc_price.category_id SEPARATOR ',') as categories,GROUP_CONCAT(bff_regions.pid SEPARATOR ',') as regions 
                    FROM bff_bbs_svc_price INNER JOIN  bff_regions ON bff_regions.id = bff_bbs_svc_price.region_id
                    GROUP BY service_id,price HAVING service_id = " . $model->id . ";";
                $result = Yii::$app->dbmy->createCommand($sql)->queryAll();
                foreach ($result as $key => $value) {
                    $new_model = new RegionalPrices();
                    $new_model->service_id = $value['service_id'];
                    $new_model->price = $value['price'];
                    $new_model->regions = explode(",",implode(",",((self::getRegions(array_unique(explode(",",$value['regions'])))))));
                    $new_model->sections = array_values(array_unique(explode(",",$value['categories'])));
                    $new_model->save();
                    fwrite(\STDOUT, "Successful copy ". $value['service_id'] ." rows\n");
                }
            }else{
                $sql = "SELECT bff_shops_svc_price.svc_id as service_id,bff_shops_svc_price.price as price, GROUP_CONCAT(bff_regions.pid SEPARATOR ',') as regions 
                    FROM bff_shops_svc_price INNER JOIN  bff_regions ON bff_regions.id = bff_shops_svc_price.region_id
                    GROUP BY service_id,price HAVING service_id = " . $model->id . ";";
                $result = Yii::$app->dbmy->createCommand($sql)->queryAll();
                foreach ($result as $key => $value) {
                    $new_model = new RegionalPrices();
                    $new_model->price = $value['price'];
                    $new_model->service_id = $value['service_id'];
                    $new_model->regions = explode(",",implode(",",((self::getRegions(array_unique(explode(",",$value['regions'])))))));
                    $new_model->save();
                    fwrite(\STDOUT, "Successful copy ". $value['service_id'] ." rows\n");
                }
            }
        }

        if(mb_substr(Yii::$app->db->dsn, 0,5) == 'pgsql'){
            Yii::$app->db->createCommand("SELECT setval('pakets_service_id_seq', (SELECT MAX(id) FROM pakets_service))")->execute();
            Yii::$app->db->createCommand("SELECT setval('services_id_seq', (SELECT MAX(id) FROM services))")->execute();
        }
        
        return true;
    }

    public static function getRegions($regions)
    {
        $data = Regions::find()->where(['last_id'=> $regions])->all();
        return \yii\helpers\ArrayHelper::getColumn($data,'id');
    }

    public static function uploadImage($img, $key)
    {
        $dir = '/web/uploads/services/';
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

        $data = microtime(true);
        $res = ftp_size($conn_id, $dir . $img);
        if ($res != -1 && $img) {
            //image already uploaded
        }
        elseif(!empty($img)){
            $link = "http://img.coding-style.uz/web/resource/".$key.".png";
            $ftp_path = $dir.$img;
            if(self::urlexists($link)){
                $ret = ftp_nb_put($conn_id, $ftp_path, $link, FTP_BINARY);
                while ($ret == FTP_MOREDATA) {
                    $ret = ftp_nb_continue($conn_id);
                }
                if ($ret != FTP_FINISHED){
                    echo "При загрузке файла произошла ошибка...";
                    fwrite(\STDOUT, $img." При загрузке файла произошла ошибка...\n");
                }else{
                    fwrite(\STDOUT, "Avatar ".$img."  successfully uploaded\n");
                }
            }
        }

    }



    /**
     * @param $url
     * @return bool
     */
    public static function urlexists($url){
        $headers=get_headers($url);
        return stripos($headers[0],"200 OK")?true:false;
    }
}