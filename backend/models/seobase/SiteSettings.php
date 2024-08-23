<?php

namespace backend\models\seobase;

use Yii;
use backend\models\references\Seo;
use backend\models\references\Translates;

class SiteSettings
{
    public static function AllSettings()
    {
    	$model = new Seo();
        $model->name = 'Приветствие (заголовок H1)';
        $model->value = 'Покупайте и продавайте свои вещи легко и быстро';
        $model->key = 'site_settings_main_titleh1';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Narsalarni tez va qulay tarzda soting va sotib oling";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = 'Доска объявлений {site.title}: сайт частных объявлений Bisyor';
        $model->key = 'site_settings_main_title';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "E'lonlar doskasi {site.title}: Xususiy e'lonlar qo'shilgan bepul sayt - ishlatilgan tovarlarni sotib olish/sotish {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = 'бесплатные объявления, объявления, сайт бесплатных объявлений, доска объявлений, частные объявления';
        $model->key = 'site_settings_main_keyword';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "bepul e’lonlar, e’lonlar, bepul e’lonlar sayti, e’lonlar sayti, e’lonlar doskasi, xususiy e’lonlar, bisyor uz, bisyor e’lonlar";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = 'Крупнейшая доска бесплатных объявлений. Огромная база предложений по темам: недвижимость, работа, транспорт, купля/продажа товаров, услуги и многое другое!';
        $model->key = 'site_settings_main_description';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "O’zbekistonning barcha e’lonlari {site.title} saytida - bu erda arzon sotib olasiz va foydali sotasiz! Bisyor.uz e’lonlar doskasida siz turli xil mavzularda reklama joylashtirishingiz mumkin, bu esa o’z navbatida butun O’zbekiston bo’ylab barcha turdagi tovarlarni (xizmatlarni) sotib olish yoki sotish imkoniyatini beradi.";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'SEO текст';
        $model->value = 'Все объявления Узбекистана на Bisyor.uz - здесь вы купите дешево и продадите выгодно! На доске объявлений Bisyor.uz вы можете разместить объявление на самую различную тематику, что в свою очередь даст возможность без особых трудностей купить или продать всевозможные товары (услуги) по весь Узбекистан.
 
					Популярные разделы на Bisyor.uz: Детский мир, Недвижимость, Транспорт, Запчасти, Работа, Животные, Дом и сад, Электроника, Бизнес и услуги, Мода и стиль.';
        $model->key = 'site_settings_main_seotext';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "O’zbekistonning barcha e’lonlari {site.title} saytida - bu erda arzon sotib olasiz va foydali sotasiz! Bisyor.uz e’lonlar doskasida siz turli xil mavzularda reklama joylashtirishingiz mumkin, bu esa o’z navbatida butun O’zbekiston bo’ylab barcha turdagi tovarlarni (xizmatlarni) sotib olish yoki sotish imkoniyatini beradi.
  
					Bisyor.uz saytidagi mashhur e'lonlar: Bolalar dunyosi, Ko'chmas mulk, Transport, Ehtiyot qismlar, Ish, Hayvonlar, Uy va bog', Elektr jihozlari, Biznes va xizmatlar, Moda va stil.";
            $tr->language_code = 'uz';
            $tr->save();
        }


        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = '{title} | {site.title}';
        $model->key = 'site_settings_static_title';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{title} | {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = '{meta-base}';
        $model->key = 'site_settings_static_keyword';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{meta-base}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = '{meta-base}';
        $model->key = 'site_settings_static_description';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{meta-base}";
            $tr->language_code = 'uz';
            $tr->save();
        }


        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = 'Карта сайта | {site.title}';
        $model->key = 'site_settings_sitemap_title';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Карта сайта | {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = ' ';
        $model->key = 'site_settings_sitemap_keyword';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "sayt xaritasi, bisyor xarita";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = '{meta-base}';
        $model->key = 'site_settings_sitemap_description';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{meta-base}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Хлебная крошка';
        $model->value = 'Карта сайта';
        $model->key = 'site_settings_sitemap_crumb';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Карта сайта";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок H1';
        $model->value = 'Карта сайта';
        $model->key = 'site_settings_sitemap_titleh1';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Карта сайта";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'SEO текст';
        $model->value = ' ';
        $model->key = 'site_settings_sitemap_seotext';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = " ";
            $tr->language_code = 'uz';
            $tr->save();
        } 


        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = 'Платные услуги | {site.title}';
        $model->key = 'site_settings_service_title';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Pulli xizmatlar | {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = 'Платные услуги';
        $model->key = 'site_settings_service_keyword';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = " ";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = 'Платные услуги';
        $model->key = 'site_settings_service_description';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = " ";
            $tr->language_code = 'uz';
            $tr->save();
        }
 
        $model = new Seo();
        $model->name = 'Заголовок H1';
        $model->value = ' ';
        $model->key = 'site_settings_service_titleh1';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = " ";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'SEO текст';
        $model->value = 'Платные услуги';
        $model->key = 'site_settings_service_seotext';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = " ";
            $tr->language_code = 'uz';
            $tr->save();
        }


        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = 'Контакты | {site.title}';
        $model->key = 'site_settings_form_title';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Контакты | {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = '{site.title}';
        $model->key = 'site_settings_form_keyword';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = " ";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = '{site.title}';
        $model->key = 'site_settings_form_description';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = " ";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Хлебная крошка';
        $model->value = 'Контакты | {site.title}';
        $model->key = 'site_settings_form_crumb';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Контакты | {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }


        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = ' ';
        $model->key = 'site_settings_site_title';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = " ";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = ' ';
        $model->key = 'site_settings_site_keyword';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = " ";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = ' ';
        $model->key = 'site_settings_site_description';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = " ";
            $tr->language_code = 'uz';
            $tr->save();
        }
    }

    public static function setMapRegions()
    {
        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = 'Карта сайта | {site.title}';
        $model->key = 'site_settings_mapregions_title';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Карта сайта | {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = ' ';
        $model->key = 'site_settings_mapregions_keyword';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "sayt xaritasi, bisyor xarita";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = '{meta-base}';
        $model->key = 'site_settings_mapregions_description';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{meta-base}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Хлебная крошка';
        $model->value = 'Карта сайта';
        $model->key = 'site_settings_mapregions_crumb';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Карта сайта";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок H1';
        $model->value = 'Карта сайта';
        $model->key = 'site_settings_mapregions_titleh1';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Карта сайта";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'SEO текст';
        $model->value = ' ';
        $model->key = 'site_settings_mapregions_seotext';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = " ";
            $tr->language_code = 'uz';
            $tr->save();
        }
    }

    public static function setPupular()
    {
        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = 'Карта сайта | {site.title}';
        $model->key = 'site_settings_pupular_title';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Карта сайта | {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = ' ';
        $model->key = 'site_settings_pupular_keyword';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "sayt xaritasi, bisyor xarita";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = '{meta-base}';
        $model->key = 'site_settings_pupular_description';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{meta-base}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Хлебная крошка';
        $model->value = 'Карта сайта';
        $model->key = 'site_settings_pupular_crumb';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Карта сайта";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок H1';
        $model->value = 'Карта сайта';
        $model->key = 'site_settings_pupular_titleh1';
        $model->group = 'site-settings';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Карта сайта";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'SEO текст';
        $model->value = ' ';
        $model->key = 'site_settings_pupular_seotext';
        $model->group = 'site-settings';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = " ";
            $tr->language_code = 'uz';
            $tr->save();
        }
    }

    public static function setSeoCategoryAll()
    {
        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = 'Карта сайта | {site.title}';
        $model->key = 'seo_translation_name_categories_title';
        $model->group = 'items';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Карта сайта | {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = ' ';
        $model->key = 'seo_translation_name_categories_keyword';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "sayt xaritasi, bisyor xarita";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = '{meta-base}';
        $model->key = 'seo_translation_name_categories_description';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{meta-base}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Хлебная крошка';
        $model->value = 'Карта сайта';
        $model->key = 'seo_translation_name_categories_crumb';
        $model->group = 'items';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Карта сайта";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок H1';
        $model->value = 'Карта сайта';
        $model->key = 'seo_translation_name_categories_titleh1';
        $model->group = 'items';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Карта сайта";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'SEO текст';
        $model->value = ' ';
        $model->key = 'seo_translation_name_categories_seotext';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = " ";
            $tr->language_code = 'uz';
            $tr->save();
        }
    }
}