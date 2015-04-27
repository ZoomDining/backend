<?php

namespace frontend\controllers;

use common\models\Sets;
use common\models\search\SetsSearch;
use Yii;

/**
 * SetsController implements the CRUD actions for Sets model.
 */
class SetsController extends ManagerController
{

    public function getModelName(){
        return Sets::className();
    }
    public function getModelSearchName(){
        return SetsSearch::className();
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
        $query[$searchModel->formName()]["category_id"] = Yii::$app->request->post("searchCategory");
        return $query;
    }
}
