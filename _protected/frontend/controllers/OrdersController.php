<?php

namespace frontend\controllers;

use common\models\search\OrdersSearchCanceled;
use common\models\search\OrdersSearchCompleted;
use common\models\search\OrdersSearchNewPreparing;
use common\models\Tables;
use common\models\User;
use common\models\UserProfile;
use Yii;
use common\models\Orders;
use common\models\search\OrdersSearch;

class OrdersController extends ManagerController
{

    public $disableCreateBtn = true;
    public $currentType = 0;

    public function getModelName(){
        return Orders::className();
    }
    public function getModelSearchName(){
        return OrdersSearch::className();
    }


    public function behaviors()
    {
        $result = parent::behaviors();

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
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($id = 0)
    {
        // return edit form
        if(Yii::$app->request->isAjax && !empty($id)){
            $model = $this->findModel($id);
            return $this->renderAjax('form', [
                'model' => $model,
                'isIndex' => false,
            ]);
        }

        // providers for gridview
        $isIndex = true;

        //NewPreparing
        $searchModelNewPreparing = new OrdersSearchNewPreparing();
        $queryParamsNewPreparing = Yii::$app->request->queryParams;
        $queryParamsNewPreparing[$searchModelNewPreparing->formName()]["type"] = $this->currentType;
        $queryParamsNewPreparing[$searchModelNewPreparing->formName()]["username"] = Yii::$app->request->post("username");
        $queryParamsNewPreparing[$searchModelNewPreparing->formName()]["id"] = Yii::$app->request->post("order_id");
        $dataProviderNewPreparing = $searchModelNewPreparing->search($queryParamsNewPreparing);

        //Completed
        $searchModelCompleted = new OrdersSearchCompleted();
        $queryParamsCompleted = Yii::$app->request->queryParams;
        $queryParamsCompleted[$searchModelCompleted->formName()]["type"] = $this->currentType;
        $queryParamsCompleted[$searchModelCompleted->formName()]["username"] = Yii::$app->request->post("username");
        $queryParamsCompleted[$searchModelCompleted->formName()]["id"] = Yii::$app->request->post("order_id");
        $dataProviderCompleted = $searchModelCompleted->search($queryParamsCompleted);

        //Completed
        $searchModelCanceled = new OrdersSearchCanceled();
        $queryParamsCanceled = Yii::$app->request->queryParams;
        $queryParamsCanceled[$searchModelCanceled->formName()]["type"] = $this->currentType;
        $queryParamsCanceled[$searchModelCanceled->formName()]["username"] = Yii::$app->request->post("username");
        $queryParamsCanceled[$searchModelCanceled->formName()]["id"] = Yii::$app->request->post("order_id");
        $dataProviderCanceled = $searchModelCanceled->search($queryParamsCanceled);


        // if GET with id, then will display edit form, else add form
        if(empty($id)) {
            $model = new $this->modelName;
        }else{
            $model= $this->findModel($id);
            $isIndex = false;
        }

        $this->update($model, $id);

        // display gridview and form
        return $this->render("//managerIndex",[
            "table" => $this->renderPartial('table', [
                'currentType'              => $this->currentType,
                'searchModelNewPreparing'  => $searchModelNewPreparing,
                'dataProviderNewPreparing' => $dataProviderNewPreparing,
                'searchModelCompleted'     => $searchModelCompleted,
                'dataProviderCompleted'    => $dataProviderCompleted,
                'searchModelCanceled'      => $searchModelCanceled,
                'dataProviderCanceled'     => $dataProviderCanceled,
            ]),
            "form"  => $this->renderPartial('form', [
                'model' => $model,
                'isIndex' => $isIndex,
            ]),
            'disableCreateBtn' => $this->disableCreateBtn,
        ]);
    }

    /**
     * @param $model
     * @return \yii\web\Response
     */
    public function update($model, $id){

        //modify status
        if(isset($_POST["status"])){
            $model->status = Yii::$app->request->post("status");
            $model->save(false);

            //send email
            $this->sendEmailStatus($model);

            //send push alert
            $this->sendPush($model);

            return $this->redirect(['index',  'id' => $id]);
        }

        //create new or update records
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function renderPartial($view, $params = [])
    {
        $view = "//orders/".$view;
        return parent::renderPartial($view, $params);
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function renderAjax($view, $params = [])
    {
        $view = "//orders/".$view;
        return parent::renderAjax($view, $params);
    }


    /**
     * @param int $id table_id
     */
    public function actionGetTableOrders($id = 0)
    {

        if (Yii::$app->request->isAjax && !empty($id)) {

            $dayStart = mktime(0,0,0);

            $orders = Orders::find()
                ->where(['and', '`table`='.intval($id), ['and', 'type=0', ['between', 'date', $dayStart, $dayStart + 86400]]])
                ->orderBy(["date" => SORT_ASC])
                ->all();

            if(empty($orders)){
                return;
            }

            $orders_js = '';
            foreach ((array)$orders as $_info) {
                $title = User::findIdentity($_info->user_id)->username." : ".$_info->id;
                $description = "Table: ".Tables::findOne($_info->table)->name;
                $start = date('c', $_info->date);

                $orders_js[] = [
                    "id"          => $_info->id,
                    "title"       => $title,
                    "description" => $description,
                    "start"       => $start,

                ];
            }

            echo json_encode($orders_js);
        }
        return;

    }


    /**
     * @param $table_id
     * @param $order_id
     */
    public function actionSetTableOrder($table_id, $order_id)
    {

        if (!Yii::$app->request->isAjax) {
            return;
        }

        Orders::updateAll(["table"=>$table_id], ["id"=>$order_id]);

//        $model= $this->findModel($order_id);
//        $model->table = $table_id;
//        $model->save();


        echo "ok";
        return;
    }


    /**
     * @param $order_id
     * @param int $status
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSetStatusOrder($order_id, $status = 0)
    {
        if (!Yii::$app->request->isAjax) {
            return;
        }

        Orders::updateAll(["status"=>$status], ["id"=>$order_id]);

        $model = $this->findModel($order_id);
		
		//send email
		$this->sendEmailStatus($model);

		//send push alert
		$this->sendPush($model);
		
//        $model->status = $status;
//        $model->save();

        echo "ok";
        return;
    }

    /**
     *
     */
    public function actionGetLiveOrders()
    {
        if (!Yii::$app->request->isAjax) {
            return;
        }

        $dayStart = mktime(0,0,0);
        $orders = Orders::find()
            ->where(['and', '`table`=0', 'type=0', 'status=0', ['between', 'date', $dayStart, $dayStart + 86400]])
            ->orderBy(["date" => SORT_ASC])
            ->all();


        echo $this->renderAjax("liveUpdate", [
            "orders"    => $orders,
        ]);

        return;
    }

    /**
     *
     */
    public function actionSendEmailStatus($order_id)
    {
        if (!Yii::$app->request->isAjax) {
            return;
        }

        $model= $this->findModel($order_id);
        $result = $this->sendEmailStatus($model);

        if($result){
            echo "ok";
        }else{
            echo "error";
        }

        return;
    }

    /**
     * @param $order_id
     * @return mixed
     *
     * send email to user about new status
     */
    static public function sendEmailStatus($model)
    {

        $subject = 'Status changed';
        $text = 'The status of your order has been changed to "'.$model->getStatuses($model->status).'"';

        //docs https://github.com/yiisoft/yii2/blob/master/docs/guide/tutorial-mailing.md
        $result = Yii::$app->mail->compose()
            ->setFrom(Yii::$app->params["adminEmail"])
            ->setTo(User::findIdentity($model->user_id)->email)
//            ->setTo("nordast@gmail.com")
            ->setSubject($subject)
            ->setTextBody($text)
//          ->setHtmlBody('<b>HTML content</b>')
            ->send();

        return $result;
    }


    /**
     * @param $model
     *
     *
     *  push info to parse.com
     *
     * docs https://parse.com/questions/php-rest-example-of-targeted-push
     *
     */
    static public function sendPush($model)
    {
        $device_id = UserProfile::findOne(["user_id"=>$model->user_id])->device_id;

        if(empty($device_id)){
            return;
        }

        $url = 'https://api.parse.com/1/push';

        $appId = Yii::$app->params["parse_app_id"];
        $restKey = Yii::$app->params["parse_rest_key"];

        $text = 'The status of your order has been changed to "'.$model->getStatuses($model->status).'"';

        $push_payload = json_encode(array(
            "where" => array(
                "installationId" => $device_id, // using installation Id of target Installation.
            ),
            "data" => array(
                "alert" => $text
            )
        ));

        $rest = curl_init();
        curl_setopt($rest,CURLOPT_URL,$url);
        curl_setopt($rest,CURLOPT_PORT,443);
        curl_setopt($rest,CURLOPT_POST,1);
        curl_setopt($rest,CURLOPT_POSTFIELDS,$push_payload);
        curl_setopt($rest,CURLOPT_HTTPHEADER,
            array("X-Parse-Application-Id: " . $appId,
                "X-Parse-REST-API-Key: " . $restKey,
                "Content-Type: application/json"));

        $response = curl_exec($rest);
        return $response;
    }

}
