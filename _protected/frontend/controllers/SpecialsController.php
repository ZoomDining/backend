<?php

namespace frontend\controllers;

use common\models\Specials;
use common\models\search\SpecialsSearch;
use Yii;

/**
 * SpecialsController implements the CRUD actions for Specials model.
 */
class SpecialsController extends ManagerController
{

    public function getModelName(){
        return Specials::className();
    }
    public function getModelSearchName(){
        return SpecialsSearch::className();
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
