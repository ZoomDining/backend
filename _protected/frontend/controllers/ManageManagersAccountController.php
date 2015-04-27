<?php

namespace frontend\controllers;

use Yii;
use common\models\Manager;
use common\models\search\ManagerSearch;

class ManageManagersAccountController extends ManagerController
{

    public function getModelName(){
        return Manager::className();
    }

    public function getModelSearchName(){
        return ManagerSearch::className();
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
