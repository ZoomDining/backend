<?php
namespace api\controllers;

use common\models\User;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;

class FavoritesController extends ActiveController{

    public $modelClass = 'common\models\Favorites';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth'  => function($username, $password){
                $result = User::findByUsernamePassword($username, $password);
                return $result;
            }
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['user'],
                ],
            ],
        ];

        return $behaviors;
    }
}


/*
// get favorites
curl http://user:user@restaurant.dev/api/favorites


//add favorites
curl -X POST -d user_id=3 -d restaurant_id=12 http://user:user@restaurant.dev/api/favorites

*/