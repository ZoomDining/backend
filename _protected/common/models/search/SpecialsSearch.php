<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Specials;

/**
 * SpecialsSearch represents the model behind the search form about `common\models\Specials`.
 */
class SpecialsSearch extends Specials
{
    public $menu;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discount'], 'integer'],
//            [['menu_id', 'description'], 'safe'],
            [['menu_id','menu','available_online'], 'safe'],
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
        $query = Specials::find();
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
        ]);

        $query->andFilterWhere(['like', 'discount', $this->discount])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'menu.name', $this->menu])
            ->andFilterWhere(['like', 'available_online', $this->available_online]);


        return $dataProvider;
    }
}
