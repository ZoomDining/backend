<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RestaurantProfile;

/**
 * RestaurantProfileSearch represents the model behind the search form about `common\models\RestaurantProfile`.
 */
class RestaurantAdvancedProfileSearch extends RestaurantProfile
{

    public $menu;
    public $category_id;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id', 'halal', 'non_halal', 'vegetarian', 'pork_free', 'vegan'], 'integer'],
            [['name', 'description','city','address','menu'], 'safe'],
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

        $query->andFilterWhere([
            'user_id' => $this->user_id,
        ]);
        $query->andFilterWhere(['like', 'restaurant_profile.name', $this->name])
            ->andFilterWhere(['like', 'restaurant_profile.description', $this->description])
            ->andFilterWhere(['like', 'restaurant_profile.city', $this->city])
            ->andFilterWhere(['like', 'restaurant_profile.address', $this->address])
            ->andFilterWhere(['like', 'menu.name', $this->menu])
            ->andFilterWhere(['=', 'menu.category_id', $this->category_id])

            ->andFilterWhere(['=', 'halal', $this->halal])
            ->andFilterWhere(['=', 'non_halal', $this->non_halal])
            ->andFilterWhere(['=', 'vegetarian', $this->vegetarian])
            ->andFilterWhere(['=', 'pork_free', $this->pork_free])
            ->andFilterWhere(['=', 'vegan', $this->vegan])


        ;

        return $dataProvider;
    }
}
