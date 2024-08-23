<?php
namespace console\controllers;

use backend\models\users\Users;
use console\models\Base;
use console\models\CopyServices;
use console\models\ItemsCategory;
use console\models\Move;
use Yii;
use yii\console\Controller;

/**
 * Class CopyController
 * @package console\controllers
 */

class CopyController extends Controller
{
    public function actionStart()
    {
        ini_set('memory_limit', '-1');
        /**
         * This begin copy Roles table
         */
        $data = microtime(true);
        if(Move::copyRoles()) fwrite(\STDOUT, "Successful copy Roles table\n");
        else fwrite(\STDOUT, "Failed copy Roles table\n");

        fwrite(\STDOUT, "Speed ".(microtime(true) - $data)."\n");
        fwrite(\STDOUT, "***********************************   B I S Y O R   ***************************************\n");
        /**
         * Rollarga metodalar biriktirish
         */
        if(Move::AddMethods()){
            fwrite(\STDOUT, "Rollarga metodlar biriktirildi \n");
            fwrite(\STDOUT, "***********************************   B I S Y O R   ***************************************\n");
        }
        /**
         * This begin copy Users table
         */
        $data = microtime(true);
        if(Move::copyUsers()) fwrite(\STDOUT, "Successful copy Users table\n");
        else fwrite(\STDOUT, "Failed copy Users table\n");

        fwrite(\STDOUT, "Speed ".(microtime(true) - $data)."\n");
        fwrite(\STDOUT, "***********************************   B I S Y O R   ***************************************\n");

        /**
         * This begin copy UserRoles table
         */
        $data = microtime(true);
        if(Move::copyUserRoles()) fwrite(\STDOUT, "Successful copy User Roles table\n");
        else fwrite(\STDOUT, "Failed copy User Roles table\n");

        fwrite(\STDOUT, "Speed ".(microtime(true) - $data)."\n");
        fwrite(\STDOUT, "***********************************   B I S Y O R   ***************************************\n");

        /**
         * This begin copy UserHistory table
         */
        $data = microtime(true);
        if(Move::copyUserHistory()) fwrite(\STDOUT, "Successfull copy table User History for type = 3\n");
        else fwrite(\STDOUT, "Failed copy table User History for type = 3\n");

        fwrite(\STDOUT, "Speed ".(microtime(true) - $data)."\n");
        fwrite(\STDOUT, "***********************************   B I S Y O R   ***************************************\n");

        /**
         * Sotsial tarmoqdagi apilar ko'chirish uchun
         */
        $data = microtime(true);
        if(Move::CopyUserSocial()) fwrite(\STDOUT, "Successfull copy table User Social\n");
        else fwrite(\STDOUT, "Failed copy table User Social\n");

        if(Move::copyCat()) fwrite(\STDOUT, "Successfull copy table Blog Category\n");
        else fwrite(\STDOUT, "Failed copy table Blog Category\n");

        if(Move::copyComment()) fwrite(\STDOUT, "Successfull copy table Blog Comment\n");
        else fwrite(\STDOUT, "Failed copy table Blog Comment\n");

        if(Move::copyBlogPosts()) fwrite(\STDOUT, "Successfull copy table Blog Post\n");
        else fwrite(\STDOUT, "Failed copy table Blog Post\n");

        if(Move::copyPostLikes()) fwrite(\STDOUT, "Successfull copy table Blog Post Likes\n");
        else fwrite(\STDOUT, "Failed copy table Blog Post Likes\n");

        if(Move::copyBlogTags()) fwrite(\STDOUT, "Successfull copy table Blog Tags\n");
        else fwrite(\STDOUT, "Failed copy table Blog Tags\n");

        if(Move::copyPostTags()) fwrite(\STDOUT, "Successfull copy table Blog Post Tags\n");
        else fwrite(\STDOUT, "Failed copy table Blog Post Tags\n");

        if(Move::copyBanners()) fwrite(\STDOUT, "Successfull copy table Banners\n");
        else fwrite(\STDOUT, "Failed copy table Banners\n");

        if(Move::copyBannersItems()) fwrite(\STDOUT, "Successfull copy table Banners Items\n");
        else fwrite(\STDOUT, "Failed copy table Banners Items\n");

        if(Move::copyBannersStat()) fwrite(\STDOUT, "Successfull copy table Banners Statistica\n");
        else fwrite(\STDOUT, "Failed copy table Banners Statistica\n");

        fwrite(\STDOUT, "Speed ".(microtime(true) - $data)."\n");
        fwrite(\STDOUT, "***********************************   B I S Y O R   ***************************************\n");

        $data = microtime(true);
        if(CopyServices::copy()) fwrite(\STDOUT, "Successful copy services table\n");
        else fwrite(\STDOUT, "Failed copy services table\n");
        fwrite(\STDOUT, "Speed ".(microtime(true) - $data)."\n");
        fwrite(\STDOUT, "**************************************************************************\n");

        $data = microtime(true);
        if(ItemsCategory::copyCategories()) fwrite(\STDOUT, "Successful copy categories table\n");
        else fwrite(\STDOUT, "Failed copy categories table\n");
        fwrite(\STDOUT, "Speed ".(microtime(true) - $data)."\n");
        fwrite(\STDOUT, "**************************************************************************\n");

        if(Move::copyShopsAbonament()) fwrite(\STDOUT, "Successfull copy table Shops Abonament\n");
        else fwrite(\STDOUT, "Failed copy table Shops Abonament\n");
        if(Move::copyShops()) fwrite(\STDOUT, "Successfull copy table Shops\n");
        else fwrite(\STDOUT, "Failed copy table Shops\n");

        $data = microtime(true);
        if(Move::copyItems()) fwrite(\STDOUT, "Successfull copy table Items\n");
        else fwrite(\STDOUT, "Failed copy table Items\n");
        fwrite(\STDOUT, "Speed ".(microtime(true) - $data)."\n");

        $data = microtime(true);
        if(Move::copyCatDyn()) fwrite(\STDOUT, "Successfull copy table categories_dynprops\n");
        fwrite(\STDOUT, "Speed ".(microtime(true) - $data)."\n");
        fwrite(\STDOUT, "***********************************   B I S Y O R   ***************************************\n");
        if(Move::copyPromocod()) fwrite(\STDOUT, "Successfull copy table promoceodes\n");
        if(Move::copyBills()) fwrite(\STDOUT, "Successfull copy table bills\n");
        if(Move::copyItemsClaim()) fwrite(\STDOUT, "Successfull copy table ItemsClaims\n");
        if(Move::copyItemsComment()) fwrite(\STDOUT, "Successfull copy table ItemsComment\n");
        if(Move::copyItemsEnotify()) fwrite(\STDOUT, "Successfull copy table ItemsEnotify\n");
        if(Move::copyItemsFav()) fwrite(\STDOUT, "Successfull copy table ItemsFav\n");

        /**
         * This updated admin pasword
         */
        $users = Users::find()->asArray()->all();
        $yii_app = Yii::$app;
        $connection = $yii_app->db;
        $transaction = $connection->beginTransaction();
        $password = $yii_app->security->generatePasswordHash("bisyor2020newsite");
        
        try {
            foreach ($users as $value) 
            {
                $connection->createCommand("UPDATE users SET password ='".$password."' WHERE id=".$value['id'].";")->execute();
            }
            if ($transaction->commit()) {
                fwrite(\STDOUT, "Barcha userlarning parollari yangilandi\n");
            }
        } 
        catch (Exception $e) {
            $transaction->rollBack();
            fwrite(\STDOUT, $e->getMessage());
        }

        $pass = $yii_app->security->generatePasswordHash('admin');
        if($yii_app->db->createCommand("UPDATE users SET password ='".$pass."', email='admin@bisyor.uz' WHERE id=1")->execute()) {
            fwrite(\STDOUT, "Admin password updated. Passsword: admin Email: admin@bisyor.uz\n");
        }

        $pass = $yii_app->security->generatePasswordHash('admin3');
        if($yii_app->db->createCommand("UPDATE users SET password ='".$pass."' WHERE id=173")->execute()) {
            fwrite(\STDOUT, "Seo Admin password updated. Passsword: admin3 \n");
        }
    }

    public function actionContinue()
    {
        ini_set('memory_limit', '-1');
        $data = microtime(true);
        if(Move::copyItemsImages()) fwrite(\STDOUT, "Successfull copy table ItemsImages\n");
        fwrite(\STDOUT, "Speed ".(microtime(true) - $data)."\n");
        fwrite(\STDOUT, "***********************************   B I S Y O R   ***************************************\n");

        /*if(Move::copyItemsTranslate()) fwrite(\STDOUT, "Successfull copy table Items Lang\n");
        if(Move::copyItemsLimits()) fwrite(\STDOUT, "Successfull copy table Items Limits\n");*/
    }

    public function actionContinue1()
    {
        ini_set('memory_limit', '-1');
        $data = microtime(true);
        if(Move::copyItemsTranslate()) fwrite(\STDOUT, "Successfull copy table Items Lang\n");
        if(Move::copyItemsLimits()) fwrite(\STDOUT, "Successfull copy table Items Limits\n");
    }

    public function actionContinue2()
    {
        ini_set('memory_limit', '-1');
        $data = microtime(true);
        if(Move::copyItemsView()) fwrite(\STDOUT, "Successfull copy table Items Views\n");
        fwrite(\STDOUT, "Speed ".(microtime(true) - $data)."\n");
    }

    public function actionContinue3()
    {
        if(Move::copyItemsUsersLimits()) fwrite(\STDOUT, "Successfull copy table Items User Limits\n");
        if(Move::copyCounters()) fwrite(\STDOUT, "Successfull copy table bff_counters\n");
        if(Move::copyIntermail()) fwrite(\STDOUT, "Successfull copy table bff_internalmail\n");
        if(Move::copyLanding()) fwrite(\STDOUT, "Successfull copy table bff_landingpages\n");
        if(Move::copyPages()) fwrite(\STDOUT, "Successfull copy table bff_pages\n");
        if(Move::copyAnalitic()) fwrite(\STDOUT, "Successfull copy table bff_plugin_google_analytics_p0f8b64\n");
        if(Move::copyPayme()) fwrite(\STDOUT, "Successfull copy table Payme Transaction\n");
        if(Move::copySearchResult()) fwrite(\STDOUT, "Successfull copy table Search Result");
        if(Move::copyRedirects()) fwrite(\STDOUT, "Successfull copy table Redirects\n");
        if(Move::copySiteRequest()) fwrite(\STDOUT, "Successfull copy table SiteRequest\n");
        if(Move::copyItemsCounters()) fwrite(\STDOUT, "Successfull copy table Items Counters\n");
        if(Move::newValueBanners()) fwrite(\STDOUT, "Successfull insert new value banners\n");
        if(Move::copyContacts()) fwrite(\STDOUT, "Successfull copy table Contacts\n");
    }

    public function actionBlog()
    {
        ini_set('memory_limit', '-1');
        if(Move::copyBlogPosts()) fwrite(\STDOUT, "Successfull copy table Blog Post\n");
        else fwrite(\STDOUT, "Failed copy table Blog Post\n");
    }

    public function actionUploadAvatar()
    {
        $user_avatar  = Users::find()->all();
        $dir = '/web/uploads/avatars/';

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
        $dir_list = [0, 1, 101, 107, 108, 11, 120, 129, 131, 14, 140, 159, 187, 19, 2, 23, 3, 33, 35, 55, 56, 82];
        foreach ($user_avatar as $avatar){
            if(!empty($avatar->avatar)){
                foreach ($dir_list as $value) {
                    $link = "https://bisyor.uz/files/images/avatars/".$value."/".$avatar->id."n".$avatar->avatar;
                    if(Base::urlexists($link)){
                        $ftp_path = $dir.$avatar->avatar;
                        $ret = ftp_nb_put($conn_id, $ftp_path, $link, FTP_BINARY);
                        while ($ret == FTP_MOREDATA) {
                            $ret = ftp_nb_continue($conn_id);
                        }
                        if ($ret != FTP_FINISHED){
                            echo "При загрузке файла произошла ошибка...";
                            fwrite(\STDOUT, $avatar->avatar." При загрузке файла произошла ошибка...\n");
                        }else{
                            fwrite(\STDOUT, "Avatar ".$avatar->avatar."  successfully uploaded\n");
                        }
                        break;
                    }
                }
            }
        }
    }

    public function actionBlogImage()
    {
        $conn_id = Base::connectFtp();
        $base = Yii::$app->dbmy->createCommand("SELECT * FROM bff_blog_posts p LEFT JOIN bff_blog_posts_lang l ON p.id = l.id WHERE l.lang='ru'")
            ->queryAll();
        foreach ($base as $item) {
            $ftp_path = '/web/uploads/blog_posts/'.$item['preview'];
            $link = "https://bisyor.uz/files/images/blog/".$item['id']."i".$item['preview'];
            if(Base::urlexists($link)){
                $ret = ftp_nb_put($conn_id, $ftp_path, $link, FTP_BINARY);
                while ($ret == FTP_MOREDATA) {
                    $ret = ftp_nb_continue($conn_id);
                }
                if($ret != FTP_FINISHED){
                    fwrite(\STDOUT, " При загрузке файла произошла ошибка...\n");
                }else{
                    fwrite(\STDOUT, $item['preview']." Изображение успешно загружено\n");
                }
            }
            $content = unserialize($item['content'])['b'];

            foreach ($content as $value){
                if(isset($value['photo'])){
                    $ftp_path = '/web/uploads/blog_posts/'.$value['photo'];
                    $link = "https://bisyor.uz/files/images/blog/".$item['id']."v".$value['photo'];
                    if(Base::urlexists($link)){
                        $ret = ftp_nb_put($conn_id, $ftp_path, $link, FTP_BINARY);
                        while ($ret == FTP_MOREDATA) {
                            $ret = ftp_nb_continue($conn_id);
                        }
                        if($ret != FTP_FINISHED){
                            fwrite(\STDOUT, " При загрузке файла произошла ошибка...\n");
                        }else{
                            fwrite(\STDOUT, $value['photo']." Изображение успешно загружено\n");
                        }
                    }

                }
            }
        }
    }

    public function actionShopsImage()
    {
        $conn_id = Base::connectFtp();
        $base = Base::takeBase('bff_shops');
        foreach ($base as $item) {
            if(isset($item['logo'])){
                $ftp_path = '/web/uploads/shops/'.$item['logo'];
                $link = "https://bisyor.uz/files/images/shop/logo/0/".$item['id']."v".$item['logo'];
                if(Base::urlexists($link)){
                    $ret = ftp_nb_put($conn_id, $ftp_path, $link, FTP_BINARY);
                    while ($ret == FTP_MOREDATA) {
                        $ret = ftp_nb_continue($conn_id);
                    }
                    if($ret != FTP_FINISHED){
                        fwrite(\STDOUT, " При загрузке файла произошла ошибка...\n");
                    }else{
                        fwrite(\STDOUT, $item['logo']." Изображение успешно загружено\n");
                    }
                }
            }
        }
    }

    public function actionItemsImage()
    {
        ini_set('memory_limit', '-1');
        $conn_id = Base::connectFtp();
        $base = Base::takeBase('bff_bbs_items');
        foreach ($base as $item) {
            $img_s = preg_replace("/(.*\/)/", "", $item['img_s']);
            $img_m = preg_replace("/(.*\/)/", "", $item['img_m']);
            if($img_s){
                $ftp_path = '/web/uploads/items/'.$img_s;
                $link = "https://".ltrim($item['img_s'], '//');
                if(Base::urlexists($link)){
                    $ret = ftp_nb_put($conn_id, $ftp_path, $link, FTP_BINARY);
                    while ($ret == FTP_MOREDATA) {
                        $ret = ftp_nb_continue($conn_id);
                    }
                    if($ret != FTP_FINISHED){
                        fwrite(\STDOUT, "При загрузке файла произошла ошибка...\n");
                    }else{
                        fwrite(\STDOUT, $item['img_s']." Изображение успешно загружено\n");
                    }
                }
            }
            if($img_m){
                $ftp_path = '/web/uploads/items/'.$img_m;
                $link = "https://".ltrim($item['img_m'], '//');
                if(Base::urlexists($link)){
                    $ret = ftp_nb_put($conn_id, $ftp_path, $link, FTP_BINARY);
                    while ($ret == FTP_MOREDATA) {
                        $ret = ftp_nb_continue($conn_id);
                    }
                    if($ret != FTP_FINISHED){
                        fwrite(\STDOUT, " При загрузке файла произошла ошибка...\n");
                    }else{
                        fwrite(\STDOUT, $item['img_m']." Изображение успешно загружено\n");
                    }
                }
            }
        }
    }

    public function actionItemsImageAll()
    {
        ini_set('memory_limit', '-1');
        $conn_id = Base::connectFtp();
        //$base = Base::takeBase('bff_bbs_items_images'); // yoqish kerak
        $base = Base::takeImgBase('bff_bbs_items_images', 's_type'); // ochirib tawlaw kerak
        $i = 0;
        foreach ($base as $item) {
            $extstor_img_s = preg_replace("/(.*\/)/", "", $item['extstor_img_s']);
            $extstor_img_m = preg_replace("/(.*\/)/", "", $item['extstor_img_m']);
            $extstor_img_v = preg_replace("/(.*\/)/", "", $item['extstor_img_v']);
            $extstor_img_z = preg_replace("/(.*\/)/", "", $item['extstor_img_z']);
            $extstor_img_o = preg_replace("/(.*\/)/", "", $item['extstor_img_o']);
            if($extstor_img_s){
                $ftp_path = '/web/uploads/items/'.$extstor_img_s;
                $link = "https://".ltrim($item['extstor_img_s'], '//');
                if(Base::urlexists($link)){
                    $ret = ftp_nb_put($conn_id, $ftp_path, $link, FTP_BINARY);
                    while ($ret == FTP_MOREDATA) {
                        $ret = ftp_nb_continue($conn_id);
                    }
                    if($ret != FTP_FINISHED){
                        fwrite(\STDOUT, "При загрузке файла произошла ошибка...\n");
                    }else{
                        fwrite(\STDOUT, $item['extstor_img_s']." Изображение успешно загружено\n");
                    }
                }
            }
            if($extstor_img_m){
                $ftp_path = '/web/uploads/items/'.$extstor_img_m;
                $link = "https://".ltrim($item['extstor_img_m'], '//');
                if(Base::urlexists($link)){
                    $ret = ftp_nb_put($conn_id, $ftp_path, $link, FTP_BINARY);
                    while ($ret == FTP_MOREDATA) {
                        $ret = ftp_nb_continue($conn_id);
                    }
                    if($ret != FTP_FINISHED){
                        fwrite(\STDOUT, "При загрузке файла произошла ошибка...\n");
                    }else{
                        fwrite(\STDOUT, $item['extstor_img_m']." Изображение успешно загружено\n");
                    }
                }
            }
            if($extstor_img_v){
                $ftp_path = '/web/uploads/items/'.$extstor_img_v;
                $link = "https://".ltrim($item['extstor_img_v'], '//');
                if(Base::urlexists($link)){
                    $ret = ftp_nb_put($conn_id, $ftp_path, $link, FTP_BINARY);
                    while ($ret == FTP_MOREDATA) {
                        $ret = ftp_nb_continue($conn_id);
                    }
                    if($ret != FTP_FINISHED){
                        fwrite(\STDOUT, "При загрузке файла произошла ошибка...\n");
                    }else{
                        fwrite(\STDOUT, $item['extstor_img_v']." Изображение успешно загружено\n");
                    }
                }
            }
            if($extstor_img_z){
                $ftp_path = '/web/uploads/items/'.$extstor_img_z;
                $link = "https://".ltrim($item['extstor_img_z'], '//');
                if(Base::urlexists($link)){
                    $ret = ftp_nb_put($conn_id, $ftp_path, $link, FTP_BINARY);
                    while ($ret == FTP_MOREDATA) {
                        $ret = ftp_nb_continue($conn_id);
                    }
                    if($ret != FTP_FINISHED){
                        fwrite(\STDOUT, "При загрузке файла произошла ошибка...\n");
                    }else{
                        fwrite(\STDOUT, $item['extstor_img_z']." Изображение успешно загружено\n");
                    }
                }
            }
            if($extstor_img_o){
                $ftp_path = '/web/uploads/items/'.$extstor_img_o;
                $link = "https://".ltrim($item['extstor_img_o'], '//');
                if(Base::urlexists($link)){
                    $ret = ftp_nb_put($conn_id, $ftp_path, $link, FTP_BINARY);
                    while ($ret == FTP_MOREDATA) {
                        $ret = ftp_nb_continue($conn_id);
                    }
                    if($ret != FTP_FINISHED){
                        fwrite(\STDOUT, "При загрузке файла произошла ошибка...\n");
                    }else{
                        fwrite(\STDOUT, $item['extstor_img_o']." Изображение успешно загружено\n");
                    }
                }
            }
            // if($i > 2) break;
            $i++;
            $base = Base::updateImgBase($item['id']); // ochiirib tawlaw kerak
        }
    }
    public function actionItemsImageOrginal()
    {
        ini_set('memory_limit', '-1');
        $conn_id = Base::connectFtp();
        $base = Base::takeBase('bff_bbs_items_images');
        foreach ($base as $item) {
            $extstor_img_o = preg_replace("/(.*\/)/", "", $item['extstor_img_o']);
            if($extstor_img_o){
                $ftp_path = '/web/uploads/items/'.$extstor_img_o;
                $link = "https://".ltrim($item['extstor_img_o'], '//');
                if(Base::urlexists($link)){
                    $ret = ftp_nb_put($conn_id, $ftp_path, $link, FTP_BINARY);
                    while ($ret == FTP_MOREDATA) {
                        $ret = ftp_nb_continue($conn_id);
                    }
                    if($ret != FTP_FINISHED){
                        fwrite(\STDOUT, "При загрузке файла произошла ошибка...\n");
                    }else{
                        fwrite(\STDOUT, $item['extstor_img_o']." Изображение успешно загружено\n");
                    }
                }
            }
        }
    }

}

?>