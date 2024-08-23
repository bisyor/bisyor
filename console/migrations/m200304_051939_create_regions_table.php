<?php

use yii\db\Migration;
use Cocur\Slugify\Slugify;

/**
 * Handles the creation of table `{{%regions}}`.
 */
class m200304_051939_create_regions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%regions}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
            'last_id' => $this->integer()->comment("Old id"),
            'keyword' => $this->string()->comment("Ключовая слова"),
        ]);


        $this->insert('regions',array('name' => 'Андижанская область','last_id' => '9063'));
        $this->insert('regions',array('name' => 'Бухарская область','last_id' => '9064'));
        $this->insert('regions',array('name' => 'Ферганская область','last_id' => '9073'));
        $this->insert('regions',array('name' => 'Джизакская область','last_id' => '9065'));
        $this->insert('regions',array('name' => 'Хорезмская область','last_id' => '9074'));
        $this->insert('regions',array('name' => 'Наманганская область','last_id' => '9068'));
        $this->insert('regions',array('name' => 'Навоийская область','last_id' => '9067'));
        $this->insert('regions',array('name' => 'Кашкадарьинская область','last_id' => '9066'));
        $this->insert('regions',array('name' => 'Самаркандская область','last_id' => '9069'));
        $this->insert('regions',array('name' => 'Сырдарьинская область','last_id' => '9071'));
        $this->insert('regions',array('name' => 'Сурхандарьинская область','last_id' => '9070'));
        $this->insert('regions',array('name' => 'Ташкентская область','last_id' => '9072'));
        $this->insert('regions',array('name' => 'Ташкент','last_id' => '9063','last_id' => '9285'));
        $this->insert('regions',array('name' => 'Республика Каракалпакстан','last_id' => '9075'));

        // Lotincha variantini kiritish

        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '1', 'field_name' => 'name', 'field_value' => 'Andijon viloyati',  'language_code' => 'uz',));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '2', 'field_name' => 'name', 'field_value' => 'Buxoro viloyati', 'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '3', 'field_name' => 'name', 'field_value' => 'Farg\'ona viloyati', 'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '4', 'field_name' => 'name', 'field_value' => 'Jizzax viloyati', 'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '5', 'field_name' => 'name', 'field_value' => 'Xorazm viloyati', 'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '6', 'field_name' => 'name', 'field_value' => 'Namangan viloyati', 'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '7', 'field_name' => 'name', 'field_value' => 'Navoiy viloyati', 'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '8', 'field_name' => 'name', 'language_code' => 'uz', 'field_value' => 'Qashqadaryo viloyati', 'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '9', 'field_name' => 'name', 'field_value' => 'Samarqand viloyati', 'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '10', 'field_name' => 'name', 'field_value' => 'Sirdaryo viloyati', 'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '11', 'field_name' => 'name', 'field_value' => 'Surxondaryo viloyati', 'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '12', 'field_name' => 'name', 'field_value' => 'Toshkent viloyati', 'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '13', 'field_name' => 'name', 'field_value' => 'Toshkent shahri', 'language_code' => 'uz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '14', 'field_name' => 'name', 'field_value' => 'Qoraqalpog\'iston Respublikasi', 'language_code' => 'uz', ));

        // Kirilcha variantini kiritish

        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '1', 'field_name' => 'name', 'field_value' => 'Андижон вилояти',  'language_code' => 'oz',));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '2', 'field_name' => 'name', 'field_value' => 'Бухоро вилояти', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '3', 'field_name' => 'name', 'field_value' => 'Фарғона вилояти', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '4', 'field_name' => 'name', 'field_value' => 'Жиззах вилояти', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '5', 'field_name' => 'name', 'field_value' => 'Хоразм вилояти', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '6', 'field_name' => 'name', 'field_value' => 'Наманган вилояти', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '7', 'field_name' => 'name', 'field_value' => 'Навоий вилояти', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '8', 'field_name' => 'name', 'field_value' => 'Қашқадарё вилояти', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '9', 'field_name' => 'name', 'field_value' => 'Самарқанд вилояти', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '10', 'field_name' => 'name', 'field_value' => 'Сирдарё вилояти', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '11', 'field_name' => 'name', 'field_value' => 'Сурхондарё вилояти', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '12', 'field_name' => 'name', 'field_value' => 'Тошкент вилояти', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '13', 'field_name' => 'name', 'field_value' => 'Тошкент шаҳри', 'language_code' => 'oz', ));
        $this->insert('translates',array('table_name' => 'regions', 'field_id' => '14', 'field_name' => 'name', 'field_value' => 'Қорақалпоғистон Республикаси', 'language_code' => 'oz', ));
    $slugify = new Slugify();
    $regions = \backend\models\references\Regions::find()->asArray()->all();
    foreach($regions as $region){
        $keyword = $slugify->slugify($region['name']);
        $this->update('regions', ['keyword' => $keyword], ['id' => $region['id']]);
    }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%regions}}');
    }
}
