<?php
namespace api\controllers;

use common\models\RestaurantProfile;
use common\models\search\RestaurantAdvancedProfileSearch;
use common\models\search\RestaurantProfileSearch;
use common\models\User;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use Yii;

class RestaurantController extends ActiveController{

    public $modelClass = 'common\models\RestaurantProfile';

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

    public function actionSearchNearest($lat, $lng, $distance = "1"){
        return RestaurantProfile::getRestaurantsDistance($lat, $lng, $distance);
    }

    public function actionSearch(){
        $model = new RestaurantProfileSearch();

        return $model->search([$model->formName() => Yii::$app->request->queryParams]);
    }

    public function actionAdvancedSearch(){
        $model = new RestaurantAdvancedProfileSearch();

        return $model->search([$model->formName() => Yii::$app->request->queryParams]);
    }
}



/*
// get restaurants
curl http://restaurant.dev/api/restaurant
// restaurant info
curl http://restaurant.dev/api/restaurant/12?expand=categories,menu,sets,specials,recommended


// JSON
curl -i -H "Accept: application/json" http://representpdx.com/api/restaurant
// XML
curl -i -H "Accept: application/xml" http://representpdx.com/api/restaurant




*/