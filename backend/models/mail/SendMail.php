<?php
/**
 * Created by PhpStorm.
 * Project: bisyor.loc
 * User: Umidjon <t.me/zoxidovuz>
 * Date: 16.05.2020
 * Time: 20:09
 */

namespace backend\models\mail;


use Yii;
use yii\base\Model;

class SendMail extends Model
{
    public $users;
    public $text;

    public function execute(){
        foreach ($this->users as $user) {
//            if($user['email'] != null && $user['email_news_alert']){
//                if($user['fio']) $message = str_replace('{fio}', $user['fio'], $this->text);
//                $multi [] = Yii::$app
//            ->mailer
//            ->compose()
//            ->setFrom(['bisyorrobot@gmail.com' => 'Bisyor.uz'])
//            ->setTo($user)
//            ->setSubject('Рассылка')
//            ->setHtmlBody($message);
//            }
            $message = str_replace('{fio}', $user, $this->text);
            Yii::$app
                ->mailer
                ->compose()
                ->setFrom(['bisyorrobot@gmail.com' => 'Bisyor.uz'])
                ->setTo($user)
                ->setSubject('Рассылка')
                ->setHtmlBody($message)->send();
        }
    }

}

?>