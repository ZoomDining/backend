<?php

namespace frontend\controllers;

use Yii;
use common\models\RestaurantReceipt;
use common\models\search\RestaurantReceiptSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RestaurantReceiptController implements the CRUD actions for RestaurantReceipt model.
 */
class RestaurantReceiptController extends Controller
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
     * Finds the RestaurantReceipt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RestaurantReceipt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RestaurantReceipt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
