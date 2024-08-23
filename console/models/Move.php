<?php
/**
 * Created by PhpStorm.
 * Project: bisyor.loc
 * User: Umidjon <t.me/zoxidovuz>
 * Date: 20.04.2020
 * Time: 11:53
 */
namespace console\models;

use backend\models\banners\Banners;
use backend\models\banners\BannersItems;
use backend\models\banners\BannersStatistic;
use backend\models\chats\Chats;
use backend\models\chats\ChatUsers;
use backend\models\references\Districts;
use backend\models\references\Regions;
use backend\models\shops\Services;
use backend\models\users\Users;
use phpDocumentor\Reflection\Types\Parent_;
use Yii;
use yii\db\Migration;

/**
 * Class Move
 * @package console\modelsl
 */
class Move extends Base
{

    /**
     * User jadvallarini ko'chirish
     * @return bool
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public static function copyUsers()
    {;
        $base = Yii::$app->dbmy->createCommand("SELECT * FROM bff_users LEFT JOIN bff_users_stat ON bff_users.user_id = bff_users_stat.user_id")->queryAll();
        $sql_history = "INSERT INTO user_history (user_id, date_cr, type, title, value) VALUES";
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql'){
            foreach ($base as $value){
                $status = self::status($value);
                $sex = self::sex($value);
                $token = Yii::$app->getSecurity()->generateRandomString();
                $expiret_at = time() + self::EXPIRE_TIME;
                $balance =!empty($value['balance']) ? $value['balance'] : NULL;
                $enotify_price_drop =!empty($value['enotify_pricedrop_bbs']) ? 't' : 'f';
                $email_verified =!empty($value['email_verified']) ? 't' : 'f';
                $phone_number_verified =!empty($value['phone_number_verified']) ? 't' : 'f';
                $created =!empty($value['created']) ? $value['created'] : NULL;
                $phones = self::phones($value);
                $telegram = json_decode($value['contacts'], true);
                $district = self::regions($value);
                $addr_addr = str_replace("'", "''", $value['addr_addr']);
                $admin_comment = str_replace("'", "''", $value['admin_comment']);
                $blocked_reason = str_replace("'", "''", $value['blocked_reason']);
                $fio = str_replace("'", "''", $value['name']);
                $last_seen = $value['last_activity'] != '0000-00-00 00:00:00' ?  $value['last_activity'] : $value['created'];
                $insert = "INSERT INTO users (id, login, password, status, sex, balance, access_token, expiret_at,
                email_fav_ads_price_alert, email_verified, phone_verified, registry_date, last_seen";
                $values_sql = "VALUES ('".$value['user_id']."', '".$value['login']."', '".$value['password']
                    ."', '".$status."', '".$sex."', '" .$balance."', '".$token."', '".$expiret_at."', '"
                    .$enotify_price_drop."', '".$email_verified."', '".$phone_number_verified."', '"
                    .$created."', '".$last_seen."'";
                if(!empty($phones)){ $insert .= ", phones"; $values_sql .= ", '".$phones."'"; }
                if(!empty($telegram)){ $insert .= ", telegram"; $values_sql .= ", '".$telegram['telegram']."'"; }
                if(!empty($district)){ $insert .= ", district_id"; $values_sql .= ", '".$district."'"; }
                if(!empty($value['phone_number'])){ $insert .= ", phone"; $values_sql .= ", '".($value['phone_number'] ? '+'.$value['phone_number'] : $value['phone_number'])."'"; }
                if(!empty($value['email'])){ $insert .= ", email"; $values_sql .= ", '".$value['email']."'"; }
                if(!empty($value['avatar'])){ $insert .= ", avatar"; $values_sql .= ", '".$value['avatar']."'"; }
                if(!empty($value['lang'])){ $insert .= ", lang_code"; $values_sql .= ", '".$value['lang']."'"; }
                if(!empty($value['birthdate'])){ $insert .= ", birthday"; $values_sql .= ", '".$value['birthdate']."'"; }
                if(!empty($value['addr_lat'])){ $insert .= ", coordinate_x"; $values_sql .= ", '".$value['addr_lat']."'"; }
                if(!empty($value['addr_lon'])){ $insert .= ", coordinate_y"; $values_sql .= ", '".$value['addr_lon']."'"; }
                if(!empty($value['site'])){ $insert .= ", site"; $values_sql .= ", '".$value['site']."'"; }
                if(!empty($value['$addr_addr'])){ $insert .= ", address"; $values_sql .= ", '".$value['$addr_addr']."'"; }
                if(!empty($addr_addr)){ $insert .= ", address"; $values_sql .= ", '".$addr_addr."'"; }
                if(!empty($admin_comment)){ $insert .= ", admin_comment"; $values_sql .= ", '".$admin_comment."'"; }
                if(!empty($blocked_reason)){ $insert .= ", block_reason"; $values_sql .= ", '".$blocked_reason."'"; }
                if(!empty($fio)){ $insert .= ", fio"; $values_sql .= ", '".$fio."'"; }

                if(Yii::$app->db->createCommand($insert.") ".$values_sql.")")->execute()){
                    fwrite(\STDOUT, "Successful copy ". $value['user_id'] ." rows\n");
                }else{
                    fwrite(\STDOUT, "Failed copy ". $value['user_id'] ." rows\n");
                }
                $sql_history .= " ({$value['user_id']}, '{$value['created']}', 2, 'Регистрация', 'Пользователь зарегистрирован'),";
            }
        }else{
            foreach ($base as $value){
                $status = self::status($value);
                $sex = self::sex($value);
                $token = Yii::$app->getSecurity()->generateRandomString();
                $expiret_at = time() + self::EXPIRE_TIME;
                $balance =!empty($value['balance']) ? $value['balance'] : NULL;
                $enotify_price_drop =!empty($value['enotify_pricedrop_bbs']) ? 1 : 0;
                $email_verified =!empty($value['email_verified']) ? 1 : 0;
                $phone_number_verified =!empty($value['phone_number_verified']) ? 1 : 0;
                $created =!empty($value['created']) ? $value['created'] : NULL;
                $phones = self::phones($value);
                $telegram = json_decode($value['contacts'], true);
                $district = self::regions($value);
                $addr_addr = addslashes($value['addr_addr']);
                $admin_comment = addslashes($value['admin_comment']);
                $blocked_reason = addslashes( $value['blocked_reason']);
                $fio = addslashes($value['name']);
                $last_seen = $value['last_activity'] != '0000-00-00 00:00:00' ?  $value['last_activity'] : $value['created'];
                $insert = "INSERT INTO users (id, login, password, status, sex, balance, access_token, expiret_at,
                email_fav_ads_price_alert, email_verified, phone_verified, registry_date, last_seen";
                $values_sql = "VALUES ('".$value['user_id']."', '".$value['login']."', '".$value['password']
                    ."', '".$status."', '".$sex."', '" .$balance."', '".$token."', '".$expiret_at."', '"
                    .$enotify_price_drop."', '".$email_verified."', '".$phone_number_verified."', '"
                    .$created."', '".$last_seen."'";
                if(!empty($phones)){ $insert .= ", phones"; $values_sql .= ", '".$phones."'"; }
                if(!empty($telegram)){ $insert .= ", telegram"; $values_sql .= ", '".$telegram['telegram']."'"; }
                if(!empty($district)){ $insert .= ", district_id"; $values_sql .= ", '".$district."'"; }
                if(!empty($value['phone_number'])){ $insert .= ", phone"; $values_sql .= ", '".($value['phone_number'] ? '+'.$value['phone_number'] : $value['phone_number'])."'"; }
                if(!empty($value['email'])){ $insert .= ", email"; $values_sql .= ", '".$value['email']."'"; }
                if(!empty($value['avatar'])){ $insert .= ", avatar"; $values_sql .= ", '".$value['avatar']."'"; }
                if(!empty($value['lang'])){ $insert .= ", lang_code"; $values_sql .= ", '".$value['lang']."'"; }
                if(!empty($value['birthdate'])){ $insert .= ", birthday"; $values_sql .= ", '".$value['birthdate']."'"; }
                if(!empty($value['addr_lat'])){ $insert .= ", coordinate_x"; $values_sql .= ", '".$value['addr_lat']."'"; }
                if(!empty($value['addr_lon'])){ $insert .= ", coordinate_y"; $values_sql .= ", '".$value['addr_lon']."'"; }
                if(!empty($value['site'])){ $insert .= ", site"; $values_sql .= ", '".$value['site']."'"; }
                if(!empty($value['$addr_addr'])){ $insert .= ", address"; $values_sql .= ", '".$value['$addr_addr']."'"; }
                if(!empty($addr_addr)){ $insert .= ", address"; $values_sql .= ", '".$addr_addr."'"; }
                if(!empty($admin_comment)){ $insert .= ", admin_comment"; $values_sql .= ", '".$admin_comment."'"; }
                if(!empty($blocked_reason)){ $insert .= ", block_reason"; $values_sql .= ", '".$blocked_reason."'"; }
                if(!empty($fio)){ $insert .= ", fio"; $values_sql .= ", '".$fio."'"; }

                if(Yii::$app->db->createCommand($insert.") ".$values_sql.")")->execute()){
                    fwrite(\STDOUT, "Successful copy ". $value['user_id'] ." rows\n");
                }else{
                    fwrite(\STDOUT, "Failed copy ". $value['user_id'] ." rows\n");
                }
                $sql_history .= " ({$value['user_id']}, '{$value['created']}', 2, 'Регистрация', 'Пользователь зарегистрирован'),";
            }
        }
        $sql_history = rtrim($sql_history, ','). ";";
        if(Yii::$app->db->createCommand($sql_history)->execute())
            fwrite(\STDOUT, "Copy user history successfull\n");
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql')
            Yii::$app->db->createCommand("SELECT setval('users_id_seq', (SELECT MAX(id) FROM users))")->execute();
        return true;
    }

    /**
     * Roles jadvalini ko'chirish
     * @return bool
     * @throws \yii\db\Exception
     */
    public static function copyRoles()
    {
        $base = self::takeBase('bff_users_groups');
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql'){
            $sql  = "INSERT INTO roles (id, name, color, key, admin_access) VALUES";
            foreach ($base as $value){
                $sql .= " ('{$value['group_id']}', '{$value['title']}', '{$value['color']}', '{$value['keyword']}', '{$value['adminpanel']}'),";
            }
        }else{
            $sql  = "INSERT INTO roles (id, name, color, roles.key, admin_access) VALUES";
            foreach ($base as $value){
                $admin = $value['adminpanel']==false ? 0 : 1;
                $sql .= " ('{$value['group_id']}', '".addslashes($value['title'])."', '".addslashes($value['color'])."',
                 '".addslashes($value['keyword'])."', {$admin}),";
            }
        }
        $sql = rtrim($sql, ",").";";
        if(Yii::$app->db->createCommand($sql)->execute()){
            if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql')
                Yii::$app->db->createCommand("SELECT setval('roles_id_seq', (SELECT MAX(id) FROM roles))")->execute();
            return true;
        }else{
            return false;
        }
    }

    /**
     * Userlarga ro'llar berib chqish
     * @return bool
     * @throws \yii\db\Exception
     */
    public static function copyUserRoles()
    {
        $base = Yii::$app->dbmy->createCommand("SELECT bff_user_in_group.user_id, group_id, bff_user_in_group.created FROM bff_user_in_group INNER JOIN bff_users ON bff_user_in_group.user_id =bff_users.user_id")->queryAll();
        $sql  = "INSERT INTO user_roles (user_id, role_id, date_cr) VALUES";
        foreach ($base as $value){
            $sql .= " ('{$value['user_id']}', '{$value['group_id']}', '{$value['created']}'),";
        }
        $sql = rtrim($sql, ",").";";
        if(Yii::$app->db->createCommand($sql)->execute()){
            return true;
        }else{
            return false;
        }
    }

    public static function copyUserHistory()
    {
        $base = self::takeBase('bff_users_stat');
        $sql = "INSERT INTO user_history (user_id, date_cr, type, title, value) VALUES";

        foreach ($base as $value){
            $ip_add = $value['last_login_ip'] == 0 ? 'Пользователь авторизованны' : long2ip($value['last_login_ip']);
            if($value['last_login'] != '0000-00-00 00:00:00')
                $sql .= " ({$value['user_id']}, '{$value['last_login']}', 3, 'Авторизация', '{$ip_add}'),";
            if($value['last_login'] != '0000-00-00 00:00:00')
                $sql .= " ({$value['user_id']}, '{$value['last_login']}', 3, 'Авторизация', '{$ip_add}'),";
        }

        $sql = rtrim($sql, ',').";";
        return Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * Sitsial setlar orqali ro'yxatdan o'tgan userlarni ko'chirish
     * @return bool
     */
    public static function CopyUserSocial()
    {
        $base  = Yii::$app->dbmy->createCommand("SELECT * FROM bff_users_social WHERE provider_id ='2'")->queryAll();
//        $dir = '/web/uploads/avatars/';
//        $host = Yii::$app->params['host'];
//        $name = $host['name'];
//        $usr = $host['username'];
//        $pwd = $host['password'];
//        $conn_id = ftp_connect($name, 21) or die ("Cannot connect to host");
//        if(ftp_login($conn_id, $usr, $pwd)){
//            ftp_pasv($conn_id, true);
//        }
        foreach($base as $value){
            $model = Users::find()->where(['id' => $value['user_id']])->one();
            if($model){
                $data = unserialize($value['profile_data']);
                $model->facebook_api_key = $data['identifier'];
                if(empty($model->fio) && !empty($data['displayName'])) $model->fio = $data['displayName'];
                if(empty($model->email) && !empty($data['email'])) $model->email = $data['email'];
                if(empty($model->phone) && !empty($data['phone'])) $model->phone = $data['phone'];
                if(empty($model->address) && !empty($data['address'])) $model->address = $data['address'];
                if(empty($model->birthday && !empty($data['birthDay']))) $model->birthday = $data['birthYear']."-".$data['birthMonth']."-".$data['birthDay'];
                if(empty($model->avatar) && !empty($data['photoURL'])){
                    $img_name = $model->id."bisyor_uz.jpg";
//                    $ftp_path = $dir.$img_name;
//                    $ret = ftp_nb_put($conn_id, $ftp_path, $data['photoURL'], FTP_BINARY);
//                    while ($ret == FTP_MOREDATA) {
//                        $ret = ftp_nb_continue($conn_id);
//                    }
//                    if($ret != FTP_FINISHED){
//                        fwrite(\STDOUT, " При загрузке файла произошла ошибка...\n");
//                    }else{
//                        fwrite(\STDOUT, "Avatar ".$img_name."  successfully uploaded\n");
//                    }
                    $model->avatar = $img_name;
                }
               if($model->save())
                fwrite(\STDOUT, "Success updated profile ".$model->fio."\n");
            }
        }
        return true;
    }

    /**
     * Rollarga metodlariini biriktirib chiqish
     * @return bool
     */
    public static function AddMethods()
    {
        $methods = array(
            array('role_id' => 7, 'method_id' => 1, 'value' => 1),
            array('role_id' => 7, 'method_id' => 2, 'value' => 1),
            array('role_id' => 7, 'method_id' => 3, 'value' => 1),
            array('role_id' => 7, 'method_id' => 4, 'value' => 1),
            array('role_id' => 7, 'method_id' => 5, 'value' => 1),
            array('role_id' => 7, 'method_id' => 6, 'value' => 1),
            array('role_id' => 7, 'method_id' => 7, 'value' => 1),
            array('role_id' => 7, 'method_id' => 8, 'value' => 1),
            array('role_id' => 7, 'method_id' => 9, 'value' => 1),
            array('role_id' => 7, 'method_id' => 10, 'value' => 1),
            array('role_id' => 7, 'method_id' => 11, 'value' => 1),
            array('role_id' => 7, 'method_id' => 12, 'value' => 1),
            array('role_id' => 7, 'method_id' => 13, 'value' => 1),
            array('role_id' => 7, 'method_id' => 14, 'value' => 1),
            array('role_id' => 7, 'method_id' => 15, 'value' => 1),
            array('role_id' => 7, 'method_id' => 16, 'value' => 1),
            array('role_id' => 7, 'method_id' => 17, 'value' => 1),
            array('role_id' => 7, 'method_id' => 18, 'value' => 1),
            array('role_id' => 7, 'method_id' => 19, 'value' => 1),
            array('role_id' => 7, 'method_id' => 20, 'value' => 1),
            array('role_id' => 7, 'method_id' => 21, 'value' => 1),
            array('role_id' => 7, 'method_id' => 22, 'value' => 1),
            array('role_id' => 7, 'method_id' => 23, 'value' => 1),
            array('role_id' => 7, 'method_id' => 24, 'value' => 1),
            array('role_id' => 7, 'method_id' => 25, 'value' => 1),
            array('role_id' => 7, 'method_id' => 26, 'value' => 1),
            array('role_id' => 7, 'method_id' => 27, 'value' => 1),
            array('role_id' => 7, 'method_id' => 28, 'value' => 1),
            array('role_id' => 7, 'method_id' => 29, 'value' => 1),
            array('role_id' => 7, 'method_id' => 30, 'value' => 1),
            array('role_id' => 7, 'method_id' => 31, 'value' => 1),
            array('role_id' => 7, 'method_id' => 32, 'value' => 1),
            array('role_id' => 7, 'method_id' => 33, 'value' => 1),
            array('role_id' => 7, 'method_id' => 34, 'value' => 1),
            array('role_id' => 7, 'method_id' => 35, 'value' => 1),
            array('role_id' => 7, 'method_id' => 36, 'value' => 1),
            array('role_id' => 7, 'method_id' => 37, 'value' => 1),
            array('role_id' => 7, 'method_id' => 38, 'value' => 1),
            array('role_id' => 7, 'method_id' => 39, 'value' => 1),
            array('role_id' => 7, 'method_id' => 40, 'value' => 1),
            array('role_id' => 7, 'method_id' => 41, 'value' => 1),
            array('role_id' => 7, 'method_id' => 42, 'value' => 1),
            array('role_id' => 7, 'method_id' => 43, 'value' => 1),
            array('role_id' => 7, 'method_id' => 44, 'value' => 1),
            array('role_id' => 7, 'method_id' => 45, 'value' => 1),
            array('role_id' => 7, 'method_id' => 46, 'value' => 1),
            array('role_id' => 7, 'method_id' => 47, 'value' => 1),
            array('role_id' => 7, 'method_id' => 48, 'value' => 1),
            array('role_id' => 7, 'method_id' => 49, 'value' => 1),
            array('role_id' => 7, 'method_id' => 50, 'value' => 1),
            array('role_id' => 7, 'method_id' => 51, 'value' => 1),
            array('role_id' => 7, 'method_id' => 52, 'value' => 1),
            array('role_id' => 7, 'method_id' => 53, 'value' => 1),
            array('role_id' => 7, 'method_id' => 54, 'value' => 1),
            array('role_id' => 7, 'method_id' => 55, 'value' => 1),
            array('role_id' => 7, 'method_id' => 56, 'value' => 1),
            array('role_id' => 7, 'method_id' => 57, 'value' => 1),
            array('role_id' => 7, 'method_id' => 58, 'value' => 1),
            array('role_id' => 7, 'method_id' => 59, 'value' => 1),
            array('role_id' => 7, 'method_id' => 60, 'value' => 1),
            array('role_id' => 7, 'method_id' => 61, 'value' => 1),
            array('role_id' => 7, 'method_id' => 62, 'value' => 1),
            array('role_id' => 7, 'method_id' => 63, 'value' => 1),
            array('role_id' => 7, 'method_id' => 64, 'value' => 1),
            array('role_id' => 7, 'method_id' => 65, 'value' => 1),
            array('role_id' => 7, 'method_id' => 66, 'value' => 1),
            array('role_id' => 7, 'method_id' => 67, 'value' => 1),
            array('role_id' => 7, 'method_id' => 68, 'value' => 1),
            array('role_id' => 7, 'method_id' => 69, 'value' => 1),
            array('role_id' => 7, 'method_id' => 70, 'value' => 1),
            array('role_id' => 7, 'method_id' => 71, 'value' => 1),
            array('role_id' => 7, 'method_id' => 72, 'value' => 1),
            array('role_id' => 7, 'method_id' => 73, 'value' => 1),
            array('role_id' => 7, 'method_id' => 74, 'value' => 1),
            array('role_id' => 7, 'method_id' => 75, 'value' => 1),
            array('role_id' => 7, 'method_id' => 76, 'value' => 1),
            array('role_id' => 7, 'method_id' => 77, 'value' => 1),
            array('role_id' => 7, 'method_id' => 78, 'value' => 1),
            array('role_id' => 7, 'method_id' => 79, 'value' => 1),
            array('role_id' => 7, 'method_id' => 80, 'value' => 1),
            array('role_id' => 7, 'method_id' => 81, 'value' => 1),
            array('role_id' => 7, 'method_id' => 82, 'value' => 1),
            array('role_id' => 7, 'method_id' => 83, 'value' => 1),
            array('role_id' => 23, 'method_id' => 1, 'value' => 1),
            array('role_id' => 23, 'method_id' => 2, 'value' => 1),
            array('role_id' => 23, 'method_id' => 3, 'value' => 1),
            array('role_id' => 23, 'method_id' => 4, 'value' => 0),
            array('role_id' => 23, 'method_id' => 5, 'value' => 0),
            array('role_id' => 23, 'method_id' => 6, 'value' => 0),
            array('role_id' => 23, 'method_id' => 7, 'value' => 1),
            array('role_id' => 23, 'method_id' => 8, 'value' => 1),
            array('role_id' => 23, 'method_id' => 9, 'value' => 1),
            array('role_id' => 23, 'method_id' => 10, 'value' => 1),
            array('role_id' => 23, 'method_id' => 11, 'value' => 1),
            array('role_id' => 23, 'method_id' => 12, 'value' => 1),
            array('role_id' => 23, 'method_id' => 13, 'value' => 1),
            array('role_id' => 23, 'method_id' => 14, 'value' => 1),
            array('role_id' => 23, 'method_id' => 15, 'value' => 1),
            array('role_id' => 23, 'method_id' => 16, 'value' => 1),
            array('role_id' => 23, 'method_id' => 17, 'value' => 1),
            array('role_id' => 23, 'method_id' => 18, 'value' => 1),
            array('role_id' => 23, 'method_id' => 19, 'value' => 1),
            array('role_id' => 23, 'method_id' => 20, 'value' => 1),
            array('role_id' => 23, 'method_id' => 21, 'value' => 1),
            array('role_id' => 23, 'method_id' => 22, 'value' => 1),
            array('role_id' => 23, 'method_id' => 23, 'value' => 1),
            array('role_id' => 23, 'method_id' => 24, 'value' => 1),
            array('role_id' => 23, 'method_id' => 25, 'value' => 1),
            array('role_id' => 23, 'method_id' => 26, 'value' => 1),
            array('role_id' => 23, 'method_id' => 27, 'value' => 1),
            array('role_id' => 23, 'method_id' => 28, 'value' => 1),
            array('role_id' => 23, 'method_id' => 29, 'value' => 1),
            array('role_id' => 23, 'method_id' => 30, 'value' => 1),
            array('role_id' => 23, 'method_id' => 31, 'value' => 1),
            array('role_id' => 23, 'method_id' => 32, 'value' => 1),
            array('role_id' => 23, 'method_id' => 33, 'value' => 1),
            array('role_id' => 23, 'method_id' => 34, 'value' => 1),
            array('role_id' => 23, 'method_id' => 35, 'value' => 1),
            array('role_id' => 23, 'method_id' => 36, 'value' => 1),
            array('role_id' => 23, 'method_id' => 37, 'value' => 1),
            array('role_id' => 23, 'method_id' => 38, 'value' => 1),
            array('role_id' => 23, 'method_id' => 39, 'value' => 1),
            array('role_id' => 23, 'method_id' => 40, 'value' => 1),
            array('role_id' => 23, 'method_id' => 41, 'value' => 1),
            array('role_id' => 23, 'method_id' => 42, 'value' => 1),
            array('role_id' => 23, 'method_id' => 43, 'value' => 1),
            array('role_id' => 23, 'method_id' => 44, 'value' => 1),
            array('role_id' => 23, 'method_id' => 45, 'value' => 1),
            array('role_id' => 23, 'method_id' => 46, 'value' => 1),
            array('role_id' => 23, 'method_id' => 47, 'value' => 1),
            array('role_id' => 23, 'method_id' => 48, 'value' => 1),
            array('role_id' => 23, 'method_id' => 49, 'value' => 1),
            array('role_id' => 23, 'method_id' => 50, 'value' => 1),
            array('role_id' => 23, 'method_id' => 51, 'value' => 1),
            array('role_id' => 23, 'method_id' => 52, 'value' => 1),
            array('role_id' => 23, 'method_id' => 53, 'value' => 1),
            array('role_id' => 23, 'method_id' => 54, 'value' => 1),
            array('role_id' => 23, 'method_id' => 55, 'value' => 1),
            array('role_id' => 23, 'method_id' => 56, 'value' => 1),
            array('role_id' => 23, 'method_id' => 57, 'value' => 1),
            array('role_id' => 23, 'method_id' => 58, 'value' => 1),
            array('role_id' => 23, 'method_id' => 59, 'value' => 1),
            array('role_id' => 23, 'method_id' => 60, 'value' => 1),
            array('role_id' => 23, 'method_id' => 61, 'value' => 1),
            array('role_id' => 23, 'method_id' => 62, 'value' => 1),
            array('role_id' => 23, 'method_id' => 63, 'value' => 1),
            array('role_id' => 23, 'method_id' => 64, 'value' => 1),
            array('role_id' => 23, 'method_id' => 65, 'value' => 0),
            array('role_id' => 23, 'method_id' => 66, 'value' => 1),
            array('role_id' => 23, 'method_id' => 67, 'value' => 0),
            array('role_id' => 23, 'method_id' => 68, 'value' => 0),
            array('role_id' => 23, 'method_id' => 69, 'value' => 1),
            array('role_id' => 23, 'method_id' => 70, 'value' => 1),
            array('role_id' => 23, 'method_id' => 71, 'value' => 1),
            array('role_id' => 23, 'method_id' => 72, 'value' => 1),
            array('role_id' => 23, 'method_id' => 73, 'value' => 1),
            array('role_id' => 23, 'method_id' => 74, 'value' => 1),
            array('role_id' => 23, 'method_id' => 75, 'value' => 1),
            array('role_id' => 23, 'method_id' => 76, 'value' => 1),
            array('role_id' => 23, 'method_id' => 77, 'value' => 1),
            array('role_id' => 23, 'method_id' => 78, 'value' => 1),
            array('role_id' => 23, 'method_id' => 79, 'value' => 1),
            array('role_id' => 23, 'method_id' => 80, 'value' => 1),
            array('role_id' => 23, 'method_id' => 81, 'value' => 1),
            array('role_id' => 23, 'method_id' => 82, 'value' => 1),
            array('role_id' => 23, 'method_id' => 83, 'value' => 1),
            array('role_id' => 24, 'method_id' => 1, 'value' => 0),
            array('role_id' => 24, 'method_id' => 2, 'value' => 0),
            array('role_id' => 24, 'method_id' => 3, 'value' => 1),
            array('role_id' => 24, 'method_id' => 4, 'value' => 0),
            array('role_id' => 24, 'method_id' => 5, 'value' => 0),
            array('role_id' => 24, 'method_id' => 6, 'value' => 0),
            array('role_id' => 24, 'method_id' => 7, 'value' => 0),
            array('role_id' => 24, 'method_id' => 8, 'value' => 0),
            array('role_id' => 24, 'method_id' => 9, 'value' => 0),
            array('role_id' => 24, 'method_id' => 10, 'value' => 0),
            array('role_id' => 24, 'method_id' => 11, 'value' => 0),
            array('role_id' => 24, 'method_id' => 12, 'value' => 0),
            array('role_id' => 24, 'method_id' => 13, 'value' => 0),
            array('role_id' => 24, 'method_id' => 14, 'value' => 0),
            array('role_id' => 24, 'method_id' => 15, 'value' => 0),
            array('role_id' => 24, 'method_id' => 16, 'value' => 0),
            array('role_id' => 24, 'method_id' => 17, 'value' => 0),
            array('role_id' => 24, 'method_id' => 18, 'value' => 0),
            array('role_id' => 24, 'method_id' => 19, 'value' => 0),
            array('role_id' => 24, 'method_id' => 20, 'value' => 0),
            array('role_id' => 24, 'method_id' => 21, 'value' => 0),
            array('role_id' => 24, 'method_id' => 22, 'value' => 0),
            array('role_id' => 24, 'method_id' => 23, 'value' => 0),
            array('role_id' => 24, 'method_id' => 24, 'value' => 0),
            array('role_id' => 24, 'method_id' => 25, 'value' => 0),
            array('role_id' => 24, 'method_id' => 26, 'value' => 0),
            array('role_id' => 24, 'method_id' => 27, 'value' => 1),
            array('role_id' => 24, 'method_id' => 28, 'value' => 1),
            array('role_id' => 24, 'method_id' => 29, 'value' => 1),
            array('role_id' => 24, 'method_id' => 30, 'value' => 1),
            array('role_id' => 24, 'method_id' => 31, 'value' => 1),
            array('role_id' => 24, 'method_id' => 32, 'value' => 1),
            array('role_id' => 24, 'method_id' => 33, 'value' => 1),
            array('role_id' => 24, 'method_id' => 34, 'value' => 1),
            array('role_id' => 24, 'method_id' => 35, 'value' => 1),
            array('role_id' => 24, 'method_id' => 36, 'value' => 1),
            array('role_id' => 24, 'method_id' => 37, 'value' => 1),
            array('role_id' => 24, 'method_id' => 38, 'value' => 1),
            array('role_id' => 24, 'method_id' => 39, 'value' => 0),
            array('role_id' => 24, 'method_id' => 40, 'value' => 0),
            array('role_id' => 24, 'method_id' => 41, 'value' => 0),
            array('role_id' => 24, 'method_id' => 42, 'value' => 0),
            array('role_id' => 24, 'method_id' => 43, 'value' => 0),
            array('role_id' => 24, 'method_id' => 44, 'value' => 0),
            array('role_id' => 24, 'method_id' => 45, 'value' => 0),
            array('role_id' => 24, 'method_id' => 46, 'value' => 0),
            array('role_id' => 24, 'method_id' => 47, 'value' => 0),
            array('role_id' => 24, 'method_id' => 48, 'value' => 0),
            array('role_id' => 24, 'method_id' => 49, 'value' => 0),
            array('role_id' => 24, 'method_id' => 50, 'value' => 0),
            array('role_id' => 24, 'method_id' => 51, 'value' => 0),
            array('role_id' => 24, 'method_id' => 52, 'value' => 0),
            array('role_id' => 24, 'method_id' => 53, 'value' => 0),
            array('role_id' => 24, 'method_id' => 54, 'value' => 1),
            array('role_id' => 24, 'method_id' => 55, 'value' => 0),
            array('role_id' => 24, 'method_id' => 56, 'value' => 0),
            array('role_id' => 24, 'method_id' => 57, 'value' => 0),
            array('role_id' => 24, 'method_id' => 58, 'value' => 0),
            array('role_id' => 24, 'method_id' => 59, 'value' => 0),
            array('role_id' => 24, 'method_id' => 60, 'value' => 0),
            array('role_id' => 24, 'method_id' => 61, 'value' => 0),
            array('role_id' => 24, 'method_id' => 62, 'value' => 0),
            array('role_id' => 24, 'method_id' => 63, 'value' => 0),
            array('role_id' => 24, 'method_id' => 64, 'value' => 0),
            array('role_id' => 24, 'method_id' => 65, 'value' => 0),
            array('role_id' => 24, 'method_id' => 66, 'value' => 0),
            array('role_id' => 24, 'method_id' => 67, 'value' => 0),
            array('role_id' => 24, 'method_id' => 68, 'value' => 0),
            array('role_id' => 24, 'method_id' => 69, 'value' => 0),
            array('role_id' => 24, 'method_id' => 70, 'value' => 0),
            array('role_id' => 24, 'method_id' => 71, 'value' => 0),
            array('role_id' => 24, 'method_id' => 72, 'value' => 1),
            array('role_id' => 24, 'method_id' => 73, 'value' => 0),
            array('role_id' => 24, 'method_id' => 74, 'value' => 0),
            array('role_id' => 24, 'method_id' => 75, 'value' => 0),
            array('role_id' => 24, 'method_id' => 76, 'value' => 0),
            array('role_id' => 24, 'method_id' => 77, 'value' => 0),
            array('role_id' => 24, 'method_id' => 78, 'value' => 0),
            array('role_id' => 24, 'method_id' => 79, 'value' => 0),
            array('role_id' => 24, 'method_id' => 80, 'value' => 0),
            array('role_id' => 24, 'method_id' => 81, 'value' => 0),
            array('role_id' => 24, 'method_id' => 82, 'value' => 0),
            array('role_id' => 24, 'method_id' => 83, 'value' => 0),
            array('role_id' => 17, 'method_id' => 1, 'value' => 0),
            array('role_id' => 17, 'method_id' => 2, 'value' => 0),
            array('role_id' => 17, 'method_id' => 3, 'value' => 0),
            array('role_id' => 17, 'method_id' => 4, 'value' => 0),
            array('role_id' => 17, 'method_id' => 5, 'value' => 0),
            array('role_id' => 17, 'method_id' => 6, 'value' => 0),
            array('role_id' => 17, 'method_id' => 7, 'value' => 0),
            array('role_id' => 17, 'method_id' => 8, 'value' => 0),
            array('role_id' => 17, 'method_id' => 9, 'value' => 0),
            array('role_id' => 17, 'method_id' => 10, 'value' => 0),
            array('role_id' => 17, 'method_id' => 11, 'value' => 0),
            array('role_id' => 17, 'method_id' => 12, 'value' => 0),
            array('role_id' => 17, 'method_id' => 13, 'value' => 0),
            array('role_id' => 17, 'method_id' => 14, 'value' => 0),
            array('role_id' => 17, 'method_id' => 15, 'value' => 0),
            array('role_id' => 17, 'method_id' => 16, 'value' => 0),
            array('role_id' => 17, 'method_id' => 17, 'value' => 0),
            array('role_id' => 17, 'method_id' => 18, 'value' => 0),
            array('role_id' => 17, 'method_id' => 19, 'value' => 0),
            array('role_id' => 17, 'method_id' => 20, 'value' => 0),
            array('role_id' => 17, 'method_id' => 21, 'value' => 0),
            array('role_id' => 17, 'method_id' => 22, 'value' => 0),
            array('role_id' => 17, 'method_id' => 23, 'value' => 0),
            array('role_id' => 17, 'method_id' => 24, 'value' => 0),
            array('role_id' => 17, 'method_id' => 25, 'value' => 0),
            array('role_id' => 17, 'method_id' => 26, 'value' => 0),
            array('role_id' => 17, 'method_id' => 27, 'value' => 0),
            array('role_id' => 17, 'method_id' => 28, 'value' => 0),
            array('role_id' => 17, 'method_id' => 29, 'value' => 0),
            array('role_id' => 17, 'method_id' => 30, 'value' => 0),
            array('role_id' => 17, 'method_id' => 31, 'value' => 0),
            array('role_id' => 17, 'method_id' => 32, 'value' => 0),
            array('role_id' => 17, 'method_id' => 33, 'value' => 0),
            array('role_id' => 17, 'method_id' => 34, 'value' => 0),
            array('role_id' => 17, 'method_id' => 35, 'value' => 0),
            array('role_id' => 17, 'method_id' => 36, 'value' => 0),
            array('role_id' => 17, 'method_id' => 37, 'value' => 0),
            array('role_id' => 17, 'method_id' => 38, 'value' => 0),
            array('role_id' => 17, 'method_id' => 39, 'value' => 0),
            array('role_id' => 17, 'method_id' => 40, 'value' => 0),
            array('role_id' => 17, 'method_id' => 41, 'value' => 0),
            array('role_id' => 17, 'method_id' => 42, 'value' => 0),
            array('role_id' => 17, 'method_id' => 43, 'value' => 0),
            array('role_id' => 17, 'method_id' => 44, 'value' => 0),
            array('role_id' => 17, 'method_id' => 45, 'value' => 0),
            array('role_id' => 17, 'method_id' => 46, 'value' => 0),
            array('role_id' => 17, 'method_id' => 47, 'value' => 0),
            array('role_id' => 17, 'method_id' => 48, 'value' => 0),
            array('role_id' => 17, 'method_id' => 49, 'value' => 0),
            array('role_id' => 17, 'method_id' => 50, 'value' => 0),
            array('role_id' => 17, 'method_id' => 51, 'value' => 0),
            array('role_id' => 17, 'method_id' => 52, 'value' => 0),
            array('role_id' => 17, 'method_id' => 53, 'value' => 0),
            array('role_id' => 17, 'method_id' => 54, 'value' => 0),
            array('role_id' => 17, 'method_id' => 55, 'value' => 0),
            array('role_id' => 17, 'method_id' => 56, 'value' => 0),
            array('role_id' => 17, 'method_id' => 57, 'value' => 0),
            array('role_id' => 17, 'method_id' => 58, 'value' => 0),
            array('role_id' => 17, 'method_id' => 59, 'value' => 0),
            array('role_id' => 17, 'method_id' => 60, 'value' => 0),
            array('role_id' => 17, 'method_id' => 61, 'value' => 0),
            array('role_id' => 17, 'method_id' => 62, 'value' => 0),
            array('role_id' => 17, 'method_id' => 63, 'value' => 0),
            array('role_id' => 17, 'method_id' => 64, 'value' => 0),
            array('role_id' => 17, 'method_id' => 65, 'value' => 0),
            array('role_id' => 17, 'method_id' => 66, 'value' => 1),
            array('role_id' => 17, 'method_id' => 67, 'value' => 0),
            array('role_id' => 17, 'method_id' => 68, 'value' => 1),
            array('role_id' => 17, 'method_id' => 69, 'value' => 1),
            array('role_id' => 17, 'method_id' => 70, 'value' => 0),
            array('role_id' => 17, 'method_id' => 71, 'value' => 0),
            array('role_id' => 17, 'method_id' => 72, 'value' => 0),
            array('role_id' => 17, 'method_id' => 73, 'value' => 0),
            array('role_id' => 17, 'method_id' => 74, 'value' => 0),
            array('role_id' => 17, 'method_id' => 75, 'value' => 0),
            array('role_id' => 17, 'method_id' => 76, 'value' => 0),
            array('role_id' => 17, 'method_id' => 77, 'value' => 0),
            array('role_id' => 17, 'method_id' => 78, 'value' => 0),
            array('role_id' => 17, 'method_id' => 79, 'value' => 0),
            array('role_id' => 17, 'method_id' => 80, 'value' => 0),
            array('role_id' => 17, 'method_id' => 81, 'value' => 0),
            array('role_id' => 17, 'method_id' => 82, 'value' => 0),
            array('role_id' => 17, 'method_id' => 83, 'value' => 0),
        );
        $migration = new Migration();
        foreach ($methods as $value) $migration->insert('role_methods', $value);
        return true;
    }

    /**
     * Bloglarni categoriyalarini ko'chirib chiqish uchun funksiya
     */
    public static function copyCat()
    {
        $query = "SELECT * FROM bff_blog_categories c LEFT JOIN bff_blog_categories_lang l ON c.id = l.id";
        $category = Yii::$app->dbmy->createCommand($query)->queryAll();
        $migration = new Migration();
        foreach($category as $value){
            if($value['lang'] == 'ru') $migration->insert('blog_categories', ['id' => $value['id'], 'name' => $value['title'], 'key' => $value['keyword'],
                'sorting' => $value['numlevel'], 'date_cr' => $value['created'], 'enabled' => $value['enabled']]);
            if($value['lang'] == 'en') $migration->insert('translates', ['table_name' => 'blog_categories', 'field_id' => $value['id'], 'field_name' => 'name',
                'field_value' => $value['title'], 'language_code' => 'en']);
            if($value['lang'] == 'uz') $migration->insert('translates', ['table_name' => 'blog_categories', 'field_id' => $value['id'], 'field_name' => 'name',
                'field_value' => $value['title'], 'language_code' => 'uz']);
        }
        return true;
    }

    /**
     * Boglarga yozilagn kommentlarni ko'chirish uchun.
     */
    public static function copyComment()
    {
        $base  = self::takeBase('bff_blog_comments');
        $migration = new Migration();
        if(!empty($base)){
            foreach($base as $value){
                $model = Chats::find()->where(['field_id' => $value['item_id'], 'type' => 3])->one();
                if(empty($model)){
                    $migration->insert('chats', ['name' => '#blogs_'.$value['user_id'],
                        'date_cr' => date("Y-m-d H:i:s"), 'status' =>1, 'type' => 3,
                        'field_id' => $value['item_id']]);
                    $model = Chats::find()->where(['field_id' => $value['item_id'], 'type' => 3])->one();
                }
                $migration->insert('chat_users', ['chat_id' => $model->id, 'user_id' => $value['user_id'], 'date_cr' => date("Y-m-d H:i:s")]);
                $migration->insert('chat_message', ['chat_id' => $model->id, 'user_id' => $value['user_id'],
                    'message' => $value['message'], 'date_cr' => date('Y-m-d H:i:s'), 'is_read' => false]);
            }
        }
        return true;
    }

    /**
     * Bloglar postlarini ko'chiradi
     * @return bool
     * @throws \yii\db\Exception
     */
    public static function copyBlogPosts()
    {
        $base = Yii::$app->dbmy->createCommand("SELECT * FROM bff_blog_posts p LEFT JOIN bff_blog_posts_lang l ON p.id = l.id WHERE l.lang='ru'")
            ->queryAll();
        $migration = new Migration();
        foreach ($base as $value){
            $migration->insert('blog_posts', ['id' => $value['id'], 'blog_categories_id' => $value['cat_id'], 'title' => $value['title'],
                'slug' => preg_replace('/(\/\/{sitehost}\/blog\/)/', '', $value['link']), 'image' => $value['preview'],
                'status' => $value['enabled'], 'short_text' => strip_tags($value['textshort']), 'text' => parent::post($value['content'], $value['id']),
                'date_cr' => $value['created'], 'view_count' => $value['fav'], 'user_id' => $value['user_id']]);
        }
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql'){
            Yii::$app->db->createCommand("SELECT setval('blog_posts_id_seq', (SELECT MAX(id) FROM blog_posts))")->execute();
        }
        return true;
    }

    /**
     * Postlarga qo'yilgan likelarni ko'chiradi
     */
    public static function copyPostLikes(){
        $base = self::takeBase('bff_blog_posts_likes');
        $migrateion = new Migration();
        if(!empty($base)){
            foreach ($base as $value){
                if($value['user_id'] != 0){
                    $migrateion->insert('blogs_posts_likes', ['blog_posts_id' => $value['post_id'], 'type' => $value['type'], 'user_id' => $value['user_id']]);
                }
            }
        }

    }

    /**
     * Bloglar taglarini ko'chiradi
     * @return bool
     */
    public static  function copyBlogTags(){
        $base = self::takeBase('bff_blog_tags');
        $mig = new Migration();
        if(!empty($base)){
            foreach ($base as $item) {
                $mig->insert('blog_tags', ['name' => $item['tag']]);
            }
        }
        return true;
    }

    /**
     * Postlarga biriktirlgan taglarni ko'chiradi
     * @return bool
     */
    public static  function copyPostTags(){
        $base = self::takeBase('bff_blog_posts_tags');
        $mig = new Migration();
        if(!empty($base)){
            foreach ($base as $item) {
                $mig->insert('blog_post_tags', ['blog_posts_id' => $item['post_id'], 'tag_id' => $item['tag_id']]);
            }
        }
        return true;
    }

    /** Bannerslarni ko'chirish uchun
     * @return bool
     */
    public static  function copyBanners(){
        $base = self::takeBase('bff_banners_pos');
        $mig = new Migration();
        if(!empty($base)){
            foreach ($base as $value) {
                $mig->insert('banners', ['keyword' => $value['keyword'], 'title' => $value['title'], 'enabled' => $value['enabled'],
                    'width' => $value['width'], 'height' => $value['height'], 'filter_auth_users' => $value['filter_auth_users']]);
            }
        }
        return true;
    }

    /**
     * Bannerlarni ko'chirish
     * @return bool
     * @throws \yii\db\Exception
     */
    public static function copyBannersItems(){
        $base = self::takeBase('bff_banners');
        if(!empty($base)){
            if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql'){
                foreach ($base as $value) {
                    $sql_insert = "INSERT INTO banners_items (id, banner_id, type, type_data, locale, url_match_exact, show_start, show_finish, show_limit, date_cr, sorting_number, enabled, target_blank, time";
                    $type_data = str_replace("'", "''", $value['type_data']);
                    $target_blank = $value['target_blank'] == 0 ? 'f' : 't';
                    $sql_value = "VALUES ('{$value['id']}', '{$value['pos']}', '{$value['type']}', '{$type_data}', '{$value['locale']}', '{$value['url_match_exact']}',
                '{$value['show_start']}', '{$value['show_finish']}', '{$value['show_limit']}', '{$value['created']}', '{$value['num']}', '{$value['enabled']}', '{$target_blank}', '5'";
                    if(!empty($value['img'])){
                        $sql_insert .= ", img";
                        $sql_value .= ", '{$value['img']}'";
                    }
                    if(!empty($value['sitemap_id'])){
                        $sql_insert .= ", sitemap_id";
                        $sql_value .= ", '{$value['sitemap_id']}'";
                    }
                    if(!empty($value['url_match'])){
                        $sql_insert .= ", url_match";
                        $sql_value .= ", '{$value['url_match']}'";
                    }
                    if(!empty($value['click_url'])){
                        $sql_insert .= ", click_url";
                        $sql_value .= ", '{$value['click_url']}'";
                    }
                    if(!empty($value['title'])){
                        $sql_insert .= ", title";
                        $sql_value .= ", '{$value['title']}'";
                    }
                    if(!empty($value['description'])){
                        $sql_insert .= ", description";
                        $sql_value .= ", '{$value['description']}'";
                    }
                    if(!empty($value['alt'])){
                        $sql_insert .= ", alt";
                        $sql_value .= ", '{$value['alt']}'";
                    }
                    if(!empty($value['list_pos'])){
                        $sql_insert .= ", list_pos";
                        $sql_value .= ", '{$value['list_pos']}'";
                    }
                    $sql_insert = $sql_insert.") ".$sql_value.")";
                    Yii::$app->db->createCommand($sql_insert)->execute();
                }
            }else{
                foreach ($base as $value) {
                    $sql_insert = "INSERT INTO banners_items (id, banner_id, type, type_data, locale, url_match_exact, show_start, show_finish, show_limit, date_cr, sorting_number, enabled, target_blank, time";
                    $type_data = addslashes($value['type_data']);
                    $sql_value = "VALUES ('{$value['id']}', '{$value['pos']}', '{$value['type']}', '{$type_data}', '{$value['locale']}', '{$value['url_match_exact']}',
                '{$value['show_start']}', '{$value['show_finish']}', '{$value['show_limit']}', '{$value['created']}', '{$value['num']}', '{$value['enabled']}', '{$value['target_blank']}', '5'";
                    if(!empty($value['img'])){
                        $sql_insert .= ", img";
                        $sql_value .= ", '{$value['img']}'";
                    }
                    if(!empty($value['sitemap_id'])){
                        $sql_insert .= ", sitemap_id";
                        $sql_value .= ", '{$value['sitemap_id']}'";
                    }
                    if(!empty($value['url_match'])){
                        $sql_insert .= ", url_match";
                        $sql_value .= ", '{$value['url_match']}'";
                    }
                    if(!empty($value['click_url'])){
                        $sql_insert .= ", click_url";
                        $sql_value .= ", '{$value['click_url']}'";
                    }
                    if(!empty($value['title'])){
                        $sql_insert .= ", title";
                        $sql_value .= ", '{$value['title']}'";
                    }
                    if(!empty($value['description'])){
                        $sql_insert .= ", description";
                        $sql_value .= ", '{$value['description']}'";
                    }
                    if(!empty($value['alt'])){
                        $sql_insert .= ", alt";
                        $sql_value .= ", '{$value['alt']}'";
                    }
                    if(!empty($value['list_pos'])){
                        $sql_insert .= ", list_pos";
                        $sql_value .= ", '{$value['list_pos']}'";
                    }
                    $sql_insert = $sql_insert.") ".$sql_value.")";
                    Yii::$app->db->createCommand($sql_insert)->execute();
                }
            }
            if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql'){
                Yii::$app->db->createCommand("SELECT setval('banners_items_id_seq', (SELECT MAX(id) FROM banners_items))")->execute();
            }
            return true;
        }else{
            return false;
        }
    }

    /**
     * Bannerslar statistikasini ko'chirish
     * @return bool
     */
    public static  function copyBannersStat(){
        $base = Yii::$app->dbmy->createCommand("SELECT banner_id, clicks, shows, period FROM bff_banners_stat s INNER JOIN bff_banners_pos p ON s.banner_id = p.id")
        ->queryAll();
        $mig = new Migration();
        if(!empty($base)){
            foreach ($base as $value) {
                $mig->insert('banners_statistic', ['banner_id' => $value['banner_id'], 'clicks' => $value['clicks'], 'shows' => $value['shows'], 'date' => $value['period']]);
            }
        }
        return true;
    }

    public static function copyShopsAbonament(){
        $base = parent::takeBase("bff_shops_abonements");
        $mig = new Migration();
        if(!empty($base)){
            foreach ($base as $value) {
                $mig->insert('shops_abonements', ['enabled' => $value['enabled'], 'title' => $value['title_ru'], 'is_free' => $value['price_free'], 'price_free_period' => $value['price_free_period'],
                    'ads_count' => $value['items'], 'import' => $value['import'], 'mark' => $value['svc_mark'], 'fix' => $value['svc_fix'], 'num' => $value['num'],
                    'one_time' => $value['one_time'], 'is_default' => $value['is_default']]);
                $mig->insert('translates', ['table_name' => 'shops_abonements', 'field_id' => $value['id'], 'field_name' =>'title', 'field_value' => $value['title_uz'], 'language_code' => 'uz']);
                $price = unserialize($value['price']);
                foreach ($price as $key => $item) {
                    $mig->insert('shops_abonement_period', ['abonement_id' => $value['id'], 'month' => $key, 'price_for_month' => $item/$key, 'total_price' => $item]);
                }
                $discount = unserialize($value['discount']);
                foreach ($discount as $key => $item){
                    $id = Services::find()->where(['keyword' => $key])->one()->id;
                    $mig->insert('tariff_service_discount', ['abonoment_id' => $value['id'], 'service_id' => $id, 'percent' => $item]);
                }
            }
        }
        return true;
    }
    public static function copyShops(){
        $base = Yii::$app->dbmy->createCommand("SELECT * FROM bff_shops b LEFT JOIN bff_shops_lang l ON b.id = l.id WHERE l.lang = 'ru';")->queryAll();
        if(!empty($base)){
            if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql'){
                Yii::$app->db->createCommand("ALTER TABLE shops DISABLE TRIGGER USER;")->execute();
                Yii::$app->db->createCommand("ALTER TABLE shops_tariff DISABLE TRIGGER USER;")->execute();
                foreach ($base as $value) {
                    $name = str_replace("'", "''", $value['title']);
                    $user_id = $value['user_id'];
                    if($value['user_id'] == 0) $user_id = 1;
                $sql_insert = "INSERT INTO shops (id, user_id, keyword, date_cr, date_up, coordinate_x, coordinate_y, status, name, status_changed";
                $sql_value = " VALUES ('{$value['id']}', '{$user_id}', '{$value['keyword']}', '{$value['created']}', '{$value['modified']}',
                 '{$value['addr_lat']}', '{$value['addr_lon']}', '{$value['status']}', '{$name}', '{$value['status_changed']}'";
                if (!empty($value['logo'])){
                    $sql_insert .= ", logo";
                    $sql_value .= ", '{$value['logo']}'";
                }
                if (!empty($value['descr'])){
                    $sql_insert .= ", description";
                    $description = str_replace("'", "''", $value['descr']);
                    $sql_value .= ", '{$description}'";
                }
                if (!empty($value['region_id'])){
                    $district_id = Districts::find()->where(['last_id' => $value['region_id']])->one();
                    if($district_id){
                        $sql_value .= ", '{$district_id->id}'";
                        $sql_insert .= ", district_id";
                    }
                }
                if(!empty($value['addr_addr'])){
                    $sql_insert .= ", address";
                    $address = str_replace("'", "''", $value['addr_addr']);
                    $sql_value .= ", '{$address}'";
                }
                if(!empty($value['phone'])){
                    $sql_insert .= ", phone";
                    $phone  = "+998".substr(preg_replace('/\s+/', '', $value['phone']), -9);
                    $sql_value .= ", '{$phone}'";
                }
                $phones = parent::phones($value);
                if(!empty($phones)){
                    $phones = json_encode($phones);
                    $sql_insert .= ", phones";
                    $sql_value .= ", '{$phones}'";
                }else{
                    $null = '"[]"';
                    $sql_insert .= ", phones";
                    $sql_value .= ", '{$null}'";
                }
                if(!empty($value['site'])){
                    $sql_insert .= ", site";
                    $sql_value .= ", '{$value['site']}'";
                }
                $social = [];
                $contacts = json_decode($value['contacts']);
                if(!empty($contacts)) $social += ['5' => $contacts->telegram];
                $networks= unserialize($value['social']);
                if(!empty($networks)){
                    foreach ($networks as $item){
                        if($item['t'] == 1)
                        $social += [$item['t'] => $item['v']];
                        if($item['t'] == 2)
                            $social += ['3' => $item['v']];
                        if($item['t'] == 4){
                            if(strpos($item['v'], 'ok.ru'))
                                $social += [$item['t'] => $item['v']];
                            else $social += ['5' => $item['v']];
                        }
                        if($item['t'] == 8)
                            $social += ['6' => $item['v']];
                    }
                }
                if(!empty($social)){
                    $social = json_encode($social, JSON_FORCE_OBJECT);
                    $sql_insert .= ", social_networks";
                    $sql_value .= ", '{$social}'";
                }
               if($value['svc_abonement_expire'] != "0000-00-00 00:00:00"){
                   $sql_tarif = "INSERT INTO shops_tariff  (abonement_id, shop_id, status, data_access, price) VALUES('{$value['svc_abonement_id']}', '{$value['id']}', '1',
                '{$value['svc_abonement_expire']}', 0)";
               }/*else{
                   $sql_tarif = "INSERT INTO shops_tariff  (abonement_id, shop_id, status, price) VALUES('{$value['svc_abonement_id']}', '{$value['id']}', '1', 0)";
               }*/
                $sql_insert = $sql_insert.") ".$sql_value.")";
                    Yii::$app->db->createCommand($sql_insert)->execute();
                    Yii::$app->db->createCommand($sql_tarif)->execute();
                }
                Yii::$app->db->createCommand("ALTER TABLE shops ENABLE TRIGGER USER;")->execute();
                Yii::$app->db->createCommand("ALTER TABLE shops_tariff ENABLE TRIGGER USER;")->execute();
                Yii::$app->db->createCommand("SELECT setval('shops_id_seq', (SELECT MAX(id) FROM shops))")->execute();
            }else{
                Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
                Yii::$app->db->createCommand("ALTER TABLE shops DISABLE KEYS;")->execute();
                Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
                Yii::$app->db->createCommand("ALTER TABLE shops_tariff DISABLE KEYS;")->execute();
                foreach ($base as $value) {
                    $name = addslashes($value['title']);
                    $user_id = $value['user_id'];
                    if($value['user_id'] == 0) $user_id = 1;
                    $sql_insert = "INSERT INTO shops (id, user_id, keyword, date_cr, date_up, coordinate_x, coordinate_y, status, name, status_changed";
                    $sql_value = " VALUES ('{$value['id']}', '{$user_id}', '{$value['keyword']}', '{$value['created']}', '{$value['modified']}',
                     '{$value['addr_lat']}', '{$value['addr_lon']}', '{$value['status']}', '{$name}', '{$value['status_changed']}'";
                    if (!empty($value['logo'])){
                        $sql_insert .= ", logo";
                        $sql_value .= ", '{$value['logo']}'";
                    }
                    if (!empty($value['descr'])){
                        $sql_insert .= ", description";
                        $description = addslashes($value['descr']);
                        $sql_value .= ", '{$description}'";
                    }
                    if (!empty($value['region_id'])){
                        $district_id = Districts::find()->where(['last_id' => $value['region_id']])->one();
                        if($district_id){
                            $sql_value .= ", '{$district_id->id}'";
                            $sql_insert .= ", district_id";
                        }
                    }
                    if(!empty($value['addr_addr'])){
                        $sql_insert .= ", address";
                        $address = addslashes($value['addr_addr']);
                        $sql_value .= ", '{$address}'";
                    }
                    if(!empty($value['phone'])){
                        $sql_insert .= ", phone";
                        $phone  = "+998".substr(preg_replace('/\s+/', '', $value['phone']), -9);
                        $sql_value .= ", '{$phone}'";
                    }
                    $phones = parent::phones($value);
                    if(!empty($phones)){
                        $phones = json_encode($phones);
                        $sql_insert .= ", phones";
                        $sql_value .= ", '{$phones}'";
                    }else{
                        $null = '"[]"';
                        $sql_insert .= ", phones";
                        $sql_value .= ", '{$null}'";
                    }
                    if(!empty($value['site'])){
                        $sql_insert .= ", site";
                        $sql_value .= ", '{$value['site']}'";
                    }
                    $social = [];
                    $contacts = json_decode($value['contacts']);
                    if(!empty($contacts)) $social[] = $contacts->telegram;
                    $networks= unserialize($value['social']);
                    if(!empty($networks)){
                        foreach ($networks as $item){
                            if($item['t'] == 1)
                                $social += [$item['t'] => $item['v']];
                            if($item['t'] == 2)
                                $social += ['3' => $item['v']];
                            if($item['t'] == 4){
                                if(strpos($item['v'], 'ok.ru'))
                                    $social += [$item['t'] => $item['v']];
                                else $social += ['5' => $item['v']];
                            }
                            if($item['t'] == 8)
                                $social += ['6' => $item['v']];
                        }
                    }
                    if(!empty($social)){
                        $social = json_encode($social, JSON_FORCE_OBJECT);
                        $sql_insert .= ", social_networks";
                        $sql_value .= ", '{$social}'";
                    }
                    if($value['svc_abonement_expire'] != "0000-00-00 00:00:00"){
                        $sql_tarif = "INSERT INTO shops_tariff  (abonement_id, shop_id, status, data_access, price) VALUES('{$value['svc_abonement_id']}', '{$value['id']}', '1',
                    '{$value['svc_abonement_expire']}', 0)";
                        }/*else{
                            $sql_tarif = "INSERT INTO shops_tariff  (abonement_id, shop_id, status, price) VALUES('{$value['svc_abonement_id']}', '{$value['id']}', '1', 0)";
                        }*/
                    $sql_insert = $sql_insert.") ".$sql_value.")";
                    Yii::$app->db->createCommand($sql_insert)->execute();
                    Yii::$app->db->createCommand($sql_tarif)->execute();

                }
                Yii::$app->db->createCommand("ALTER TABLE shops ENABLE KEYS;")->execute();
                Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
                Yii::$app->db->createCommand("ALTER TABLE shops_tariff ENABLE KEYS;")->execute();
                Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
            }

            }
        $cat_in = parent::takeBase('bff_shops_in_categories');
        $mig = new Migration();
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            Yii::$app->db->createCommand("ALTER TABLE shops_sections DISABLE TRIGGER USER;")->execute();
            foreach ($cat_in as $value) {
                $mig->insert('shops_sections', ['id' => $value['id'], 'shop_id' => $value['shop_id'], 'section_id' => $value['category_id']]);
            }
            Yii::$app->db->createCommand("ALTER TABLE shops_sections ENABLE TRIGGER USER;")->execute();
            Yii::$app->db->createCommand("SELECT setval('shops_sections_id_seq', (SELECT MAX(id) FROM shops_sections))")->execute();
        }else{
            Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
            Yii::$app->db->createCommand("ALTER TABLE shops_sections DISABLE KEYS;")->execute();
            foreach ($cat_in as $value) {
                $mig->insert('shops_sections', ['id' => $value['id'], 'shop_id' => $value['shop_id'], 'section_id' => $value['category_id']]);
            }
            // Yii::$app->db->createCommand("ALTER TABLE shops_sections ENABLE USER;")->execute();
            Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
        }
        return true;
    }


    public static function copyCatDyn(){
        $base = parent::takeBase('bff_bbs_categories_dynprops');
        $mig = new Migration();
        foreach ($base as $value) {
            $title = str_replace("'", "''", $value['title_ru']);
            $mig_array = ['id' => $value['id'], 'category_id' => $value['cat_id'], 'title' => $title, 'type' => $value['type'],
                'req' => $value['req'], 'is_cache' => $value['is_cache'], 'extra' => $value['extra'], 'parent' => $value['parent'],
                'parent_value' => $value['parent_value'], 'enabled' => $value['enabled'], 'data_field' => $value['data_field'], 'num' => $value['num'], 'txt' => $value['txt'],
                'in_table' => $value['in_table'], 'search_hidden' => $value['search_hidden'], 'in_search' => $value['is_search'], 'in_seek' => $value['in_seek'], 'num_first' => $value['num_first']];

            if(!empty($value['description_ru'])){
                $mig_array += ['description' => $value['description_ru']];
            }
            if(!empty($value['default_value'])){
                $mig_array += ['default_value' => $value['default_value']];
            }
            if(!empty($value['title_uz'])){
                $mig->insert('translates', ['table_name' => 'categories_dynprops', 'field_id' => $value['id'], 'field_name' => 'title',
                    'field_value' => $value['title_uz'], 'language_code' => 'uz']);
            }
            if(!empty($value['title_en'])){
                $mig->insert('translates', ['table_name' => 'categories_dynprops', 'field_id' => $value['id'], 'field_name' => 'title',
                    'field_value' => $value['title_en'], 'language_code' => 'en']);
            }
            if(!empty($value['description_uz'])){
                $mig->insert('translates', ['table_name' => 'categories_dynprops', 'field_id' => $value['id'], 'field_name' => 'description',
                    'field_value' => $value['description_uz'], 'language_code' => 'uz']);
            }
            if(!empty($value['description_en'])){
                $mig->insert('translates', ['table_name' => 'categories_dynprops', 'field_id' => $value['id'], 'field_name' => 'description',
                    'field_value' => $value['description_en'], 'language_code' => 'en']);
            }
            $mig->insert('categories_dynprops', $mig_array);
        }
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            Yii::$app->db->createCommand("SELECT setval('categories_dynprops_id_seq', (SELECT MAX(id) FROM categories_dynprops))")->execute();
        }

        $cat_multi = parent::takeBase('bff_bbs_categories_dynprops_multi');
        $i = 1;
        $sql = "INSERT INTO categories_dynprops_multi (dynprop_id, name, value, num) VALUES";
        $sql_trans = "INSERT INTO translates (table_name, field_id, field_name, field_value, language_code) VALUES";
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql'){
            foreach ($cat_multi as $item) {
                if($item['name_ru'] != 'Выбрать' && $item['name_ru'] != 'Select') {
                    $name = str_replace("'", "''", $item['name_ru']);
                    $name_uz = str_replace("'", "''", $item['name_uz']);
                    $name_en = str_replace("'", "''", $item['name_en']);
                    $sql .= " ({$item['dynprop_id']}, '{$name}', '{$item['value']}', '{$item['num']}'),";
                    $sql_trans .= " ('categories_dynprops_multi', '{$i}', 'name', '{$name_uz}', 'uz'),";
                    $sql_trans .= " ('categories_dynprops_multi', '{$i}', 'name', '{$name_en}', 'en'),";
                    $i++;
                }
            }
        }else{
            foreach ($cat_multi as $item) {
                if($item['name_ru'] != 'Выбрать' && $item['name_ru'] != 'Select') {
                    $name = addslashes($item['name_ru']);
                    $name_uz = addslashes($item['name_uz']);
                    $name_en = addslashes($item['name_en']);
                    $sql .= " ('{$item['dynprop_id']}', '{$name}', '{$item['value']}', '{$item['num']}'),";
                    $sql_trans .= " ('categories_dynprops_multi', '{$i}', 'name', '{$name_uz}', 'uz'),";
                    $sql_trans .= " ('categories_dynprops_multi', '{$i}', 'name', '{$name_en}', 'en'),";
                    $i++;
                }
            }
        }
        $sql = rtrim($sql, ',').";";
        $sql_trans = rtrim($sql_trans, ',');
        Yii::$app->db->createCommand($sql)->execute();
        Yii::$app->db->createCommand($sql_trans)->execute();
        return true;
    }

    public static function copyPromocod()
    {
        $base = parent::takeBase('bff_promocodes_p031d74');
        $mig = new Migration();
        foreach($base as $value){
            $mig_value = ['id' => $value['id'], 'code' => $value['code'], 'title' => $value['title'], 'type' => $value['type'], 'amount' => $value['amount'],
                'usage_by' => $value['usage_by'], 'discount_type' => $value['discount_type'], 'discount' => $value['discount'], 'usage_for' => $value['usage_for'],
                'active' => $value['active'], 'usage_limit' => $value['usage_limit'], 'is_once' => $value['is_once'], 'break_days' => $value['break_days'],
                'used' => $value['used'], 'created_at' => $value['created_at']];
            if($value['active_from'] != '0000-00-00 00:00:00'){
                $mig_value += ['active_from' => $value['active_from']];
            }
            if($value['active_to'] != '0000-00-00 00:00:00'){
                $mig_value += ['active_from' => $value['active_to']];
            }
            $mig->insert('promocodes', $mig_value);
        }
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            Yii::$app->db->createCommand("SELECT setval('promocodes_id_seq', (SELECT MAX(id) FROM promocodes))")->execute();
        }
        $cat_list = parent::takeBase('bff_promocodes_p031d74_categories');
        $value = Yii::$app->dbmy->createCommand('SELECT promocode_id AS id FROM bff_promocodes_p031d74_categories GROUP BY promocode_id')->queryAll();
        if(!empty($value)){
            foreach ($value as $val){
                $str = "";
                foreach($cat_list as $valall){
                    if($valall['promocode_id'] == $val['id']){
                        $str .= $valall['category_id'].", ";
                    }
                }
                $mig->update('promocodes', ['category_list' => rtrim($str)], ['id' => $val['id']]);
            }
        }

        $cat_list = parent::takeBase('bff_promocodes_p031d74_categories');
        $value = Yii::$app->dbmy->createCommand('SELECT promocode_id AS id FROM bff_promocodes_p031d74_regions GROUP BY promocode_id')->queryAll();
        if(!empty($value)){
            foreach ($value as $val){
                $str = "";
                foreach($cat_list as $valall){
                    if($valall['promocode_id'] == $val['id']){
                        $str .= $valall['region_id'].", ";
                    }
                }
                $mig->update('promocodes', ['regions_list' => rtrim($str)], ['id' => $val['id']]);
            }
        }

        $promo_usage = parent::takeBase('bff_promocodes_p031d74_usage');
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            Yii::$app->db->createCommand("ALTER TABLE promocodes_usage DISABLE TRIGGER USER;")->execute();
            foreach($promo_usage as $value){
                if($value['shop_id'] == 0) {
                    $shop_id = new \yii\db\Expression('null');
                }else{
                    $shop_id = $value['shop_id'];
                }
                if($value['category_id'] == 0) {
                    $category_id = new \yii\db\Expression('null');
                }else{
                    $category_id = $value['category_id'];
                }
                if($value['item_id'] == 0) {
                    $item_id = new \yii\db\Expression('null');
                }else{
                    $item_id = $value['item_id'];
                }
                if($value['promocode_id'] == 0) {
                    $promocode_id = new \yii\db\Expression('null');
                }else{
                    $promocode_id = $value['promocode_id'];
                }
                $mig_usafe = ['id' => $value['id'], 'promocode_id' => $promocode_id, 'user_id' => $value['user_id'], 'category_id' => $category_id,
                    'category_root_id' => $value['category_root_id'], 'item_id' => $item_id, 'shop_id' => $shop_id,
                    'is_active' => $value['is_active'], 'success' => $value['success'], 'used_at' => $value['used_at']];
                if(!empty($value['shop_categories'])) $mig_usafe += ['shop_categories' => json_decode($value['shop_categories'])[0]->cat_id];
                $mig->insert('promocodes_usage', $mig_usafe);

            }
            Yii::$app->db->createCommand("ALTER TABLE promocodes_usage ENABLE TRIGGER USER;")->execute();
            Yii::$app->db->createCommand("SELECT setval('promocodes_usage_id_seq', (SELECT MAX(id) FROM promocodes_usage))")->execute();
        }else{
            Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
            Yii::$app->db->createCommand("ALTER TABLE promocodes_usage DISABLE KEYS;")->execute();
            foreach($promo_usage as $value){
                if($value['shop_id'] == 0) {
                    $shop_id = new \yii\db\Expression('null');
                }else{
                    $shop_id = $value['shop_id'];
                }
                if($value['category_id'] == 0) {
                    $category_id = new \yii\db\Expression('null');
                }else{
                    $category_id = $value['category_id'];
                }
                if($value['item_id'] == 0) {
                    $item_id = new \yii\db\Expression('null');
                }else{
                    $item_id = $value['item_id'];
                }
                if($value['promocode_id'] == 0) {
                    $promocode_id = new \yii\db\Expression('null');
                }else{
                    $promocode_id = $value['promocode_id'];
                }
                $mig_usafe = ['id' => $value['id'], 'promocode_id' => $promocode_id, 'user_id' => $value['user_id'], 'category_id' => $category_id,
                    'category_root_id' => $value['category_root_id'], 'item_id' => $item_id, 'shop_id' => $shop_id,
                    'is_active' => $value['is_active'], 'success' => $value['success'], 'used_at' => $value['used_at']];
                if(!empty($value['shop_categories'])) $mig_usafe += ['shop_categories' => json_decode($value['shop_categories'])[0]->cat_id];
                $mig->insert('promocodes_usage', $mig_usafe);
            }
            Yii::$app->db->createCommand("ALTER TABLE promocodes_usage ENABLE KEYS;")->execute();
            Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
        }
        
        $statistics = parent::takeBase('bff_promocodes_p031d74_statistics');

        foreach ($statistics as $stat){
            $mig_stat = ['prmocode_id' => $stat['promocode_id'], 'active_from' => $stat['active_from'], 'used' => $stat['used']];
            if(!empty($stat['active_to'])) $mig_stat += ['active_to' => $stat['active_to']];
            $mig->insert('promocodes_statistics', $mig_stat);
        }
        return true;
    }
    public static function copyBills(){
        $bills = parent::takeBase('bff_bills');
        $migration = new Migration();
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            Yii::$app->db->createCommand("ALTER TABLE bills DISABLE TRIGGER USER;")->execute();
            foreach ($bills as $bill){
                if($bill['svc_id'] == 0) {
                    $service_id = new \yii\db\Expression('null');
                }else{
                    $service = \backend\models\shops\Shops::findOne($bill['svc_id']);
                    if($service != null) $service_id = $bill['svc_id'];
                    else $service_id = new \yii\db\Expression('null');
                }
                if($bill['currency_id'] == 0) {
                    $currency_id = new \yii\db\Expression('null');
                }else{
                    $currency_id = $bill['currency_id'];
                }
                if($bill['item_id'] == 0) {
                    $item_id = new \yii\db\Expression('null');
                }else{
                    $item = \backend\models\items\Items::findOne($bill['item_id']);
                    if($item != null) $item_id = $bill['item_id'];
                    else{
                        $shop = \backend\models\shops\Shops::findOne($bill['item_id']);
                        if($shop != null) $item_id = $bill['item_id'];
                        else $item_id = new \yii\db\Expression('null');
                    }
                }
                if($bill['promocode_id'] == 0) {
                    $promocode_id = new \yii\db\Expression('null');
                }else{
                    $promocode_id = $bill['promocode_id'];
                }
                if($bill['user_id'] == 0) {
                    $user_id = new \yii\db\Expression('null');
                }else{
                    $user_id = $bill['user_id'];
                }
                $mig_bills = ['user_id' => $user_id, 'user_balance' => $bill['user_balance'], 'service_id' => $service_id,
                    'svc_activate' => $bill['svc_activate'], 'svc_settings' => $bill['svc_settings'], 'item_id' => $item_id,
                    'type' => $bill['type'], 'psystem' => $bill['psystem'], 'amount' => $bill['amount'], 'money' => $bill['money'],
                    'currency_id' => $currency_id, 'date_cr' => $bill['created'],
                    'status' => $bill['status'], 'description' => $bill['description'],
                    'promocode_id' => $promocode_id];
                if($bill['payed'] != '0000-00-00 00:00:00') $mig_bills += ['date_pay' => $bill['payed']];
                if(!empty($bill['ip'])) $mig_bills += ['ip' => $bill['ip']];
                if(!empty($bill['details'])) $mig_bills += ['details' => $bill['details']];
                $migration->insert('bills', $mig_bills);
            }
            Yii::$app->db->createCommand("ALTER TABLE bills ENABLE TRIGGER USER;")->execute();
        }else{
            Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
            Yii::$app->db->createCommand("ALTER TABLE bills DISABLE KEYS;")->execute();
            foreach ($bills as $bill){
                if($bill['svc_id'] == 0) {
                    $service_id = new \yii\db\Expression('null');
                }else{
                    $service = \backend\models\shops\Shops::findOne($bill['svc_id']);
                    if($service != null) $service_id = $bill['svc_id'];
                    else $service_id = new \yii\db\Expression('null');
                }
                if($bill['currency_id'] == 0) {
                    $currency_id = new \yii\db\Expression('null');
                }else{
                    $currency_id = $bill['currency_id'];
                }
                if($bill['item_id'] == 0) {
                    $item_id = new \yii\db\Expression('null');
                }else{
                    $item = \backend\models\items\Items::findOne($bill['item_id']);
                    if($item != null) $item_id = $bill['item_id'];
                    else{
                        $shop = \backend\models\shops\Shops::findOne($bill['item_id']);
                        if($shop != null) $item_id = $bill['item_id'];
                        else $item_id = new \yii\db\Expression('null');
                    }
                }
                if($bill['promocode_id'] == 0) {
                    $promocode_id = new \yii\db\Expression('null');
                }else{
                    $promocode_id = $bill['promocode_id'];
                }
                if($bill['user_id'] == 0) {
                    $user_id = new \yii\db\Expression('null');
                }else{
                    $user_id = $bill['user_id'];
                }
                $mig_bills = ['user_id' => $user_id, 'user_balance' => $bill['user_balance'], 'service_id' => $service_id,
                    'svc_activate' => $bill['svc_activate'], 'svc_settings' => $bill['svc_settings'], 'item_id' => $item_id,
                    'type' => $bill['type'], 'psystem' => $bill['psystem'], 'amount' => $bill['amount'], 'money' => $bill['money'],
                    'currency_id' => $currency_id, 'date_cr' => $bill['created'],
                    'status' => $bill['status'], 'description' => $bill['description'],
                    'promocode_id' => $promocode_id];
                if($bill['payed'] != '0000-00-00 00:00:00') $mig_bills += ['date_pay' => $bill['payed']];
                if(!empty($bill['ip'])) $mig_bills += ['ip' => $bill['ip']];
                if(!empty($bill['details'])) $mig_bills += ['details' => $bill['details']];
                $migration->insert('bills', $mig_bills);
            }
            Yii::$app->db->createCommand("ALTER TABLE bills ENABLE KEYS;")->execute();
            Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
        }
        return true;
    }
    public static function copyItems(){
        $return = true;
        $base = parent::takeBase('bff_bbs_items');
        $insert = "";
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $connection->createCommand("ALTER TABLE items DISABLE TRIGGER USER;")->execute();
                foreach ($base as $value){
                    $link = preg_replace('/(.*\/)/', '', $value['link']);
                    $description = str_replace("'", "''", $value['descr']);
                    $name = str_replace("'", "''", $value['name']);
                    $addr_addr = str_replace("'", "''", $value['addr_addr']);
                    if($value['shop_id'] == 0) {
                        $shop_id = new \yii\db\Expression('null');
                    }else{
                        $shop_id = $value['shop_id'];
                    }
                    if($value['moderated'] == 0) {
                        $moderated_id = new \yii\db\Expression('null');
                    }else{
                        $moderated_id = $value['moderated'];
                    }
                    if($value['price_curr'] == 0) {
                        $currency_id = new \yii\db\Expression('null');
                    }else{
                        $currency_id = $value['price_curr'];
                    }
                    if(empty($connection->createCommand("SELECT * FROM categories WHERE id =".$value['cat_id'].";")->queryAll())){
                        $cat_id = new \yii\db\Expression('null');
                    }else{
                        $cat_id = $value['cat_id'];
                    }
                    $title = str_replace("'", "''", $value['title']);
                    $img_s = preg_replace("/(.*\/)/", "", $value['img_s']);
                    $img_m = preg_replace("/(.*\/)/", "", $value['img_m']);
                    $img_prefix = preg_replace(["/\/\/img1.bisyor.uz\/files\/images\/items\//", "/(\/.*)/"], "", $value['img_s']);
                    $sql = "INSERT INTO items (id, user_id, user_ip, shop_id, is_publicated, is_moderating, status, status_prev, status_changed, deleted, cat_id, cat_type, owner_type, address, svc_up_activate, svc_upauto_on, svc_fixed, svc_premium, svc_press_status, coordinate_x, coordinate_y, title, keyword, lang, img_s, img_m, img_prefix, date_cr, date_up, price, price_search, currency_id, name, phones, publicated_period, moderated_id, f1, f2, f3, f4, f5, f6, f7, f8, f9, f10, f11, f12, f13, f14, f15, price_ex";
                    $sql_val =  "VALUES ('{$value['id']}', '{$value['user_id']}', '{$value['user_ip']}', {$shop_id}, '{$value['is_publicated']}', '{$value['is_moderating']}', '{$value['status']}', '{$value['status_prev']}', '{$value['status_changed']}', '{$value['deleted']}', {$cat_id}, '{$value['cat_type']}', '{$value['owner_type']}', '{$addr_addr}', '{$value['svc_up_activate']}', '{$value['svc_upauto_on']}', '{$value['svc_fixed']}', '{$value['svc_premium']}', '{$value['svc_press_status']}', '{$value['addr_lat']}', '{$value['addr_lon']}', '{$title}', '{$value['keyword']}', '{$value['lang']}', '{$img_s}', '{$img_m}', '{$img_prefix}', '{$value['created']}', '{$value['modified']}', '{$value['price']}', '{$value['price_search']}', {$currency_id}, '{$name}', '{$value['phones']}', '{$value['publicated_period']}', {$moderated_id}, '{$value['f1']}', '{$value['f2']}', '{$value['f3']}', '{$value['f4']}', '{$value['f5']}', '{$value['f6']}', '{$value['f7']}', '{$value['f8']}', '{$value['f9']}', '{$value['f10']}', '{$value['f11']}', '{$value['f12']}', '{$value['f13']}', '{$value['f14']}', '{$value['f15']}', '{$value['price_ex']}'";
                    if (!$value['district_id']) {
                    	$district_id = Districts::find()->where(['last_id' => $value['city_id']])->one();
                    }else{
                    	$district_id = Districts::find()->where(['last_id' => $value['district_id']])->one();
                    }
                    if($district_id) { $sql .= ", district_id"; $sql_val .= ", '{$district_id->id}'";}
                    if($value['svc_up_date'] != "0000-00-00 00:00:00") { $sql .= ", svc_up_date"; $sql_val .= ", '{$value['svc_up_date']}'";}
                    if($value['svc_up_free'] != "0000-00-00") { $sql .= ", svc_up_free"; $sql_val .= ", '{$value['svc_up_free']}'";}
                    if(!empty($value['svc_upauto_sett'])) { $sql .= ", svc_upauto_sett"; $sql_val .= ", '{$value['svc_upauto_sett']}'";}
                    if($value['svc_upauto_next'] != "0000-00-00 00:00:00") { $sql .= ", svc_upauto_next"; $sql_val .= ", '{$value['svc_upauto_next']}'";}
                    if($value['svc_fixed_to'] != "0000-00-00 00:00:00") { $sql .= ", svc_fixed_to"; $sql_val .= ", '{$value['svc_fixed_to']}'";}
                    if($value['svc_fixed_order'] != "0000-00-00 00:00:00") { $sql .= ", svc_fixed_order"; $sql_val .= ", '{$value['svc_fixed_order']}'";}
                    if($value['svc_premium_to'] != "0000-00-00 00:00:00") { $sql .= ", svc_premium_to"; $sql_val .= ", '{$value['svc_premium_to']}'";}
                    if($value['svc_premium_order'] != "0000-00-00 00:00:00") { $sql .= ", svc_premium_order"; $sql_val .= ", '{$value['svc_premium_order']}'";}
                    if($value['svc_marked_to'] != "0000-00-00 00:00:00") { $sql .= ", svc_marked_to"; $sql_val .= ", '{$value['svc_marked_to']}'";}
                    if($value['svc_press_date'] != "0000-00-00") { $sql .= ", svc_press_date"; $sql_val .= ", '{$value['svc_press_date']}'";}
                    if($value['svc_press_date_last'] != "0000-00-00") { $sql .= ", svc_press_date_last"; $sql_val .= ", '{$value['svc_press_date_last']}'";}
                    if($value['svc_quick_to'] != "0000-00-00 00:00:00") { $sql .= ", svc_quick_to"; $sql_val .= ", '{$value['svc_quick_to']}'";}
                    if(!empty($description)) { $sql .= ", description"; $sql_val .= ", '{$description}'";}
                    if(!empty($link)) { $sql .= ", link"; $sql_val .= ", '{$link}'";}
                    if($value['publicated'] != "0000-00-00 00:00:00") { $sql .= ", publicated"; $sql_val .= ", '{$value['publicated']}'";}
                    if($value['publicated_to'] != "0000-00-00 00:00:00") { $sql .= ", publicated_to"; $sql_val .= ", '{$value['publicated_to']}'";}
                    if($value['publicated_order'] != "0000-00-00 00:00:00") { $sql .= ", publicated_order"; $sql_val .= ", '{$value['publicated_order']}'";}
                    if(!empty($value['moderated_data'])) { $sql .= ", moderated_date"; $moderated_data = str_replace("'", "''", $value['moderated_data']); $sql_val .= ", '{$moderated_data}'";}
                    if(!empty($value['blocked_reason'])) { $sql .= ", blocked_reason"; $sql_val .= ", '{$value['blocked_reason']}'";}
                    if(!empty($value['f16'])) { $sql .= ", f16"; $f16 = str_replace("'", "''", $value['f16']); $sql_val .= ", '{$f16}'";}
                    if(!empty($value['f17'])) { $sql .= ", f17"; $f17 = str_replace("'", "''", $value['f17']); $sql_val .= ", '{$f17}'";}
                    if(!empty($value['f18'])) { $sql .= ", f18"; $f18 = str_replace("'", "''", $value['f18']); $sql_val .= ", '{$f18}'";}
                    if(!empty($value['f19'])) { $sql .= ", f19"; $f19 = str_replace("'", "''", $value['f19']); $sql_val .= ", '{$f19}'";}
                    if(!empty($value['f20'])) { $sql .= ", f20"; $f20 = str_replace("'", "''", $value['f20']); $sql_val .= ", '{$f20}'";}
                    if(!empty($value['video'])) { $sql .= ", video"; $video = str_replace("'", "''", $value['video']); $sql_val .= ", '{$video}'";}
                    if(!empty($value['video_embed'])) { $sql .= ", video_embed"; $video_embed = str_replace("'", "''", $value['video_embed']);  $sql_val .= ", '{$video_embed}'";}
                    Yii::$app->db->createCommand($sql.") ".$sql_val.");")->execute();
                }
                $transaction->commit();
            } catch (\Exception $e){
                $transaction->rollBack();
                fwrite(\STDOUT, $e->getMessage());
                $return  = false;
            }
            $connection->createCommand("ALTER TABLE items ENABLE TRIGGER USER;")->execute();
            $connection->createCommand("SELECT setval('items_id_seq', (SELECT MAX(id) FROM items))")->execute();
        }else{
            Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
            Yii::$app->db->createCommand("ALTER TABLE items DISABLE KEYS;")->execute();
            $insert = "";
            $i = 0;
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                foreach ($base as $value){
                    $link = preg_replace('/(.*\/)/', '', $value['link']);
                    $description = addslashes($value['descr']);
                    $name = addslashes($value['name']);
                    $addr_addr = str_replace("'", "''", $value['addr_addr']);
                    $title = addslashes($value['title']);
                    if($value['shop_id'] == 0) {
                        $shop_id = new \yii\db\Expression('null');
                    }else{
                        $shop_id = $value['shop_id'];
                    }
                    if($value['moderated'] == 0) {
                        $moderated_id = new \yii\db\Expression('null');
                    }else{
                        $moderated_id = $value['moderated'];
                    }
                    if($value['price_curr'] == 0) {
                        $currency_id = new \yii\db\Expression('null');
                    }else{
                        $currency_id = $value['price_curr'];
                    }
                    if(empty($connection->createCommand("SELECT * FROM categories WHERE id =".$value['cat_id'].";")->queryAll())){
                        $cat_id = new \yii\db\Expression('null');
                    }else{
                        $cat_id = $value['cat_id'];
                    }
                    $img_s = preg_replace("/(.*\/)/", "", $value['img_s']);
                    $img_m = preg_replace("/(.*\/)/", "", $value['img_m']);
                    $img_prefix = preg_replace(["/\/\/img1.bisyor.uz\/files\/images\/items\//", "/(\/.*)/"], "", $value['img_s']);
                    $sql = "INSERT INTO items (id, user_id, user_ip, shop_id, is_publicated, is_moderating, status, status_prev, status_changed, deleted, cat_id, cat_type,  owner_type, address, svc_up_activate, svc_upauto_on, svc_fixed, svc_premium, svc_press_status, coordinate_x, coordinate_y, title, keyword, lang, img_s, img_m, img_prefix, date_cr, date_up, price, price_search, currency_id, name, phones, publicated_period, moderated_id, f1, f2, f3, f4, f5, f6, f7, f8, f9, f10, f11, f12, f13, f14, f15, price_ex";
                    $sql_val =  "VALUES ('{$value['id']}', '{$value['user_id']}', 
        '{$value['user_ip']}', '{$shop_id}', '{$value['is_publicated']}', '{$value['is_moderating']}', '{$value['status']}'
        , '{$value['status_prev']}', '{$value['status_changed']}', '{$value['deleted']}', {$cat_id}, '{$value['cat_type']}', '{$value['owner_type']}'
        , '{$addr_addr}', '{$value['svc_up_activate']}', '{$value['svc_upauto_on']}', '{$value['svc_fixed']}'
        , '{$value['svc_premium']}', '{$value['svc_press_status']}', '{$value['addr_lat']}', '{$value['addr_lon']}', '{$title}', '{$value['keyword']}',
        '{$value['lang']}', '{$img_s}', '{$img_m}', '{$img_prefix}', '{$value['created']}', '{$value['modified']}', '{$value['price']}', '{$value['price_search']}', {$currency_id},
        '{$name}', '{$value['phones']}', '{$value['publicated_period']}', {$moderated_id},
        '{$value['f1']}', '{$value['f2']}', '{$value['f3']}', '{$value['f4']}', '{$value['f5']}', '{$value['f6']}', '{$value['f7']}', '{$value['f8']}',
        '{$value['f9']}', '{$value['f10']}', '{$value['f11']}', '{$value['f12']}', '{$value['f13']}', '{$value['f14']}', '{$value['f15']}', '{$value['price_ex']}'";
                    if (!$value['district_id']) {
                    	$district_id = Districts::find()->where(['last_id' => $value['city_id']])->one();
                    }else{
                    	$district_id = Districts::find()->where(['last_id' => $value['district_id']])->one();
                    }
                    if($district_id) { $sql .= ", district_id"; $sql_val .= ", '{$district_id->id}'";}
                    if($value['svc_up_date'] != "0000-00-00 00:00:00") { $sql .= ", svc_up_date"; $sql_val .= ", '{$value['svc_up_date']}'";}
                    if($value['svc_up_free'] != "0000-00-00") { $sql .= ", svc_up_free"; $sql_val .= ", '{$value['svc_up_free']}'";}
                    if(!empty($value['svc_upauto_sett'])) { $sql .= ", svc_upauto_sett"; $sql_val .= ", '{$value['svc_upauto_sett']}'";}
                    if($value['svc_upauto_next'] != "0000-00-00 00:00:00") { $sql .= ", svc_upauto_next"; $sql_val .= ", '{$value['svc_upauto_next']}'";}
                    if($value['svc_fixed_to'] != "0000-00-00 00:00:00") { $sql .= ", svc_fixed_to"; $sql_val .= ", '{$value['svc_fixed_to']}'";}
                    if($value['svc_fixed_order'] != "0000-00-00 00:00:00") { $sql .= ", svc_fixed_order"; $sql_val .= ", '{$value['svc_fixed_order']}'";}
                    if($value['svc_premium_to'] != "0000-00-00 00:00:00") { $sql .= ", svc_premium_to"; $sql_val .= ", '{$value['svc_premium_to']}'";}
                    if($value['svc_premium_order'] != "0000-00-00 00:00:00") { $sql .= ", svc_premium_order"; $sql_val .= ", '{$value['svc_premium_order']}'";}
                    if($value['svc_marked_to'] != "0000-00-00 00:00:00") { $sql .= ", svc_marked_to"; $sql_val .= ", '{$value['svc_marked_to']}'";}
                    if($value['svc_press_date'] != "0000-00-00") { $sql .= ", svc_press_date"; $sql_val .= ", '{$value['svc_press_date']}'";}
                    if($value['svc_press_date_last'] != "0000-00-00") { $sql .= ", svc_press_date_last"; $sql_val .= ", '{$value['svc_press_date_last']}'";}
                    if($value['svc_quick_to'] != "0000-00-00 00:00:00") { $sql .= ", svc_quick_to"; $sql_val .= ", '{$value['svc_quick_to']}'";}
                    if(!empty($description)) { $sql .= ", description"; $sql_val .= ", '{$description}'";}
                    if(!empty($link)) { $sql .= ", link"; $sql_val .= ", '{$link}'";}
                    if($value['publicated'] != "0000-00-00 00:00:00") { $sql .= ", publicated"; $sql_val .= ", '{$value['publicated']}'";}
                    if($value['publicated_to'] != "0000-00-00 00:00:00") { $sql .= ", publicated_to"; $sql_val .= ", '{$value['publicated_to']}'";}
                    if($value['publicated_order'] != "0000-00-00 00:00:00") { $sql .= ", publicated_order"; $sql_val .= ", '{$value['publicated_order']}'";}
                    if(!empty($value['moderated_data'])) { $sql .= ", moderated_date";  $moderated_data = str_replace("'", "''", $value['moderated_data']); $sql_val .= ", '{$moderated_data}'";}
                    if(!empty($value['blocked_reason'])) { $sql .= ", blocked_reason"; $sql_val .= ", '{$value['blocked_reason']}'";}
                    if(!empty($value['f16'])) { $sql .= ", f16"; $f16 = str_replace("'", "\'", $value['f16']); $sql_val .= ", '{$f16}'";}
                    if(!empty($value['f17'])) { $sql .= ", f17"; $f17 = str_replace("'", "\'", $value['f17']); $sql_val .= ", '{$f17}'";}
                    if(!empty($value['f18'])) { $sql .= ", f18"; $f18 = str_replace("'", "\'", $value['f18']); $sql_val .= ", '{$f18}'";}
                    if(!empty($value['f19'])) { $sql .= ", f19"; $f19 = str_replace("'", "\'", $value['f19']); $sql_val .= ", '{$f19}'";}
                    if(!empty($value['f20'])) { $sql .= ", f20"; $f20 = str_replace("'", "\'", $value['f20']); $sql_val .= ", '{$f20}'";}
                    if(!empty($value['video'])) { $sql .= ", video"; $video = str_replace("'", "\'", $value['video']); $sql_val .= ", '{$video}'";}
                    if(!empty($value['video_embed'])) { $sql .= ", video_embed"; $video_embed = str_replace("'", "\'", $value['video_embed']);  $sql_val .= ", '{$video_embed}'";}
                    $connection->createCommand($sql.") ".$sql_val.");")->execute();
                }
                $transaction->commit();
            } catch (\Exception $e){
                $transaction->rollBack();
                $return  = false;
            }
            Yii::$app->db->createCommand("ALTER TABLE items ENABLE KEYS;")->execute();
            Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
        }
        return $return;
    }

    public static function copyItemsClaim()
    {
        $base = parent::takeBase('bff_bbs_items_claims');

        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            Yii::$app->db->createCommand("ALTER TABLE items_claim DISABLE TRIGGER USER;")->execute();
            foreach ($base as $value){
                if($value['user_id'] == 0) {
                    $user_id = new \yii\db\Expression('null');
                }else{
                    $user_id = $value['user_id'];
                }
                $sql_insert = 'INSERT INTO items_claim (id, item_id, user_id, user_ip, reason, viewed, date_cr';
                $sql_values = "VALUES ('{$value['id']}', '{$value['item_id']}', {$user_id}, '{$value['user_ip']}', '{$value['reason']}',
             '{$value['viewed']}', '{$value['created']}'";
                if(!empty($value['message'])){ $sql_insert .= ", message"; $message = str_replace("'", "''", $value['message']); $sql_values .= ", '{$message}'"; }
                Yii::$app->db->createCommand($sql_insert.") ".$sql_values.")")->execute();
            }
            Yii::$app->db->createCommand("ALTER TABLE items_claim ENABLE TRIGGER USER;")->execute();
            Yii::$app->db->createCommand("SELECT setval('items_claim_id_seq', (SELECT MAX(id) FROM items_claim))")->execute();
        }else{
            Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
            Yii::$app->db->createCommand("ALTER TABLE items_claim DISABLE KEYS;")->execute();
            foreach ($base as $value){
                if($value['user_id'] == 0) {
                    $user_id = new \yii\db\Expression('null');
                }else{
                    $user_id = $value['user_id'];
                }
                $sql_insert = 'INSERT INTO items_claim (id, item_id, user_id, user_ip, reason, viewed, date_cr';
                $sql_values = "VALUES ('{$value['id']}', '{$value['item_id']}', {$user_id}, '{$value['user_ip']}', '{$value['reason']}',
             '{$value['viewed']}', '{$value['created']}'";
                if(!empty($value['message'])){ $sql_insert .= ", message"; $message = addslashes($value['message']); $sql_values .= ", '{$message}'"; }
                Yii::$app->db->createCommand($sql_insert.") ".$sql_values.")")->execute();
            }
            Yii::$app->db->createCommand("ALTER TABLE items_claim ENABLE KEYS;")->execute();
            Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
        }
        return true;
    }

    public static function copyItemsComment()
    {
        $base = parent::takeBase('bff_bbs_items_comments');

        $migration = new Migration();
        if(!empty($base)){
            foreach($base as $value){
                $model = Chats::find()->where(['field_id' => $value['item_id'], 'type' => 4])->one();
                if(empty($model)){
                    $migration->insert('chats', ['name' => '#items_'.$value['user_id'],
                        'date_cr' => $value['created'], 'status' => 1, 'type' => 4,
                        'field_id' => $value['item_id']]);
                    $model = Chats::find()->where(['field_id' => $value['item_id'], 'type' => 4])->one();
                }
                $migration->insert('chat_users', ['chat_id' => $model->id, 'user_id' => $value['user_id'], 'date_cr' => $value['created']]);
                $migration->insert('chat_message', ['chat_id' => $model->id, 'user_id' => $value['user_id'],
                    'message' => $value['message'], 'date_cr' => $value['created'], 'is_read' => false]);
            }
        }
        return true;
    }

    public static function copyItemsEnotify()
    {
        $base = parent::takeBase('bff_bbs_items_enotify');
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            Yii::$app->db->createCommand("ALTER TABLE items_enotify DISABLE TRIGGER USER;")->execute();
        }else{
                Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
            Yii::$app->db->createCommand("ALTER TABLE items_enotify DISABLE KEYS;")->execute();
            }
        if(!empty($base)){
            $sql_insert = 'INSERT INTO items_enotify (item_id, sended, message_type) VALUES';
            foreach ($base as $value){
                if($value['item_id'] == 0) {
                    $item_id = new \yii\db\Expression('null');
                }else{
                    $item = \backend\models\items\Items::findOne($value['item_id']);
                    if($item != null) $item_id = $value['item_id'];
                    else $item_id = new \yii\db\Expression('null');
                }
                $sql_insert .= " ({$item_id}, '{$value['sended']}', '{$value['message_type']}'),";
            }
            $sql_insert = rtrim($sql_insert, ",").";";
            Yii::$app->db->createCommand($sql_insert)->execute();
        }
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            Yii::$app->db->createCommand("ALTER TABLE items_enotify ENABLE TRIGGER USER;")->execute();
        }else{
            Yii::$app->db->createCommand("ALTER TABLE items_enotify ENABLE KEYS;")->execute();
            Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
        }
        return true;
    }

    public static function copyItemsFav()
    {
        $base = parent::takeBase('bff_bbs_items_fav');
        if(!empty($base)){
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                foreach ($base as $value) {
                    $sql_insert = 'INSERT INTO favorites (item_id, user_id, default_price, price, type';
                    $sql_val = "VALUES ('{$value['item_id']}', '{$value['user_id']}', '{$value['pricedrop_default']}', '{$value['pricedrop_price']}', '1'";
                    if (!empty($value['pricedrop_change'])) {
                        $sql_insert .= ", changed_date";
                        $sql_val .= ", '{$value['pricedrop_change']}'";

                    };
                    $connection->createCommand($sql_insert . ") " . $sql_val . ");")->execute();
                }
                $transaction->commit();
            } catch (\Exception $e){
                $transaction->rollBack();
            }
        }
        return true;
    }

    public static function copyItemsImages(){
        $base = parent::takeBase('bff_bbs_items_images');
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            $connection = Yii::$app->db;
            $connection->createCommand("ALTER TABLE items_images DISABLE TRIGGER USER;")->execute();
            $sql = "INSERT INTO items_images (id, item_id, user_id, filename, created, width, height, num, extstor_img_s, extstor_img_m, extstor_img_v, extstor_img_z, extstor_img_o, img_prefix) VALUES";
            $step = 0;
            $index = 0;
            foreach ($base as $value) {
                if($value['item_id'] == 0) {
                    $item_id = new \yii\db\Expression('null');
                }else{
                    $item = \backend\models\items\Items::findOne($value['item_id']);
                    if($item != null) $item_id = $value['item_id'];
                    else $item_id = new \yii\db\Expression('null');
                }
                if($value['user_id'] == 0) {
                    $user_id = new \yii\db\Expression('null');
                }else{
                    $user_id = $value['user_id'];
                }
                $extstor_img_s = preg_replace("/(.*\/)/", "", $value['extstor_img_s']);
                $extstor_img_m = preg_replace("/(.*\/)/", "", $value['extstor_img_m']);
                $extstor_img_v = preg_replace("/(.*\/)/", "", $value['extstor_img_v']);
                $extstor_img_z = preg_replace("/(.*\/)/", "", $value['extstor_img_z']);
                $extstor_img_o = preg_replace("/(.*\/)/", "", $value['extstor_img_o']);
                $img_prefix = preg_replace("/(\/.*)/", "", $value['filename']);
                $step++;
                $sql .= " ('{$value['id']}', {$item_id}, {$user_id}, '{$value['filename']}', '{$value['created']}', '{$value['width']}', '{$value['height']}', '{$value['num']}', '{$extstor_img_s}',  '{$extstor_img_m}', '{$extstor_img_v}', '{$extstor_img_z}', '{$extstor_img_o}', '{$img_prefix}'),";
                if($step == 10000) {
                    $index++;
                    $sql = rtrim($sql, ",");
                    $connection->createCommand($sql)->execute();
                    fwrite(\STDOUT, "Import ItemsImages step=" . ($index * $step) . "\n");
                    $step = 0;
                    $sql = "INSERT INTO items_images (id, item_id, user_id, filename, created, width, height, num, extstor_img_s, extstor_img_m, extstor_img_v, extstor_img_z, extstor_img_o, img_prefix) VALUES";
                }

            }

            if($step > 0) {
                $index++;
                $sql = rtrim($sql, ",");
                $connection->createCommand($sql)->execute();
                fwrite(\STDOUT, "Import ItemsImages step=" . ($index * $step) . "\n");
            }
        
            /*$sql = rtrim($sql, ",");
            $connection->createCommand($sql)->execute();*/
            $connection->createCommand("ALTER TABLE items_images ENABLE TRIGGER USER;")->execute();
            $connection->createCommand("SELECT setval('items_images_id_seq', (SELECT MAX(id) FROM items_images))")->execute();
        }else{
            $connection = Yii::$app->db;
            $connection->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
            $connection->createCommand("ALTER TABLE items_images DISABLE KEYS;")->execute();
            $sql = "INSERT INTO items_images (id, item_id, user_id, filename, created, width, height, num, extstor_img_s, extstor_img_m, extstor_img_v, extstor_img_z, extstor_img_o, img_prefix) VALUES";
            foreach ($base as $value) {
                if($value['item_id'] == 0) {
                    $item_id = new \yii\db\Expression('null');
                }else{
                    $item = \backend\models\items\Items::findOne($value['item_id']);
                    if($item != null) $item_id = $value['item_id'];
                    else $item_id = new \yii\db\Expression('null');
                }
                if($value['user_id'] == 0) {
                    $user_id = new \yii\db\Expression('null');
                }else{
                    $user_id = $value['user_id'];
                }
                $extstor_img_s = preg_replace("/(.*\/)/", "", $value['extstor_img_s']);
                $extstor_img_m = preg_replace("/(.*\/)/", "", $value['extstor_img_m']);
                $extstor_img_v = preg_replace("/(.*\/)/", "", $value['extstor_img_v']);
                $extstor_img_z = preg_replace("/(.*\/)/", "", $value['extstor_img_z']);
                $extstor_img_o = preg_replace("/(.*\/)/", "", $value['extstor_img_o']);
                $img_prefix = preg_replace("/(\/.*)/", "", $value['filename']);
                $sql .= " ({$value['id']}, {$item_id}, {$user_id}, '{$value['filename']}', '{$value['created']}', '{$value['width']}', '{$value['height']}', '{$value['num']}', '{$extstor_img_s}',  '{$extstor_img_m}', '{$extstor_img_v}', '{$extstor_img_z}', '{$extstor_img_o}', '{$img_prefix}'),";
            }
            $sql = rtrim($sql, ",");
            $connection->createCommand($sql)->execute();
            $connection->createCommand("ALTER TABLE items_images ENABLE KEYS;")->execute();
            $connection->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
        }
        return true;
    }

    public static function copyItemsTranslate(){
        $base = parent::takeBase('bff_bbs_items_lang');
        $sql = "INSERT INTO translates (table_name, field_id, field_name, field_value, language_code) VALUES";
        foreach ($base as $value){
            if($value['lang'] == 'uz' || $value['lang'] == 'ru' || $value['lang'] == 'en'){
                if($value['title']){
                    $title = str_replace("'", "''", $value['title']);
                    $sql .= "('items', '{$value['id']}', 'title', '{$title}', '{$value['lang']}}'), ";
                }
                if($value['descr']){
                    $descr = str_replace("'", "''", $value['descr']);
                    $sql .= "('items', '{$value['id']}', 'description', '{$descr}', '{$value['lang']}}'), ";
                }
            }
        }
        $sql = rtrim($sql, ", ").";";
        Yii::$app->db->createCommand($sql)->execute();
        return true;
    }

    public static function copyItemsLimits()
    {
        $base = parent::takeBase('bff_bbs_items_limits');
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            Yii::$app->db->createCommand("ALTER TABLE items_limits DISABLE TRIGGER USER;")->execute();
            foreach($base as $value){
                if($value['cat_id'] == 0) {
                    $cat_id = 0;
                }else{
                    $cat_id = $value['cat_id'];
                }
                $sql_insert = "INSERT INTO items_limits (id, cat_id, shop, free, items, enabled, group_id";
                $sql_value = "VALUES ('{$value['id']}', {$cat_id}, '{$value['shop']}', '{$value['free']}', '{$value['items']}', '{$value['enabled']}', '{$value['group_id']}'";
                $district_id = Regions::find()->where(['last_id' => $value['reg2_region']])->one();
                if($district_id){
                    $sql_insert .= ", district_id";
                    $sql_value .= ", '{$district_id->id}'";
                }else{
                	$sql_insert .= ", district_id";
                    $sql_value .= ", 0";
                }
                if(!empty($value['settings'])){
                   $sql_insert .= ", settings";
                   $sql_value .= ", '{$value['settings']}'";
                }
                if(!empty($value['title'])){
                    if($value['reg2_region'] != 0){
                        $serialize = unserialize($value['title']);
                        $new_ser = [
                            'min' => $serialize['min'],
                            'max' => $serialize['max']
                        ];
                        $regs = [];
                        foreach ($serialize['regs'] as $key => $val){
                            $reg_id = Regions::find()->where(['last_id' => Yii::$app->dbmy->createCommand('SELECT pid FROM bff_regions WHERE id = '.$key)->queryOne()['pid']])->one()->id;
                            $regs[$reg_id] = [
                                'lvl' => $val['lvl'],
                                't' => $val['t'],
                                'c' => $val['c'],
                            ];
                        }
                        $new_ser['regs'] = $regs;
                        $value['title'] = serialize($new_ser);
                    }
                   $sql_insert .= ", title";
                   $sql_value .= ", '{$value['title']}'";
                }
                Yii::$app->db->createCommand($sql_insert.") ".$sql_value.")")->execute();
            }
            Yii::$app->db->createCommand("ALTER TABLE items_limits ENABLE TRIGGER USER;")->execute();
            Yii::$app->db->createCommand("SELECT setval('items_limits_id_seq', (SELECT MAX(id) FROM items_limits))")->execute();
        }else{
            Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
            Yii::$app->db->createCommand("ALTER TABLE items_limits DISABLE KEYS;")->execute();
            foreach($base as $value){
                if($value['cat_id'] == 0) {
                    $cat_id = new \yii\db\Expression('null');
                }else{
                    $cat_id = $value['cat_id'];
                }
                $sql_insert = "INSERT INTO items_limits (id, cat_id, shop, free, items, enabled, group_id";
                $sql_value = "VALUES ('{$value['id']}', {$cat_id}, '{$value['shop']}', '{$value['free']}', '{$value['items']}', '{$value['enabled']}', '{$value['group_id']}'";
                $district_id = Regions::find()->where(['last_id' => $value['reg2_region']])->one();
                if($district_id){
                    $sql_insert .= ", district_id";
                    $sql_value .= ", '{$district_id->id}'";
                }
                if(!empty($value['settings'])){
                    $sql_insert .= ", settings";
                    $sql_value .= ", '{$value['settings']}'";
                }
                if(!empty($value['title'])){
                    if($value['reg2_region'] != 0){
                        $serialize = unserialize($value['title']);
                        $new_ser = [
                            'min' => $serialize['min'],
                            'max' => $serialize['max']
                        ];
                        $regs = [];
                        foreach ($serialize['regs'] as $key => $val){
                            $reg_id = Regions::find()->where(['last_id' => Yii::$app->dbmy->createCommand('SELECT pid FROM bff_regions WHERE id = '.$key)->queryOne()['pid']])->one()->id;
                            $regs[$reg_id] = [
                                'lvl' => $val['lvl'],
                                't' => $val['t'],
                                'c' => $val['c'],
                            ];
                        }
                        $new_ser['regs'] = $regs;
                        $value['title'] = serialize($new_ser);
                    }
                    $sql_insert .= ", title";
                    $sql_value .= ", '{$value['title']}'";
                }
                Yii::$app->db->createCommand($sql_insert.") ".$sql_value.")")->execute();
            }
            Yii::$app->db->createCommand("ALTER TABLE items_limits ENABLE KEYS;")->execute();
            Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
        }
        return true;
    }

    public static function copyItemsView()
    {
        $base = parent::takeBase('bff_bbs_items_views');
        $sql = "INSERT INTO items_views (item_id, item_views, contacts_views, period) VALUES";
        $connection = Yii::$app->db;
        $step = 0;
        $index = 0;
        foreach($base as $value){
            $step++;
            $sql .= " ({$value['item_id']}, '{$value['item_views']}', '{$value['contacts_views']}', '{$value['period']}'),";
            /*Yii::$app->db->createCommand()->insert('items_views', [
                'item_id' => $value['item_id'],
                'item_views' => $value['item_views'],
                'contacts_views' => $value['contacts_views'],
                'period' => $value['period'],
            ])->execute();*/
            if($step == 10000) {
                $index++;
                $sql = rtrim($sql, ",").";";
                $connection->createCommand($sql)->execute();
                fwrite(\STDOUT, "Import ItemsView step=" . ($index * $step) . "\n");
                $step = 0;
                $sql = "INSERT INTO items_views (item_id, item_views, contacts_views, period) VALUES";
            }
        }

        if($step > 0) {
            $index++;
            $sql = rtrim($sql, ",").";";
            $connection->createCommand($sql)->execute();
            fwrite(\STDOUT, "Import ItemsView step=" . ($index * $step) . "\n");
        }
        return true;
    }

    public static function copyItemsCounters(){
        $base = parent::takeBase('bff_bbs_items_counters');
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            $connection->createCommand("ALTER TABLE items_counters DISABLE TRIGGER USER;")->execute();
        }else{
            $connection->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
            $connection->createCommand("ALTER TABLE items_counters DISABLE KEYS;")->execute();
        }
        try {
            foreach ($base as $value){
                if($value['cat_id'] == 0) {
                    $cat_id = new \yii\db\Expression('null');
                }else{
                    $cat_id = $value['cat_id'];
                }
                $sql = "INSERT INTO items_counters (cat_id, delivery, items";
                $sql_val = ") VALUES ({$cat_id}, '{$value['delivery']}', '{$value['items']}'";
                $district = Districts::find()->where(['last_id' => $value['region_id']])->one();
                if(!empty($district)){
                    $sql .= ", district_id";
                    $sql_val .= ", '{$district->id}'";
                }
                $sql = $sql.$sql_val.")";
                $connection->createCommand($sql)->execute();
            }
            $transaction->commit();
        } catch (\Exception $e){
            $transaction->rollBack();
        }
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            $connection->createCommand("ALTER TABLE items_counters ENABLE TRIGGER USER;")->execute();
        }else{
            $connection->createCommand("ALTER TABLE items_counters ENABLE KEYS;")->execute();
            $connection->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
        }
        return true;
    }
    public static function copyItemsUsersLimits(){
        $base = parent::takeBase('bff_bbs_items_limits_users');
        $connection = Yii::$app->db;
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            $connection->createCommand("ALTER TABLE items_limits_users DISABLE TRIGGER USER;")->execute();
        }else{
            $connection->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
            $connection->createCommand("ALTER TABLE items_limits_users DISABLE KEYS;")->execute();
        }
        foreach ($base as $value){
            if($value['cat_id'] == 0) {
                $cat_id = new \yii\db\Expression('null');
            }else{
                $cat_id = $value['cat_id'];
            }
            if($value['user_id'] == 0) {
                $user_id = new \yii\db\Expression('null');
            }else{
                $user_id = $value['user_id'];
            }
            $sql = "INSERT INTO items_limits_users (active, user_id, cat_id, free_id, paid_id, items, shop, expire, created, need_check";
            $sql_val = ") VALUES ('{$value['active']}', {$user_id}, {$cat_id}, '{$value['free_id']}', '{$value['paid_id']}', '{$value['items']}', '{$value['shop']}', '{$value['expire']}', '{$value['created']}', '{$value['need_check']}'";
            if(!empty($value['bill_id'])){
                $sql .= ", bill_id";
                $sql_val .= ", '{$value['bill_id']}'";
            }
            $sql = $sql.$sql_val.")";
            $connection->createCommand($sql)->execute();
        }
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            $connection->createCommand("ALTER TABLE items_limits_users ENABLE TRIGGER USER;")->execute();
        }else{
            $connection->createCommand("ALTER TABLE items_limits_users ENABLE KEYS;")->execute();
            $connection->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
        }
        return true;
    }
    public static function copyCounters(){
        $base = parent::takeBase('bff_counters');
        $sql = "INSERT INTO counters (title, code, code_position, enabled, date_cr, num) VALUES";
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            foreach($base as $value){
                $title = str_replace("'", "''", $value['title']);
                $code = str_replace("'", "''", $value['code']);
                $sql .= " ('{$title}', '{$code}', '{$value['code_position']}', '{$value['enabled']}', '{$value['created']}', '{$value['num']}'),";
            }
        }else{
            foreach($base as $value){
                $title = addslashes($value['title']);
                $code = addslashes($value['code']);
                $sql .= " ('{$title}', '{$code}', '{$value['code_position']}', '{$value['enabled']}', '{$value['created']}', '{$value['num']}'),";
            }
        }
        $sql = rtrim($sql, ",");
        if(Yii::$app->db->createCommand($sql)->execute()){
            return true;
        }else return false;
    }
    public static function copyIntermail()
    {
        $base = parent::takeBase('bff_internalmail');

        $migration = new Migration();
        $sql_chat_users = "INSERT INTO chat_users (chat_id, user_id, date_cr) VALUES";
        if(!empty($base)){
            foreach($base as $value){
                if($value['shop_id'] == 0) {
                    //aslida type = 6 ga o'tkazishimiz kerak Nodirni fikri boyicha
                    //$model = Chats::find()->where(['field_id' => $value['item_id'], 'type' => 2])->one();
                    $model = Chats::find()
                        ->where(['name' => '#chats_'.$value['author'].'_'.$value['recipient'], 'type' => 2])
                        ->orWhere(['name' => '#chats_'.$value['recipient'].'_'.$value['author'], 'type' => 2])
                        ->one();
                    if(empty($model)){
                        $migration->insert('chats', ['name' => '#chats_'.$value['author'].'_'.$value['recipient'],
                            'date_cr' => $value['created'], 'status' => 1, 'type' => 2,
                            'field_id' => $value['item_id']]);
                        $model = Chats::find()->where(['field_id' => $value['item_id'], 'type' => 2])->one();
                    }
                }elseif($value['item_id'] != 0){
                    $model = Chats::find()->where(['field_id' => $value['shop_id'], 'type' => 5])->one();
                    if(empty($model)){
                        $migration->insert('chats', ['name' => '#shops_'.$value['author'],
                            'date_cr' => $value['created'], 'status' => 1, 'type' => 5,
                            'field_id' => $value['shop_id']]);
                        $model = Chats::find()->where(['field_id' => $value['shop_id'], 'type' => 5])->one();
                    }
                }else{
                    if($value['recipient'] == 1 || $value['author'] == 1){
                        $model = Chats::find()->where(['name' => '#admin_'.$value['author'], 'type' => 1])->one();
                        if(empty($model)){
                            $migration->insert('chats', ['name' => '#admin_'.$value['author'],
                                'date_cr' => $value['created'], 'status' => 1, 'type' => 1, 'field_id' => $value['author']]);
                            $model = Chats::find()->where(['name' => '#admin_'.$value['author'], 'type' => 1])->one();
                        }
                    }else{
                        $model = Chats::find()->where(['name' => '#chats_'.$value['author'], 'type' => 2])->one();
                        if(empty($model)){
                            $migration->insert('chats', ['name' => '#chats_'.$value['author'],
                                'date_cr' => $value['created'], 'status' => 1, 'type' => 2, 'field_id' => $value['author']]);
                            $model = Chats::find()->where(['name' => '#chats_'.$value['author'], 'type' => 2])->one();
                        }
                    }
                }
                if(!empty($model)){
                    $chat_user_1 = ChatUsers::find()->where(['chat_id' => $model->id, 'user_id' => $value['author']])->one();
                    $chat_user_2 = ChatUsers::find()->where(['chat_id' => $model->id, 'user_id' => $value['recipient']])->one();
                    if(empty($chat_user_1)) $sql_chat_users .= " ('{$model->id}', '{$value['author']}', '{$value['created']}'),";
                    if(empty($chat_user_2)) $sql_chat_users .= " ('{$model->id}', '{$value['recipient']}', '{$value['created']}'),";
                    $migration->insert('chat_message', ['chat_id' => $model->id, 'user_id' => $value['author'],
                        'message' => $value['message'], 'date_cr' => $value['created'], 'is_read' => $value['is_new'], 'file' => $value['attach']]);
                    //$migration->insert('chat_message', ['chat_id' => $model->id, 'user_id' => $value['recipient'],
                    //    'message' => $value['message'], 'date_cr' => $value['created'], 'is_read' => $value['is_new'], 'file' => $value['attach']]);
                }
            }
            $sql_chat_users = rtrim($sql_chat_users, ",").";";
            Yii::$app->db->createCommand($sql_chat_users)->execute();
        }
        return true;
    }
    public static function copyLanding(){
        $base = parent::takeBase('bff_landingpages');
        $sql = "INSERT INTO landingpages (landing_uri, original_uri, date_cr, modified, user_id, user_ip, enabled, is_relative, joined, joined_module) VALUES";
        foreach ($base as $value){
            $ip = long2ip($value['user_ip']);
            $sql .= " ('{$value['landing_uri']}', '{$value['original_uri']}', '{$value['created']}', '{$value['modified']}', '{$value['user_id']}', '{$ip}', '{$value['enabled']}', '{$value['is_relative']}', '{$value['joined']}', '{$value['joined_module']}'),";
        }
        $sql = rtrim($sql, ",");
        if(Yii::$app->db->createCommand($sql)->execute()) return true; else return false;
    }

    public static function copyPages(){
        $base = Yii::$app->dbmy->createCommand("SELECT * FROM bff_pages b LEFT JOIN bff_pages_lang l ON b.id = l.id WHERE l.lang = 'ru'")->queryAll();
        foreach ($base as $value){
            $sql = "INSERT INTO pages (filename, changed_id, date_cr, date_up, noindex, title";
            $sql_val = " VALUES ('{$value['filename']}', '{$value['modified_uid']}', '{$value['created']}', '{$value['modified']}', '{$value['noindex']}', '{$value['title']}'";
            if(!empty($value['content'])){
                $sql .= ", description";
                $sql_val .= ", '{$value['content']}'";
            }
            if(!empty($value['mtitle'])){
                $sql .= ", mtitle";
                $sql_val .= ", '{$value['mtitle']}'";
            }
            if(!empty($value['mkeywords'])){
                $sql .= ", mkeywords";
                $sql_val .= ", '{$value['mkeywords']}'";
            }
            if(!empty($value['mdescription'])){
                $sql .= ", mdescription";
                $sql_val .= ", '{$value['mdescription']}'";
            }
            $sql = $sql.")".$sql_val.")";
            Yii::$app->db->createCommand($sql)->execute();
        }
        $trans = parent::takeBase('bff_pages_lang');

        $sql = "INSERT INTO translates (table_name, field_id, field_name, field_value, language_code) VALUES ";
        if(mb_substr(Yii::$app->db->dsn, 0,5) == 'pgsql') $rpl = "''"; else $rpl = "\'";
        foreach ($trans as $value){
            if($value['lang'] == 'uz' || $value['lang'] == 'en'){
                if($value['title']){
                    $title = str_replace("'", $rpl, $value['title']);
                    $sql .= "('pages', '{$value['id']}', 'title', '{$title}', '{$value['lang']}'), ";
                }
                if($value['content']){
                    $content = str_replace("'", $rpl, $value['content']);
                    $sql .= "('pages', '{$value['id']}', 'description', '{$content}', '{$value['lang']}'), ";
                }
                if($value['mtitle']){
                    $mtitle = str_replace("'", $rpl, $value['mtitle']);
                    $sql .= "('pages', '{$value['id']}', 'mtitle', '{$mtitle}', '{$value['lang']}'), ";
                }
                if($value['mkeywords']){
                    $mkeywords = str_replace("'", $rpl, $value['mkeywords']);
                    $sql .= "('pages', '{$value['id']}', 'mkeywords', '{$mkeywords}', '{$value['lang']}'), ";
                }
                if($value['mdescription']){
                    $mdescription = str_replace("'", $rpl, $value['mdescription']);
                    $sql .= "('pages', '{$value['id']}', 'mdescription', '{$mdescription}}', '{$value['lang']}'), ";
                }
            }
        }
        $sql = rtrim($sql, ", ").";";
        Yii::$app->db->createCommand($sql)->execute();
        $date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO pages (filename, changed_id, date_cr, date_up, noindex, title, description, mtitle) VALUES ('about', '1', '{$date}', '{$date}', '0', 'О нас', 'О нас', 'О нас')";
        Yii::$app->db->createCommand($sql)->execute();
        Yii::$app->db->createCommand("INSERT INTO translates (table_name, field_id, field_name, field_value, language_code) VALUES ('pages', '5', 'title', 'Biz haqimizda', 'uz')")->execute();
        Yii::$app->db->createCommand("INSERT INTO translates (table_name, field_id, field_name, field_value, language_code) VALUES ('pages', '5', 'description', 'Biz haqimizda', 'uz')")->execute();
        Yii::$app->db->createCommand("INSERT INTO translates (table_name, field_id, field_name, field_value, language_code) VALUES ('pages', '5', 'title', 'About us', 'en')")->execute();
        Yii::$app->db->createCommand("INSERT INTO translates (table_name, field_id, field_name, field_value, language_code) VALUES ('pages', '5', 'description', 'About us', 'en')")->execute();

        return true;
    }
    public static function copyAnalitic(){
        $base = parent::takeBase('bff_plugin_google_analytics_p0f8b64');
        $sql = "INSERT INTO google_analytics (name, value) VALUES";
        foreach ($base as $value){
            $sql .= " ('{$value['name']}', '{$value['value']}'),";
        }
        $sql = rtrim($sql, ",").";";
        Yii::$app->db->createCommand($sql)->execute();
        return true;
    }
    public static function copyPayme(){
        $base = parent::takeBase('bff_plugin_payme_p03a3b8');
        $sql = "INSERT INTO transactions (order_id, paycom_transaction_id, transaction_created, transaction_canceled) VALUES";
        foreach ($base as $value){
            $sql .= " ('{$value['order_id']}', '{$value['transaction_id']}', '{$value['transaction_created']}', '{$value['transaction_canceled']}'),";
        }
        $sql = rtrim($sql, ",").";";
        if(Yii::$app->db->createCommand($sql)->execute()) return true;
        else return false;
    }

    public static function copySearchResult(){
        $base = parent::takeBase('bff_plugin_search_results_p021ad5');
        $rpl = mb_substr(Yii::$app->db->dsn, 0,5) == 'pgsql' ? "''" : "\'";
        $connect = Yii::$app->db;
        $transaction = $connect->beginTransaction();
        try{
            foreach($base as $value){
                $sql_insert = "INSERT INTO search_results (pid, counter, hits, last_time";
                $sql_val = "VALUES ('{$value['pid']}', '{$value['counter']}', '{$value['hits']}', '{$value['last_time']}'";
                $district = Districts::find()->where(['last_id' => $value['region_id']])->one();
                if($district){
                    $sql_insert .= ", region_id";
                    $sql_val .= ", '{$district->id}'";
                }
                $query = str_replace("'", $rpl, $value['query']);

                if(!empty($query)){
                    $sql_insert .= ", query";
                    $sql_val .= ", '{$query}'";
                }
                $sql = $sql_insert.") ".$sql_val.")";
                $connect->createCommand($sql)->execute();
            }
            $transaction->commit();
        }catch (\Exception $e){
            $transaction->rollBack();
        }
        return true;
    }
    
    public static function copyRedirects(){
        $base = parent::takeBase('bff_redirects');
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            foreach($base as $value){
                $sql = "INSERT INTO redirects (from_uri, to_uri, status, is_relative, add_extra, add_query, enabled, date_cr, date_up, user_id, user_ip, joined";
                $ip = long2ip($value['user_ip']);
                $sql_val = " VALUES ('{$value['from_uri']}', '{$value['to_uri']}', '{$value['status']}', '{$value['is_relative']}',
            '{$value['add_extra']}', '{$value['add_query']}', '{$value['enabled']}', '{$value['created']}', '{$value['modified']}', '{$value['user_id']}', '{$ip}', '{$value['joined']}'";
                if($value['joined_module']){
                    $sql .= ", joined_module";
                    $sql_val .= ", '{$value['joined_module']}'";
                }
                $sql = $sql.") ".$sql_val.");";
                $connection->createCommand($sql)->execute();
            }
            $transaction->commit();
        } catch (\Exception $e){
            $transaction->rollBack();
        }
        return true;
    }

    public static function copySiteRequest(){
        $base = parent::takeBase('bff_site_requests');
        $connection = Yii::$app->db;
        $sql =  "INSERT INTO site_requests (user_action, user_id, user_ip, date_cr, counter) VALUES";
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            $connection->createCommand("ALTER TABLE site_requests DISABLE TRIGGER USER;")->execute();
        }else{
            $connection->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
            $connection->createCommand("ALTER TABLE site_requests DISABLE KEYS;")->execute();
        }
        foreach($base as $value){
            if($value['user_id'] == 0) {
                $user_id = new \yii\db\Expression('null');
            }else{
                $user_id = $value['user_id'];
            }
            $sql .= " ('{$value['user_action']}', {$user_id}, '{$value['user_ip']}', '{$value['created']}', '{$value['counter']}'),";
        }
        $sql = rtrim($sql, ",").";";
        $connection->createCommand($sql)->execute();
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            $connection->createCommand("ALTER TABLE site_requests ENABLE TRIGGER USER;")->execute();
        }else{
            $connection->createCommand("ALTER TABLE site_requests ENABLE KEYS;")->execute();
            $connection->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
        }
        return true;
    }
    public static function newValueBanners()
    {
        $banners = [
            ['id' => 1, 'keyword' => 'item_list', 'title' => 'Обявления', 'enabled' => true, 'width' => 0, 'height' => 0, 'filter_auth_users' => false],
            ['id' => 2, 'keyword' => 'blog_view', 'title' => 'Блог - Просмотр', 'enabled' => true, 'width' => 0, 'height' => 0, 'filter_auth_users' => false],
            ['id' => 3, 'keyword' => 'site_index_item_before', 'title' => 'Главная - Перед блоком обявлении', 'enabled' => true, 'width' => 0, 'height' => 0, 'filter_auth_users' => false],
            ['id' => 4, 'keyword' => 'site_index_item_after_left', 'title' => 'Главная - После блока обявлении - Слева', 'enabled' => true, 'width' => 0, 'height' => 0, 'filter_auth_users' => false],
            ['id' => 5, 'keyword' => 'site_index_item_after_right', 'title' => 'Главная - После блока обявлении - Направо', 'enabled' => true, 'width' => 0, 'height' => 0, 'filter_auth_users' => false],
            ['id' => 6, 'keyword' => 'service_list', 'title' => 'Сервис - Список', 'enabled' => true, 'width' => 0, 'height' => 0, 'filter_auth_users' => false]
        ];

        $slides = [
            ['banner_id' => 1, 'type' => 1, 'img' => 'item_list.png', 'title' => 'Mashhur smartfonlar & Aksessuarlar', 'url' => 'https://bisyor.uz/', 'enabled' => 1, 'target_blank' => 1, 'show_start' => '2020-05-01', 'show_finish' => '2020-09-01', 'show_limit' => 1000],
            ['banner_id' => 2, 'type' => 1, 'img' => 'blog_view.jpg', 'title' => 'Расскажите читателям о своём опыте', 'url' => 'https://bisyor.uz/', 'enabled' => 1, 'target_blank' => 1, 'show_start' => '2020-05-01', 'show_finish' => '2020-09-01', 'show_limit' => 1000],
            ['banner_id' => 3, 'type' => 1, 'img' => 'site_index_item_before.png', 'title' => 'Mashhur smartfonlar & Aksessuarlar', 'url' => 'https://bisyor.uz/', 'enabled' => 1, 'target_blank' => 1, 'show_start' => '2020-05-01', 'show_finish' => '2020-09-01', 'show_limit' => 1000],
            ['banner_id' => 4, 'type' => 1, 'img' => 'site_index_item_after_left.jpg', 'title' => 'Yangi qishki liboslar to\'plami', 'description' => 'Dunyoning eng taniqli brandlar, siz uchun qulay narxlarda.', 'url' => 'https://bisyor.uz/', 'enabled' => 1, 'target_blank' => 1, 'show_start' => '2020-05-01', 'show_finish' => '2020-09-01', 'show_limit' => 1000],
            ['banner_id' => 5, 'type' => 1, 'img' => 'site_index_item_after_right.jpg', 'title' => 'Yangi kuzgi kolleksiyalar', 'description' => 'Yevropa va amerikaning eng sifatli kolleksiyasi', 'url' => 'https://bisyor.uz/', 'enabled' => 1, 'target_blank' => 1, 'show_start' => '2020-05-01', 'show_finish' => '2020-09-01', 'show_limit' => 1000],
            ['banner_id' => 6, 'type' => 1, 'img' => 'service_list.png', 'title' => 'Подайте новое объявление и сделайте его заметным', 'url' => 'https://bisyor.uz/', 'enabled' => 1, 'target_blank' => 1, 'show_start' => '2020-05-01', 'show_finish' => '2020-09-01', 'show_limit' => 1000]
        ];

        $migratios = new Migration();
        $banner_old = Banners::find()->all();
        $banner_stat = BannersStatistic::find()->all();
        $banner_items = BannersItems::find()->all();
        foreach($banner_stat as $value){
            $migratios->delete('banners_statistic', ['id' => $value->id]);
        }
        foreach($banner_items as $value){
            $migratios->delete('banners_items', ['id' => $value->id]);
        }
        foreach($banner_old as $value){
            $migratios->delete('banners', ['id' => $value->id]);
        }
        foreach ($banners as $banner) {
            $migratios->insert('banners', $banner);
        }
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql')
            Yii::$app->db->createCommand("SELECT setval('banners_id_seq', (SELECT MAX(id) FROM banners))")->execute();
//        $conn_id = parent::connectFtp();
        foreach ($slides as $slide) {
            $migratios->insert('banners_items', $slide);
//            $ftp_path = '/web/uploads/banners/' . $slide['img'];
//            $link = "C:/OSPanel/domains/bisyor.loc/backend/web/resource/banners/" . $slide['img'];
//            $ret = ftp_nb_put($conn_id, $ftp_path, $link, FTP_BINARY);
//            while ($ret == FTP_MOREDATA) {
//                $ret = ftp_nb_continue($conn_id);
//            }
//            if ($ret != FTP_FINISHED) {
//                fwrite(\STDOUT, " При загрузке файла произошла ошибка...\n");
//            } else {
//                fwrite(\STDOUT, $slide['img'] . " Изображение успешно загружено\n");
//            }
        }
        return true;
    }
    public static function copyContacts(){
        $base = parent::takeBase('bff_contacts');

        $connection = Yii::$app->db;
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            $replac = "''";
            $connection->createCommand("ALTER TABLE contacts DISABLE TRIGGER USER;")->execute();
        }else{
            $replac = "\'";
            $connection->createCommand("SET FOREIGN_KEY_CHECKS = 0;")->execute();
            $connection->createCommand("ALTER TABLE contacts DISABLE KEYS;")->execute();
        }

        foreach ($base as $item) {
            if($item['user_id'] == 0) {
                $user_id = new \yii\db\Expression('null');
            }else{
                $user_id = $item['user_id'];
            }
            $sql_into = "INSERT INTO contacts (type, user_id, user_ip, name, email, message, useragent, date_cr, viewed";
            $msg = str_replace("'", $replac, $item['message']);
            $sql = "VALUES ('{$item['ctype']}', {$user_id}, '{$item['user_ip']}', '{$item['name']}', '{$item['email']}', '{$msg}', '{$item['useragent']}', '{$item['created']}', '{$item['viewed']}'";
            if($item['modified'] != "0000-00-00 00:00:00"){
                $sql_into .= ", date_up";
                $sql .= ", '{$item['modified']}'";
            }
            $sql = $sql_into.") ".$sql.")";
            $connection->createCommand($sql)->execute();
        }
        if(mb_substr(Yii::$app->db->dsn, 0, 5) == 'pgsql') {
            $connection->createCommand("ALTER TABLE contacts ENABLE TRIGGER USER;")->execute();
        }else{
            $connection->createCommand("ALTER TABLE contacts ENABLE KEYS;")->execute();
            $connection->createCommand("SET FOREIGN_KEY_CHECKS = 1;")->execute();
        }
        return true;

    }
}