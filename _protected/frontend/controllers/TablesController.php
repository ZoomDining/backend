<?php

namespace frontend\controllers;

use common\models\Tables;
use common\models\search\TablesSearch;
use Yii;
use yii\filters\AccessControl;

/**
 * TablesController implements the CRUD actions for Tables model.
 */
class TablesController extends ManagerController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['restaurant'],
                    ],
                ],
            ],
        ];
    }

    public function getModelName(){
        return Tables::className();
    }
    public function getModelSearchName(){
        return TablesSearch::className();
    }

}
