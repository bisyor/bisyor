<?php

namespace backend\models\shops;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ShopsSettings extends Model
{
    public $max_length_title;
    public $max_length_description;
    public $max_count_phone_numbers;
    public $max_count_social_network_links;
    public $max_count_ads_page;

    const _MAX_LENGTH_TITLE = 50;
    const _MAX_LENGTH_DESCRIPTION = 1000;
    const _MAX_COUNT_PHONE_NUMBERS = 4;
    const _MAX_COUNT_SOCIAL_NETWORK_LINKS = 5;
    const _MAX_COUNT_ADS_PAGE = 18;
    
    function __construct($foo = null)
    {
        $this->max_length_description = self::_MAX_LENGTH_DESCRIPTION;
        $this->max_count_ads_page = self::_MAX_COUNT_ADS_PAGE;
        $this->max_length_title = self::_MAX_LENGTH_TITLE;
        $this->max_count_phone_numbers = self::_MAX_COUNT_PHONE_NUMBERS;
        $this->max_count_social_network_links = self::_MAX_COUNT_SOCIAL_NETWORK_LINKS;
    }

    public function attributeLabels()
    {
        return [
            'max_length_title' => 'Максимальная длина заголовка',
            'max_length_description' => 'Описание максимальной длины',
            'max_count_phone_numbers' => 'Максимальное количество телефонных номеров',
            'max_count_ads_page' => 'Страница с максимальным количеством объявлений',
            'max_count_social_network_links' => 'Максимальное количество ссылок на социальные сети',
        ];
    }
}
