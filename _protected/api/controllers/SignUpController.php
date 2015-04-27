<?php
namespace api\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;

class SignUpController extends ActiveController{

    public $modelClass = 'api\models\SignupUser';

    public function actions()
    {
        return null;
    }


    public function actionCreate(){

        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass();

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->validate()) {
            $model->signup();
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }

}
