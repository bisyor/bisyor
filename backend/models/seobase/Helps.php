<?php

namespace backend\models\seobase;

use Yii;
use backend\models\references\Seo;
use backend\models\references\Translates;

class Helps
{
    public static function AllHelps()
    {
    	$model = new Seo();
        $model->name = 'Заголовок';
        $model->value = 'Помощь {site.title}';
        $model->key = 'helps_main_title';
        $model->group = 'helps';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Yordam {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = ' ';
        $model->key = 'helps_main_keyword';
        $model->group = 'helps';
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
        $model->key = 'helps_main_description';
        $model->group = 'helps';
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
        $model->key = 'helps_main_titleh1';
        $model->group = 'helps';
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
        $model->value = ' ';
        $model->key = 'helps_main_seotext';
        $model->group = 'helps';
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
        $model->value = '{category} | Помощь {site.title}';
        $model->key = 'helps_category_title';
        $model->group = 'helps';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{category} | Помощь {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = ' ';
        $model->key = 'helps_category_keyword';
        $model->group = 'helps';
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
        $model->key = 'helps_category_description';
        $model->group = 'helps';
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
        $model->value = '"{query}" | Помощь {site.title} {page}';
        $model->key = 'helps_search_title';
        $model->group = 'helps';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = '"{query}" | Помощь {site.title} {page}';
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = ' ';
        $model->key = 'helps_search_keyword';
        $model->group = 'helps';
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
        $model->key = 'helps_search_description';
        $model->group = 'helps';
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
        $model->value = '{title} | Помощь {site.title}';
        $model->key = 'helps_view_title';
        $model->group = 'helps';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = '{title} | Помощь {site.title}';
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = '{category}: помощь на сайте {site.title}';
        $model->key = 'helps_view_keyword';
        $model->group = 'helps';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{category}: помощь на сайте {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = '{textshort}';
        $model->key = 'helps_view_description';
        $model->group = 'helps';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{textshort}";
            $tr->language_code = 'uz';
            $tr->save();
        } 
    }
}