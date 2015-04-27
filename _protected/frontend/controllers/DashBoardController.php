<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;

/**
 * Site controller.
 * It is responsible for displaying static pages, logging users in and out,
 * sign up and account activation, password reset.
 */
class DashBoardController extends Controller
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
