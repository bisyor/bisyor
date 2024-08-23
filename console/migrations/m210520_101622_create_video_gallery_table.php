<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%video_galereya}}`.
 */
class m210520_101622_create_video_gallery_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%video_gallery}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'item_id' => $this->integer(),
            'user_id' => $this->integer(),
            'file' => $this->string(),
            'duration' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createIndex(
            '{{%idx-video_gallery-item_id}}',
            '{{%video_gallery}}',
            'item_id'
        );

        $this->createIndex(
            '{{%idx-video_gallery-user_id}}',
            '{{%video_gallery}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-video_gallery-user_id}}',
            '{{%video_gallery}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            '{{%fk-video_gallery-item_id}}',
            '{{%video_gallery}}',
            'item_id',
            '{{%items}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-video_gallery-item_id}}',
            '{{%video_gallery}}'
        );

        $this->dropIndex(
            '{{%idx-video_gallery-item_id}}',
            '{{%video_gallery}}'
        );

        $this->dropForeignKey(
            '{{%fk-video_gallery-user_id}}',
            '{{%video_gallery}}'
        );

        $this->dropIndex(
            '{{%idx-video_gallery-user_id}}',
            '{{%video_gallery}}'
        );

        $this->dropTable('{{%video_gallery}}');
    }
}
