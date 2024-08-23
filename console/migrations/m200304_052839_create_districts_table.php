<?php

use yii\db\Migration;
use Cocur\Slugify\Slugify;

/**
 * Handles the creation of table `{{%districts}}`.
 */
class m200304_052839_create_districts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%districts}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
            'region_id' => $this->integer()->comment("Регион"),
            'last_id' => $this->integer()->comment("Old id"),
            'keyword' => $this->string()->comment("Ключовая слова"),
        ]);

        $this->createIndex(
            'idx-districts-region_id',
            'districts',
            'region_id'
        );


        // add foreign key for table `regions`
        $this->addForeignKey(
            'fk-districts-region_id',
            'districts',
            'region_id',
            'regions',
            'id',
            'CASCADE'
        );
        
        //========================================================================================
        //Andijon viloyatidagi tumanlar
            $this->insert('districts',array('name' => 'город Андижан','region_id'=>'1','last_id' => '9078'));
            $this->insert('districts',array('name' => 'Асакинский район','region_id'=>'1','last_id' => '9079'));
            $this->insert('districts',array('name' => 'Бозский район','region_id'=>'1','last_id' => '9082'));
            $this->insert('districts',array('name' => 'Булакбашинский район','region_id'=>'1','last_id' => '9083'));

            //yo'q bular
            $this->insert('districts',array('name' => 'Избасканский район','region_id'=>'1','last_id' => ''));
            $this->insert('districts',array('name' => 'Джалакудукский район    ','region_id'=>'1','last_id' => ''));
            //

            $this->insert('districts',array('name' => 'Мархаматский район','region_id'=>'1','last_id' => '9087'));
            $this->insert('districts',array('name' => 'Алтынкульский район ','region_id'=>'1','last_id' => '9077'));
            $this->insert('districts',array('name' => ' Пахтаабадский район','region_id'=>'1', 'last_id' => '9089'));
            $this->insert('districts',array('name' => 'Кургантепинский район','region_id'=>'1', 'last_id' => '9086'));
            $this->insert('districts',array('name' => 'Шахриханский район','region_id'=>'1', 'last_id' => '9090'));

            //yo'q bular
            $this->insert('districts',array('name' => 'Улугнорский район','region_id'=>'1', 'last_id' => ''));
            //

            $this->insert('districts',array('name' => 'Ходжаабадский район','region_id'=>'1', 'last_id' => '9092'));
            $this->insert('districts',array('name' => 'Балыкчинский район','region_id'=>'1', 'last_id' => '9081'));
            $this->insert('districts',array('name' => 'Андижанский район   ','region_id'=>'1', 'last_id' => '9078'));
            $this->insert('districts',array('name' => 'город Ханабад','region_id'=>'1', 'last_id' => '9091'));
        
        //Buxoro viloyatidagi tumanlar
    
            $this->insert('districts',array('name' => 'Алатский район','region_id'=>'2', 'last_id' => '9093'));
            $this->insert('districts',array('name' => 'Бухарский район','region_id'=>'2', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Гиждуванский район','region_id'=>'2', 'last_id' => '9097'));
            $this->insert('districts',array('name' => 'Жондорский район','region_id'=>'2', 'last_id' => '9104'));
            $this->insert('districts',array('name' => 'Каганский район','region_id'=>'2', 'last_id' => '9098'));
            $this->insert('districts',array('name' => 'Каракульский район','region_id'=>'2', 'last_id' => '9099'));
            $this->insert('districts',array('name' => 'Караулбазарский район','region_id'=>'2', 'last_id' => '9100'));
            $this->insert('districts',array('name' => 'Пешкунский район','region_id'=>'2', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Ромитанский район','region_id'=>'2', 'last_id' => '9101'));
            $this->insert('districts',array('name' => 'Шафирканский район','region_id'=>'2', 'last_id' => '9102'));
            $this->insert('districts',array('name' => 'Вабкентский район','region_id'=>'2', 'last_id' => '9103'));
            $this->insert('districts',array('name' => 'город Бухара','region_id'=>'2', 'last_id' => '9094'));
            $this->insert('districts',array('name' => 'город Каган','region_id'=>'2', 'last_id' => ''));
        
        //Farg'ona viloyatidagi tumanlar
            $this->insert('districts',array('name' => 'Алтыарыкский район','region_id'=>'3', 'last_id' => '9219'));
            $this->insert('districts',array('name' => 'Багдадский район','region_id'=>'3', 'last_id' => '9220'));
            $this->insert('districts',array('name' => 'Бешарикский район','region_id'=>'3', 'last_id' => '9220'));
            $this->insert('districts',array('name' => 'Бувайдинский район','region_id'=>'3', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Дангаринский район','region_id'=>'3', 'last_id' => '9222'));
            
            //buyam yo'q
            $this->insert('districts',array('name' => 'Ферганский район','region_id'=>'3', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Фуркатский район','region_id'=>'3', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Куштепинский район','region_id'=>'3', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Кувинский район','region_id'=>'3', 'last_id' => '9225'));
            $this->insert('districts',array('name' => 'Риштанский район','region_id'=>'3', 'last_id' => '9231'));
            $this->insert('districts',array('name' => 'Сохский район','region_id'=>'3', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Ташлакский район','region_id'=>'3', 'last_id' => '9233'));
            $this->insert('districts',array('name' => 'Учкуприкский район','region_id'=>'3', 'last_id' => '9234'));
            $this->insert('districts',array('name' => 'Узбекистанский район','region_id'=>'3', 'last_id' => ''));
            //

            $this->insert('districts',array('name' => 'Язъяванский район','region_id'=>'3', 'last_id' => '9240'));
            $this->insert('districts',array('name' => 'город Фергана','region_id'=>'3', 'last_id' => '9223'));
            $this->insert('districts',array('name' => 'город Коканд','region_id'=>'3', 'last_id' => '9224'));
            $this->insert('districts',array('name' => 'город Кувасай','region_id'=>'3', 'last_id' => '9226'));
            $this->insert('districts',array('name' => 'город Маргилан','region_id'=>'3', 'last_id' => '9238'));

        //Jizzax viloyatidagi tumanlar
            // bularam yo'q
            $this->insert('districts',array('name' => 'Арнасайский район','region_id'=>'4', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Бахмальский район','region_id'=>'4', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Дустликский район','region_id'=>'4', 'last_id' => '9108'));
            $this->insert('districts',array('name' => 'Фаришский район','region_id'=>'4', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Галляаральский район','region_id'=>'4', 'last_id' => '9111'));
            $this->insert('districts',array('name' => 'Шараф-Рашидовский район','region_id'=>'4', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Мирзачульский район','region_id'=>'4', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Пахтакорский район','region_id'=>'4', 'last_id' => '9114'));
            $this->insert('districts',array('name' => 'Янгиабадский район','region_id'=>'4', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Зааминский район','region_id'=>'4', 'last_id' => '9118'));
            $this->insert('districts',array('name' => 'Зафарабадский район','region_id'=>'4', 'last_id' => '9119'));
            $this->insert('districts',array('name' => 'Зарбдарский район','region_id'=>'4', 'last_id' => '9120'));
            $this->insert('districts',array('name' => 'город Джизак','region_id'=>'4', 'last_id' => ''));
            //

        
        //Xorazm viloyatidagi tumanlar
            $this->insert('districts',array('name' => 'Багатский район','region_id'=>'5', 'last_id' => '9207'));
            $this->insert('districts',array('name' => 'Гурленский район','region_id'=>'5', 'last_id' => '9209'));
            $this->insert('districts',array('name' => 'Кошкупырский район','region_id'=>'5', 'last_id' => '9211'));
            $this->insert('districts',array('name' => 'Ургенчский район','region_id'=>'5', 'last_id' => '9214'));
            $this->insert('districts',array('name' => 'Хазараспский район','region_id'=>'5', 'last_id' => '9216'));
            $this->insert('districts',array('name' => 'Ханкинский район','region_id'=>'5', 'last_id' => '9215'));
            $this->insert('districts',array('name' => 'Хивинский район','region_id'=>'5', 'last_id' => '9217'));
            $this->insert('districts',array('name' => 'Шаватский район','region_id'=>'5', 'last_id' => '9213'));
            $this->insert('districts',array('name' => 'Янгиарыкский район','region_id'=>'5', 'last_id' => '9218'));
            //bula yo'q
            $this->insert('districts',array('name' => 'Янгибазарский район','region_id'=>'5', 'last_id' => ''));
            $this->insert('districts',array('name' => 'город Ургенч','region_id'=>'5', 'last_id' => ''));
            $this->insert('districts',array('name' => 'город Хива','region_id'=>'5', 'last_id' => ''));
        
        //Namangan viloyatidagi tumanlar
            //bular yo'q
            $this->insert('districts',array('name' => 'Мингбулакский район ','region_id'=>'6', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Касансайский район','region_id'=>'6', 'last_id' => '9152'));
            $this->insert('districts',array('name' => 'Наманганский район','region_id'=>'6', 'last_id' => '9153'));
            $this->insert('districts',array('name' => 'Нарынский район','region_id'=>'6', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Папский район','region_id'=>'6', 'last_id' => '9154'));
            $this->insert('districts',array('name' => 'Туракурганский район','region_id'=>'6', 'last_id' => '9156'));
            $this->insert('districts',array('name' => 'Уйчинский район','region_id'=>'6', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Учкурганский район','region_id'=>'6', 'last_id' => '9157'));
            $this->insert('districts',array('name' => 'Чартакский район','region_id'=>'6', 'last_id' => '9148'));
            $this->insert('districts',array('name' => 'Чустский район','region_id'=>'6', 'last_id' => '9150'));
            $this->insert('districts',array('name' => 'Янгикурганский район','region_id'=>'6', 'last_id' => ''));
            $this->insert('districts',array('name' => 'город Наманган','region_id'=>'6', 'last_id' => ''));
            //

        //Navoiy viloyatidagi tumanlar
            //bularam yo'q
            //
            $this->insert('districts',array('name' => 'Канимехский район','region_id'=>'7', 'last_id' => '9139'));
            $this->insert('districts',array('name' => 'Кызылтепинский район','region_id'=>'7', 'last_id' => '9141'));
            $this->insert('districts',array('name' => 'Навбахорский район','region_id'=>'7', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Карманинский район','region_id'=>'7', 'last_id' => '9140'));
            $this->insert('districts',array('name' => 'Нуратинский район','region_id'=>'7', 'last_id' => '9143'));
            $this->insert('districts',array('name' => 'Тамдынский район','region_id'=>'7', 'last_id' => '9144'));
            $this->insert('districts',array('name' => 'Учкудукский район','region_id'=>'7', 'last_id' => '9145'));
            $this->insert('districts',array('name' => 'Хатырчинский район','region_id'=>'7', 'last_id' => ''));
            $this->insert('districts',array('name' => 'город Навои','region_id'=>'7', 'last_id' => '9142'));
            $this->insert('districts',array('name' => 'город Зарафшан','region_id'=>'7', 'last_id' => '9147'));
        
        //Qashqadaryo viloyatidagi tumanlar
            $this->insert('districts',array('name' => 'Гузарский район','region_id'=>'8', 'last_id' => '9124'));
            $this->insert('districts',array('name' => 'Дехканабадский район','region_id'=>'8', 'last_id' => '9123'));
            $this->insert('districts',array('name' => 'Камашинский район','region_id'=>'8', 'last_id' => '9125'));
            $this->insert('districts',array('name' => 'Касанский район','region_id'=>'8', 'last_id' => '9128'));
            $this->insert('districts',array('name' => 'Китабский район','region_id'=>'8', 'last_id' => '9130'));
            $this->insert('districts',array('name' => 'Миришкорский район','region_id'=>'8', 'last_id' => '9136'));
            $this->insert('districts',array('name' => 'Мубарекский район','region_id'=>'8', 'last_id' => '9131'));
            $this->insert('districts',array('name' => 'Нишанский район','region_id'=>'8', 'last_id' => '9137'));
            $this->insert('districts',array('name' => 'Касбийский район','region_id'=>'8', 'last_id' => '9129'));
            $this->insert('districts',array('name' => 'Чиракчинский район','region_id'=>'8', 'last_id' => '9122'));
            $this->insert('districts',array('name' => 'Шахрисабзский район','region_id'=>'8', 'last_id' => '9133'));
            $this->insert('districts',array('name' => 'Яккабагский район','region_id'=>'8', 'last_id' => '9135'));
            $this->insert('districts',array('name' => 'город Карши','region_id'=>'8', 'last_id' => '9127'));
            $this->insert('districts',array('name' => 'город Шахрисабз','region_id'=>'8', 'last_id' => '9133'));

        //Samarqand viloyatidagi tumanlar
            //bular yo'q
            //
            $this->insert('districts',array('name' => 'Акдарьинский район','region_id'=>'9', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Булунгурский район','region_id'=>'9', 'last_id' => '9160'));
            $this->insert('districts',array('name' => 'Джамбайский район','region_id'=>'9', 'last_id' => '9163'));
            $this->insert('districts',array('name' => 'Иштыханский район','region_id'=>'9', 'last_id' => '9167'));
            $this->insert('districts',array('name' => 'Каттакурганский район','region_id'=>'9', 'last_id' => '9168'));
            $this->insert('districts',array('name' => 'Кошрабадский район','region_id'=>'9', 'last_id' => '9169'));
            $this->insert('districts',array('name' => 'Нарпайский район','region_id'=>'9', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Пайарыкский район','region_id'=>'9', 'last_id' => '9172'));
            $this->insert('districts',array('name' => 'Пастдаргомский район','region_id'=>'9', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Пахтачийский район','region_id'=>'9', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Самаркандский район','region_id'=>'9', 'last_id' => ''));

            $this->insert('districts',array('name' => 'Нурабадский район','region_id'=>'9', 'last_id' => '9171'));
            $this->insert('districts',array('name' => 'Ургутский район','region_id'=>'9', 'last_id' => '9176'));
            $this->insert('districts',array('name' => 'Тайлакский район','region_id'=>'9', 'last_id' => '9175'));
            $this->insert('districts',array('name' => 'город Самарканд','region_id'=>'9', 'last_id' => '9174'));
            $this->insert('districts',array('name' => 'город Каттакурган','region_id'=>'9', 'last_id' => '9168'));
        
        //Sirdaryo viloyatidagi tumanlar
            //bular yo'q
            //
            $this->insert('districts',array('name' => 'Акалтынский район','region_id'=>'10', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Баяутский район','region_id'=>'10', 'last_id' => '9179'));
            $this->insert('districts',array('name' => 'Сайхунабадский район','region_id'=>'10', 'last_id' => '9201'));
            $this->insert('districts',array('name' => 'Гулистанский район','region_id'=>'10', 'last_id' => '9199'));
            $this->insert('districts',array('name' => 'Сардобский район','region_id'=>'10', 'last_id' => '9202'));
            $this->insert('districts',array('name' => 'Мирзаабадский район','region_id'=>'10', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Сырдарьинский район','region_id'=>'10', 'last_id' => '9198'));
            $this->insert('districts',array('name' => 'Хавастский район','region_id'=>'10', 'last_id' => '9205'));
            $this->insert('districts',array('name' => 'город Гулистан','region_id'=>'10', 'last_id' => '9199'));
            $this->insert('districts',array('name' => 'город Ширин','region_id'=>'10', 'last_id' => '9203'));
            $this->insert('districts',array('name' => 'город Янгиер','region_id'=>'10', 'last_id' => '9206'));
        
        //Surxondaryo viloyatidagi tumanlar
            $this->insert('districts',array('name' => 'Алтынсайский район','region_id'=>'11', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Ангорский район','region_id'=>'11', 'last_id' => '9178'));
            $this->insert('districts',array('name' => 'Байсунский район','region_id'=>'11', 'last_id' => '9179'));
            $this->insert('districts',array('name' => 'Музработский район','region_id'=>'11', 'last_id' => '9186'));
            $this->insert('districts',array('name' => 'Денауский район','region_id'=>'11', 'last_id' => '9181'));
            $this->insert('districts',array('name' => 'Джаркурганский район','region_id'=>'11', 'last_id' => '9182'));
            $this->insert('districts',array('name' => 'Кумкурганский район','region_id'=>'11', 'last_id' => '9185'));
            $this->insert('districts',array('name' => 'Кизирикский район','region_id'=>'11', 'last_id' => '9184'));
            $this->insert('districts',array('name' => 'Сариасийский район','region_id'=>'11', 'last_id' => '9187'));
            $this->insert('districts',array('name' => 'Термизский район','region_id'=>'11', 'last_id' => '9187'));
            $this->insert('districts',array('name' => 'Узунский район','region_id'=>'11', 'last_id' => '9194'));
            $this->insert('districts',array('name' => 'Шерабадский район','region_id'=>'11', 'last_id' => '9190'));
            $this->insert('districts',array('name' => 'Шурчинский район','region_id'=>'11', 'last_id' => '9191'));
            $this->insert('districts',array('name' => 'город Термез','region_id'=>'11', 'last_id' => '9192'));

        //Toshkent viloyatidagi tumanlar
            $this->insert('districts',array('name' => 'Бекабадский район','region_id'=>'12', 'last_id' => '9261'));
            $this->insert('districts',array('name' => 'Бостанлыкский район','region_id'=>'12', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Букинский район','region_id'=>'12', 'last_id' => '9263'));
            $this->insert('districts',array('name' => 'Куйичирчикский район','region_id'=>'12', 'last_id' => '9266'));
            $this->insert('districts',array('name' => 'Зангиатинский район','region_id'=>'12', 'last_id' => '9294'));
            $this->insert('districts',array('name' => 'Юкоричирчикский район','region_id'=>'12', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Кибрайский район','region_id'=>'12', 'last_id' => '9276'));
            $this->insert('districts',array('name' => 'Паркентский район','region_id'=>'12', 'last_id' => '9282'));
            $this->insert('districts',array('name' => 'Пскентский район','region_id'=>'12', 'last_id' => '9283'));
            $this->insert('districts',array('name' => 'Уртачирчикский район','region_id'=>'12', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Чиназский район','region_id'=>'12', 'last_id' => '9265'));
            $this->insert('districts',array('name' => 'Янгиюльский район','region_id'=>'12', 'last_id' => '9292'));
            $this->insert('districts',array('name' => 'Ташкентский район','region_id'=>'12', 'last_id' => '9285'));
            $this->insert('districts',array('name' => 'Город Нурафшон','region_id'=>'12', 'last_id' => ''));
            $this->insert('districts',array('name' => 'город Алмалык','region_id'=>'12', 'last_id' => '9258'));
            $this->insert('districts',array('name' => 'город Ангрен','region_id'=>'12', 'last_id' => '9259'));
            $this->insert('districts',array('name' => 'город Бекабад','region_id'=>'12', 'last_id' => '9261'));
            $this->insert('districts',array('name' => 'город Ахангаран','region_id'=>'12', 'last_id' => '9260'));
            $this->insert('districts',array('name' => 'город Чирчик','region_id'=>'12', 'last_id' => '9266'));
            $this->insert('districts',array('name' => 'город Янгиюль','region_id'=>'12', 'last_id' => '9292'));
        
        //Toshkent shaharidagi tumanlar
            $this->insert('districts',array('name' => 'Учтепинский район','region_id'=>'13', 'last_id' => '85'));
            $this->insert('districts',array('name' => 'Бектемирский район','region_id'=>'13', 'last_id' => '77'));
            $this->insert('districts',array('name' => 'Юнусабадский район','region_id'=>'13', 'last_id' => '87'));
            $this->insert('districts',array('name' => 'Мирзо-Улугбекский район','region_id'=>'13', 'last_id' => '81'));
            $this->insert('districts',array('name' => 'Мирабадский район','region_id'=>'13', 'last_id' => '80'));
            $this->insert('districts',array('name' => 'Шайхантахурский район','region_id'=>'13', 'last_id' => '83'));
            $this->insert('districts',array('name' => 'Алмазарский район','region_id'=>'13', 'last_id' => '84'));
            $this->insert('districts',array('name' => 'Сергелийский район','region_id'=>'13', 'last_id' => '82'));
            $this->insert('districts',array('name' => 'Яккасарайский район','region_id'=>'13', 'last_id' => '86'));
            $this->insert('districts',array('name' => 'Яшнабадский район','region_id'=>'13', 'last_id' => '79'));
            $this->insert('districts',array('name' => 'Чиланзарский район','region_id'=>'13', 'last_id' => '78'));
            //Qoraqalpog'iston Respublikasi tumanlari
            $this->insert('districts',array('name' => 'Амударьинский район','region_id'=>'14', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Берунийский район','region_id'=>'14', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Караузякский район','region_id'=>'14', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Кегейлийский район','region_id'=>'14', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Кунградский район','region_id'=>'14', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Канлыкульский район','region_id'=>'14', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Муйнакский район','region_id'=>'14', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Нукусский район','region_id'=>'14', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Тахиаташский район','region_id'=>'14', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Тахтакупырский район','region_id'=>'14', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Турткульский район','region_id'=>'14', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Ходжейлийский район','region_id'=>'14', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Чимбайский район','region_id'=>'14', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Шуманайский район','region_id'=>'14', 'last_id' => ''));
            $this->insert('districts',array('name' => 'Элликкалинский район','region_id'=>'14', 'last_id' => ''));
            $this->insert('districts',array('name' => 'город Нукус','region_id'=>'14', 'last_id' => ''));
        //================================================================================================

        // Toshkent viloyati uchun qo'shimcha tuman

        $this->insert('districts',array('name' => 'Аккурганский район','region_id'=>'12', 'last_id' => '9257'));

        $slugify = new Slugify();
        $distircts = \backend\models\references\Districts::find()->asArray()->all();
        foreach($distircts as $distirct){
            $keyword = $slugify->slugify($distirct['name']);
            $this->update('districts', ['keyword' => $keyword], ['id' => $distirct['id']]);
        }
        
        // Lotincha ko'rinishi uchun

         //Andijon viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '1','field_value' => 'Andijon shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '2','field_value' => 'Asaka tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '3','field_value' => 'Bo\'z tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '4','field_value' => 'Buloqboshi tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '5','field_value' => 'Izboskan tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '6','field_value' => 'Jalaquduq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '7','field_value' => 'Marhamat tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '8','field_value' => 'Oltinko\'l tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '9','field_value' => 'Paxtaobod tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '10','field_value' => 'Qo\'rg\'ontepa tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '11','field_value' => 'Shahrixon tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '12','field_value' => 'Ulug\'nor tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '13','field_value' => 'Xo\'jaobod tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '14','field_value' => 'Baliqchi tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '15','field_value' => 'Andijon tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '16','field_value' => 'Xonobod shahri',  'language_code' => 'uz', ));
        //Buxoro viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '17','field_value' => 'Olot tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '18','field_value' => 'Buxoro tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '19','field_value' => 'G\'ijduvon tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '20','field_value' => 'Jondor tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '21','field_value' => 'Kogon tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '22','field_value' => 'Qorako\'l tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '23','field_value' => 'Qorovulbozor tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '24','field_value' => 'Peshku tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '25','field_value' => 'Romitan tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '26','field_value' => 'Shofirkon tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '27','field_value' => 'Vobkent tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '28','field_value' => 'Buxoro shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '29','field_value' => 'Kogon shahri',  'language_code' => 'uz', ));
        //Farg'ona viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '30','field_value' => 'Oltiariq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '31','field_value' => 'Bog\'dod tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '32','field_value' => 'Beshariq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '33','field_value' => 'Buvayda tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '34','field_value' => 'Dang\'ara tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '35','field_value' => 'Farg\'ona tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '36','field_value' => 'Furqat tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '37','field_value' => 'Qo\'shtepa tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '38','field_value' => 'Quva tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '39','field_value' => 'Rishton tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '40','field_value' => 'So\'x tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '41','field_value' => 'Toshloq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '42','field_value' => 'Uchko\'prik tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '43','field_value' => 'O\'zbekiston tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '44','field_value' => 'Yozyovon tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '45','field_value' => 'Farg\'ona shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '46','field_value' => 'Qo\'qon shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '47','field_value' => 'Quvasoy shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '48','field_value' => 'Marg\'ilon shahri',  'language_code' => 'uz', ));
        //Jizzax viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '49','field_value' => 'Arnasoy tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '50','field_value' => 'Baxmal tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '51','field_value' => 'Do\'stlik tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '52','field_value' => 'Forish tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '53','field_value' => 'G\'allaorol tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '54','field_value' => 'Sharof Rashidov tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '55','field_value' => 'Mirzacho\'l tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '56','field_value' => 'Paxtakor tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '57','field_value' => 'Yangiobod tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '58','field_value' => 'Zomin tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '59','field_value' => 'Zafarobod tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '60','field_value' => 'Zarbdor tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '61','field_value' => 'Jizzax shahri',  'language_code' => 'uz', ));
        //Xorazm viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '62','field_value' => 'Bog\'ot tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '63','field_value' => 'Gurlan tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '64','field_value' => 'Qo\'shko\'prik tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '65','field_value' => 'Urganch tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '66','field_value' => 'Hazorasp tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '67','field_value' => 'Xonqa tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '68','field_value' => 'Xiva tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '69','field_value' => 'Shovot tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '70','field_value' => 'Yangiariq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '71','field_value' => 'Yangibozor tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '72','field_value' => 'Urganch shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '73','field_value' => 'Xiva shahri',  'language_code' => 'uz', ));
        //Namangan viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '74','field_value' => 'Mingbuloq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '75','field_value' => 'Kosonsoy tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '76','field_value' => 'Namangan tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '77','field_value' => 'Norin tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '78','field_value' => 'Pop tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '79','field_value' => 'To\'raqo\'rg\'on tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '80','field_value' => 'Uychi tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '81','field_value' => 'Uchqo\'rg\'on tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '82','field_value' => 'Chortoq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '83','field_value' => 'Chust tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '84','field_value' => 'Yangiqo\'rg\'on tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '85','field_value' => 'Namangan shahri',  'language_code' => 'uz', ));
        //Navoiy viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '86','field_value' => 'Konimex tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '87','field_value' => 'Qiziltepa tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '88','field_value' => 'Navbahor tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '89','field_value' => 'Karmana tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '90','field_value' => 'Nurota tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '91','field_value' => 'Tomdi tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '92','field_value' => 'Uchquduq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '93','field_value' => 'Xatirchi tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '94','field_value' => 'Navoiy shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '95','field_value' => 'Zarafshon shahri',  'language_code' => 'uz', ));
        //Qashqadaryo viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '96','field_value' => 'G\'uzor tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '97','field_value' => 'Dehqanabod tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '98','field_value' => 'Qamashi tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '99','field_value' => 'Koson tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '100','field_value' => 'Kitob tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '101','field_value' => 'Mirishkor tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '102','field_value' => 'Muborak tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '103','field_value' => 'Nishon tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '104','field_value' => 'Kasbi tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '105','field_value' => 'Chiriqchi tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '106','field_value' => 'Shahrisabz tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '107','field_value' => 'Yakkabog\' tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '108','field_value' => 'Qarshi shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '109','field_value' => 'Shahrisabz shahri',  'language_code' => 'uz', ));
        //Samarqand viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '110','field_value' => 'Oqdaryo tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '111','field_value' => 'Bulung\'ur tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '112','field_value' => 'Jomboy tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '113','field_value' => 'Ishtixon tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '114','field_value' => 'Kattaqo\'rg\'on tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '115','field_value' => 'Qo\'shrabot tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '116','field_value' => 'Narpay tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '117','field_value' => 'Payariq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '118','field_value' => 'Pastdarg\'om tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '119','field_value' => 'Paxtachi tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '120','field_value' => 'Samarqand tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '121','field_value' => 'Nurobot tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '122','field_value' => 'Urgut tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '123','field_value' => 'Tayloq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '124','field_value' => 'Samarqand shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '125','field_value' => 'Kattaqo\'rg\'on shahri',  'language_code' => 'uz', ));
        //Sirdaryo viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '126','field_value' => 'Oqoltin tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '127','field_value' => 'Boyovut tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '128','field_value' => 'Sayxunobod tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '129','field_value' => 'Guliston tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '130','field_value' => 'Sardoba tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '131','field_value' => 'Mirzaobod tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '132','field_value' => 'Sirdaryo tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '133','field_value' => 'Xovos tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '134','field_value' => 'Guliston shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '135','field_value' => 'Shirin shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '136','field_value' => 'Yangiyer shahri',  'language_code' => 'uz', ));
        //Surxondaryo viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '137','field_value' => 'Oltinsoy tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '138','field_value' => 'Angor tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '139','field_value' => 'Boysun tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '140','field_value' => 'Muzrabot tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '141','field_value' => 'Denov tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '142','field_value' => 'Jarqo\'rg\'on tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '143','field_value' => 'Qumqo\'rg\'on tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '144','field_value' => 'Qiziriq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '145','field_value' => 'Sariosiyo tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '146','field_value' => 'Termiz tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '147','field_value' => 'Uzun tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '148','field_value' => 'Sherobod tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '149','field_value' => 'Sho\'rchi tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '150','field_value' => 'Termiz shahri',  'language_code' => 'uz', ));
        //Toshkent viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '151','field_value' => 'Bekobod tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '152','field_value' => 'Bo\'stonliq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '153','field_value' => 'Bo\'ka tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '154','field_value' => 'Quyichirchiq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '155','field_value' => 'Zangiota tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '156','field_value' => 'Yuqorichirchiq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '157','field_value' => 'Qibray tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '158','field_value' => 'Parkent tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '159','field_value' => 'Pskent tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '160','field_value' => 'O\'rtachirchiq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '161','field_value' => 'Chinoz tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '162','field_value' => 'Yangiyo\'l tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '163','field_value' => 'Toshkent tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '164','field_value' => 'Nurafshon shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '165','field_value' => 'Olmaliq shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '166','field_value' => 'Angren shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '167','field_value' => 'Bekobod shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '168','field_value' => 'Ohangaron shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '169','field_value' => 'Chirchiq shahri',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '170','field_value' => 'Yangiyo\'l shahri',  'language_code' => 'uz', ));
        //Toshkent shaharidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '171','field_value' => 'Uchtepa tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '172','field_value' => 'Bektemir tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '173','field_value' => 'Yunusobod tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '174','field_value' => 'Mirzo Ulug\'bek tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '175','field_value' => 'Mirobod tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '176','field_value' => 'Shayxontohur tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '177','field_value' => 'Olmazor tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '178','field_value' => 'Sirg\'ali tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '179','field_value' => 'Yakkasaroy tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '180','field_value' => 'Yashnobod tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '181','field_value' => 'Chilonzor tumani',  'language_code' => 'uz', ));
        //Qoraqalpog'iston Respublikasi tumanlari
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '182','field_value' => 'Amudaryo tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '183','field_value' => 'Beruniy tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '184','field_value' => 'Qorao\'zak tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '185','field_value' => 'Kegeyli tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '186','field_value' => 'Qo\'ng\'irot tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '187','field_value' => 'Qanliko\'l tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '188','field_value' => 'Mo\'ynoq tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '189','field_value' => 'Nukus tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '190','field_value' => 'Taxiatosh tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '191','field_value' => 'Taxtako\'prik tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '192','field_value' => 'To\'rtko\'l tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '193','field_value' => 'Xo\'jayli tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '194','field_value' => 'Chimboy tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '195','field_value' => 'Shumanay tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '196','field_value' => 'Ellikqala tumani',  'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '197','field_value' => 'Nukus shahri',  'language_code' => 'uz', ));
        //================================================================================================
            // O'qqo'rg'on tumani
            $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '198','field_value' => 'Аккурганский район',  'language_code' => 'uz', ));
        //===============================================================================================

             // Krilcha ko'rinishi uchun

         //Andijon viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '1','field_value' => 'Андижон шаҳри', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '2','field_value' => 'Асака тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '3','field_value' => 'Бўз тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '4','field_value' => 'Булоқбоши тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '5','field_value' => 'Избоскан тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '6','field_value' => 'Жалақудуқ тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '7','field_value' => 'Марҳамат тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '8','field_value' => 'Олтинкўл тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '9','field_value' => 'Пахтаобод тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '10','field_value' => 'Қўрғонтепа тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '11','field_value' => 'Шаҳрихон тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '12','field_value' => 'Улуғнор тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '13','field_value' => 'Хўжаобод тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '14','field_value' => 'Балиқчи тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '15','field_value' => 'Андижон тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '16','field_value' => 'Хонобод шаҳри', 'language_code' => 'oz', ));
        //Buxoro viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '17','field_value' => 'Олот тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '18','field_value' => 'Бухоро тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '19','field_value' => 'Ғиждувон тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '20','field_value' => 'Жондор тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '21','field_value' => 'Когон тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '22','field_value' => 'Қоракўл тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '23','field_value' => 'Қоровулбозор тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '24','field_value' => 'Пешку тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '25','field_value' => 'Ромитан тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '26','field_value' => 'Шофиркон тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '27','field_value' => 'Вобкент тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '28','field_value' => 'Бухоро шаҳри',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '29','field_value' => 'Когон шаҳри',  'language_code' => 'oz', ));
        //Farg'ona viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '30','field_value' => 'Олтиариқ тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '31','field_value' => 'Бағдод тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '32','field_value' => 'Бешариқ тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '33','field_value' => 'Бувайда тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '34','field_value' => 'Данғара тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '35','field_value' => 'Фарғона тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '36','field_value' => 'Фурқат тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '37','field_value' => 'Қўштепа тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '38','field_value' => 'Қува тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '39','field_value' => 'Риштон тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '40','field_value' => 'Сўх тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '41','field_value' => 'Тошлоқ тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '42','field_value' => 'Учкўприк тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '43','field_value' => 'Ўзбекистон тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '44','field_value' => 'Ёзёвон тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '45','field_value' => 'Фарғона тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '46','field_value' => 'Қўқон шаҳри', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '47','field_value' => 'Қувасой шаҳри', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '48','field_value' => 'Марғилон шаҳри', 'language_code' => 'oz', ));
        //Jizzax viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '49','field_value' => 'Арансой тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '50','field_value' => 'Бахмал тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '51','field_value' => 'Дўстлик тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '52','field_value' => 'Фориш тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '53','field_value' => 'Ғаллаорол тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '54','field_value' => 'Шароф Рашидов тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '55','field_value' => 'Мирзачўл тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '56','field_value' => 'Пахтакор тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '57','field_value' => 'Янгиобод тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '58','field_value' => 'Зомин тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '59','field_value' => 'Зафаробод тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '60','field_value' => 'Зарбдор тумани', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '61','field_value' => 'Жиззах шаҳри', 'language_code' => 'oz', ));
        //Xorazm viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '62','field_value' => 'Боғот тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '63','field_value' => 'Гурлан тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '64','field_value' => 'Қўшкўпир тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '65','field_value' => 'Урганч тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '66','field_value' => 'Хазорасп тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '67','field_value' => 'Хонқа тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '68','field_value' => 'Хива тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '69','field_value' => 'Шовот тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '70','field_value' => 'Янгиариқ тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '71','field_value' => 'Янгибозор тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '72','field_value' => 'Урганч шаҳри',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '73','field_value' => 'Хива шаҳри',  'language_code' => 'oz', ));
        //Namangan viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '74','field_value' => 'Мингбулоқ тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '75','field_value' => 'Косонсой тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '76','field_value' => 'Наманган тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '77','field_value' => 'Норин тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '78','field_value' => 'Поп тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '79','field_value' => 'Тўрақўрғон тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '80','field_value' => 'Уйчи тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '81','field_value' => 'Учқўрғон тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '82','field_value' => 'Чортоқ тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '83','field_value' => 'Чуст тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '84','field_value' => 'Янгиқўрғон тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '85','field_value' => 'Наманган шаҳри',  'language_code' => 'oz', ));
        //Navoiy viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '86','field_value' => 'Конимех тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '87','field_value' => 'Қизилтепа тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '88','field_value' => 'Навбаҳор тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '89','field_value' => 'Кармана тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '90','field_value' => 'Нурота тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '91','field_value' => 'Томди тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '92','field_value' => 'Учқудуқ тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '93','field_value' => 'Хатирчи тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '94','field_value' => 'Навоий шаҳри',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '95','field_value' => 'Зарафшон шаҳри',  'language_code' => 'oz', ));
        //Qashqadaryo viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '96','field_value' => 'Ғузор тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '97','field_value' => 'Деҳқонобод тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '98','field_value' => 'Қамаши тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '99','field_value' => 'Косон тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '100','field_value' => 'Китоб тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '101','field_value' => 'Миришкор тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '102','field_value' => 'Муборак тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '103','field_value' => 'Нишон тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '104','field_value' => 'Касби тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '105','field_value' => 'Чироқчи тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '106','field_value' => 'Шахрисабз тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '107','field_value' => 'Яккабоғ тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '108','field_value' => 'Қарши шаҳри',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '109','field_value' => 'Шахрисабз шаҳри',  'language_code' => 'oz', ));
        //Samarqand viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '110','field_value' => 'Оқдарё тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '111','field_value' => 'Булунғур тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '112','field_value' => 'Жомбой тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '113','field_value' => 'Иштихон тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '114','field_value' => 'Каттақўрғон тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '115','field_value' => 'Қўшработ тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '116','field_value' => 'Нарпай тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '117','field_value' => 'Пайариқ тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '118','field_value' => 'Пастдарғом тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '119','field_value' => 'Пахтачи тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '120','field_value' => 'Самарқанд тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '121','field_value' => 'Нуробод  тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '122','field_value' => 'Ургут тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '123','field_value' => 'Тойлоқ тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '124','field_value' => 'Самарқанд шаҳри',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '125','field_value' => 'Каттақўрғон шаҳри',  'language_code' => 'oz', ));
        //Sirdaryo viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '126','field_value' => 'Оқолтин тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '127','field_value' => 'Боёвут тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '128','field_value' => 'Сайхунобод тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '129','field_value' => 'Гулистон тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '130','field_value' => 'Сардоба тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '131','field_value' => 'Мирзаобод тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '132','field_value' => 'Сирдарё тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '133','field_value' => 'Ховос тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '134','field_value' => 'Гулистон шаҳри',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '135','field_value' => 'Ширин шаҳри',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '136','field_value' => 'Янгиер шаҳри',  'language_code' => 'oz', ));
        //Surxondaryo viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '137','field_value' => 'Олтинсой тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '138','field_value' => 'Ангор тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '139','field_value' => 'Бойсун тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '140','field_value' => 'Музработ тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '141','field_value' => 'Денов тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '142','field_value' => 'Жарқўрғон тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '143','field_value' => 'Қумқўрғон тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '144','field_value' => 'Қизириқ тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '145','field_value' => 'Сариосиё тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '146','field_value' => 'Термиз тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '147','field_value' => 'Узун тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '148','field_value' => 'Шеробод тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '149','field_value' => 'Шўрчи тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '150','field_value' => 'Термиз шаҳри',  'language_code' => 'oz', ));
        //Toshkent viloyatidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '151','field_value' => 'Бекобод тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '152','field_value' => 'Бўстонлиқ тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '153','field_value' => 'Бўка тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '154','field_value' => 'Қуйичирчиқ тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '155','field_value' => 'Зангиота тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '156','field_value' => 'Юқоричирчиқ тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '157','field_value' => 'Қибрай тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '158','field_value' => 'Паркент тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '159','field_value' => 'Пискент тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '160','field_value' => 'Ўртачирчиқ тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '161','field_value' => 'Чиноз тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '162','field_value' => 'Янгийўл тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '163','field_value' => 'Тошкент тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '164','field_value' => 'Нурафшон шаҳри',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '165','field_value' => 'Олмалиқ шаҳри',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '166','field_value' => 'Ангрен шаҳри',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '167','field_value' => 'Бекобод шаҳри',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '168','field_value' => 'Оҳангарон    шаҳри',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '169','field_value' => 'Чирчиқ шаҳри',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '170','field_value' => 'Янгийўл шаҳри',  'language_code' => 'oz', ));
        //Toshkent shaharidagi tumanlar
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '171','field_value' => 'Учтепа тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '172','field_value' => 'Бектемир тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '173','field_value' => 'Юнусобод тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '174','field_value' => 'Мирзо Улуғбек    тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '175','field_value' => 'Миробод тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '176','field_value' => 'Шайхонтохур тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '177','field_value' => 'Олмазор тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '178','field_value' => 'Сирғали тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '179','field_value' => 'Яккасарой тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '180','field_value' => 'Яшнобод тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '181','field_value' => 'Чилонзор тумани',  'language_code' => 'oz', ));
        //Qoraqalpog'iston Respublikasi tumanlari
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '182','field_value' => 'Амударё тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '183','field_value' => 'Беруний тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '184','field_value' => 'Қораўзак тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '185','field_value' => 'Кегейли тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '186','field_value' => 'Қўнғирот тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '187','field_value' => 'Қанликўл тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '188','field_value' => 'Мўйноқ тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '189','field_value' => 'Нукус тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '190','field_value' => 'Тахиатош тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '191','field_value' => 'Тахтакўпир тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '192','field_value' => 'Тўрткўл тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '193','field_value' => 'Хўжайли тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '194','field_value' => 'Чимбой тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '195','field_value' => 'Шуманай тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '196','field_value' => 'Элликқалъа тумани',  'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '197','field_value' => 'Нукус шаҳри',  'language_code' => 'oz', ));
        //================================================================================================
            // O'qqo'rg'on tumani
            $this->insert('translates',array('table_name' => 'districts', 'field_name' => 'name', 'field_id' => '198','field_value' => 'Оққўрғон',  'language_code' => 'oz', ));
        //===============================================================================================

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%districts}}');
    }
}
