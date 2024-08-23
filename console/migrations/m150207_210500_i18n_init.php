<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

use yii\db\Migration;

/**
 * Initializes i18n messages tables.
 *
 *
 *
 * @author Dmitry Naumenko <d.naumenko.a@gmail.com>
 * @since 2.0.7
 */
class m150207_210500_i18n_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'pgsql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            // $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%source_message}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string(255)->comment("Категория"),
            'message'=> $this->text()->comment("Текст"),
        ]);

        $this->createTable('{{%message}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(16)->notNull(),
            'translation' => $this->text(),
        ]);

        $this->addPrimaryKey('pk_message_id_language', '{{%message}}', ['id', 'language']);
        $this->addForeignKey('fk_message_source_message', '{{%message}}', 'id', '{{%source_message}}', 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('idx_source_message_category', '{{%source_message}}', 'category');
        $this->createIndex('idx_message_language', '{{%message}}', 'language');

        $translations_oz = include Yii::getAlias('backend').'/web/uploads/langs/oz.php';
        $translations_uz = include Yii::getAlias('backend').'/web/uploads/langs/uz.php';
        $translations_ru = include Yii::getAlias('backend').'/web/uploads/langs/ru.php';
        $translations_en = include Yii::getAlias('backend').'/web/uploads/langs/en.php';

        $keys = array_keys($translations_oz);
        $values_oz = array_values($translations_oz);
        $values_uz = array_values($translations_uz);
        $values_ru = array_values($translations_ru);
        $values_en = array_values($translations_en);


        // ************************ umumiy keylar bular ************************
        foreach ($keys as $key => $value) {
            $this->insert('{{%source_message}}',array(
                'message' => $value,
                'category' => 'app',
            ));
        };

        //  insert ***********************
         foreach ($values_oz as $key => $value) {
            $this->insert('{{%message}}',array(
                'id' => ($key+1),
                'language' => 'oz',
                'translation' => $value,
            ));
        }


        // ******************* uz *********************

        foreach ($values_uz as $key => $value) {
            $this->insert('{{%message}}',array(
                'id' => ($key+1),
                'language' => 'uz',
                'translation' => $value,
            ));
        }

        // ******************* en *********************

        foreach ($values_en as $key => $value) {
            $this->insert('{{%message}}',array(
                'id' => ($key+1),
                'language' => 'en',
                'translation' => $value,
            ));
        }
      
        // ******************* ru *********************

        foreach ($values_ru as $key => $value) {
            $this->insert('{{%message}}',array(
                'id' => ($key+1),
                'language' => 'ru',
                'translation' => $value,
            ));
        }
    }

    public function down()
    {
        $this->dropForeignKey('fk_message_source_message', '{{%message}}');
        $this->dropTable('{{%message}}');
        $this->dropTable('{{%source_message}}');
    }
}
