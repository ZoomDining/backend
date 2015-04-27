<?php

namespace frontend\controllers;

use common\models\Menu;
use common\models\search\MenuSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends ManagerController
{

    public function getModelName(){
        return Menu::className();
    }
    public function getModelSearchName(){
        return MenuSearch::className();
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
