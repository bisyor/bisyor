<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items_images}}`.
 */
class m200506_063135_create_items_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%items_images}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer(),
            'user_id' => $this->integer(),
            'filename' => $this->string(255),
            'created' => $this->dateTime(),
            'width' => $this->integer(),
            'height' => $this->integer(),
            'num' => $this->integer(),
            'extstor_img_s' => $this->string(255),
            'extstor_img_m' => $this->string(255),
            'extstor_img_v' => $this->string(255),
            'extstor_img_z' => $this->string(255),
            'extstor_img_o' => $this->string(255),
            'img_prefix' => $this->string(255), // Vaqtinchalik polya
        ]);

        $this->createIndex(
            '{{%idx-items_images-item_id}}',
            '{{%items_images}}',
            'item_id'
        );

        $this->addForeignKey(
            '{{%fk-items_images-item_id}}',
            '{{%items_images}}',
            'item_id',
            '{{%items}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-items_images-user_id}}',
            '{{%items_images}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-items_images-user_id}}',
            '{{%items_images}}',
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
        $this->dropForeignKey(
            '{{%fk-items_images-item_id}}',
            '{{%items_images}}'
        );

        $this->dropIndex(
            '{{%idx-items_images-item_id}}',
            '{{%items_images}}'
        );
        $this->dropForeignKey(
            '{{%fk-items_images-user_id}}',
            '{{%items_images}}'
        );

        $this->dropIndex(
            '{{%idx-items_images-user_id}}',
            '{{%items_images}}'
        );
        $this->dropTable('{{%items_images}}');
    }
}
