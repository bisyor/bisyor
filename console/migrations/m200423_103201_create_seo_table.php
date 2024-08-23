<?php

use yii\db\Migration;
use backend\models\seobase\Items;
use backend\models\seobase\Shops;
use backend\models\seobase\Users;
use backend\models\seobase\Blogs;
use backend\models\seobase\Helps;
use backend\models\seobase\SiteSettings;
/**
 * Handles the creation of table `{{%seo}}`.
 */
class m200423_103201_create_seo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%seo}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment('Наименование'),
            'value' => $this->text()->comment('Значение'),
            'key' => $this->string(255)->comment('Ключ'),
            'group' => $this->string(255)->comment('Группа'),
            'type' => $this->string(255)->comment('Тип полей'),
        ]);

        Items::AllCategory();
        Shops::AllShops();
        Users::AllUsers();
        Blogs::AllBlogs();
        Helps::AllHelps();
        SiteSettings::AllSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%seo}}');
    }
}
