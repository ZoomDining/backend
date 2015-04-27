<?php
namespace api\controllers;

use common\models\Orders;
use common\models\RestaurantNotification;
use common\models\RestaurantProfile;
use Yii;
use common\models\User;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;

class OrdersController extends ActiveController{

    public $modelClass = 'common\models\Orders';



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

    /**
     * @param $order_id
     * @return mixed
     */
    public function actionEmail($order_id){
        $result = $this->sendEmailNotification($order_id);
        return json_encode(array());
    }

    /**
     * @param $id
     * @return mixed
     */
    static public function sendEmailNotification($id)
    {

        $order_info = Orders::findOne($id);
        $restaurant_id = $order_info->restaurant_id;

        $restaurant_email = RestaurantProfile::findOne($restaurant_id)->email;
        $notification_email = RestaurantNotification::findOne($restaurant_id)->email;
        $user_email = User::findOne($order_info->user_id)->email;
//        $restaurant_email = "test@gmail.com";

        $subject = 'New order #'.$id;

        $result = false;
        if(!empty($restaurant_email)) {
            //docs https://github.com/yiisoft/yii2/blob/master/docs/guide/tutorial-mailing.md
            $result = Yii::$app->mail->compose('mail', [
                'order_id' => $id,
            ])
                ->setFrom(Yii::$app->params["adminEmail"])
                ->setTo($restaurant_email)
                ->setSubject($subject)
                ->send();
        }


        if(!empty($notification_email)) {
            $result = Yii::$app->mail->compose('mail', [
                'order_id' => $id,
            ])
                ->setFrom(Yii::$app->params["adminEmail"])
                ->setTo($notification_email)
                ->setSubject($subject)
                ->send();
        }

        if(!empty($user_email)) {
            $result = Yii::$app->mail->compose('mail', [
                'order_id' => $id,
            ])
                ->setFrom(Yii::$app->params["adminEmail"])
                ->setTo($user_email)
                ->setSubject($subject)
                ->send();
        }

        return $result;
    }


}


/*
// get orders
curl http://user:user@restaurant.dev/api/orders
//add order
curl -X POST -d date=7777777 -d restaurant_id=12 -d guests=2 -d type=1 http://user:user@restaurant.dev/api/orders
{"date":"7777777","restaurant_id":"12","guests":"2","type":"1","user_id":3,"id":15,"ordersItems":[]}

//add items
curl -X POST -d date=7777777 -d restaurant_id=12 -d guests=2 -d type=1 http://user:user@restaurant.dev/api/orders

//send email
curl http://user:user@restaurant.dev/api/orders/email?order_id=8
*/