<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RestaurantProfile;

/**
 * RestaurantProfileSearch represents the model behind the search form about `common\models\RestaurantProfile`.
 */
class RestaurantProfileSearch extends RestaurantProfile
{

    public $query;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['query'], 'safe'],
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
        $query = RestaurantProfile::find();

        $query->joinWith(['menu']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->sort->attributes['menu'] = [
            'asc' => ['menu.name' => SORT_ASC],
            'desc' => ['menu.name' => SORT_DESC],
        ];

        $this->load($params);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->orFilterWhere([
            'user_id' => $this->user_id,
        ]);

        $query->orFilterWhere(['like', 'restaurant_profile.name', $this->query])
            ->orFilterWhere(['like', 'restaurant_profile.description', $this->query])
            ->orFilterWhere(['like', 'restaurant_profile.city', $this->query])
            ->orFilterWhere(['like', 'restaurant_profile.address', $this->query])
            ->orFilterWhere(['like', 'menu.name', $this->query])
        ;

        return $dataProvider;
    }
}
