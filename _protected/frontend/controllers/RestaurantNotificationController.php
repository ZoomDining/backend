<?php

namespace frontend\controllers;

use Yii;
use common\models\RestaurantNotification;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;


/**
 * RestaurantNotificationController implements the CRUD actions for RestaurantNotification model.
 */
class RestaurantNotificationController extends Controller
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
                ],
            ],
        ];
    }

    /**
     * Lists all RestaurantNotification models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = $this->findModel($this->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Finds the RestaurantNotification model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RestaurantNotification the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RestaurantNotification::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
