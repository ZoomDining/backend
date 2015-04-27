<?php

namespace frontend\controllers;

use common\models\search\RestaurantProfileSearch;
use Yii;
use common\models\RestaurantProfile;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RestaurantProfileController implements the CRUD actions for RestaurantProfile model.
 */
class RestaurantProfileController extends Controller
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
     * Lists all RestaurantProfile models.
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
     * Finds the RestaurantProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RestaurantProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RestaurantProfile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
