<?php

namespace backend\models\seobase;

use Yii;
use backend\models\references\Seo;
use backend\models\references\Translates;

class Items
{
    public static function AllCategory()
    {
        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = '{query} Доска объявлений {region} {page}: бесплатные частные объявления на {site.title}';
        $model->key = 'items_all_category_title';
        $model->group = 'items';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{query} {region}ning bepul e‘lonlar sayti {page}: yangi yoki ishlatilgan narsalarni {site.title} dan topishingiz mumkin";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = '{query}, {query} {region.in}, бесплатные объявления {region}, объявления {region}, сайт бесплатных объявлений {region}, доска объявлений {region}, частные объявления {region}, {site.title} {page}';
        $model->key = 'items_all_category_keyword';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{query}, {query} {region.in}, bepul e'lonlar {region}, e'lonlar {region}, bepul e'lonlar sayti {region}, e'lonlar doskasi {region}, shaxsiy e'lonlar {region}, {site.title} {page}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = 'Доска объявлений {region} {page} - бесплатные частные объявления {region} по темам: недвижимость, работа, купля/продажа товаров, услуги и многое другое! {page}';
        $model->key = 'items_all_category_description';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "E'lonlar doskasi {region} {page} - ko'chmas mulk, ish, tovarlarni sotib olish/sotish va xizmatlarni taqdim etish bo'yicha bepul xususiy e'lonlar {region}.";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок H1';
        $model->value = 'Все объявления {region.in}';
        $model->key = 'items_all_category_titleh1';
        $model->group = 'items';
        $model->type = 'string';
        $model->save();
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Hamma e'lonlar {region.in}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'SEO текст';
        $model->value = 'Доска объявлений {site.title} {page} - бесплатные частные объявления {region.in} по темам: недвижимость, работа, купля/продажа товаров, услуги и многое другое! ';
        $model->key = 'items_all_category_seotext';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Доска объявлений {site.title} {page} - бесплатные частные объявления {region} по темам: недвижимость, работа, купля/продажа товаров, услуги и многое другое! ";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = '{category} {page} {region.in} на доске объявлений {site.title}';
        $model->key = 'items_category_title';
        $model->group = 'items';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{category} {page} {region.in} | Bepul e'lonlar sayti {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = '{category}, объявления, {region}, {site.title}';
        $model->key = 'items_category_keyword';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{category}, ishbor, ish bor, ishlar, {region}, {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = '{category} {region.in} {total.text} - Доска объявлений {site.title} {page} - бесплатные частные объявления {region.in}';
        $model->key = 'items_category_description';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{category} {region.in} {total.text} - E'lonlar sayti {site.title} {page} - Bepul e'lonlar {region.in}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Хлебная крошка:';
        $model->value = '{category} {region.in}';
        $model->key = 'items_category_crumb';
        $model->group = 'items';
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
        $model->key = 'items_category_title_h1';
        $model->group = 'items';
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
        $model->value = 'Доска объявлений {site.title} {page} - бесплатные частные объявления {region.in} по темам: {categories}, купля/продажа товаров, услуги и многое другое! ';
        $model->key = 'items_category_seo_text';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "E'lonlar sayti {site.title} {page} - bepul shaxsiy e'lonlar {region.in} bo'lim bo'yicha: {categories}, sotib olish/sotish narsalarni, xizmatlar va juda ko'p boshqa narsalar! ";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = '{title} {price}: {categories.reverse}, {address}, {city}, {country} - №{id}';
        $model->key = 'items_ads_title';
        $model->group = 'items';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{title} {price}: {categories.reverse}, {address}, {city}, {country}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = '{title}, {price}, {categories}';
        $model->key = 'items_ads_keyword';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{title}, {price}, {categories}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = '{meta-base} {title}: {address}, {categories}, {region.in}, {country} - №{id}';
        $model->key = 'items_ads_description';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{meta-base} {title}: {address}, {categories}, {region.in}, {country}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок (поделиться в соц. сетях)';
        $model->value = '{meta-base}';
        $model->key = 'items_ads_title_social';
        $model->group = 'items';
        $model->type = 'string';
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
        $model->name = 'Описание (поделиться в соц. сетях)';
        $model->value = '{meta-base}';
        $model->key = 'items_ads_description_social';
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
        $model->name = 'Название сайта (поделиться в соц. сетях)';
        $model->value = '{meta-base}';
        $model->key = 'items_ads_site';
        $model->group = 'items';
        $model->type = 'string';
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
        $model->value = 'Подать объявление бесплатно на сайте {site.title} - разместить объявление без регистрации';
        $model->key = 'items_add_ads_title';
        $model->group = 'items';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Подать объявление бесплатно на сайте {site.title} - разместить объявление без регистрации";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = 'Подать объявление, объявление бесплатно, Подать объявление бесплатно';
        $model->key = 'items_add_ads_keyword';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Подать объявление, объявление бесплатно, Подать объявление бесплатно";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = 'Подать объявление бесплатно на сайте {site.title} – разместите объявление без регистрации и его увидят тысячи пользователей. Попробуйте удобную форму подачи объявлений!';
        $model->key = 'items_add_ads_description';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Подать объявление бесплатно на сайте {site.title} – разместите объявление без регистрации и его увидят тысячи пользователей. Попробуйте удобную форму подачи объявлений!";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Хлебная крошка';
        $model->value = 'Подать объявление бесплатно на сайте {site.title}';
        $model->key = 'items_add_ads_crumb';
        $model->group = 'items';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Bisyor.uz saytida bepul e'lon berish";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок H1';
        $model->value = 'Разместить объявление';
        $model->key = 'items_add_ads_title_h1';
        $model->group = 'items';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Bepul e'lon berish";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = '{name} {region} {page} - Объявления {site.title}';
        $model->key = 'items_user_title';
        $model->group = 'items';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{name} {region} {page} - E'lonlar {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = 'Все объявления автора {name}';
        $model->key = 'items_user_keyword';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Все объявления автора {name}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = '{name} - все объявления автора - {region} {country}';
        $model->key = 'items_user_desctiption';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{name} - все объявления автора - {region} {country}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок H1';
        $model->value = '{name} - все объявления автора';
        $model->key = 'items_user_title_h1';
        $model->group = 'items';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{name} - все объявления автора";
            $tr->language_code = 'uz';
            $tr->save();
        }

    }

    public static  function setSeoForFavoritesAds()
    {
        $model = new Seo();
        $model->name = 'Заголовок';
        $model->value = '{query} Доска объявлений {region} {page}: бесплатные частные объявления на {site.title}';
        $model->key = 'items_ads_favorites_title';
        $model->group = 'items';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{query} {region}ning bepul e‘lonlar sayti {page}: yangi yoki ishlatilgan narsalarni {site.title} dan topishingiz mumkin";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = '{query}, {query} {region.in}, бесплатные объявления {region}, объявления {region}, сайт бесплатных объявлений {region}, доска объявлений {region}, частные объявления {region}, {site.title} {page}';
        $model->key = 'items_ads_favorites_keyword';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{query}, {query} {region.in}, bepul e'lonlar {region}, e'lonlar {region}, bepul e'lonlar sayti {region}, e'lonlar doskasi {region}, shaxsiy e'lonlar {region}, {site.title} {page}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = 'Доска объявлений {region} {page} - бесплатные частные объявления {region} по темам: недвижимость, работа, купля/продажа товаров, услуги и многое другое! {page}';
        $model->key = 'items_ads_favorites_description';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "E'lonlar doskasi {region} {page} - ko'chmas mulk, ish, tovarlarni sotib olish/sotish va xizmatlarni taqdim etish bo'yicha bepul xususiy e'lonlar {region}.";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок H1';
        $model->value = 'Все объявления {region.in}';
        $model->key = 'items_ads_favorites_titleh1';
        $model->group = 'items';
        $model->type = 'string';
        $model->save();
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Hamma e'lonlar {region.in}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'SEO текст';
        $model->value = 'Доска объявлений {site.title} {page} - бесплатные частные объявления {region.in} по темам: недвижимость, работа, купля/продажа товаров, услуги и многое другое! ';
        $model->key = 'items_ads_favorites_seotext';
        $model->group = 'items';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Доска объявлений {site.title} {page} - бесплатные частные объявления {region} по темам: недвижимость, работа, купля/продажа товаров, услуги и многое другое! ";
            $tr->language_code = 'uz';
            $tr->save();
        }
    }
}
