<?php
namespace api\controllers;

use common\models\User;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;

class OrdersItemsController extends ActiveController{

    public $modelClass = 'common\models\OrdersItems';



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
//add items
curl -X POST -d order_id=15 -d menu_id=10 -d count=5 http://user:user@restaurant.dev/api/orders-items

*/