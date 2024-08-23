<?php


namespace backend\components;


use backend\models\items\Categories;
use backend\models\items\CategoriesDynprops;
use backend\models\items\CategoriesDynpropsMulti;
use backend\models\items\Items;
use Yii;

class ParserOlx extends Parser
{
    const OTHER_CAT_ID = [1547 => 311, 1533 => 334, 1517 => 16, 1513 => 16, 1489 => 60, 1425 => 60, 1503 => 842, 1501 => 837, 1499 => 1183,
        1497 => 1183, 842 => 1183, 1493 => 837, 1491 => 842, 1433 => 612, 1548 => 1314, 1431 => 1310,
        1509 => 186, 1429 => 88, 1505 => 496, 1485 => 107, 1487 => 107, 1535 => 1315, 1537 => 1316, 1539 => 1317,
        1541 => 1318, 1543 => 1319, 1479 => 70, 1481 => 541, 1483 => 540, 1495 => 88, 1427 => 851, 1451 =>608
    ];
    const TOKEN = '1f7551d3eb1a222fbbd4b96f34785820b685b93e';
    const ADD_OPTION_KEY = 'Доп. опции';
    const OWNER_TYPE_KEY = 'Объявление от';
    const HOUSING_TYPE = 'Тип жилья';
    const SUB_CATEGORIES_KEY = 'Подкатегории';

    public static $failed_links = [];
    const LIMIT_PARSING = 80;

    const NEXT_TEXT = '<svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24" width="1em" height="1em" class="css-1mougrc"><path fill="currentColor" fill-rule="evenodd" d="M7 2v1.414l1.271 1.27L15.586 12l-7.315 7.315L7 20.585V22h1.414l1.27-1.271L17 13.414l1-1v-.827l-3.942-3.942v-.001L9.686 3.271 8.413 2z"></path></svg>';

    /**
     *
     * @param $file
     * @param bool $parsing_date
     * @return $this
     */
    public function getOfferOlx($file, $parsing_date = false)
    {
        ini_set('max_execution_time', '0'); // for infinite time of execution
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $doc = \phpQuery::newDocument($file);
        $pagination = $doc->find('.next.abs a')->attr('href');
        $offers = $doc->find(".offer-wrapper");
//        $elements = $offers->find('.lheight22.margintop5');
        $elements = $offers;
        $today_date = date('d');
        foreach ($elements as $element) {
            $element = pq($element);
            $view_url = $element->find('a')->attr('href');
            $date_offer = $this->getDate($element->find('.lheight16:eq(1) span:eq(1))')->text());
            $array_url = explode('#', $view_url);
            if (array_key_exists(0, $array_url)) {
                $view_url = $array_url[0];
            }
            if ($parsing_date === false) {
                $this->getViewByJson($this->set(CURLOPT_FOLLOWLOCATION, true)->exec($view_url), $view_url, self::$results);
            } elseif ($date_offer != $today_date) {
                if ($date_offer != $parsing_date) {
                    break;
                }
                $this->getViewByJson($this->set(CURLOPT_FOLLOWLOCATION, true)->exec($view_url), $view_url, self::$results);
            }
        }
        if ($pagination) {
            $file = $this->set(CURLOPT_FOLLOWLOCATION, true)->exec($pagination);
            $this->getOfferOlx($file, $parsing_date);
        }

        return $this;
    }

    /**
     * Elon kiritilgan sanani aniqlab berish funksiyasi
     *
     * @param $date
     * @return false|mixed|string
     */
    public function getDate($date)
    {
        $date_offer = '';
        if (mb_stripos($date, 'Сегодня') !== false) {
            $date_offer = date('d');
        } elseif (mb_stripos($date, 'Вчера') !== false) {
            $date_offer = date('d', strtotime("-1 day"));
        } else {
            $date_offer = explode(' ', $date)[0];
        }
        return $date_offer;
    }

    /**
     * Magazinlar uchun sananani aniqlab olish
     *
     * @param $date
     * @return false|mixed|string
     */
    public function getDateBusinesPage($date)
    {
        $date_offer = '';
        if (mb_stripos($date, 'Сегодня') !== false) {
            $date_offer = date('d');
        } elseif (mb_stripos($date, 'Вчера') !== false) {
            $date_offer = date('d', strtotime("-1 day"));
        } else {
            $date_offer = explode(' ', $date)[0];
        }
        return rtrim($date_offer, ',');
    }

    /**
     * Olxdan elonlarni ko'chirish
     * Faqat biznes sahifalar uchun ishlaydi
     *
     * @param $file
     * @param $link
     * @param false $parsing_date
     * @return $this
     */
    public function getOfferOlxBusiness($file, $link, $parsing_date = false)
    {
        ini_set('max_execution_time', '0'); // for infinite time of execution
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $doc = \phpQuery::newDocument($file);

        $pagination = $doc->find('.pagination-list')->children('a');
        $next_page = null;
        foreach ($pagination as $page) {
            $page = pq($page);
            if (strtolower($page->html()) ==  strtolower(self::NEXT_TEXT))
                $next_page = $page->attr('href');
        }
        $offers = $doc->find(".css-1gdt55e");
        $elements = $offers->find('.css-19ucd76');
        $today_date = date('d');
        foreach ($elements as $element) {
            $element = pq($element);
            $date = $element->find('.css-utpi6t-Text')->text();
            if (empty($date)) continue; // Sanasi mavjud bo'lmasa keyingi qadamga o'tsin
            $date_offer = $this->getDateBusinesPage($date);
            $view_url = $element->find('a')->attr('href');
            if ($parsing_date === false) {
                $this->getViewByJson($this->set(CURLOPT_FOLLOWLOCATION, true)->exec($view_url), $view_url, self::$results);
            } elseif ($date_offer != $today_date) {
                if ($date_offer != $parsing_date) {
                    break;
                }
                $this->getViewByJson($this->set(CURLOPT_FOLLOWLOCATION, true)->exec($view_url), $view_url, self::$results);
            }
        }
        // Paginatsiyali sahifalari xam bo'lsa ularniham olish kerak
        if ($next_page && $next_page != '/') {
            $next_page = explode('?', $next_page);
            $file = $this->set(CURLOPT_FOLLOWLOCATION, true)->exec($link . "/?" . $next_page[1]);
            $this->getOfferOlxBusiness($file, $link, $parsing_date);
        }
        return $this;
    }

    /**
     * Link magazinikkimi yo'qmi aniqlash
     *
     * @param $link
     * @return bool
     */
    public function isShop($link)
    {
        $is_shop = true;
        if (mb_stripos($link, 'www.olx.uz') !== false) {
            $is_shop = false;
        }
        return $is_shop;
    }


    public function getViewByJson($file, $view_url, &$result){
        $doc = \phpQuery::newDocument($file);

        $config = $doc->find('#olx-init-config')->text();
        $text = str_replace(['window.__LANG_CONFIG_', 'window.__TAURUS_'], '', explode('_=', explode('_ =', $config)[3])[1]);
        $json_data = json_decode(rtrim(trim($text), ';'));
        $dynamic_props = [];
        if(!isset($json_data->ad)){
            return;
        }
        $category_id = $json_data->ad->ad->category->id;

        if (array_key_exists($category_id, self::OTHER_CAT_ID)) {
            $category_id = self::OTHER_CAT_ID[$category_id];
        }

        if(is_array($json_data->ad->ad->params)){
            foreach ($json_data->ad->ad->params as $value){
                $dynamic_props += [$value->name => $value->value];
            }
        }
        $description = str_replace('', '- показать телефон -', str_replace('+ 998 - показать телефон -', '', trim($json_data->ad->ad->description)));
        list($dyn_props, $add_text) = self::dynamicProps($dynamic_props, $category_id);
        array_push(
            $result,
            [
                'title' => parent::clrSpaces(is_string($json_data->ad->ad->title) ? $json_data->ad->ad->title : ''),
                'address' => parent::clrSpaces($json_data->ad->ad->location->pathName),
                'description' => strip_tags($description),
                'name' => parent::clrSpaces($json_data->ad->ad->user->name),
                'price' => $json_data->ad->ad->price->regularPrice ?? null,
                'dynamic_props' => $dyn_props,
                'images' => $json_data->ad->ad->photos,
                'coordinate_x' => $json_data->ad->ad->map->lat,
                'coordinate_y' => $json_data->ad->ad->map->lon,
                'category_id' => $category_id,
                'owner_type' => $json_data->ad->ad->isBusiness == 1 ? 1 : 2,
                'view_link' => $view_url,
            ]
        );
    }

    public function dynamicProps($dynamic_props, $category_id){
        if (array_key_exists(self::HOUSING_TYPE, $dynamic_props)) {
            if ($dynamic_props[self::HOUSING_TYPE] === 'Вторичный рынок') {
                $category_id = 207;
            } else {
                $category_id = 345;
            }
        }
        if (array_key_exists(self::SUB_CATEGORIES_KEY, $dynamic_props)) {
            $cat_list = Categories::find()
                ->where(['title' => $dynamic_props[self::SUB_CATEGORIES_KEY]])
                ->asArray()->one();
            if ($cat_list) $category_id = $cat_list['id'];
        }

        return self::getTypeDynamic($dynamic_props, $category_id);
    }
    /**
     * Olx elon sahifasidan ma'lumotlarni terib olsh
     *
     * @param $file
     * @param $view_url
     * @param $result
     */
    public function getViewPageOlx($file, $view_url, &$result)
    {
        $doc = \phpQuery::newDocument($file);

//        echo $doc;
//        die;
        $view = $doc->find('.css-15ctlif');
        $config = $doc->find('#olx-init-config')->text();
        $big_image = $view->find('img.css-1bmvjcs')->attr('src');
        $images = $view->find('img.swiper-lazy');

//        if (!$doc->find('noscript img')->attr('src')) {
//            return;
//        }
        $category_id = self::getCategoryId($doc->find('noscript img')->attr('src'));
        $dynamic_props = self::getDynamicProps($view->find('.offer-details__item'));
//        $phones = $this->getPhone($view->find('.spoilerHidden')->attr('data-raw'));
        $title = $view->find('.offer-titlebox h1')->text();
        $address = $view->find('address p')->text();
        $name = $view->find('.quickcontact__user-name')->text();
        $price = self::getPriceAndCurrency($view->find('.pricelabel__value')->text());
        $lat = $view->find('#mapcontainer')->attr('data-lat');
        $lon = $view->find('#mapcontainer')->attr('data-lon');
        $description = $view->find('.css-g5mtbi-Text')->text();



        list($dyn_props, $add_text) = self::dynamicProps($dynamic_props, $category_id);

        if ($add_text) {
            $description .= "\n\n***\n\n" . parent::clrSpaces($add_text);
        }

        array_push(
            $result,
            [
                'title' => parent::clrSpaces($title),
                'address' => parent::clrSpaces($address),
                'description' => str_replace('', '- показать телефон -', str_replace('+ 998 - показать телефон -', '', trim($description))),
                'name' => parent::clrSpaces($name),
                'price' => $price,
                'dynamic_props' => $dyn_props,
                'images' => self::getImagesOlx($images, $big_image),
                'coordinate_x' => $lat,
                'coordinate_y' => $lon,
                'category_id' => $category_id,
                'owner_type' => self::getOwnerType($dynamic_props),
                'view_link' => $view_url,
            ]
        );
    }


    /**
     * Elon tipini aniqlash uchun funksiya
     *
     * @param $dynamic_props
     * @return int
     */
    public static function getOwnerType($dynamic_props)
    {
        $response = 1;
        if (array_key_exists(self::OWNER_TYPE_KEY, $dynamic_props)) {
            if ($dynamic_props[self::OWNER_TYPE_KEY] === 'Компании') {
                $response = 2;
            }
        }
        return $response;
    }

    /**
     * Elonninga bog'langan telefon raqamni ajax so'rov bilan oolvolish
     *
     * @param $offer_id
     * @return mixed
     */
    public function getPhone($offer_id)
    {
        $this->set(
            CURLOPT_HTTPHEADER,
            ['Content-Type: application/json', "Authorization: Bearer " . self::TOKEN]
        );
        $response = $this->set(
            CURLOPT_FOLLOWLOCATION,
            ['Content-Type: application/json', "Authorization: Bearer " . self::TOKEN]
        )->exec("https://www.olx.uz/api/v1/offers/{$offer_id}/phones/");

        $phone = json_decode($response, true);
        return $phone['data']['phones'];
    }

    /**
     * Sahifadan mahsulot narhi yozilgan qatorni ajratib olib
     * uni qayta ishlab narh va valyuta ko'rinishda qaytarish kerak
     *
     * @param $price_text
     * @return array
     */
    public static function getPriceAndCurrency($price_text)
    {
        $result = [];
        if (strpos($price_text, 'сум') !== false) {
            $result['currency'] = 1;
            $result['price'] = preg_replace("/[^0-9]/", "", $price_text);
        } else {
            $result['currency'] = 3;
            $result['price'] = preg_replace("/[^0-9]/", "", $price_text);
        }
        return $result;
    }

    /**
     * OLX elon saxifasidagi qo'shimcha dinamik xossalarini
     * aniqlab massivga yuklab chiqadi
     *
     * @param $dynamic_props
     * @return array
     */
    public static function getDynamicProps($dynamic_props)
    {
        $results = [];
        foreach ($dynamic_props as $dynamic) {
            $d = pq($dynamic);
            $index = parent::clrSpaces($d->find('.offer-details__param .offer-details__name')->text());
            $value = parent::clrSpaces($d->find('.offer-details__param .offer-details__value')->text());
            $results += [$index => $value];
        }
        return $results;
    }

    /**
     * Rasmlarni linklarini yig'ib qaytaradi
     *
     * @param $files
     * @param $big_image
     * @return array
     */
    public static function getImagesOlx($files, $big_image)
    {
        $results = [];
        foreach ($files as $file) {
            $image_url = pq($file);
            array_push($results, $url = $image_url->find('a')->attr('href'));
        }
        if (count($results) == 0) {
            if ($big_image) {
                array_push($results, $big_image);
            }
        }
        return $results;
    }

    /**
     * Olx elonning kategoriyasini aniqlab berish uchun funksiya
     *
     * @param string $url
     * @return mixed
     */
    public static function getCategoryId(string $url)
    {
        $result = 1;
        $url_components = (parse_url($url));
        $params = [];
        parse_str($url_components['query'], $params);

        if ($params['category_id']) {
            $result = $params['category_id'];
            if (array_key_exists($result, self::OTHER_CAT_ID)) {
                $result = self::OTHER_CAT_ID[$result];
            }
        }
        return $result;
    }

    public static function getTypeDynamic($dynamic_props, $cat_id)
    {
        $results = [];

        $cat_list = Categories::getParents($cat_id); //Shu va shu categoriyaning parentlari
        $cat_dyn_prop = CategoriesDynprops::find()->andWhere(['category_id' => $cat_list])->asArray()->all();
        // $cat_dyn_prop -> Ko'rilayotgan kategoriyaga va uning parentlariga tegishli diynamik maydonlarni o'qib oladi
        $success_props = []; // Bizdan topilgan dinamik polyalar

        if ($cat_dyn_prop) {
            foreach ($cat_dyn_prop as $item) {
                if (array_key_exists($item['title'], $dynamic_props)) {

                    array_push($success_props, $item['title']);
                    $index = $item['data_field'];
                    $value = str_replace(' ', '', $dynamic_props[$item['title']]);

                    $first_value = $value;

                    /* Agar dinamik maydonga description mavjud bo'lsa uning ichidan html kodni alishtirish */
                    if ($item['description']) {
                        $item['description'] = trim(str_replace('<sup>2</sup>', '²', $item['description']));
                        $value = trim(str_replace($item['description'], '', $value));
                    }

                    /* Multi dinamik maydon bo'yichda bizdagi qiymatini yuklab olish */
                    if ($item['type'] == 6) {
                        $multi = CategoriesDynpropsMulti::find()
                            ->where(['dynprop_id' => $item['id'], 'name' => $value])
                            ->asArray()->one();
                        if ($multi) {
                            $value = $multi['value'];
                        }
                    } elseif (in_array($item['type'], [8, 9, 4])) {
                        $multi = CategoriesDynpropsMulti::find()
                            ->where(['dynprop_id' => $item['id']])
                            ->asArray()->all();
                        $temp_value = 0;
                        foreach ($multi as $mult) {
                            if (mb_stripos($value, $mult['name']) !== false) {
                                $temp_value += $mult['value'];
                            }
                        }
                        $value = $temp_value;
                    }

                    if ($first_value !== $value || is_numeric($value)) {
                        $results[] = [$index, $value];
                    }
                }
                if (array_key_exists(self::ADD_OPTION_KEY, $dynamic_props)) {
                    $dyn_id = 63;
                    $value = $dynamic_props[self::ADD_OPTION_KEY];
                    $multi = CategoriesDynpropsMulti::find()
                        ->where(['dynprop_id' => $dyn_id])
                        ->asArray()->all();
                    $temp_value = 0;
                    foreach ($multi as $mult) {
                        if (strpos($value, $mult['name']) !== false) {
                            $temp_value += $mult['value'];
                        }
                    }
                    $index = '6';
                    $value = $temp_value;
                    $results[] = [$index, $value];
                }
            }
        }

        $add_text = self::getAdditionalText($dynamic_props, $success_props);
        return [$results, $add_text];
    }

    /**
     * Olxda mavjud lekin bizda topilmagan dinamik ppolyalarni text formatda descriptionga qo'shib yuboradi
     *
     * @param $dynamic_props
     * @param $success_props
     * @return string
     */
    public static function getAdditionalText($dynamic_props, $success_props)
    {
        $add_text = '';
        foreach ($dynamic_props as $key => $value) {
            if (!in_array($key, $success_props)) {
                if ($key !== self::ADD_OPTION_KEY && $key !== self::OWNER_TYPE_KEY && $key !== self::HOUSING_TYPE) {
                    $add_text .= "\n $key : $value";
                }
            }
        }
        return $add_text;
    }

    /**
     * Elonni saqlash uchun funksiya
     *
     * @param $user_id
     * @param $district_id
     * @param $phone
     * @param $publicated_period
     * @return array
     */
    public function saveOffer($user_id, $district_id, $phone, $publicated_period)
    {

        ini_set('max_execution_time', '0'); // for infinite time of execution
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $count_offers = count(self::$results);
        foreach (self::$results as $result) {
                if (Items::find()->where(
                    [
                        'title' => $result['title'],
                        /*'cat_id' => $result['category_id'],
                        'district_id' => $district_id,*/
                        'user_id' => $user_id,
                        /*'description' => $result['description'],*/
                    ]
                )/*->andWhere(['status' => Items::STATUS_TYPE[Items::STATUS_MODERATING]['statuses']])*/->one()) {
                    continue;
                }
                if ($count_offers > self::LIMIT_PARSING) {
                    self::writeToJson($user_id, $district_id, $phone, $result, $publicated_period);
                }else{
                    $this->fillOlx($user_id, $district_id, $phone, $result, $publicated_period);
                }
            }

        return ['success' => self::$count, 'failed' => self::$failed_links];
    }


    public static function writeToJson($user_id, $district_id, $phone, $data, $publicated_period)
    {
        $currency_id = null;
        $price = null;
        if($data['price']){
            $currency_id = $data['price']->currencyCode == 'UZS' ? 1:3;
            $price = (float)$data['price']->value;
        }
        $array = [
            'owner_type' => $data['owner_type'],
            'cat_type' => 0,
            'user_id' => $user_id,
            'currency_id' => $currency_id,
            'price_ex' => 0,
            'name' => $data['name'],
            'cat_id' => $data['category_id'],
            'district_id' => $district_id,
            'title' => $data['title'],
            'description' => $data['description'],
            'address' => $data['address'],
            'price' => $price,
            'phones' => [$phone],
            'coordinate_x' => (string)$data['coordinate_x'],
            'coordinate_y' => (string)$data['coordinate_y'],
            'publicated_period' => $publicated_period,
            'images' => $data['images'],
        ];

        foreach ($data['dynamic_props'] as $value) {
            $array += ["f$value[0]" => (string)$value[1]];
        }

        $data = file_get_contents(Yii::$app->basePath . '/components/data/parsing.json');
        $parsing_data = $json = json_decode($data, true);
        array_push($parsing_data, $array);
        $fp = fopen(Yii::$app->basePath . '/components/data/parsing.json', 'w');
        fwrite($fp, json_encode($parsing_data));
        self::$count++;
        fclose($fp);
    }

    /**
     * Json faylga yuklab qo'yilgan elonlarni 100 tadan bazaga kiritib chiqadi
     * @param $parsing_data
     */
    public function readFromJsonSetToBase($parsing_data)
    {
        ini_set('max_execution_time', '0'); // for infinite time of execution
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        
        foreach ($parsing_data as $key => $value) {
            $model = new Items();
            foreach ($value as $k => $val) {
                if ($k == 'images') continue;
                $model->$k = $val;
            }
            
            if ($model->save()) {
                $this->uploadImage($model, $value['user_id'], $value['images']);
                $model->saveFromOlxUz();
            }
        }
    }

    /**
     * Elonlarni bazaga yozish
     *
     * @param $user_id
     * @param $district_id
     * @param $phone
     * @param $data
     * @param $publicated_period
     */
    public function fillOlx($user_id, $district_id, $phone, $data, $publicated_period)
    {
        $model = new Items();
        $model->owner_type = $data['owner_type'];
        $model->cat_type = 0;
        $model->user_id = $user_id;
        if($data['price']){
            $model->currency_id = $data['price']->currencyCode == 'UZS' ? 1:3;
            $model->price = (float)$data['price']->value;
        }
        $model->price_ex = 0;
        $model->name = $data['name'];
        $model->cat_id = $data['category_id'];
        $model->district_id = $district_id;
        $model->title = $data['title'];
        $model->description = $data['description'];
        $model->address = $data['address'];
        $model->phones = [$phone];
        $model->coordinate_x = (string)$data['coordinate_x'];
        $model->coordinate_y = (string)$data['coordinate_y'];
        $model->publicated_period = $publicated_period;
        foreach ($data['dynamic_props'] as $value) {
            $model->{"f$value[0]"} = (string)$value[1];
        }

        if ($model->save()) {
            $this->uploadImage($model, $user_id, $data['images']);
            $model->saveFromOlxUz();
            self::$count++;
        } else {
            print_r($model->getErrorMessage());
            die;
            array_push(self::$failed_links, $data['view_link']);
        }
    }

    /**
     * Rasmlarni linklar bo'yicha trash papkaga saqlaydi va items papkaga jo'natadi
     *
     * @param $item
     * @param $user_id
     * @param $image_links
     */
    public function uploadImage($item, $user_id, $image_links)
    {
        $array = $this->saveImgStorage($image_links);
        if ($array !== false) {
            $array = implode(',', $array);
            $item->newSaveImg(['uploaded_files' => $array], $user_id);
        }
    }

    /**
     * Rasmlarni o'zimizning serverga ko'chirib chiqadi
     *
     * @param $file_links
     * @return array|false
     */
    public function saveImgStorage($file_links)
    {
        $names = [];
        foreach ($file_links as $link) {
//            $file_name = str_replace('/image;s=1000x700', '', str_replace('https://apollo-olx.cdnvideo.ru:443/v1/files/', '', $link));
            $file_name = str_replace('https://apollo-olx.cdnvideo.ru:443/v1/files/', '', $link);
            array_push($names, explode('/', $file_name)[0] . ".jpg");
        }
        $curl_url = Yii::$app->params['image_site'] . '/api/upload-olx';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $curl_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['links' => $file_links]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_result = curl_exec($ch);
        curl_close($ch);

        if ($server_result) return $names; else return false;
    }

}