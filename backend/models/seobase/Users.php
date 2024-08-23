<?php

namespace backend\models\seobase;

use Yii;
use backend\models\references\Seo;
use backend\models\references\Translates;

class Users
{
    public static function AllUsers()
    {
    	$model = new Seo();
        $model->name = 'Заголовок';
        $model->value = 'Авторизация на {site.title}';
        $model->key = 'users_auth_title';
        $model->group = 'users';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Tizimga kirish {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = 'Авторизация bisyor.uz,';
        $model->key = 'users_auth_keyword';
        $model->group = 'users';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Авторизация bisyor.uz,";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = ' ';
        $model->key = 'users_auth_description';
        $model->group = 'users';
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
        $model->value = 'Авторизация на {site.title}';
        $model->key = 'users_auth_titleh1';
        $model->group = 'users';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Авторизация на {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }


    	$model = new Seo();
        $model->name = 'Заголовок';
        $model->value = 'Регистрация на {site.title}';
        $model->key = 'users_reg_title';
        $model->group = 'users';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Регистрация на {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = ' ';
        $model->key = 'users_reg_keyword';
        $model->group = 'users';
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
        $model->key = 'users_reg_description';
        $model->group = 'users';
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
        $model->value = 'Восстановление пароля на {site.title}';
        $model->key = 'users_recover_title';
        $model->group = 'users';
        $model->type = 'string';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Восстановление пароля на {site.title}";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Ключевые слова';
        $model->value = 'Восстановление пароля';
        $model->key = 'users_recover_keyword';
        $model->group = 'users';
        $model->type = 'text';
        if($model->save()) {
            $tr = new Translates();
            $tr->table_name = 'seo';
            $tr->field_id = $model->id;
            $tr->field_name = $model->key;
            $tr->field_value = "Восстановление пароля";
            $tr->language_code = 'uz';
            $tr->save();
        }

        $model = new Seo();
        $model->name = 'Описание';
        $model->value = ' ';
        $model->key = 'users_recover_description';
        $model->group = 'users';
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