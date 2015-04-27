<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Recommended;

/**
 * RecommendedSearch represents the model behind the search form about `common\models\Recommended`.
 */
class RecommendedSearch extends Recommended
{
    public $menu;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['id', 'available_online'], 'integer'],
//            [['menu_id', 'price', 'description'], 'safe'],
            [['menu_id','menu'], 'safe'],
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
        $query = Recommended::find();
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
            'id' => $this->id,
            'menu_id' => $this->menu_id,
            'available_online' => $this->available_online,
        ]);

        $query->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'menu.name', $this->menu]);

        return $dataProvider;
    }
}
