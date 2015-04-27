<?php
namespace api\controllers;

use Yii;
use common\models\search\MenuSearch;
use common\models\User;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;

class MenuController extends ActiveController{

    public $modelClass = 'common\models\Menu';



    public function behaviors()
    {
        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
//            'class' => HttpBasicAuth::className(),
//            'auth'  => function($username, $password){
//                $result = User::findByUsernamePassword($username, $password);
//                return $result;
//            }
//        ];
//
//        $behaviors['access'] = [
//            'class' => AccessControl::className(),
//            'rules' => [
//                [
//                    'allow' => true,
//                    'roles' => ['user'],
//                ],
//            ],
//        ];

        return $behaviors;
    }

    public function actionSearch(){
        $model = new MenuSearch();
        return $model->search([$model->formName() => Yii::$app->request->queryParams]);
    }

}


/*
// get menu
curl http://user:user@restaurant.dev/api/menu/


*/