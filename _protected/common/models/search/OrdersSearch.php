<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Orders;

/**
 * OrdersSearch represents the model behind the search form about `common\models\Orders`.
 */
class OrdersSearch extends Orders
{

    public $username;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'restaurant_id', 'date', 'table', 'guests', 'type', 'status'], 'integer'],
            [['username'], 'safe'],
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
    public function search($params)
    {
        $query = Orders::find();
        $query->joinWith(['user']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'orders.id' => $this->id,
            'user_id' => $this->user_id,
            'restaurant_id' => $this->restaurant_id,
            'date' => $this->date,
            'table' => $this->table,
            'guests' => $this->guests,
            'type' => $this->type,
            'orders.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user.username', $this->username]);

        $query->andFilterWhere(['>=', 'date', $this->datestart]);
        $query->andFilterWhere(['<', 'date', $this->dateend]);

        $this->setStatusQueryParams($query);

        return $dataProvider;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function setStatusQueryParams($query){

        return $query;
    }
}
