<?php

namespace frontend\controllers;

use Yii;
use common\models\Orders;
use common\models\search\OrdersSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReservationsController implements the CRUD actions for Orders model.
 */
class ReservationsController extends Controller
{
    public $currentType = 4;

    public function behaviors()
    {
        $result = [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['restaurant'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];

        $result['access']['rules'][] = [
            'allow'         => true,
            'roles'         => ['manager'],
            'matchCallback' => function(){
                return Yii::$app->user->can("controllerAccess",["controller"=>"orders"]);
            }
        ];

        return $result;
    }

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search($this->getSearchParams());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @return array|mixed
     */
    public function getSearchParams()
    {
        $searchModel = new OrdersSearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams[$searchModel->formName()]["type"] = $this->currentType;
        $queryParams[$searchModel->formName()]["username"] = Yii::$app->request->post("searchName");
        return $queryParams;
    }
}
