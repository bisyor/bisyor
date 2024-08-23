<?php

namespace backend\models\banners;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use backend\models\references\Translates; 
use backend\models\users\Users;

use Yii;

/**
 * This is the model class for table "banners_statistic".
 *
 * @property int $id
 * @property int|null $banner_id Рекламный баннер
 * @property string|null $date Дата
 * @property int|null $clicks Количество кликов
 * @property int|null $shows Количество просмотров
 *
 * @property Banners $banner
 */
class BannersStatistic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banners_statistic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['banner_id', 'clicks', 'shows'], 'default', 'value' => null],
            [['banner_id', 'clicks', 'shows'], 'integer'],
            [['date'], 'safe'],
            [['banner_id'], 'exist', 'skipOnError' => true, 'targetClass' => BannersItems::className(), 'targetAttribute' => ['banner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'banner_id' => 'Рекламный баннер',
            'date' => 'Дата',
            'clicks' => 'Количество кликов',
            'shows' => 'Количество просмотров',
        ];
    }

    public function search($params, $id)
    {
        $banners = array_column(BannersItems::find()->where(['banner_id' => $id])->asArray()->all(), 'id');
        $query = BannersStatistic::find()->joinWith(['bannerItems'])->where(['in', 'banners_statistic.banner_id', $banners])->orderBy(['date' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'banner_id', $this->banner_id])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'clicks', $this->clicks]);

        return $dataProvider;
    }

    /**
     * Gets query for [[Banner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBannerItems()
    {
        return $this->hasOne(BannersItems::className(), ['id' => 'banner_id']);
    }
}
