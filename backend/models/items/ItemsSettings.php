<?php

namespace backend\models\items;

use Yii;
use yii\base\Model;
use backend\models\settings\Settings;


class ItemsSettings extends Model
{
    public $the_term_of_publication_of_the_announcement;
    public $the_term_of_ad_renewal_period_365;
    public $notify_users_of_the_completion_of_publishing_ads_the_1_day;
    public $notify_users_of_the_completion_of_publishing_ads_the_2_day;
    public $notify_users_of_the_completion_of_publishing_ads_the_5_day;

    public function rules()
    {
        return [
            [['the_term_of_publication_of_the_announcement','the_term_of_ad_renewal_period_365','notify_users_of_the_completion_of_publishing_ads_the_1_day' ,'notify_users_of_the_completion_of_publishing_ads_the_2_day' ,'notify_users_of_the_completion_of_publishing_ads_the_5_day' ],'integer'],
        ];
    }


    /**
     * setingsdagi qiymatlarni olish
     */
    public function getValueSettingis()
    {
        $public_duration = Settings::find()
                            ->where(['key'=>'the_term_of_publication_of_the_announcement'])
                            ->one();
        $renewal_period  = Settings::find()
                            ->where(['key'=>'the_term_of_ad_renewal_period_365'])
                            ->one();

        $the_1_day  = Settings::find()
                            ->where(['key'=>'notify_users_of_the_completion_of_publishing_ads_the_1_day'])
                            ->one();
        $the_2_day  = Settings::find()
                            ->where(['key'=>'notify_users_of_the_completion_of_publishing_ads_the_2_day'])
                            ->one();
        $the_5_day  = Settings::find()
                            ->where(['key'=>'notify_users_of_the_completion_of_publishing_ads_the_5_day'])
                            ->one();
        $this->the_term_of_publication_of_the_announcement = $public_duration->value;
        $this->the_term_of_ad_renewal_period_365 = $renewal_period->value;
        $this->notify_users_of_the_completion_of_publishing_ads_the_1_day = $the_1_day->value;
        $this->notify_users_of_the_completion_of_publishing_ads_the_2_day = $the_2_day->value;
        $this->notify_users_of_the_completion_of_publishing_ads_the_5_day = $the_5_day->value;

    }


    /**
     * setiingsga qiymatlarni saqlash
     */
    public function setSaveSettings()
    {       
            $public_duration = Settings::find()
                                ->where(['key'=>'the_term_of_publication_of_the_announcement'])
                                ->one();
            $renewal_period  = Settings::find()
                                ->where(['key'=>'the_term_of_ad_renewal_period_365'])
                                ->one();

            $the_1_day  = Settings::find()
                                ->where(['key'=>'notify_users_of_the_completion_of_publishing_ads_the_1_day'])
                                ->one();
            $the_2_day  = Settings::find()
                                ->where(['key'=>'notify_users_of_the_completion_of_publishing_ads_the_2_day'])
                                ->one();
            $the_5_day  = Settings::find()
                                ->where(['key'=>'notify_users_of_the_completion_of_publishing_ads_the_5_day'])
                                ->one();

            $public_duration->value = $this->the_term_of_publication_of_the_announcement;
            $public_duration->save();

            $renewal_period->value = $this->the_term_of_ad_renewal_period_365;
            $renewal_period->save();

            $the_1_day->value = $this->notify_users_of_the_completion_of_publishing_ads_the_1_day;
            $the_1_day->save();

            $the_2_day->value = $this->notify_users_of_the_completion_of_publishing_ads_the_2_day;
            $the_2_day->save();

            $the_5_day->value = $this->notify_users_of_the_completion_of_publishing_ads_the_5_day;
            $the_5_day->save();

    }
}
