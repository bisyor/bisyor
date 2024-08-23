<?php

namespace backend\models\users;

use backend\models\items\Items;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UsersSearch represents the model behind the search form about `backend\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * @inheritdoc
     */
    public $reg_from;
    public $reg_to;
    public $last_from;
    public $last_to;
    public $regionId;
    public $count;
    public $device;
    public function rules()
    {
        return [
            [['id', 'status', 'sex', 'expiret_at', 'district_id', 'regionId','count'], 'integer'],
            [['reg_from', 'reg_to', 'last_from', 'last_to', 'login', 'phone', 'email', 'password', 'fio', 'avatar', 'lang_code', 'birthday', 'address', 'phones', 'coordinate_x', 'coordinate_y', 'telegram', 'site', 'last_seen', 'access_token', 'resume_file', 'admin_comment', 'sms_code', 'google_api_key', 'facebook_api_key', 'telegram_api_key', 'apple_api_key', 'registry_date'], 'safe'],
            [['balance', 'referal_balance', 'bonus_balance', 'device'], 'number'],
            [['is_verify','email_news_alert', 'email_message_alert', 'email_comment_alert', 'email_fav_ads_price_alert', 'sms_news_alert', 'sms_comment_alert', 'sms_fav_ads_price_alert', 'email_verified', 'phone_verified'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @param $type
     * @return ActiveDataProvider
     */
    public function search($params, $type)
    {
        if ($type == 'user') {
            $admin = array_column(Users::find()->join('LEFT JOIN', 'user_roles', 'users.id = user_roles.user_id')
                ->where(['!=', 'user_roles.role_id', self::USER])->asArray()->all(), 'id');
            $query = Users::find()
                ->select(['users.*','(select count(*) from items where items.user_id=users.id) as count'])
                ->join('LEFT JOIN', 'user_roles', 'users.id = user_roles.user_id')
                ->joinWith('district')->joinWith('device')->where(['not in', 'users.id', $admin]);
        }else{
            $query = Users::find()
                ->select(['users.*','(select count(*) from items where items.user_id=users.id) as count'])
                ->join('LEFT JOIN', 'user_roles', 'users.id = user_roles.user_id')->where(['!=', 'user_roles.role_id', self::USER]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => [
                'id'=>SORT_DESC
            ],
            'attributes' => [
                'id',
                'email',
                'fio',
                'status',
                'phone',
                'last_seen',
                'count',
            ]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'districts.region_id' => $this->regionId,
            'district_id' => $this->district_id,
            'is_verify' => $this->is_verify,
            'user_history.from_device' => $this->device,
        ]);

        $query->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'fio', $this->fio]);

        if (!empty($this->reg_from) && !empty($this->reg_to)) {
            $start_reg = date("Y-m-d", strtotime($this->reg_from));
            $end_reg = date("Y-m-d", strtotime("+1 day", strtotime($this->reg_to)));
            $query->andFilterWhere(['>=', 'registry_date', $start_reg])->andFilterWhere(['<', 'registry_date', $end_reg]);
        }
        if (!empty($this->last_from) && !empty($this->last_to)) {
            $start_last = date("Y-m-d", strtotime($this->last_from));
            $end_last = date("Y-m-d", strtotime("+1 day", strtotime($this->last_to)));
            $query->andFilterWhere(['>=', 'last_seen', $start_last])->andFilterWhere(['<', 'last_seen', $end_last]);
        }

        return $dataProvider;
    }

    public function moderator($params, $type)
    {

        $moderators  = UserRoles::find()
            ->select(['user_id'])
            ->andWhere(['!=' , 'role_id' ,22])
            ->asArray()
            ->all();
        $query = Items::find()
            ->select(['moderated_id','count(items.id) as count','moderated_id as id'])
            ->with(['moderated'])
            ->andWhere(['items.moderated_id' => array_column($moderators , 'user_id')])
            ->groupBy(['items.moderated_id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query->asArray(),

        ]);



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->reg_from) && !empty($this->reg_to)) {
            $start_reg = date("Y-m-d", strtotime($this->reg_from));
            $end_reg = date("Y-m-d", strtotime("+1 day", strtotime($this->reg_to)));
            $query->andFilterWhere(['>=', 'items.moderation_date', $start_reg])
                ->andFilterWhere(['<=', 'items.moderation_date', $end_reg]);
        }

//        echo '<pre>';
//        print_r($query->asArray()->all()); die;

        return $dataProvider;
    }
}
