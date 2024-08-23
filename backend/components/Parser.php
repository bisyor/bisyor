<?php

namespace backend\components;

use backend\models\items\Items;
use backend\models\references\Currencies;

require_once(dirname(__FILE__) . '/phpQuery.php');

class Parser
{
    private $ch;
    const URLS = [
        '1' => [
            'name' => 'Ўқитувчи, педагог / Преподаватель, педагог',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=1&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 1,
            'category_bisyor' => 141,
        ],
        '2' => [
            'name' => 'Муҳандис, бош муҳандис / Инженер, глав инженер',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=2&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 2,
            'category_bisyor' => 180,
        ],
        '3' => [
            'name' => 'Шифокор, бош шифокор / Врач, глав врач',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=3&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 3,
            'category_bisyor' => 134,
        ],
        '4' => [
            'name' => 'Ҳамшира, бош ҳамшира, доя / Медсестра, старшая сестра, акушерки',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=4&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 4,
            'category_bisyor' => 134,
        ],
        '5' => [
            'name' => 'Ҳисобчи, бош ҳисобчи / Бухгалтер, главный бухгалтер',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=5&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 5,
            'category_bisyor' => 171,
        ],
        '6' => [
            'name' => 'Иқтисодчи, бош иқтисодчи,&nbsp;банк ходими / Экономист, главный экономист, банковский служащий',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=6&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 6,
            'category_bisyor' => 171,
        ],
        '7' => [
            'name' => 'Уста, кончи усталар / Мастер, мастер шахтёр',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=7&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 7,
            'category_bisyor' => 181,
        ],
        '8' => [
            'name' => 'Механик, бош механик / Механик, старший механик',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=8&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 8,
            'category_bisyor' => 180,
        ],
        '9' => [
            'name' => 'Мутахассис, бош мутахассис / Специалист, главный специалист',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=9&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 9,
            'category_bisyor' => 151,
        ],
        '10' => [
            'name' => 'Кичик ёки катта илмий ходим / Научный сотрудник, старший научный сотрудник',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=10&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 10,
            'category_bisyor' => 141,
        ],
        '11' => [
            'name' => 'Тарбиячи, кутубхоначи / Педагог, библиотекар',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=11&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 11,
            'category_bisyor' => 141,
        ],
        '12' => [
            'name' => 'Бўлим, бўлинма бошлиғи / Начальник департамент, начальник отдела',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=12&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 12,
            'category_bisyor' => 151,
        ],
        '13' => [
            'name' => 'Лабарант, лабараторя мудири / Лабарант, заведующий лабораторией',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=13&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 13,
            'category_bisyor' => 141,
        ],
        '14' => [
            'name' => 'Ҳуқуқшунос / Юрист',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=14&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 14,
            'category_bisyor' => 1145,
        ],
        '15' => [
            'name' => 'ЭҲМ оператор / Оператор ЭВМ',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=15&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 15,
            'category_bisyor' => 166,
        ],
        '16' => [
            'name' => 'Котиба / Секретарь',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=16&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 16,
            'category_bisyor' => 177,
        ],
        '17' => [
            'name' => 'Назоратчи / Контролёр',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=17&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 17,
            'category_bisyor' => 945,
        ],
        '18' => [
            'name' => 'Тикувчи-бичувчи / Портной-швеи',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=18&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 18,
            'category_bisyor' => 156,
        ],
        '19' => [
            'name' => 'Сервис хизматлар / Сервисное обслуживание',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=19&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 19,
            'category_bisyor' => 1163,
        ],
        '20' => [
            'name' => 'Офис хизматчи / Офисный персонал',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=20&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 20,
            'category_bisyor' => 175,
        ],
        '21' => [
            'name' => 'Ахборот технологиялари, Дастурчилар, Интернет / Работа в сфере IT, Программисты, Интернет',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=21&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 21,
            'category_bisyor' => 165,
        ],
        '22' => [
            'name' => 'Медицина, Фармация / Медицина, Фармация',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=22&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 22,
            'category_bisyor' => 134,
        ],
        '23' => [
            'name' => 'Инженер, Технолог, Конструктор / Инженеры, Технологи, Конструкторы',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=23&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 23,
            'category_bisyor' => 180,
        ],
        '24' => [
            'name' => 'Қўриқлаш, Хавфсизлик / Охрана, Безопасность',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=24&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 24,
            'category_bisyor' => 152,
        ],
        '25' => [
            'name' => 'Туризм, Меҳмонхона, Ресторан, Общепит / Туризм, Гостиницы, Рестораны, Общепит',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=25&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 25,
            'category_bisyor' => 132,
        ],
        '26' => [
            'name' => 'Юрист, Адвокат, Нотариус / Юрист, Адвокат, Нотариус',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=26&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 26,
            'category_bisyor' => 1145,
        ],
        '27' => [
            'name' => 'Банк, Лизинг / Банки, Лизинг',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=27&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 27,
            'category_bisyor' => 171,
        ],
        '28' => [
            'name' => 'Таъмирлаш, хизматлар / Услуги, ремонт',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=28&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 28,
            'category_bisyor' => 1163,
        ],
        '29' => [
            'name' => 'Бошқалар / Другие',
            'url' => 'http://ish.mehnat.uz/vacancy/index?VacancySearch%5Bregion_id%5D=&VacancySearch%5Bcity_id%5D=&VacancySearch%5Bvacancy_type_id%5D=29&VacancySearch%5Bclassificator_id%5D=&VacancySearch%5Beducation_step%5D=&VacancySearch%5Bsalary_begin%5D=&VacancySearch%5Bsalary_end%5D=',
            'category_ish' => 29,
            'category_bisyor' => 151,
        ],
    ];
    const USER_ID = 7719;
    const LIMIT = 70;
    const AUTHOR_NAME = 'Mexnat.uz';
    protected static $count = 0;

    protected static $results = [];

    public function __construct($print = false)
    {
        $this->ch = curl_init();
        if (!$print) {
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        }
    }

    /**
     * ish.mexnat.uz saytidagi mavjud bo'limlar manzillari
     *
     * @param $key
     * @return array
     */
    public function getUrls($key = false)
    {
        if ($key === false) {
            return self::URLS;
        }
        return self::URLS[$key];
    }

    public function set($name, $value)
    {
        curl_setopt($this->ch, $name, $value);
        return $this;
    }

    public function get()
    {
        return self::$results;
    }

    public function setResultNull()
    {
        self::$results = [];
    }

    public function exec($url)
    {
        ini_set('max_execution_time', '0'); // for infinite time of execution 
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        curl_setopt($this->ch, CURLOPT_URL, $url);
        return curl_exec($this->ch);
    }

    public function safeExec()
    {
        ini_set('max_execution_time', '0'); // for infinite time of execution
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        return curl_exec($this->ch);
    }

    public function getVacancy($file)
    {
        $break = false;
        $doc = \phpQuery::newDocument($file);
        $pagination = pq($doc->find('.pagination li.active'));
        $pagination = $pagination->next()->find('a')->attr('href');

        $elements = $doc->find('.table.table-striped.table-bordered tbody tr');
        $date = date('d.m.Y', strtotime("-1 day"));
        foreach ($elements as $element) {
            $element = pq($element);
            $created_date = $element->find(':eq(10)')->html();
            if ($created_date < $date) {
                $break = true;
                break;
            } elseif ($created_date == $date) {
                $view_url = 'http://ish.mehnat.uz' . $element->find(':eq(11) a')->attr('href');
                $temp_res = [
                    'region' => $element->find(':eq(2)')->html(),
                    'special' => $element->find(':eq(3) a')->html(),
                    'business_name' => $element->find(':eq(5)')->html(),
                    'price' => $element->find(':eq(7)')->html(),
                    'rate' => $element->find(':eq(8)')->html(),
                    'count' => $element->find(':eq(9)')->html(),
                    'date' => $created_date,
                    'view' => 'http://ish.mehnat.uz' . $element->find(':eq(11) a')->attr('href'),
                ];
                $this->getViewPage($this->set(CURLOPT_FOLLOWLOCATION, true)->exec($view_url), $temp_res);
                array_push(self::$results, $temp_res);
            }
        }
        if (!$break) {
            $file = $this->set(CURLOPT_FOLLOWLOCATION, true)->exec('http://ish.mehnat.uz' . $pagination);
            $this->getVacancy($file);
        }
        return $this;
    }

    public function getViewPage($file, &$result)
    {
        $doc = \phpQuery::newDocument($file);
        $view = $doc->find('.panel');
        $result = array_merge(
            $result,
            [
                'address' => $view->find('.panel-heading table tbody span p')->html(),
                'phone' => $view->find('.panel-heading table tbody span:eq(3)')->html(),
                'education' => $view->find('.panel-body p:eq(4)')->html(),
                'practice' => $view->find('.panel-body p:eq(2)')->html(),
                'description' => $view->find('.panel-footer span b')->remove()->end()
                    ->find('.panel-footer span')->text(),
                'type_work' => $view->find('.panel-body p:eq(5)')->html(),
                'type_payment' => $view->find('.panel-body p:eq(6)')->html(),
            ]
        );
    }

    public function saveVacancy($cat_id)
    {
        $date_begin = date('Y-m-d 00:00:00', time());
        $date_end = date('Y-m-d 23:59:59', time());
        $lastItems = Items::find()->where(['user_id' => self::USER_ID])->andWhere(['between', 'date_cr', $date_begin, $date_end])->all();

        foreach (self::$results as $value) {
            $district = $this->get_districts()[$value['region']];
            $description = $this->buildDescription($value);
            $status = false;
            foreach ($lastItems as $item) {
                if($item->title == $value['special'] && $item->cat_id == $cat_id && $item->district_id == $district && $item->description == $description ) {
                    $status = true;
                    break;
                }
            }
            /*if (Items::find()->where(
                [
                    'title' => $value['special'],
                    'cat_id' => $cat_id,
                    'district_id' => $district,
                    'description' => $description
                ]
            )->one()) {
                continue;
            }*/
            if(!$status)$this->fill($value, $district, $cat_id, $description);
            /*if(self::$count >= self::LIMIT){
                break;
            }*/

        }

        return self::$count;
    }

    public function fill($value, $district, $cat_id, $description)
    {
        $phone = preg_replace('/\s+/', ' ', $value['phone']);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace(' ', '', $phone);

        $model = new Items();
        $model->owner_type = 1;
        $model->cat_type = 1;
        $model->user_id = self::USER_ID;
        $model->currency_id = 1;
        $model->price_ex = 0;
        $model->name = self::AUTHOR_NAME;
        $model->cat_id = $cat_id;
        $model->district_id = $district;
        $model->title = $value['special'];
        $model->description = $description;
        $model->address = self::clrSpaces(ucfirst(strtolower($value['address'])));
        $model->price = (float)preg_replace(['/,\d{2}/', '/[^0-9]+/'], '', $value['price']);
        $model->phones = [$phone];

        if ($model->save()) {
            $model->saveFromMehnatUz();
            self::$count++;
        }
    }

    public function buildDescription($item)
    {
        return "{$item['description']}\n Маош: {$item['price']} \n  Ставка: {$item['rate']} \n Иш малакаси: {$item['practice']} \n Иш ўринлари сони: {$item['count']} \n Таълим даражаси: ". self::clrSpaces(str_replace(["\n", "\r"], '', $item['education'])) ." \n Тўлов шакли: ". self::clrSpaces(str_replace(["\n", "\r"], '', $item['type_payment']));
    }

    public function get_districts()
    {
        return [
            'Нукус шаҳар' => 197,
            'Амударё тумани' => 182,
            'Беруний тумани' => 183,
            'Қонликўл тумани' => 187,
            'Қораўзак тумани' => 184,
            'Кегейли тумани' => 185,
            'Қўнғирот тумани' => 186,
            'Муйноқ тумани' => 188,
            'Нукус тумани' => 189,
            'Тахтакўприк тумани' => 191,
            'Тўрткўл тумани' => 192,
            'Хўжайли тумани' => 193,
            'Чимбой тумани' => 194,
            'Шўманай тумани' => 195,
            'Элликқалъа тумани' => 196,
            'Тахиатош' => 190,
            'Бўзатов тумани' => 1,
            'Бухоро шаҳар' => 28,
            'Бухоро туман' => 18,
            'Вобкент туман' => 27,
            'Ғиждувон туман' => 19,
            'Жондор туман' => 20,
            'Когон туман' => 21,
            'Олот туман' => 17,
            'Пешку туман' => 24,
            'Ромитан туман' => 25,
            'Шофиркон туман' => 26,
            'Қоракўл туман' => 22,
            'Қоровулбозор туман' => 23,
            'Когон шаҳар' => 29,
            'Самарқанд шаҳар' => 124,
            'Оқдарё тумани' => 110,
            'Булунғур тумани' => 111,
            'Жомбой тумани' => 112,
            'Каттақўрғон тумани' => 114,
            'Каттақўрғон шаҳар' => 125,
            'Қўшрабод тумани' => 115,
            'Нарпай тумани' => 116,
            'Нуробод тумани' => 121,
            'Пайариқ тумани' => 117,
            'Пастдарғом тумани' => 118,
            'Пахтачи тумани' => 119,
            'Самарқанд тумани' => 120,
            'Тайлоқ тумани' => 123,
            'Ургут тумани' => 122,
            'Иштихон тумани' => 113,
            'Навоий шаҳар' => 94,
            'Кармана тумани' => 89,
            'Навбахор тумани' => 88,
            'Нурота тумани' => 90,
            'Хатирчи тумани' => 93,
            'Қизилтепа тумани' => 87,
            'Конимех тумани' => 86,
            'Учқудуқ тумани' => 92,
            'Зарафшон шаҳар' => 95,
            'Томди тумани' => 91,
            'Андижон шаҳар' => 1,
            'Хонобод шаҳар' => 16,
            'Андижон тумани' => 15,
            'Асака тумани' => 2,
            'Балиқчи тумани' => 14,
            'Бўз тумани' => 3,
            'Булоқбоши тумани' => 4,
            'Жалолқудуқ тумани' => 6,
            'Избоскан тумани' => 5,
            'Улуғнор тумани' => 12,
            'Қўрғонтепа тумани' => 12,
            'Мархамат тумани' => 7,
            'Олтинкўл тумани' => 8,
            'Пахтаобод тумани' => 9,
            'Ҳўжаобод тумани' => 13,
            'Шахрихон тумани' => 11,
            'Марғилон шаҳар' => 48,
            'Фарғона шаҳар' => 45,
            'Қувасой шаҳар' => 47,
            'Қўқон шаҳар' => 46,
            'Боғдод тумани' => 31,
            'Бешариқ тумани' => 32,
            'Бувайда тумани' => 33,
            'Данғара тумани' => 34,
            'Ёзёвон тумани' => 44,
            'Олтиариқ тумани' => 30,
            'Қўштепа тумани' => 37,
            'Риштон тумани' => 39,
            'Сўх тумани' => 40,
            'Тошлоқ тумани' => 41,
            'Учкўприк тумани' => 42,
            'Фарғона тумани' => 35,
            'Фурқат тумани' => 36,
            'Ўзбекистон тумани' => 43,
            'Қува тумани' => 47,
            'Ангор тумани' => 138,
            'Бойсун тумани' => 139,
            'Денов тумани' => 141,
            'Жарқўрғон тумани' => 143,
            'Қизириқ тумани' => 144,
            'Қумқўрғон тумани' => 143,
            'Музработ тумани' => 140,
            'Олтинсой тумани' => 137,
            'Сариосиё тумани' => 145,
            'Термиз тумани' => 146,
            'Термиз шаҳар' => 150,
            'Узун тумани' => 147,
            'Шеробод тумани' => 148,
            'Шўрчи тумани' => 149,
            'Бандихон тумани' => 1,
            'Оқолтин тумани' => 126,
            'Боёвут тумани' => 127,
            'Гулистон тумани' => 129,
            'Мирзаобод тумани' => 131,
            'Сайхунобод тумани' => 128,
            'Сирдарё тумани' => 132,
            'Сардоба тумани' => 130,
            'Ховос тумани' => 133,
            'Гулистон шаҳар' => 134,
            'Ширин шаҳар' => 135,
            'Янгиер шаҳар' => 136,
            'Урганч шаҳар' => 65,
            'Боғот тумани' => 62,
            'Гурлан тумани' => 63,
            'Хозарасп тумани' => 66,
            'Хива тумани' => 68,
            'Хонқа тумани' => 67,
            'Урганч тумани' => 65,
            'Қўшкўпир тумани' => 64,
            'Шовот тумани' => 69,
            'Янгиариқ тумани' => 70,
            'Янгибозор тумани' => 71,
            'Хива шаҳар' => 73,
            'Тупроққалъа тумани' => 1,
            'Ангрен шаҳар' => 166,
            'Бекобод шаҳар' => 151,
            'Олмалиқ шаҳар' => 165,
            'Чирчиқ шаҳар' => 169,
            'Бекобод тумани' => 151,
            'Бўка тумани' => 153,
            'Бўстонлиқ тумани' => 152,
            'Қибрай тумани' => 157,
            'Зангиота тумани' => 155,
            'Қуйичирчиқ тумани' => 154,
            'Оққўрғон тумани' => 198,
            'Охонгарон тумани' => 198,
            'Паркент тумани' => 158,
            'Пскент тумани' => 159,
            'Ўртачирчиқ тумани' => 160,
            'Чиноз тумани' => 161,
            'Юқоричирчиқ тумани' => 156,
            'Янгийўл тумани' => 170,
            'Тошкент тумани' => 163,
            'Янгийўл шаҳар' => 170,
            'Оҳангарон шаҳар' => 168,
            'Нурафшон шаҳар' => 164,
            'Қарши шаҳар' => 108,
            'Ғузор тумани' => 96,
            'Қарши тумани' => 108,
            'Касби тумани' => 104,
            'Косон тумани' => 99,
            'Китоб тумани' => 100,
            'Миришкор тумани' => 101,
            'Муборак тумани' => 102,
            'Нишон тумани' => 103,
            'Чироқчи тумани' => 105,
            'Шахрисабз тумани' => 106,
            'Қамаши тумани' => 98,
            'Дехқонобод тумани' => 97,
            'Яккабоғ тумани' => 107,
            'Шахрисабз шаҳар' => 109,
            'Жиззах шаҳар' => 61,
            'Бахмал тумани' => 50,
            'Дўстлик тумани' => 51,
            'Ғаллаорол тумани' => 53,
            'Ш.Рашидов тумани' => 1,
            'Зарбдор тумани' => 60,
            'Зафаробод тумани' => 59,
            'Зомин тумани' => 58,
            'Пахтакор тумани' => 56,
            'Мирзачўл тумани' => 55,
            'Фориш тумани' => 52,
            'Янгиобод тумани' => 57,
            'Арнасой тумани' => 76,
            'Наманган шаҳар' => 85,
            'Мингбулоқ тумани' => 74,
            'Поп тумани' => 78,
            'Норин тумани' => 77,
            'Тўрақўрғон тумани' => 79,
            'Уйчи тумани' => 80,
            'Чортоқ тумани' => 82,
            'Чуст тумани' => 83,
            'Янгиқўрғон тумани' => 84,
            'Наманган тумани' => 76,
            'Учқўрғон тумани' => 81,
            'Косонсой тумани' => 75,
            'Юнусобод тумани' => 173,
            'Миробод тумани' => 175,
            'Яккасарой тумани' => 179,
            'Олмазор тумани' => 177,
            'Бектемир тумани' => 172,
            'Яшнобод тумани' => 180,
            'Чилонзор тумани' => 181,
            'Учтепа тумани' => 171,
            'Мирзо Улуғбек тумани' => 174,
            'Сергели тумани' => 178,
            'Шайхонтохур тумани' => 176
        ];
    }

    /**
     * Matn taarkibidagi ketma ket kelgan probellarni bittaasiga alishtiradi
     *
     * @param $text
     * @return string
     */
    public static function clrSpaces($text){
        return trim(preg_replace('/\s+/', ' ', $text));
    }


    public function __destruct()
    {
        curl_close($this->ch);
    }
}