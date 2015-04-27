<?php

namespace frontend\controllers;

use Yii;
use common\models\Categories;
use common\models\search\CategoriesSearch;

class CategoryController extends ManagerController
{

    public function getModelName(){
        return Categories::className();
    }
    public function getModelSearchName(){
        return CategoriesSearch::className();
    }

    public function behaviors()
    {
        $result = parent::behaviors();

        $result['access']['rules'][] = [
            'allow'         => true,
            'roles'         => ['manager'],
            'matchCallback' => function(){
                return Yii::$app->user->can("controllerAccess",["controller"=>"items"]);
            }
        ];

        return $result;
    }

    /**
     * @return array|mixed
     */
    public function getSearchParams()
    {
        $searchModel = new $this->modelSearchName;
        $query = Yii::$app->request->queryParams;
        $query[$searchModel->formName()]["name"] = Yii::$app->request->post("searchName");
        return $query;
    }
}
