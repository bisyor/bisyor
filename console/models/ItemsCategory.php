<?php
/**
 * Created by PhpStorm.
 * Project: bisyor.loc
 * User: Umidjon <t.me/zoxidovuz>
 * Date: 20.04.2020
 * Time: 11:53
 */
namespace console\models;

use Yii;
use yii\base\Model;
use backend\models\items\Categories;
/**
 * Class Move
 * @package console\modelsl
 */
class ItemsCategory extends Model
{
    public static function copyCategories()
    {
        $sql = "SELECT bff_bbs_categories.id as category_id,bff_bbs_categories.*, bff_bbs_categories_lang.*  FROM bff_bbs_categories INNER JOIN bff_bbs_categories_lang ON bff_bbs_categories_lang.id = bff_bbs_categories.id WHERE bff_bbs_categories_lang.lang = 'ru'";
        $result = Yii::$app->dbmy->createCommand($sql)->queryAll();

        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql'){
            Yii::$app->db->createCommand("ALTER TABLE categories DISABLE TRIGGER USER;")->execute();
            foreach ($result as $value){
                $parent_id = (int)$value['pid'];
                if($parent_id == 0) $parent_id = NULL;
                $model = new Categories();
                $model->id = $value['category_id'];
                $model->sorting = null;
                $model->numlevel = $value['numlevel'];
                $model->icon_b = $value['keyword']."_b.png";
                $model->icon_s = $value['keyword']."_s.png";
                $model->keyword = $value['keyword'];
                $model->enabled = $value['enabled'];
                $model->date_cr = $value['created'];
                $model->date_up = $value['modified'];
                // $model->parent_id = $parent_id;
                $model->title = $value['title'];
                $model->type_offer_form = $value['type_offer_form'];
                $model->type_offer_search = $value['type_offer_search'];
                $model->type_seek_form = $value['type_seek_form'];
                $model->type_seek_search = $value['type_seek_search'];
                $model->seek = $value['seek'];
                $model->price = $value['price'];
                $model->price_sett = $value['price_sett'];
                $model->photos = $value['photos'];
                $model->owner_business = $value['owner_business'];
                $model->owner_private_form = $value['owner_private_form'];
                $model->owner_private_search = $value['owner_private_search'];
                $model->owner_business_form = $value['owner_business_form'];
                $model->owner_business_search = $value['owner_business_search'];
                $model->owner_search = $value['owner_search'];
                $model->owner_search_business = null;
                $model->address = $value['addr'];
                $model->metro = $value['addr_metro'];
                $model->regions_delivery = $value['regions_delivery'];
                $model->list_type = $value['list_type'];
                $model->keyword_edit = $value['keyword_edit'];
                $model->search_exrta_keywords = $value['search_exrta_keywords'];
                $model->items = $value['items'];
                $model->shops = $value['shops'];
                $model->subs_filter_level = $value['subs_filter_level'];
                $model->subs_filter_title = $value['subs_filter_title'];
                $model->tpl_title_enabled = $value['tpl_title_enabled'];
                $model->tpl_title_view = $value['tpl_title_view'];
                $model->tpl_title_list = $value['tpl_title_list'];
                $model->tpl_descr_list = $value['tpl_descr_list'];
                $model->mtitle = $value['mtitle'];
                $model->mkeywords = $value['mkeywords'];
                $model->mdescription = $value['mdescription'];
                $model->breadcrumb = $value['breadcrumb'];
                $model->titleh1 = $value['titleh1'];
                $model->seotext = $value['seotext'];
                $model->landing_id = $value['landing_id'];
                $model->landing_url = $value['landing_url'];
                $model->mtemplate = $value['mtemplate'];
                $model->view_mtitle = $value['view_mtitle'];
                $model->view_mkeywords = $value['view_mkeywords'];
                $model->view_mdescription = $value['view_mdescription'];
                $model->view_share_title = $value['view_share_title'];
                $model->view_share_description = $value['view_share_description'];
                $model->view_share_sitename = $value['view_share_sitename'];
                $model->view_mtemplate = $value['view_mtemplate'];
                if($model->save(false)){
//                    if(!empty($model->icon_s) && $model->parent_id == 1) self::uploadImage($model->id,$model->icon_s, $model->keyword);
//                    if(!empty($model->icon_b) && $model->parent_id == 1) self::uploadImage($model->id,$model->icon_b, $model->keyword);
                    fwrite(\STDOUT, "Successful copy ". $value['id'] ." rows\n");
                }else{
                    fwrite(\STDOUT, "Failed copy ". $value['id'] ." rows\n");
                }
            }
            foreach ($result as $value){
                $parent_id = (int)$value['pid'];
                if($parent_id == 0) $parent_id = NULL;
                $model = Categories::findOne($value['category_id']);
                if($model != null) {
                    $model->parent_id = $parent_id;
                    $model->save();
                }
            }
            Yii::$app->db->createCommand("ALTER TABLE categories ENABLE TRIGGER USER;")->execute();
            Yii::$app->db->createCommand("SELECT setval('categories_id_seq', (SELECT MAX(id) FROM categories))")->execute();
            
        }else{
            Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
            Yii::$app->db->createCommand("ALTER TABLE categories DISABLE KEYS;")->execute();
            foreach ($result as $value){
                $parent_id = (int)$value['pid'];
                if($parent_id == 0) $parent_id = NULL;
                
                $model = new Categories();
                $model->id = $value['category_id'];
                $model->sorting = null;
                $model->numlevel = $value['numlevel'];
                $model->icon_b = $value['keyword']."_b.png";
                $model->icon_s = $value['keyword']."_s.png";
                $model->keyword = $value['keyword'];
                $model->enabled = $value['enabled'];
                $model->date_cr = $value['created'];
                $model->date_up = $value['modified'];
                // $model->parent_id = $parent_id;
                $model->title = $value['title'];
                $model->type_offer_form = $value['type_offer_form'];
                $model->type_offer_search = $value['type_offer_search'];
                $model->type_seek_form = $value['type_seek_form'];
                $model->type_seek_search = $value['type_seek_search'];
                $model->seek = $value['seek'];
                $model->price = $value['price'];
                $model->price_sett = $value['price_sett'];
                $model->photos = $value['photos'];
                $model->owner_business = $value['owner_business'];
                $model->owner_private_form = $value['owner_private_form'];
                $model->owner_private_search = $value['owner_private_search'];
                $model->owner_business_form = $value['owner_business_form'];
                $model->owner_business_search = $value['owner_business_search'];
                $model->owner_search = $value['owner_search'];
                $model->owner_search_business = null;
                $model->address = $value['addr'];
                $model->metro = $value['addr_metro'];
                $model->regions_delivery = $value['regions_delivery'];
                $model->list_type = $value['list_type'];
                $model->keyword_edit = $value['keyword_edit'];
                $model->search_exrta_keywords = $value['search_exrta_keywords'];
                $model->items = $value['items'];
                $model->shops = $value['shops'];
                $model->subs_filter_level = $value['subs_filter_level'];
                $model->subs_filter_title = $value['subs_filter_title'];
                $model->tpl_title_enabled = $value['tpl_title_enabled'];
                $model->tpl_title_view = $value['tpl_title_view'];
                $model->tpl_title_list = $value['tpl_title_list'];
                $model->tpl_descr_list = $value['tpl_descr_list'];
                $model->mtitle = $value['mtitle'];
                $model->mkeywords = $value['mkeywords'];
                $model->mdescription = $value['mdescription'];
                $model->breadcrumb = $value['breadcrumb'];
                $model->titleh1 = $value['titleh1'];
                $model->seotext = $value['seotext'];
                $model->landing_id = $value['landing_id'];
                $model->landing_url = $value['landing_url'];
                $model->mtemplate = $value['mtemplate'];
                $model->view_mtitle = $value['view_mtitle'];
                $model->view_mkeywords = $value['view_mkeywords'];
                $model->view_mdescription = $value['view_mdescription'];
                $model->view_share_title = $value['view_share_title'];
                $model->view_share_description = $value['view_share_description'];
                $model->view_share_sitename = $value['view_share_sitename'];
                $model->view_mtemplate = $value['view_mtemplate'];
                if($model->save(false)){
//                    if(!empty($model->icon_s) && $model->parent_id == 1) self::uploadImage($model->id,$model->icon_s, $model->keyword);
//                    if(!empty($model->icon_b) && $model->parent_id == 1) self::uploadImage($model->id,$model->icon_b, $model->keyword);
                    fwrite(\STDOUT, "Successful copy ". $value['id'] ." rows\n");
                }else{
                    fwrite(\STDOUT, "Failed copy ". $value['id'] ." rows\n");
                }
            }
            foreach ($result as $value){
                $parent_id = (int)$value['pid'];
                if($parent_id == 0) $parent_id = NULL;
                $model = Categories::findOne($value['category_id']);
                if($model != null) {
                    $model->parent_id = $parent_id;
                    $model->save();
                }
            }
            Yii::$app->db->createCommand("ALTER TABLE categories ENABLE KEYS;")->execute();
            Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
        }
        return true;
    }

    

    public static function uploadImage($id,$img, $key)
    {
        $dir = '/web/uploads/categories/';
        $host = Yii::$app->params['host'];
        //host
        $name = $host['name'];
        $usr = $host['username'];
        $pwd = $host['password'];
        // connect to FTP server (port 21)
        $conn_id = ftp_connect($name, 21) or die ("Cannot connect to host");
        // send access parameters
        if(ftp_login($conn_id, $usr, $pwd)){
            ftp_pasv($conn_id, true);
        }

        $data = microtime(true);
        $res = ftp_size($conn_id, $dir . $img);
        if ($res != -1 && $img) {
            //image already uploaded
        }
        elseif(!empty($img)){
            $link = "http://img.coding-style.uz/web/resource/".$key.".png";
            $ftp_path = $dir.$img;
            if(self::urlexists($link)){
                $ret = ftp_nb_put($conn_id, $ftp_path, $link, FTP_BINARY);
                while ($ret == FTP_MOREDATA) {
                    $ret = ftp_nb_continue($conn_id);
                }
                if ($ret != FTP_FINISHED){
                    echo "При загрузке файла произошла ошибка...";
                    fwrite(\STDOUT, $img." При загрузке файла произошла ошибка...\n");
                }else{
                    fwrite(\STDOUT, "Avatar ".$img."  successfully uploaded\n");
                }
            }
        }

    }


        
    /**
     * @param $url
     * @return bool
     */
    public static function urlexists($url){
        $headers=get_headers($url);
        return stripos($headers[0],"200 OK")?true:false;
    }
}