<?php
namespace api\controllers;

use common\models\User;
use common\models\UserProfile;
use Yii;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;

class UserProfileController extends ActiveController{

    public $modelClass = 'common\models\UserProfile';


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

    public function actions()
    {
        $actions = parent::actions();
        $result["update"] = $actions["update"];

        return $result;
    }


    public function actionIndex()
    {
        $model = UserProfile::findOne(Yii::$app->user->id);
        return $model;
    }

}


/*
// get
curl http://user:user@restaurant.dev/api/user-profile


//update

curl -X PUT -d phone=111 -d date_of_birth=222222 -d address=33333 http://user:user@restaurant.dev/api/user-profile/3

*/