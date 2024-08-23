<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%google_analytics}}`.
 */
class m200324_152330_create_google_analytics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%google_analytics}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment('Наименвоание'),
            'value' => $this->string(255)->comment('Значение'),
        ]);

//        $this->insert('google_analytics',array(
//            'name' => 'client_id',
//            'value' => '974654239084-jfu4vi7al9bcttlfk5hln1u2dh1qoucc.apps.googleusercontent.com',
//        ));
//        $this->insert('google_analytics',array(
//            'name' => 'client_secret',
//            'value' => 'dZ6jreawLf8kq-LWA198Ka_b',
//        ));
//        $this->insert('google_analytics',array(
//            'name' => 'access_token',
//            'value' => 'ya29.ImGyBwV5cvs4dMCnksK_JaMbWzUPUD94ZBReYmB07nyXvv-dEoDfl-yiu-8-TOhyRyltrlE0NUpKcGVWX8jchFYUrsMqQL8ck19vSW7kRwo2wnvDM97KAlW504CrjNtwEcg0',
//        ));
//        $this->insert('google_analytics',array(
//            'name' => 'token_type',
//            'value' => 'Bearer',
//        ));
//        $this->insert('google_analytics',array(
//            'name' => 'expires_in',
//            'value' => '3600',
//        ));
//        $this->insert('google_analytics',array(
//            'name' => 'refresh_token',
//            'value' => '1/3pRjcDps3_NmNBQ9uXY3xjw26Bt6vH1JAwWEuDSsxno',
//        ));
//        $this->insert('google_analytics',array(
//            'name' => 'created_on',
//            'value' => '1574323809',
//        ));
//        $this->insert('google_analytics',array(
//            'name' => 'account_id',
//            'value' => '132758354',
//        ));
//        $this->insert('google_analytics',array(
//            'name' => 'property_id',
//            'value' => 'UA-132758354-1',
//        ));
//        $this->insert('google_analytics',array(
//            'name' => 'profile_id',
//            'value' => '188273643',
//        ));
//        $this->insert('google_analytics',array(
//            'name' => 'profile_timezone',
//            'value' => 'Asia/Tashkent',
//        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%google_analytics}}');
    }
}
