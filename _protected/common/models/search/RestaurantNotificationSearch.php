<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RestaurantNotification;

/**
 * RestaurantNotificationSearch represents the model behind the search form about `common\models\RestaurantNotification`.
 */
class RestaurantNotificationSearch extends RestaurantNotification
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'daily_summary', 'events_info', 'customer_feedback', 'transaction_email'], 'integer'],
            [['email'], 'safe'],
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
        $query = RestaurantNotification::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'daily_summary' => $this->daily_summary,
            'events_info' => $this->events_info,
            'customer_feedback' => $this->customer_feedback,
            'transaction_email' => $this->transaction_email,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
