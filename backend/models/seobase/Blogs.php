<?php

namespace backend\models\seobase;

use Yii;
use backend\models\references\Seo;
use backend\models\references\Translates;

class Blogs
{
    public static function AllBlogs()
    {
    	$model = new Seo();
        $model->name = 'Заголовок';
        $model->value = 'Блог {site.title} {page}';
        $model->key = 'blog_list_title';
        $model->group = 'blogs';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Блог {site.title} {page}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = 'Блог, Блог {site.title}';
        $model->key = 'blog_list_keyword';
        $model->group = 'blogs';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Блог, Блог {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = '{page} {site.title}';
        $model->key = 'blog_list_description';
        $model->group = 'blogs';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{page} {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Заголовок H1';
        $model->value = ' ';
        $model->key = 'blog_list_titleh1';
        $model->group = 'blogs';
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
        $model->key = 'blog_list_seotext';
        $model->group = 'blogs';
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
        $model->value = '{meta-base} | Блог {site.title} {page}';
        $model->key = 'blog_category_title';
        $model->group = 'blogs';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{meta-base} | Блог {site.title} {page}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = '{meta-base}';
        $model->key = 'blog_category_keyword';
        $model->group = 'blogs';
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
        $model->key = 'blog_category_description';
        $model->group = 'blogs';
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
        $model->value = '{tag} | Блог {site.title} {page}';
        $model->key = 'blog_teg_title';
        $model->group = 'blogs';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{tag} | Блог {site.title} {page}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = ' ';
        $model->key = 'blog_teg_keyword';
        $model->group = 'blogs';
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
        $model->key = 'blog_teg_description';
        $model->group = 'blogs';
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
        $model->value = '{title} | Блог {site.title}';
        $model->key = 'blog_post_title';
        $model->group = 'blogs';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{title} | Блог {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = '{title} {tags} {meta-base}';
        $model->key = 'blog_post_keyword';
        $model->group = 'blogs';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "{title} {tags} {meta-base}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = '{textshort}';
        $model->key = 'blog_post_description';
        $model->group = 'blogs';
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

        $model = new Seo();
        $model->name = 'Заголовок (поделиться в соц. сетях){title}';
        $model->value = '{title}';
        $model->key = 'blog_post_social';
        $model->group = 'blogs';
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
        $model->value = '{textshort}';
        $model->key = 'blog_post_social_description';
        $model->group = 'blogs';
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
         
        $model = new Seo();
        $model->name = 'Название сайта (поделиться в соц. сетях)';
        $model->value = '{site.title}';
        $model->key = 'blog_post_site_name';
        $model->group = 'blogs';
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