<?php

namespace frontend\controllers;

use common\models\Recommended;
use common\models\search\RecommendedSearch;
use Yii;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class RecommendedController extends ManagerController
{

    public function getModelName(){
        return Recommended::className();
    }
    public function getModelSearchName(){
        return RecommendedSearch::className();
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
        $query[$searchModel->formName()]["menu"] = Yii::$app->request->post("searchName");
        return $query;
    }
}
