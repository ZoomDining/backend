<?php

namespace common\models\search;

use Yii;

/**
 * OrdersSearch represents the model behind the search form about `common\models\Orders`.
 */
class OrdersSearchCanceled extends OrdersSearch
{

    /**
     * @param $query
     * @return mixed
     */
    public function setStatusQueryParams($query){
        $query->andWhere('orders.status=3');
        return $query;
    }

}