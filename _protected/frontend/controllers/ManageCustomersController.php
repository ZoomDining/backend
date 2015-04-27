<?php

namespace frontend\controllers;

use Yii;
use common\models\Customer;
use common\models\search\CustomerSearch;

class ManageCustomersController extends CustomerController
{

    public function getModelName(){
        return Customer::className();
    }

    public function getModelSearchName(){
        return CustomerSearch::className();
    }

    /**
     * @return array|mixed
     */
    public function getSearchParams()
    {
        $searchModel = new $this->modelSearchName;
        $query = Yii::$app->request->queryParams;
        $query[$searchModel->formName()]["username"] = Yii::$app->request->post("searchName");
        return $query;
    }
}
