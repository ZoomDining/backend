<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RestaurantReceipt;

/**
 * RestaurantReceiptSearch represents the model behind the search form about `common\models\RestaurantReceipt`.
 */
class RestaurantReceiptSearch extends RestaurantReceipt
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'show_description'], 'integer'],
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
        $query = RestaurantReceipt::find();

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
            'show_description' => $this->show_description,
        ]);

        return $dataProvider;
    }
}
