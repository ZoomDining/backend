<?php

namespace frontend\controllers;

use common\models\Menu;
use common\models\Orders;
use common\models\OrdersItems;
use common\models\RestaurantProfile;
use common\models\User;
use common\models\UserProfile;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;


class ReportsController extends Controller
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
                    ]
                ],
            ],
        ];
    }

    public function actionIndex()
    {

        //export
        if(isset($_POST["export"])){

            $this->export();
        }

        return $this->render('index');
    }

    public function export()
    {

        $report_data = $this->getDataSearch()->all();

        if (empty($report_data)) {
            echo 'No results found.';
            exit;
        }

        $result_arr = [];

        //add table headers
        $info = [];
        if (Yii::$app->request->post("personal_info")) {
            $info["personal_info"] = "personal_info";
            $info["email"] = "email";
            $info["invoice_number"] = "invoice_number";
            $info["date_of_birth"] = "date_of_birth";
            $info["sex"] = "sex";
        }
        if (Yii::$app->request->post("restaurant_name")) {
            $info["restaurant_name"] = "restaurant_name";
        }
        if (Yii::$app->request->post("restaurant_address")) {
            $info["restaurant_address"] = "restaurant_address";
        }
        if (Yii::$app->request->post("order_qty")) {
            $info["order_qty"] = "order_qty";
        }
        if (Yii::$app->request->post("order_date")) {
            $info["order_date"] = "order_date";
        }
        if (Yii::$app->request->post("order_number")) {
            $info["order_number"] = "order_number";
        }
        if (Yii::$app->request->post("order_amount")) {
            $info["order_amount"] = "order_amount";
        }

        $info["delivery_info"] = "delivery_info";

        if (Yii::$app->request->post("product_caption") || Yii::$app->request->post("product_qty") || Yii::$app->request->post("product_price") || Yii::$app->request->post("product_tax")) {
            $info["products_info"] = "products_info";
        }

        $result_arr[] = $info;

        foreach ($report_data as $data) {
            $info = [];

            if (Yii::$app->request->post("personal_info")) {
                $info["personal_info"] = ReportsController::getPersonalInfo($data->user_id);
                $info["email"] = ReportsController::getEmail($data->user_id);
                $info["invoice_number"] = ReportsController::getInvoiceNumber($data->user_id);
                $info["date_of_birth"] = ReportsController::getDOB($data->user_id);
                $info["sex"] = ReportsController::getSex($data->user_id);
            }
            if (Yii::$app->request->post("restaurant_name")) {
                $info["restaurant_name"] = ReportsController::getRestaurantName($data->restaurant_id);
            }
            if (Yii::$app->request->post("restaurant_address")) {
                $info["restaurant_address"] = ReportsController::getRestaurantAddress($data->restaurant_id);
            }
            if (Yii::$app->request->post("order_qty")) {
                $info["order_qty"] = ReportsController::getOrderQty($data->id);
            }
            if (Yii::$app->request->post("order_date")) {
                $info["order_date"] = ReportsController::getOrderDate($data->date);
            }
            if (Yii::$app->request->post("order_number")) {
                $info["order_number"] = $data->id;
            }
            if (Yii::$app->request->post("order_amount")) {
                $info["order_amount"] = ReportsController::getOrderAmount($data->id);
            }

            $info["delivery_info"] = Orders::getTypes($data->type);

            if (Yii::$app->request->post("product_caption") || Yii::$app->request->post("product_qty") || Yii::$app->request->post("product_price") || Yii::$app->request->post("product_tax")) {
                $products_info = "";
                $orders_items = OrdersItems::find()->where(["order_id" => $data->id])->all();
                if(!empty($orders_items)){
                    foreach ((array)$orders_items as $_item) {
                        if (Yii::$app->request->post("product_caption")) {
                            $products_info .= "Caption: ".Menu::findOne(["id" => $_item->menu_id])->name.", ";
                        }
                        if (Yii::$app->request->post("product_qty")) {
                            $products_info .= "QTY: ".$_item->count.", ";
                        }
                        if (Yii::$app->request->post("product_price")) {
                            $products_info .= "Price: ".$_item->price.", ";
                        }
                        if (Yii::$app->request->post("product_tax")) {
                            $products_info .= "TAX: ".$_item->tax.", ";
                        }
                        $products_info = rtrim($products_info, ",");
                        $products_info .= "\n";
                    }
                }
                $info["products_info"] = $products_info;
            }
            $result_arr[] = $info;
        }

        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=file.csv");
        // Disable caching
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
        header("Pragma: no-cache"); // HTTP 1.0
        header("Expires: 0"); // Proxies

        $output = fopen("php://output", "w");
        foreach ($result_arr as $row) {
            fputcsv($output, $row, ";"); // here you can change delimiter/enclosure
        }
        fclose($output);

        exit;
    }

    static public function getDataSearch()
    {
        $delivery_type = Yii::$app->request->post("delivery_type");
        $date_start = Yii::$app->request->post("date_start");
        $date_end = Yii::$app->request->post("date_end");

        if (empty($delivery_type) || empty($date_start) || empty($date_end)) {
            echo 'No results found.';
            return "";
        }

        $date_start_stamp = strtotime($date_start);
        $date_end_stamp = strtotime($date_end) + 86400;

        foreach ((array)$delivery_type as $_type_id => $_val) {
            $type[$_type_id] = $_type_id;
        }

        if (Yii::$app->user->can("admin")) {
            $data = Orders::find()
                ->where(["type" => $type])
                ->andWhere(['>=', 'date', $date_start_stamp])
                ->andWhere(['<', 'date', $date_end_stamp]);
        } else {
            // manager see orders form related to him restaurant
            $data = Orders::find()
                ->where(["type" => $type])
                ->andWhere(['>=', 'date', $date_start_stamp])
                ->andWhere(['<', 'date', $date_end_stamp])
                ->andWhere("orders.restaurant_id=" . Yii::$app->user->identity->restaurant_id);
        }

        return $data;
    }


    static public function getPersonalInfo($user_id){
        $user_profile = UserProfile::findOne(["user_id" => $user_id]);

        $info = " ";
        if ($user_profile->firstname) {
            $info .= " " . $user_profile->firstname;
        }
        if ($user_profile->lastname) {
            $info .= " " . $user_profile->lastname;
        }
        return trim($info);
    }

    static public function getEmail($user_id){
        return User::findIdentity($user_id)->email;
    }

    static public function getInvoiceNumber($user_id){
        return UserProfile::findOne(["user_id" => $user_id])->phone;

    }

    static public function getDOB($user_id){
        $date = UserProfile::findOne(["user_id" => $user_id])->date_of_birth;
        return date("d-m-Y", $date);
    }

    static public function getSex($user_id){
        $gender = UserProfile::findOne(["user_id" => $user_id])->gender;
        if ($gender == "1") {
            return "MALE";
        } elseif ($gender == "2") {
            return "FEMALE";
        }
        return "";
    }

    static public function getRestaurantName($restaurant_id){
        return RestaurantProfile::findOne(["user_id" => $restaurant_id])->name;
    }

    static public function getRestaurantAddress($restaurant_id){
        $info = RestaurantProfile::findOne(["user_id" => $restaurant_id]);
        return $info->city . " " . $info->address;
    }

    static public function getOrderQty($order_id){
        $info = OrdersItems::findAll(["order_id" => $order_id]);
        return count($info);
    }

    static public function getOrderDate($date){
        return date("d-m-Y H:i:s", $date);
    }

    static public function getOrderAmount($order_id){
        $info = OrdersItems::findAll(["order_id" => $order_id]);
        if (empty($info)) {
            return "0";
        }

        $amount = 0;
        foreach ((array)$info as $_info) {
            $amount += $_info->price * $_info->count;
        }
        return $amount;
    }








}
