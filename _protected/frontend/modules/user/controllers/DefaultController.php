<?php

namespace frontend\modules\user\controllers;

use common\models\RestaurantProfile;
use frontend\modules\user\models\AccountForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $model = new AccountForm();
        $model->username = $user->username;
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            RestaurantProfile::updateAll([
                "security_question" => Yii::$app->request->post("security_question"),
            ], "user_id=".$user->id);

            $user->username = $model->username;
            $user->setPassword($model->password);
            $user->save();
            Yii::$app->session->setFlash('alert', [
                'options'=>['class'=>'alert-success'],
                'body'=>Yii::t('frontend', 'Your profile has been successfully saved')
            ]);


            return $this->refresh();
        }


        return $this->render('index', ['model'=>$model]);
    }

    public function actionProfile()
    {
        $model = Yii::$app->user->identity->profile;
        if($model->load($_POST) && $model->save()){
            Yii::$app->session->setFlash('alert', [
                'options'=>['class'=>'alert-success'],
                'body'=>Yii::t('frontend', 'Your profile has been successfully saved')
            ]);
            return $this->refresh();
        }
        return $this->render('profile', ['model'=>$model]);
    }
}
