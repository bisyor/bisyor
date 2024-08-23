<?php

namespace backend\controllers\references;


use backend\models\chats\ChatMessage;
use backend\models\chats\Chats;
use backend\models\chats\ChatUsers;
use backend\models\items\ItemsCounters;
use backend\models\items\ItemsScale;
use backend\models\promocodes\Promocodes;
use backend\models\references\Api;
use backend\models\references\CroneOlx;
use backend\models\references\Districts;
use backend\models\users\Users;
use Yii;
use yii\db\Expression;
use yii\web\Controller;
use yii\filters\VerbFilter;
use \yii\web\Response;
use backend\models\references\Currencies;
use common\modules\translations\models\SourceMessage;
use backend\models\references\Lang;
use backend\models\settings\Settings;
use backend\models\items\Categories;
use backend\models\blogs\BlogPosts;
use backend\models\shops\Shops;
use backend\models\items\Items;
use backend\models\references\Pages;
use backend\models\references\Regions;
use backend\models\mail\SendmailMassendUser;
use backend\models\references\Translates;
use backend\models\references\SearchResults;
use backend\models\shops\Services;
use backend\components\StaticFunction;

class ApiController extends Controller
{
    
    public function behaviors()
    {
        return [
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
     * tarjimadagi sozlarni php faylga yozib berish
     * settingslarni xam
     * @return bool
     */
    public function actionIndex()
    {   
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $langs = Lang::find()->all();
            $sources = SourceMessage::find()->messages()->all();
            $result = "";
            foreach ($langs as $key => $value) {
                $my_file =  'uploads/php_file/';
                $result = "";
                foreach ($sources as $source){ $messages = $source->messages;
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

        // ********************** begin settings **************************
        $my_file =  'uploads/php_file/'.'settings.php';
        $settins = Settings::find()->asArray()->all();
        $result = "";
        foreach ($settins as $key => $value) {
            $result .= "     '".$value['key']."'".'=>'."'".$value['value']."',\n";
        }
        
        $handle = fopen($my_file, 'w+') or die('Fayl hosil qila olmadi.');
        fwrite($handle, "<?php");
        fwrite($handle, "\n return [\n");
        fwrite($handle, $result);
        fwrite($handle, "\n];\n");
        fwrite($handle, "?>\n");
        fclose($handle);
        return true;
    }


    /**
     * cureencydagi kursni update qilish
     */
    public function actionUpdateCourse()
    {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        Currencies::changeRate();
    }


    /**
     * fayllarni arxivlash
     */
    public function actionArchiveZip()
    {   
        $zip = new \ZipArchive;
        $settings = 'settings.zip';
        if(file_exists($settings)) unlink(Yii::getAlias($settings));
        $zip->open($settings, \ZipArchive::CREATE);
        $dir_name = 'uploads/php_file/';
        $files = scandir($dir_name);
        foreach ($files as $file) {
            if(!file_exists($file) && $file != '.gitignore') $zip->addFile('uploads/php_file/'.$file, $file);
        }
        $zip->close();
        \Yii::$app->response->sendFile($settings);
    }


    /**
     * sitemap zip faylni skachat qb olish
     */
    public function actionSitemapImageZip()
    {
        $sitemapimage = 'uploads/trash/sitemapimage.zip';
        \Yii::$app->response->sendFile($sitemapimage);
    }


    /**
     * robots faylini skachat qib olish
     */
    public function actionRobots()
    {
        ini_set('max_execution_time', '0'); // for infinite time of execution 
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $settings = 'uploads/robots/settings.txt';
        \Yii::$app->response->sendFile($settings);
    }


    /**
     * @param $filename
     */
    public function actionSitemapDownload($filename)
    {
        ini_set('max_execution_time', '0'); // for infinite time of execution 
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $sitemap = 'uploads/sitemap/' . $filename;
        \Yii::$app->response->sendFile($sitemap);
    }


    /**
     *
     */
    public function actionSitemap()
    {
        ini_set('max_execution_time', '0'); // for infinite time of execution 
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $sitemapLinks = [];

        /*kategoriyalar royhatini shakllantirish*/
        $categories = Categories::find()->where(['enabled' => 1])->andWhere(['>', 'parent_id', 0])->orderBy(['numlevel' => SORT_ASC])->all();
        foreach ($categories as $category) {
            $sitemapLinks [] = [
                'loc' => Yii::$app->params['siteCategoryUrl'] . $category->keyword,
                'priority' => 0.9
            ];
        }

        /*statik sahufalar royhatini shakllantirish*/
        $pages = Pages::find()->all();
        foreach ($pages as $page) {
            $sitemapLinks [] = [
                'loc' => Yii::$app->params['site_name'] . '/' . $page->filename,
                'priority' => 0.5
            ];
        }

        /*bloglar royhatini shakllantirish*/
        $blogposts = BlogPosts::find()->where(['status' => BlogPosts::ACTIVE_STATUS])->all();
        foreach ($blogposts as $blog) {
            $sitemapLinks [] = [
                'loc' => Yii::$app->params['blogUrl'] . $blog->slug,
                'priority' => 0.9
            ];
        }

        /*magazinlar royhatini shakllantirish*/
        $shops = Shops::find()->where(['status' => Shops::STATUS_ACTIVE])->all();
        foreach ($shops as $shop) {
            $sitemapLinks [] = [
                'loc' => Yii::$app->params['shopUrl'] . $shop->keyword,
                'priority' => 0.9
            ];
        }

        /*elonlar royhatini shakllantirish*/
        $items = Items::find()->orderBy(['status_changed' => SORT_DESC, 'id' => SORT_DESC])->all();
        foreach ($items as $item) {
            $sitemapLinks [] = [
                'loc' => Yii::$app->params['itemLink'] . $item->link,
                'priority' => 0.9
            ];
        }

        /*regionlar royhatini shakllantirish*/
        $regions = Regions::find()->all();
        foreach ($regions as $region) {
            $sitemapLinks [] = [
                'loc' => Yii::$app->params['site_name'] . '/' . $region->keyword,
                'priority' => 0.9
            ];
        }

        $sitemapPath =  'uploads/sitemap/';
        $i = 0; $sitemapCount = 0;
        $result = '';
        $siteMap = '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($sitemapLinks as $link){ 
            $i++;
            $result .= "
            <url>
                <loc>" . $link['loc'] . "</loc>
                <lastmod>" . date(DATE_ATOM, time()) . "</lastmod>
                <priority>" . $link['priority'] . "</priority>
            </url>";

            if($i == 30000) {
                $result = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . $result . '</urlset>';
                $sitemapCount++;
                $fileName = 'sitemap' . $sitemapCount . ".xml";
                $handle = fopen($sitemapPath . $fileName, 'w+') or die('Fayl hosil qila olmadi.');
                fwrite($handle, $result);
                fclose($handle);
                $i = 0;
                $result = '';
                $siteMap .= '<sitemap>' . '<loc>' . Yii::$app->params['sitemapPath'] . $fileName . '</loc>' . '<lastmod>' . date(DATE_ATOM, time()) . '</lastmod>' . '</sitemap>';
                $homepage = StaticFunction::file_get_contents_curl(Yii::$app->params['downloadSitemapUrl'] . '?fileName=' . $fileName . '&path=1');
            }
        }

        if($result != '') {
            $result = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . $result . '</urlset>';
            $sitemapCount++;
            $fileName = 'sitemap' . $sitemapCount . ".xml";
            $handle = fopen($sitemapPath . $fileName, 'w+') or die('Fayl hosil qila olmadi.');
            fwrite($handle, $result);
            fclose($handle);
            $siteMap .= '<sitemap>' . '<loc>' . Yii::$app->params['sitemapPath'] . $fileName . '</loc>' . '<lastmod>' . date(DATE_ATOM, time()) . '</lastmod>' . '</sitemap>';
            $homepage = StaticFunction::file_get_contents_curl(Yii::$app->params['downloadSitemapUrl'] . '?fileName=' . $fileName . '&path=1');
        }

        $siteMap .= '</sitemapindex>';
        $fileName = 'sitemap.xml';
        $handle = fopen($sitemapPath . $fileName, 'w+') or die('Fayl hosil qila olmadi.');
        fwrite($handle, $siteMap);
        fclose($handle);
        $homepage = StaticFunction::file_get_contents_curl(Yii::$app->params['downloadSitemapUrl'] . '?fileName=' . $fileName . '&path=0');

    }


    /**
     * sitemap images
     */
    public function actionSitemapImages()
    {
        ini_set('max_execution_time', 900); //15 minut
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $i = 0; 
        $result = '';
        $sitemapCount = 0;
        $sitemapPath =  'uploads/sitemap/';
        $siteMap = '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        /*elonlar royhatini shakllantirish*/
        $items = Items::find()->where(['items.is_publicated' => 1, 'items.is_moderating' => 0, 'items.status' => 3])->andWhere(['>', 'items.id', 50000])/*->joinWith(['itemsImages'])*/->orderBy(['items.status_changed' => SORT_DESC, 'items.id' => SORT_DESC])->all();

        foreach ($items as $item) { 
            if($i + count($item->itemsImages) < 1000) {
                $result .= "
                <url>
                    <loc>" . Yii::$app->params['itemLink'] . $item->link. "</loc>";
                foreach ($item->itemsImages as $image) {
                    $i++;
                    $result .= "
                    <image:image>
                        <image:loc>" . Yii::$app->params['itemImagePath'] . $image->extstor_img_z . "</image:loc>
                    </image:image>";
                }
                $result .= "
                </url>";
            }
            else{
                $result = '<?xml version="1.0" encoding="UTF-8"?>
            <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . $result . '
            </urlset>';
                $sitemapCount++;
                $fileName = 'sitemap-image' . $sitemapCount . ".xml";
                $handle = fopen($sitemapPath . $fileName, 'w+') or die('Fayl hosil qila olmadi.');
                fwrite($handle, $result);
                fclose($handle);
                $i = 0;
                $result = '';
                $siteMap .= '
                <sitemap>
                    <loc>' . Yii::$app->params['sitemapPath'] . $fileName . '</loc>
                    <lastmod>' . date(DATE_ATOM, time()) . '</lastmod>
                </sitemap>';
            }
        }

        if($result != '') {
            $result = '<?xml version="1.0" encoding="UTF-8"?>
            <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . $result . '
            </urlset>';
            $sitemapCount++;
            $fileName = 'sitemap-image' . $sitemapCount . ".xml";
            $handle = fopen($sitemapPath . $fileName, 'w+') or die('Fayl hosil qila olmadi.');
            fwrite($handle, $result);
            fclose($handle);
            $i = 0;
            $result = '';
            $siteMap .= '
                <sitemap>
                    <loc>' . Yii::$app->params['sitemapPath'] . $fileName . '</loc>
                    <lastmod>' . date(DATE_ATOM, time()) . '</lastmod>
                </sitemap>';
        }

        $siteMap .= '
            </sitemapindex>';
        $fileName = 'sitemapimages.xml';
        $handle = fopen($sitemapPath . $fileName, 'w+') or die('Fayl hosil qila olmadi.');
        fwrite($handle, $siteMap);
        fclose($handle);

        $sitemapimage = 'uploads/trash/sitemapimage.zip';
        $dir_name = 'uploads/sitemap/';
        if(file_exists($sitemapimage)) unlink(Yii::getAlias($sitemapimage));

        $zip = new \ZipArchive;
        $zip->open($sitemapimage, \ZipArchive::CREATE);
        $files = scandir($dir_name);
        foreach ($files as $file) {
            if (strpos($file, 'sitemap-image') !== false) {
                $zip->addFile($dir_name . $file, $file);
            }
        }
        $zip->close();
        $homepage = StaticFunction::file_get_contents_curl(Yii::$app->params['downloadSitemapImageUrl']);

        $homepage = StaticFunction::file_get_contents_curl(Yii::$app->params['downloadSitemapUrl'] . '?fileName=' . $fileName . '&path=0');
    }


    public function actionSitemapPopularKeyword()
    {
        ini_set('max_execution_time', '0'); // for infinite time of execution 
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $sitemapLinks = [];

        /*popular keywordlar royhatini shakllantirish*/
        $searchResults = SearchResults::find()->where(['pid' => 0])->orderBy(['counter' => SORT_DESC])->all();
        foreach ($searchResults as $keyword) {
            if($keyword->counter - $keyword->hits > 0) {
                $string = $keyword->query;
                //$string = preg_replace('[^0-9a-zA-Z_\s]', '', $string);
                $string = str_replace(' ', '+', $string);
                $string = str_replace('<', '&lt;', $string);
                $string = str_replace('>', '&gt;', $string);
                $string = str_replace('&', '&amp;', $string);
                $string = str_replace('%', '', $string);

                if($string != null && $string != '') {
                    $sitemapLinks [] = [
                        'loc' => Yii::$app->params['popularSearchKeywordUrl'] . $string,
                        'priority' => 0.9
                    ];
                }
            }
        }

        $sitemapPath =  'uploads/sitemap/';
        $i = 0; $sitemapCount = 0;
        $result = '';
        $siteMap = '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($sitemapLinks as $link){ 
            $i++;
            $result .= "
            <url>
                <loc>" . $link['loc'] . "</loc>
                <lastmod>" . date(DATE_ATOM, time()) . "</lastmod>
                <priority>" . $link['priority'] . "</priority>
            </url>";

            if($i == 30000) {
                $result = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . $result . '</urlset>';
                $sitemapCount++;
                $fileName = 'sitemap-popular' . $sitemapCount . ".xml";
                $handle = fopen($sitemapPath . $fileName, 'w+') or die('Fayl hosil qila olmadi.');
                fwrite($handle, $result);
                fclose($handle);
                $i = 0;
                $result = '';
                $siteMap .= '<sitemap>' . '<loc>' . Yii::$app->params['sitemapPath'] . $fileName . '</loc>' . '<lastmod>' . date(DATE_ATOM, time()) . '</lastmod>' . '</sitemap>';
                $homepage = StaticFunction::file_get_contents_curl(Yii::$app->params['downloadSitemapUrl'] . '?fileName=' . $fileName . '&path=1');
            }
        }

        if($result != '') {
            $result = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . $result . '</urlset>';
            $sitemapCount++;
            $fileName = 'sitemap-popular' . $sitemapCount . ".xml";
            $handle = fopen($sitemapPath . $fileName, 'w+') or die('Fayl hosil qila olmadi.');
            fwrite($handle, $result);
            fclose($handle);
            $siteMap .= '<sitemap>' . '<loc>' . Yii::$app->params['sitemapPath'] . $fileName . '</loc>' . '<lastmod>' . date(DATE_ATOM, time()) . '</lastmod>' . '</sitemap>';
            $homepage = StaticFunction::file_get_contents_curl(Yii::$app->params['downloadSitemapUrl'] . '?fileName=' . $fileName . '&path=1');
        }

        $siteMap .= '</sitemapindex>';
        $fileName = 'sitemap-popular.xml';
        $handle = fopen($sitemapPath . $fileName, 'w+') or die('Fayl hosil qila olmadi.');
        fwrite($handle, $siteMap);
        fclose($handle);
        $homepage = StaticFunction::file_get_contents_curl(Yii::$app->params['downloadSitemapUrl'] . '?fileName=' . $fileName . '&path=0');

    }


    /**
     * siteni statusi  , agar xatolik chiqsa developerlarga sms ketadi
     */
    public function actionSiteStatus()
    {
        $url = Yii::$app->params['site_name'];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpcode != '200' && $httpcode != 0) {
            $model = new SendmailMassendUser();
            $token = $model->getSmsAccessToken();

            $model->sendSms('998909066628', "Sayt ishlamay qoldi, zudlik bilan to'g'irlash kerak. Error code: " . $httpcode, $token);
            $model->sendSms('998977071218', "Sayt ishlamay qoldi, zudlik bilan to'g'irlash kerak. Error code: " . $httpcode, $token);

            $token = Yii::$app->params['botToken'];
            $data = [
                'text' => "Sayt ishlamay qoldi, zudlik bilan to'g'irlash kerak. Error code: " . $httpcode,
                'chat_id' => 407993744
            ];
            file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data) );

            $data = [
                'text' => "Sayt ishlamay qoldi, zudlik bilan to'g'irlash kerak. Error code: " . $httpcode,
                'chat_id' => 129246845
            ];
            file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data) );
        }
    }


    /**
     * categoriyaga tegishli elonlarni countini tekshririb turih
     * @return bool
     */
    public function actionCategoryCountUpdate()
    {
        $categories = Categories::find()->where(['enabled' => 1])->all();
        foreach ($categories as $item){
            $categoryId = null;
            $categoryId = Categories::getCategoryForParentId($item->id);
            $item->items_count = Items::find()
                ->andWhere(['cat_id' => $categoryId])
                ->andWhere(['status' => 3])
                ->andWhere(['is_publicated' => 1])
                ->andWhere(['is_moderating' => 0])
                ->count();
            $item->save();
        }
        return true;
    }


    /**
     * categoriyaga tegishli elonlar countini shaharlar boyicha yangilab turish
     * @throws \yii\db\Exception
     */
    public function actionItemsCategoryCount()
    {
        ini_set('max_execution_time', 900); //15 minut
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        ItemsCounters::deleteAll();

        $ActiveItems = Items::find()->select(['count(*) as count','cat_id','district_id'])->andWhere(['is_publicated' =>1 ,'is_moderating' =>0 ,'status' =>3])->groupBy(['cat_id','district_id'])->asArray()->all();
        $AllItems = Items::find()->select(['count(*) as count','cat_id','district_id'])->groupBy(['cat_id','district_id'])->asArray()->all();

        $results = [];
        $categories = Categories::find()->with('children')->where(['enabled' => 1])->asArray()->all();

        $districts = Districts::find()->asArray()->all();

        foreach ($categories as $value)
        {
            $categoryId = null;
            $categoryId = Categories::buildTree($value['children'],$value['id']);


            foreach ($districts as $data){
                $activeCount = 0;  $AllCount = 0;
                if($data['id'] != null && $categoryId != null){

                    $district = array($data['id']);

                    // *************************  active items count  begin *****************************
                    $resultActive = null;  $resultAll = null;
                    $resultActive = array_filter($ActiveItems, function($e) use ($district){
                        return (in_array($e['district_id'], $district));
                    });
                    $resultActive = array_filter($resultActive, function($e) use ($categoryId){
                        return in_array($e['cat_id'], $categoryId);
                    });
                    $activeCount = array_sum(array_column($resultActive ,'count'));


                        // *************************  all items count  begin *****************************
                    $resultAll = array_filter($AllItems, function($e) use ($district){
                        return (in_array($e['district_id'], $district));
                    });

                    $resultAll = array_filter($resultAll, function($e) use ($categoryId){
                        return in_array($e['cat_id'], $categoryId);
                    });
                    $AllCount = array_sum(array_column($resultAll ,'count'));


                    $results [] =[
                        'cat_id' => $value['id'],
                        'district_id' => $data['id'],
                        'items' =>$AllCount,
                        'items_active' =>$activeCount,
                    ];
                }
            }

        }
//
        Yii::$app->db->createCommand()->batchInsert('items_counters',
            ['cat_id','district_id' , 'items' ,'items_active'],
            $results
        )->execute();
    }


    /**
     * yuqoridagini tez ishlaydigan varianti
     * @return string|true
     * @throws \yii\db\Exception
     */
//    public function actionTest()
//    {
//        ItemsCounters::deleteAll();
//        $results = [];
//        $ActiveItems = Items::find()
//            ->select(['count(items.district_id) AS items_count','items.district_id','items.cat_id'])
//            ->leftJoin('districts','districts.id = items.district_id')
//            ->leftJoin('categories','categories.id = items.cat_id')
//            ->andWhere(['items.is_publicated' =>1,'items.is_moderating' =>0 ,'items.status' =>3])
//            ->groupBy(['items.cat_id','items.district_id'])->asArray()->all();
//        foreach ($ActiveItems as $value){
//            $results [] = [
//                'cat_id' => $value['cat_id'],
//                'district_id' => $value['district_id'],
//                'items_active' =>$value['items_count'],
//            ];
//        }
//
//        Yii::$app->db->createCommand()->batchInsert('items_counters',
//            ['cat_id','district_id','items_active'],
//            $results
//        )->execute();
//        return $this->render('index',['count' => 1]);
//    }


    /**
     * categriyani telegram kanallariga elonlarni yuborish
     * @return string|true
     * @throws \yii\db\Exception
     */
    public function actionTelegram()
    {
        ini_set('max_execution_time', 900); //15 minut
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        
        $items = Api::getItems();
        $token = Settings::find()->where(['id' =>165])->one();
        if($token == null) return print_r('token xatooo yoki xato kirilgan');
        else {
            $botToken = $token->value;
        }

        $i = 0;
        foreach ($items as $value){
            if($i == 25){
                sleep(2);
                $i = 0;
            }

            $chanelName = null;
            $chanelName = Categories::getParentsTelegram($value->cat_id);
            $address = null;
            $address = $value->address != null ? ' , '. $value->address : '';
            $price = null;
            $pirce = $value->getPriceForApi();
            if($chanelName){
                foreach ($chanelName as $val) {
                    $chat_id = $val; // Telegram uchun kanal
                    // $botToken='1262931926:AAGVIL4XwioxLWCpB7wQgdPtwVbQh4HH3xk'; // Telegram BOT api
                    $bot_url= "https://api.telegram.org/bot".$botToken."/";
                    $url4 = $bot_url . "sendphoto?chat_id=" . $chat_id;

                    $district = $value->district_id != null ?  str_replace(' ', '_', $value->district->name) : '';
                    $district = str_replace('-', '_', $district);

                    $region = $value->district_id != null ? str_replace(' ', '_', $value->district->region->name) : '';
                    $region = str_replace('_', '_', $region);


                    $url_social = "<a href='https://facebook.com/bisyor'>Facebook</a> | <a href='https://t.me/joinchat/AAAAAEpJ9zDeX5pMrxnLLA'>Telegram</a> | <a href='https://instagram.com/bisyoruz'>Instagram</a> | <a href='https://youtube.com/bisyor'>Youtube</a>";
                    $url_adv = "<a href='".Yii::$app->params['site_name'].'/obyavlenie/'.$value->link."'>Посмотреть объявление на Bisyor.uz</a>";

                    $phones = '';
                    if(isset($value->phones[0])) $phones = "\n\n🤙 Телефон: ".$value->phones[0];
                    $text = "📌 <b>".$value->title."</b>\n\n💰 Цена: ".$pirce."\n\n🌎 Адрес: #".$region.', #'.$district.$address.$phones;
                    $photo = $value->getImageForTelegram();
                    $name = null;
                    if(count($photo) > 1 ){
                        $name = time().".jpg";
                        $photo = Api::getCollageImages($photo ,$name);
                    } else {
                        $photo = $photo[0];
                    }
                    $text = $text." \n\n 🔗 ".$url_adv."\n\n".$url_social;
                    $ttt = Api::sendChanelMessage($photo , $text, $url4);
                    if(file_exists('uploads/trash/'.$name) && $name != null)
                    {
                        unlink('uploads/trash/'.$name);
                    }

                    Yii::$app->db->createCommand()->update('items',  ['is_publicated_telegram' => 1], ['id' => $value->id])->execute();
                }
            }
            $i++;
        }

        return  true;
    }


    /**
     * change footer text
     */
    public function actionChangeFooterText()
    {
        $langs = Lang::find()->where(['status' => 1])->all();
        $itemCount = Items::find()
            ->andWhere(['status' => 3, 'is_publicated' => 1,'is_moderating' =>0])
            ->count();
        $shopCount = Shops::find()->count();
        $date = date('H:i d.m.Y');

        foreach ($langs as $lang) {

            $text = '{item_count} предложений от {shops_count} магазинов.<br>Обновлено в {date}';
            if($lang->url == 'uz') $text = '{shops_count} ta magazindan {item_count} ta takliflar. <br> {date} da yangilangan';
            if($lang->url == 'oz') $text = '{shops_count} та магазиндан {item_count} та таклифлар. <br> {date} да янгиланган';

            $text = str_replace('{item_count}', $itemCount, $text);
            $text = str_replace('{shops_count}', $shopCount, $text);
            $text = str_replace('{date}', $date, $text);

            if($lang->url == 'ru') {
                $setting = Settings::find()->where(['key' => 'footer_text', 'group' => 'site-settings'])->one();
                if($setting != null) {
                    $setting->value = $text;
                    $setting->save(false);
                }
            }
            else {
                $translate = Translates::find()->where(['field_name' => 'footer_text', 'table_name' => 'settings', 'language_code' => $lang->url])->one();
                if($translate != null) {
                    $translate->field_value = $text;
                    $translate->save(false);
                }
            }
        }

    }

    public function actionPopularItems()
    {
        ini_set('max_execution_time', 900); //15 minut
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $datetime = date("Y-m-d H:i:s", strtotime(date('Y-m-d H:i:s').' - 30 days'));

        $itemsScale = ItemsScale::find()->where(['status' =>1])->all();
        $items = Items::find()
            ->with(['itemViews', 'itemFavorites'])
            ->andWhere(['is_publicated' => 1, 'status' => 3,'is_moderating' =>0])
            ->andWhere(['between' , 'status_changed',$datetime,date('Y-m-d H:i:s')])
            ->all();

        foreach ($items as $value)
        {
            ItemsScale::setBallItemsForCrone($value,$itemsScale);
        }
        return 'true';
    }


    /**
     * @param $id
     * @return string
     */
    public function actionCalcPopular($id)
    {
        ini_set('max_execution_time', 900); //15 minut
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $itemsScale = ItemsScale::find()->where(['status' =>1])->all();
        $item = Items::find()->joinWith(['itemViews', 'itemFavorites'])->andWhere(['items.id' => $id])->one();
        
        $result = '';
        if($item != null){
            $result = ItemsScale::setBallItemsForCrone($item,$itemsScale);
        }
        return $result;
    }


    /**
     * auto podnyatie xizmatini kron apisi
     */
    public function actionAutoUpCrone()
    {
        ini_set('max_execution_time', '0'); // for infinite time of execution 
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $lang = 'ru';
        $billCreateUrl = Yii::$app->params['billCreateUrl'];
        $serviceUp = Services::find()->where(['keyword' => 'up'])->one();
        $begin_date = date('Y-m-d H:i:s', strtotime("-30 minutes"));
        $end_date = date('Y-m-d H:i:s');
        $createCommand = Yii::$app->db->createCommand();

        $items = Items::find()
            ->joinWith(['user'])
            ->where(['svc_upauto_on' => 1])
            ->andWhere(['between', 'svc_upauto_next', $begin_date, $end_date])
            ->all();

        foreach ($items as $item) {
            //agar userni balansida yetarlicha mablag' bo'lmasa unda avtopodnyatieni statusini nofaol qilamiz
            if($item->user->balance < $serviceUp->price) {
                $createCommand->update('items',['svc_upauto_on'=>false,'svc_upauto_next'=>null],['id'=>$item->id])->execute();
            }
            // aks holda service sotib olinadi
            else {
                $api = $billCreateUrl . "?user_id=" . $item->user_id . "&amount=" . $serviceUp->price . "&type=5&item_id=" . 
                    $item->id . "&service_id=" . $serviceUp->id . "&lang=" . $lang;
                $json = StaticFunction::file_get_contents_curl($api);
                $json = json_decode($json, true);

                //$json['status'] = true; // vaqtinchalik, ochirib tawlash kerak !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                if (!$json['status']) {
                    echo "<pre>";
                    print_r("Avtopodnyatie kronini ishlatishda muammo chiqdi");
                    echo "</pre>";
                }
                // service muvaffaqiyatli sotib olindi
                else {
                    $upauto_sett = unserialize($item->svc_upauto_sett);
                    // в
                    if($upauto_sett['t'] == '1') {

                        $hour = $upauto_sett['h'] < 10 ? ('0' . $upauto_sett['h']) : $upauto_sett['h'];
                        $minut = $upauto_sett['m'] < 10 ? ('0' . $upauto_sett['m']) : $upauto_sett['m'];
                        $strtotime = strtotime(date('Y-m-d ' . $hour . ':' . $minut . ':00'));

                        //Каждый день в неделе
                        if($upauto_sett['p'] == '1') {
                        
                            $nextDate = date('Y-m-d H:i:s', strtotime("+1 day", $strtotime));
                            $createCommand->update('items',['svc_upauto_next'=>$nextDate],['id'=>$item->id])->execute();

                            // agar bugungi kun yakshanba bolsa, avtopodnyatieni o'chiramiz
                            if(date('w') == 0) {
                                $createCommand->update('items',['svc_upauto_on'=>false,'svc_upauto_next'=>null],['id'=>$item->id])->execute();
                            }
                        }

                        //Раз в 3 дня
                        elseif($upauto_sett['p'] == '3') {
                            $nextDate = date('Y-m-d H:i:s', strtotime("+3 day", $strtotime));
                            $createCommand->update('items',['svc_upauto_next'=>$nextDate],['id'=>$item->id])->execute();
                        }

                        //Раз в неделю
                        elseif($upauto_sett['p'] == '7') {
                            $nextDate = date('Y-m-d H:i:s', strtotime("+7 day", $strtotime));
                            $createCommand->update('items',['svc_upauto_next'=>$nextDate],['id'=>$item->id])->execute();
                        }

                        //Каждый будний день
                        elseif($upauto_sett['p'] == '-1') {
                            $nextDate = date('Y-m-d H:i:s', strtotime("+1 day", $strtotime));
                            $createCommand->update('items',['svc_upauto_next'=>$nextDate],['id'=>$item->id])->execute();
                            
                            // agar bugungi kun juma bolsa, avtopodnyatieni o'chiramiz
                            if(date('w') == 5) {
                                $createCommand->update('items',['svc_upauto_on'=>false,'svc_upauto_next'=>null],['id'=>$item->id])->execute();
                            }
                        }
                        
                        // aks holatda avtopodnyatieni ochiramiz
                        else{
                            $createCommand->update('items',['svc_upauto_on'=>false,'svc_upauto_next'=>null],['id'=>$item->id])->execute();
                        }
                    }
                    // периодически
                    else {
                        $fr_hour = $upauto_sett['fr_h'] < 10 ? ('0' . $upauto_sett['fr_h']) : $upauto_sett['fr_h'];
                        $fr_minut = $upauto_sett['fr_m'] < 10 ? ('0' . $upauto_sett['fr_m']) : $upauto_sett['fr_m'];
                        $from_date = date('Y-m-d ' . $fr_hour . ':' . $fr_minut . ':00');
                        $fromStrtotime = strtotime($from_date);

                        $to_hour = $upauto_sett['to_h'] < 10 ? ('0' . $upauto_sett['to_h']) : $upauto_sett['to_h'];
                        $to_minut = $upauto_sett['to_m'] < 10 ? ('0' . $upauto_sett['to_m']) : $upauto_sett['to_m'];
                        $to_date = date('Y-m-d ' . $to_hour . ':' . $to_minut . ':00');
                        $toStrtotime = strtotime($to_date);

                        $nextMinutes = $upauto_sett['int'];
                        $nextDate = date('Y-m-d H:i:s', strtotime("+" . $nextMinutes . " minutes", strtotime($item->svc_upauto_next)));
                        $nextDateStrtotime = strtotime($nextDate);

                        // keyingi vaqt от ва до oralig'iga tushsa
                        if($fromStrtotime <= $nextDateStrtotime && $nextDateStrtotime <= $toStrtotime){
                            $createCommand->update('items',['svc_upauto_next'=>$nextDate],['id'=>$item->id])->execute();
                        }
                        // agar oraliqqa tushmasa keyingi kunga o'tishini to'g'irlash joyi
                        else{
                            //Каждый день в неделе
                            if($upauto_sett['p'] == '1') {
                                $nextDate = date('Y-m-d H:i:s', strtotime("+1 day", $fromStrtotime));
                                $createCommand->update('items',['svc_upauto_next'=>$nextDate],['id'=>$item->id])->execute();

                                // agar bugungi kun yakshanba bolsa, avtopodnyatieni o'chiramiz
                                if(date('w') == 0) {
                                    $createCommand->update('items',['svc_upauto_on'=>false,'svc_upauto_next'=>null],['id'=>$item->id])->execute();
                                }
                            }

                            //Раз в 3 дня
                            elseif($upauto_sett['p'] == '3') {
                                $nextDate = date('Y-m-d H:i:s', strtotime("+3 day", $fromStrtotime));
                                $createCommand->update('items',['svc_upauto_next'=>$nextDate],['id'=>$item->id])->execute();
                            }

                            //Раз в неделю
                            elseif($upauto_sett['p'] == '7') {
                                $nextDate = date('Y-m-d H:i:s', strtotime("+7 day", $fromStrtotime));
                                $createCommand->update('items',['svc_upauto_next'=>$nextDate],['id'=>$item->id])->execute();
                            }

                            //Каждый будний день
                            elseif($upauto_sett['p'] == '-1') {
                                $nextDate = date('Y-m-d H:i:s', strtotime("+1 day", $fromStrtotime));
                                $createCommand->update('items',['svc_upauto_next'=>$nextDate],['id'=>$item->id])->execute();
                                
                                // agar bugungi kun juma bolsa, avtopodnyatieni o'chiramiz
                                if(date('w') == 5) {
                                    $createCommand->update('items',['svc_upauto_on'=>false,'svc_upauto_next'=>null],['id'=>$item->id])->execute();
                                }
                            }
                            
                            // aks holatda avtopodnyatieni ochiramiz
                            else{
                                $createCommand->update('items',['svc_upauto_on'=>false,'svc_upauto_next'=>null],['id'=>$item->id])->execute();
                            }
                        }
                    }
                }
            }
        }
    }


    /**
     *
     */
    public function actionShopsSendTelegramChanel()
    {
        ini_set('max_execution_time', 900); //15 minut
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $items = Api::getShopsItems();

        $token = Settings::find()->where(['id' =>165])->one();
        if($token == null) return print_r('token xatooo yoki xato kirilgan');
        else {
            $botToken = $token->value;
        }

        $i = 0;
        if(!$items) return true;
        foreach ($items as $value){
            $chanelName = $value->shopApi->telegram_channel;
            if($i == 25 ){
                sleep(2);
                $i = 0;
            }
            $address = null;
            $address = $value->address != null ? ' , '. $value->address : '';
            $price = null;
            $pirce = $value->getPriceForApi();
            $dyn_drops = null;
            $dyn_drops = $value->getAdditionalFieldValue();
            $dyn_drops_text = null;
            if($dyn_drops) {
                foreach ($dyn_drops as $data) {
                    $dyn_drops_text .= $data["title"].": ".$data["value"]."\n";
                }
            }

            if($dyn_drops_text != null){
                $text_dyn_push = "\n\n⚙ <b>Свойствы:</b> \n".$dyn_drops_text;
            } else {
                $text_dyn_push = '';
            }

            if($chanelName){
                    $chat_id = $chanelName; // Telegram uchun kanal
                    // $botToken='1262931926:AAGVIL4XwioxLWCpB7wQgdPtwVbQh4HH3xk'; // Telegram BOT api
                    $bot_url= "https://api.telegram.org/bot".$botToken."/";
                    $url4 = $bot_url . "sendPhoto?chat_id=" . $chat_id;

                    $district = $value->district_id != null ?  str_replace(' ', '_', $value->district->name) : '';
                    $district = str_replace('-', '_', $district);

                    $region = $value->district_id != null ? str_replace(' ', '_', $value->district->region->name) : '';
                    $region = str_replace('_', '_', $region);


                    $url_social = "<a href='https://facebook.com/bisyor'>Facebook</a> | <a href='https://t.me/joinchat/AAAAAEpJ9zDeX5pMrxnLLA'>Telegram</a> | <a href='https://instagram.com/bisyoruz'>Instagram</a> | <a href='https://youtube.com/bisyor'>Youtube</a>";
                    $url_adv = "<a href='".Yii::$app->params['site_name'].'/obyavlenie/'.$value->link."'>Посмотреть объявление на Bisyor.uz</a>";

                    $phones = '';
                    if(isset($value->phones[0])) $phones = "\n\n🤙 Телефон: ".$value->phones[0];
                    $text = "📌 <b>".$value->title."</b>\n\n⁉️ Инфо: ".mb_substr($value->description, 0, 700)." \n\n💰 Цена: ".$pirce."\n\n🌎 Адрес: #".$region.', #'.$district.$address.$phones.$text_dyn_push;
                    $photo = $value->getImageM();
                    $text = $text." \n\n 🔗 ".$url_adv."\n\n".$url_social;
                    Api::sendChanelMessage($photo , $text, $url4);
                    Yii::$app->db->createCommand()->update('items',  ['is_publicated_shops_telegram' => 1], ['id' => $value['id']])->execute();
            }
            $i++;
        }

        return  true;
    }

    public function actionSendMessagePersonalItems()
    {

        ini_set('max_execution_time', 900); //15 minut
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $items = Api::getChatUsersItemsList();
        $token = Settings::find()->where(['id' =>165])->one();
        if($token == null) return print_r('token xatooo yoki xato kirilgan');
        else {
            $botToken = $token->value;
        }

        if(!$items) return true;

        $i = 0;
        foreach ($items as $value){
            if($value['user_id'] == $value['message_user']) continue;
            if(isset($value['telegram_id'])) {
                $chanelName = $value['telegram_id'];
            } else {
                continue;
            }

            if($i == 25 ){
                sleep(2);
                $i = 0;
            }

            if($chanelName){
                $chat_id = $chanelName; // Telegram uchun kanal
                // $botToken='1262931926:AAGVIL4XwioxLWCpB7wQgdPtwVbQh4HH3xk'; // Telegram BOT api
                $bot_url= "https://api.telegram.org/bot".$botToken."/";
                $url4 = $bot_url . "sendMessage?chat_id=" . $chat_id;

                $text = "<b>🔔Platformamizda shu e'loningiz bo'yicha yangi xabar kelgan\n\n#️⃣".$value['id']." ".$value['title']."</b>";
                Api::sendUserMessage($text, $url4);
            }
            $i++;
        }
        return  true;
    }

    public function actionCroneOlx()
    {
        $crone_olx_users = CroneOlx::find()
            ->select('user_id')
            ->andWhere(['between' ,'today_date',date('Y-m-d 00:00:01') ,date('Y-m-d 23:59:59')])
            ->asArray()
            ->all();
        $users_olx = [];
        $users_olx = array_column($crone_olx_users ,'user_id');
        $users = Users::find()
            ->select(['id','olx_link'])
            ->andWhere(['status' => 1])
            ->andWhere([ 'and',
                ['not',['olx_link'=> null]],
                ['not',['olx_link'=> '']],
            ])
            ->andWhere(['not in','id' , $users_olx])
            ->asArray()
            ->all();

        if($users){
            $date = date('Y-m-d H:i:s');
            foreach ($users as $value){
                $model = new CroneOlx();
                $model->user_id = $value['id'];
                $model->olx_link = $value['olx_link'];
                $model->today_date = $date;
                $model->status = 0;
                $model->save(false);
            }
            return true;
        }
        return  true;
    }


    /**
     * tugulgan kunlar uchun promocod sovga qilish
     * @return bool
     */
    public function actionPromocodForBirthDay()
    {
        $promocod = Promocodes::findOne(10);
        if(!$promocod || !$promocod->code) return true;
        $users = Users::find()
            ->select('id')
            ->andWhere(['status' =>1])
            ->andWhere(['to_char(birthday,  \'MM-DD\')' => date('m-d')])
            ->all();

        if(!$users) return  true;
        foreach ($users as $value)
        {
            $chats = Chats::find()->andWhere(['name' => '#admin_'.$value->id])->one();
            if($chats){
                $chatMessage = new ChatMessage();
                $chatMessage->chat_id = $chats->id;
                $chatMessage->user_id = 1;
                $chatMessage->message = "Assalomu alaykum, sizni bugungi tavallud kuningiz bilan Bisyor jamoasi tabriklaydi. Bugungi kun uchun sizga promokod sovg'a qilamiz. Bu promokod bilan hisobingizni to'ldirib, bizning platformamizdagi xizmatlardan foydalanishingiz mumkin. Promokod : ".$promocod->code." Hurmat bilan Bisyor jamoasi.";
                $chatMessage->save();
            } else {
                $chat = new Chats();
                $chat->name = '#admin_'.$value->id;
                $chat->date_cr = date('Y-m-d H:i');
                $chat->type = 1;
                $chat->save();

                $chat1 = new ChatUsers();
                $chat2 = new ChatUsers();

                $chat1->chat_id = $chat->id;
                $chat2->chat_id = $chat->id;
                $chat1->date_cr =  date('Y-m-d H:i');
                $chat2->date_cr =  date('Y-m-d H:i');
                $chat1->user_id = 1;
                $chat2->user_id = $value->id;

                $chat1->save();
                $chat2->save();

                $chatMessage = new ChatMessage();
                $chatMessage->chat_id = $chat->id;
                $chatMessage->user_id = 1;
                $chatMessage->message = "Assalomu alaykum, sizni bugungi tavallud kuningiz bilan Bisyor jamoasi tabriklaydi. Bugungi kun uchun sizga promokod sovg'a qilamiz. Bu promokod bilan hisobingizni to'ldirib, bizning platformamizdagi xizmatlardan foydalanishingiz mumkin.
                    Promokod : ".$promocod->code."
                    Hurmat bilan Bisyor jamoasi.";
                $chatMessage->save();
            }
        }
        return  true;
    }
}
