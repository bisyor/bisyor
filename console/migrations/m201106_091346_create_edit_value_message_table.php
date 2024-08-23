<?php

use backend\models\chats\ChatMessage;
use backend\models\chats\Chats;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%edit_value_message}}`.
 */
class m201106_091346_create_edit_value_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $chats = Chats::find()->where(['type' => 1])->asArray()->all();
        $chat_message = ChatMessage::find()
            ->andWhere(['chat_id' => array_column($chats , 'id') ])
            ->andWhere(['!=' , 'user_id' , 1 ])
            ->andWhere(['or',
                [ 'message' => '"Поздравляем! Вы успешно зарегистрировались на Bisyor.uz"'] ,
                ['message' => '"Поздравляем! Вы успешно зарегистрировались на лучшей онлайн платформу. Это чат техподдержки. В случае технических неполадок Вы можете направлять сюда Ваши письма. Команда наших модераторов ответит на Ваше письмо в течении 2 рабочих дней. Так же в данный чат будут приходить рассылки и различные объявления от нашей администрации. Благодарим Вас то что выбрали нас. С уважением команда Bisyor.uz."']
            ])
            ->all();

        foreach ($chat_message as $value){
            $value->user_id = 1;
            $value->save(false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $this->dropTable('{{%edit_value_message}}');
    }
}
