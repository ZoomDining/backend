<?php

namespace common\models\search;

use Yii;

/**
 * OrdersSearch represents the model behind the search form about `common\models\Orders`.
 */
class OrdersSearchCompleted extends OrdersSearch
{

    /**
     * @param $query
     * @return mixed
     */
    public function setStatusQueryParams($query){
        $query->andWhere('orders.status=2');
        return $query;
    }

}