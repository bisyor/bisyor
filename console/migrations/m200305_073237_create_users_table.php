<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%companies}}`
 */
class m200305_073237_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string(255)->comment("Логин"),
            'phone' => $this->string(255)->comment("Телефон"),
            'email' => $this->string(255)->comment("Эмаил"),
            'password' => $this->string(255)->comment("Пароль"),
            'fio' => $this->string(255)->comment("ФИО"),
            'avatar' => $this->string(255)->comment("Аватар"),
            'status' => $this->integer()->comment("Статус пользователя "),
            'sex' => $this->integer()->comment("Пол"),
            'lang_code' => $this->string(10)->comment("Код языка"),
            'birthday'=>$this->date()->comment("Дата рождение"),
            'address'=>$this->text()->comment("Точный адрес"),
            'phones'=>$this->text()->comment("Допольнителные телефонные номеры"),
            'coordinate_x' => $this->string(255)->comment("Coordinate X"),
            'coordinate_y' => $this->string(255)->comment("Coordinate Y"),
            'telegram' => $this->string(255)->comment("Телеграм Профил"),
            'site' => $this->string(255)->comment("Веб Сайт"),
            'balance' => $this->float()->defaultValue(0)->comment("Баланс пользователья"),
            'referal_balance' => $this->float()->defaultValue(0)->comment("Реферальный Баланс"),
            'bonus_balance' => $this->float()->defaultValue(0)->comment("Бонусный Баланс"),
            'last_seen' => $this->datetime()->comment("Последное активность"),
            'access_token' => $this->string(255)->comment("Токен"),
            'expiret_at' => $this->integer()->comment("Жизненной цикл"),
            'district_id' => $this->integer()->comment("Район "),
            'resume_file' => $this->string(255)->comment("Резюме пользователя (файл)"),
            'admin_comment' => $this->text()->comment("Комментария админа"),
            'email_news_alert' => $this->boolean()->comment("Получать рассылку о новостях Bisyor.uz"),
            'email_message_alert' => $this->boolean()->comment("Получать уведомления о новых сообщениях"),
            'email_comment_alert' => $this->boolean()->comment("Получать уведомления о новых комментариях на объявления"),
            'email_fav_ads_price_alert' => $this->boolean()->comment("Получать уведомления об изменении цены в избранных объявлениях"),
            'sms_news_alert' => $this->boolean()->comment("Получать уведомления о новых сообщениях"),
            'sms_comment_alert' => $this->boolean()->comment("Получать уведомления о новых комментариях на объявления"),
            'sms_fav_ads_price_alert' => $this->boolean()->comment("Получать уведомления об изменении цены в избранных объявлениях"),
            'sms_code' => $this->string(255)->comment("Смс код"),
            'email_verified' => $this->boolean()->comment("E-mail Верифицирован"),
            'phone_verified' => $this->boolean()->comment("Телефон номер Верифицирован"),
            'google_api_key' => $this->string(255)->comment("Google auth"),
            'facebook_api_key' => $this->string(255)->comment("Facebook auth"),
            'telegram_api_key' => $this->string(255)->comment("Telegram auth"),
            'apple_api_key' => $this->string(255)->comment(" Apple auth"),
            'registry_date' => $this->datetime()->comment("Дата регистрации"),
            'block_reason' => $this->text()->comment("Причина блокировки"),
        ]);
        $this->createIndex(
            'idx-users-district_id',
            'users',
            'district_id'
        );
        $this->createIndex(
            'idx-users-login',
            'users',
            'login'
        );
        $this->createIndex(
            'idx-users-phone',
            'users',
            'phone'
        );
        $this->createIndex(
            'idx-users-email',
            'users',
            'email'
        );
        $this->createIndex(
            'idx-users-status',
            'users',
            'status'
        );


        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-users-district_id',
            'users',
            'district_id',
            'districts',
            'id',
            'CASCADE'
        );


          $this->insert('users',array(
            'fio'=>'Иванов Иван Иванович',
            'login' => 'admin',
            'email'=>'admin@gmail.com',
            'phone' => '+998999999999',
            'password' => Yii::$app->security->generatePasswordHash('admin'),
            'avatar' => 'avatar.jpg',
            'district_id' => 181,
            'status' => 1,
            'sex' => 1,
            'address' => 'Integro biznes center',
            'access_token' => Yii::$app->getSecurity()->generateRandomString(),
            'expiret_at' => time()+ 3600 * 24 * 7,
            'registry_date' => date("Y-m-d H:i"),
            'last_seen' => date("Y-m-d H:i"),
            'birthday' => '1996-01-20',
            'coordinate_x' => '41.2748753',
            'coordinate_y' => '69.2071344',
          ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-users-district_id', 'users');
        $this->dropIndex(
            '{{%idx-users-district_id}}',
            '{{%users}}'
        );
        $this->dropIndex(
            'idx-users-login',
            'users'
        );
        $this->dropIndex(
            'idx-users-phone',
            'users'
        );
        $this->dropIndex(
            'idx-users-email',
            'users'
        );
        $this->dropIndex(
            'idx-users-status',
            'users'
        );
        $this->dropTable('{{%users}}');
    }
}
