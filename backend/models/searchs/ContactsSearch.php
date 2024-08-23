<?php

namespace backend\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\references\Contacts;

/**
 * ContactsSearch represents the model behind the search form about `backend\models\references\Contacts`.
 */
class ContactsSearch extends Contacts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'user_id'], 'integer'],
            [['user_ip', 'name', 'email', 'message', 'useragent', 'date_cr', 'date_up'], 'safe'],
            [['viewed'], 'boolean'],
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
     * @return ActiveDataProvider
     */
    public function search($params, $type = null)
    {
        $query = Contacts::find()
            ->andFilterWhere(['type' => $type])
            ->orderBy('id desc');

        if($type != null){
            $query->andFilterWhere(['or',
               [ 'is', 'viewed', new \yii\db\Expression('null')],
                ['!=', 'viewed', 1]
            ]);
        }

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
            'type' => $this->type,
            'user_id' => $this->user_id,
            'date_cr' => $this->date_cr,
            'date_up' => $this->date_up,
            'viewed' => $this->viewed,
        ]);

        $query->andFilterWhere(['like', 'user_ip', $this->user_ip])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'useragent', $this->useragent]);

        return $dataProvider;
    }
}
