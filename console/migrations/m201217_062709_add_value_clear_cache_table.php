<?php

use yii\db\Migration;

/**
 * Class m201217_062709_add_value_clear_cache_table
 */
class m201217_062709_add_value_clear_cache_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $data = [
            ['name' => 'shopsItems', 'minutes' => '5', 'key' => 'shopsItems'],
            ['name' => 'smilarItems', 'minutes' => '10', 'key' => 'smilarItems'],
            ['name' => 'mainCategory', 'minutes' => '20', 'key' => 'mainCategory'],
            ['name' => 'chaildCategory', 'minutes' => '20', 'key' => 'chaildCategory'],
            ['name' => 'mainCategoryList', 'minutes' => '20', 'key' => 'mainCategoryList'],
            ['name' => 'chaildCategoryList', 'minutes' => '20', 'key' => 'chaildCategoryList'],
            ['name' => 'services', 'minutes' => '1140', 'key' => 'services'],
            ['name' => 'packet', 'minutes' => '1140', 'key' => 'packet'],
            ['name' => 'servicesAll', 'minutes' => '1140', 'key' => 'servicesAll'],
            ['name' => 'languageKey', 'minutes' => '1140', 'key' => 'languageKey'],
            ['name' => 'regionList', 'minutes' => '1140', 'key' => 'regionList'],
            ['name' => 'shopsTariffsList', 'minutes' => '1140', 'key' => 'shopsTariffsList'],
            ['name' => 'catDynpropSearch', 'minutes' => '60', 'key' => 'catDynpropSearch'],
            ['name' => 'topCatItemCount', 'minutes' => '60', 'key' => 'topCatItemCount'],
            ['name' => 'itemInRegion', 'minutes' => '60', 'key' => 'itemInRegion'],
            ['name' => 'currentCategory', 'minutes' => '60', 'key' => 'currentCategory'],
            ['name' => 'itemViewLikeItems', 'minutes' => '30', 'key' => 'itemViewLikeItems'],
            ['name' => 'shopCategoriesList', 'minutes' => '120', 'key' => 'shopCategoriesList'],
            ['name' => 'topPost', 'minutes' => '120', 'key' => 'topPost'],
            ['name' => 'itemView', 'minutes' => '120', 'key' => 'itemView'],
            ['name' => 'currencyList', 'minutes' => '120', 'key' => 'currencyList'],
            ['name' => 'setting', 'minutes' => '60', 'key' => 'setting'],
            ['name' => 'topShops', 'minutes' => '120', 'key' => 'topShops'],
            ['name' => 'langs', 'minutes' => '120', 'key' => 'langs'],
            ['name' => 'counters', 'minutes' => '120', 'key' => 'counters'],
            ['name' => 'topBlog', 'minutes' => '60', 'key' => 'topBlog'],
            ['name' => 'newBlogs', 'minutes' => '120', 'key' => 'newBlogs'],
            ['name' => 'premiumItems', 'minutes' => '10', 'key' => 'premiumItems'],
            ['name' => 'newItems', 'minutes' => '10', 'key' => 'newItems'],
        ];

        foreach ($data as $value) {
            $this->insert('cache_clear', $value);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201217_062709_add_value_clear_cache_table cannot be reverted.\n";

        return false;
    }

}
