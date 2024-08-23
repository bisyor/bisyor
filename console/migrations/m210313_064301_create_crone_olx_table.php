<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crone_olx}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m210313_064301_create_crone_olx_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crone_olx}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment("Пользователи"),
            'today_date' => $this->datetime()->comment("Дата"),
            'status' => $this->integer()->comment("Статус"),
            'olx_link' => $this->string(255)->comment("Olx link"),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-crone_olx-user_id}}',
            '{{%crone_olx}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-crone_olx-user_id}}',
            '{{%crone_olx}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-crone_olx-user_id}}',
            '{{%crone_olx}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-crone_olx-user_id}}',
            '{{%crone_olx}}'
        );

        $this->dropTable('{{%crone_olx}}');
    }
}
