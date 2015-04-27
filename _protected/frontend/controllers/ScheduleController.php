<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;


class ScheduleController extends Controller
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
                    [
                        'allow'         => true,
                        'roles'         => ['manager'],
                        'matchCallback' => function(){
                            return Yii::$app->user->can("controllerAccess",["controller"=>"schedule"]);
                        }
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        return $this->render('index');
    }
}
