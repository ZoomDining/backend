<?php

namespace common\models\search;

use Yii;

/**
 * OrdersSearch represents the model behind the search form about `common\models\Orders`.
 */
class OrdersSearchNewPreparing extends OrdersSearch
{

    /**
     * @param $query
     * @return mixed
     */
    public function setStatusQueryParams($query){
        $query->andWhere(['in', 'orders.status', [0,1]]);
        return $query;
    }

}
