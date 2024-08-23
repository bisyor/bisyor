<?php

namespace backend\models\seobase;

use Yii;
use backend\models\references\Seo;
use backend\models\references\Translates;

class Shops
{
    public static function AllShops()
    {
    	$model = new Seo();
        $model->name = 'Заголовок';
        $model->value = 'Магазины и компании {region.in} {page}: на {site.title} {region.in}';
        $model->key = 'shops_all_category_title';
        $model->group = 'shops';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Магазины {region.in} {page}: на {site.title} {region.in}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = 'магазины {region.in}, доска объявлений {region.in}, {site.title}, Магазины и компании';
        $model->key = 'shops_all_category_keyword';
        $model->group = 'shops';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "магазины {region.in}, доска объявлений {region.in}, {site.title} {page}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = 'Доска объявлений {site.title} {page} - магазины {region.in}';
        $model->key = 'shops_all_category_description';
        $model->group = 'shops';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Доска объявлений {site.title} {page} - магазины {region.in}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок H1';
        $model->value = 'Все магазины и компании {region.in}';
        $model->key = 'shops_all_category_titleh1';
        $model->group = 'shops';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Все магазины {region.in}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'SEO текст';
        $model->value = 'Доска объявлений {site.title} {page} - Магазины и компании {region.in}';
        $model->key = 'shops_all_category_seotext';
        $model->group = 'shops';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Доска объявлений {site.title} {page} - магазины {region.in}";
            $tr->language_code = 'uz';
            $tr->save();
        }


        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = '{category} {page} - магазины {site.title} {region.in}';
        $model->key = 'shops_category_title';
        $model->group = 'shops';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{category} {page} - магазины {site.title} {region.in}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = '{category}, магазины, {region}, {site.title}';
        $model->key = 'shops_category_keyword';
        $model->group = 'shops';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{category}, do'kon, {region}, {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = 'Магазины {category} {region.in}, есть аренда недвижимости, продажа недвижимости, покупка недвижимости ➨ Заходите';
        $model->key = 'shops_category_description';
        $model->group = 'shops';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{region.in} {category} do'koni, ijaraga olingan ko'chmas mulk mavjud, ko'chmas mulkni sotish, ko'chmas mulk sotib olish";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Хлебная крошка';
        $model->value = '{category} {region.in}';
        $model->key = 'shops_category_crumb';
        $model->group = 'shops';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{category} {region.in}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок H1';
        $model->value = '{category} {region.in}';
        $model->key = 'shops_category_titleh1';
        $model->group = 'shops';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{category} {region.in}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'SEO текст';
        $model->value = '{categories} - магазины {page} {region.in}';
        $model->key = 'shops_category_seo_text';
        $model->group = 'shops';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{categories} - магазины {page} {region.in}";
            $tr->language_code = 'uz';
            $tr->save();
        }


        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = '{title} {region.in} {page} - Объявления {site.title}';
        $model->key = 'shops_view_title';
        $model->group = 'shops';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{title} {region.in} {page} - Объявления {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = 'Все объявления магазина {title}';
        $model->key = 'shops_view_keyword';
        $model->group = 'shops';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Все объявления магазина {title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = '{description}';
        $model->key = 'shops_view_description';
        $model->group = 'shops';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{description}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок (поделиться в соц. сетях)';
        $model->value = '{title}';
        $model->key = 'shops_view_social';
        $model->group = 'shops';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание (поделиться в соц. сетях)';
        $model->value = '{description}';
        $model->key = 'shops_view_social_text';
        $model->group = 'shops';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{description}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Название сайта (поделиться в соц. сетях)';
        $model->value = '{site.title}';
        $model->key = 'shops_view_site_name';
        $model->group = 'shops';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }
    }
}