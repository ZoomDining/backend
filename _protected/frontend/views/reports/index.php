<?php

use common\models\Menu;
use common\models\Orders;
use common\models\OrdersItems;
use frontend\controllers\ReportsController;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\jui\DatePicker;

$this->title = Yii::$app->name . " :: " . ucfirst(Yii::$app->controller->id);

?>

<div class="reports-index">

    <?php
    $form = ActiveForm::begin([
            'layout' => 'horizontal']
    );
    ?>

    <div class="clearfix">
        <div class="col-lg-3">

            <div class="form-group">
                <?= Html::label('Selected fields:'); ?>
            </div>

            <div class="form-group">
                <?= Html::label("Start date:", '', ['class' => 'label-ag']); ?>
                <?= DatePicker::widget([
                    "name"       => "date_start",
                    'value'      => Yii::$app->request->post("date_start"),
                    'dateFormat' => 'dd-MM-yyyy',
                ]);
                ?>
            </div>

            <div class="form-group">
                <?= Html::label("End date:", '', ['class' => 'label-ag']); ?>
                <?= DatePicker::widget([
                    "name"       => "date_end",
                    'value'      => Yii::$app->request->post("date_end"),
                    'dateFormat' => 'dd-MM-yyyy',
                ]);
                ?>
            </div>

            <div class="title-check-box-ag">
                <?= Html::label("Customer info:"); ?>
            </div>
            <div class="body-check-box-ag">
                <div class="form-group">
                    <?= Html::checkbox("personal_info", Yii::$app->request->post("personal_info"), ["id" => "personal_info"]); ?>
                    <?= Html::label("Personal info(name, phone, email, date of birth)", "personal_info"); ?>
                </div>
            </div>

            <div class="title-check-box-ag">
                <?= Html::label("Order info:"); ?>
            </div>
            <div class="body-check-box-ag">

                <div class="form-group">
                    <?= Html::checkbox("restaurant_name", Yii::$app->request->post("restaurant_name"), ["id" => "restaurant_name"]); ?>
                    <?= Html::label("Restaurant name", "restaurant_name"); ?>
                </div>

                <div class="form-group">
                    <?= Html::checkbox("restaurant_address", Yii::$app->request->post("restaurant_address"), ["id" => "restaurant_address"]); ?>
                    <?= Html::label("Restaurant city / address", "restaurant_address"); ?>
                </div>

                <div class="form-group">
                    <?= Html::checkbox("order_qty", Yii::$app->request->post("order_qty"), ["id" => "order_qty"]); ?>
                    <?= Html::label("Order QTY", "order_qty"); ?>
                </div>

                <div class="form-group">
                    <?= Html::checkbox("order_date", Yii::$app->request->post("order_date"), ["id" => "order_date"]); ?>
                    <?= Html::label("Order Date", "order_date"); ?>
                </div>

                <div class="form-group">
                    <?= Html::checkbox("order_number", Yii::$app->request->post("order_number"), ["id" => "order_number"]); ?>
                    <?= Html::label("Order Number", "order_number"); ?>
                </div>

                <div class="form-group">
                    <?= Html::checkbox("order_amount", Yii::$app->request->post("order_amount"), ["id" => "order_amount"]); ?>
                    <?= Html::label("Order Amount", "order_amount"); ?>
                </div>
            </div>

            <div class="title-check-box-ag">
                <?= Html::label("Products info:"); ?>
            </div>
            <div class="body-check-box-ag">
                <div class="form-group">
                    <?= Html::checkbox("product_caption", Yii::$app->request->post("product_caption"), ["id" => "product_caption"]); ?>
                    <?= Html::label("Caption", "product_caption"); ?>
                </div>

                <div class="form-group">
                    <?= Html::checkbox("product_qty", Yii::$app->request->post("product_qty"), ["id" => "product_qty"]); ?>
                    <?= Html::label("QTY", "product_qty"); ?>
                </div>

                <div class="form-group">
                    <?= Html::checkbox("product_price", Yii::$app->request->post("product_price"), ["id" => "product_price"]); ?>
                    <?= Html::label("Price", "product_price"); ?>
                </div>

                <div class="form-group">
                    <?= Html::checkbox("product_tax", Yii::$app->request->post("product_tax"), ["id" => "product_tax"]); ?>
                    <?= Html::label("TAX", "product_tax"); ?>
                </div>
            </div>

            <div class="title-check-box-ag">
                <?= Html::label("Delivery Info:"); ?>
            </div>
            <div class="body-check-box-ag">
                <?php
                    $delivery_type = Yii::$app->request->post("delivery_type");
                ?>

                <div class="form-group">
                    <?= Html::checkbox("delivery_type[0]", (isset($delivery_type[0]) ? $delivery_type[0] : false), ["id" => "delivery_type0"]); ?>
                    <?= Html::label("Dine In", "delivery_type0"); ?>
                </div>

                <div class="form-group">
                    <?= Html::checkbox("delivery_type[1]", (isset($delivery_type[1]) ? $delivery_type[1] : false), ["id" => "delivery_type1"]); ?>
                    <?= Html::label("Take away", "delivery_type1"); ?>
                </div>

                <div class="form-group">
                    <?= Html::checkbox("delivery_type[2]", (isset($delivery_type[2]) ? $delivery_type[2] : false), ["id" => "delivery_type2"]); ?>
                    <?= Html::label("Delivery", "delivery_type2"); ?>
                </div>
            </div>

            <div class="body-check-box-ag">
                <div class="form-group">
                    <?= Html::checkbox("social", Yii::$app->request->post("social"), ["id" => "social"]); ?>
                    <?= Html::label("Social (FB users, Google users, Manual)", "social"); ?>
                </div>
                <div class="form-group">
                    <?= Html::checkbox("device_id", Yii::$app->request->post("device_id"), ["id" => "device_id"]); ?>
                    <?= Html::label("Device ID (Android/IOS)", "device_id"); ?>
                </div>
            </div>

        </div>


        <div class="col-lg-9">
            <div class="button-box-ag clearfix">
                <?= Html::submitButton('Export to CSV', ['id' => 'export_btn', 'name' => 'export', 'class' => 'btn btn-primary pull-right']); ?>
                <?= Html::submitButton('Generate', ['name' => 'generate', 'class' => 'btn btn-success pull-right']); ?>
            </div>

            <?php
            $delivery_type = Yii::$app->request->post("delivery_type");
            $date_start = Yii::$app->request->post("date_start");
            $date_end = Yii::$app->request->post("date_end");

            if (empty($delivery_type) || empty($date_start) || empty($date_end)) {
                echo 'No results found.';
                echo '<br><br>Please select Start date, End date, Delivery Info.';
            } else {

                echo GridView::widget([
                    'id'           => "report_table",
                    'dataProvider' => new ActiveDataProvider([
                        'query' => ReportsController::getDataSearch(),
                        'pagination' => [
                            'pageSize' => 50,
                        ],
                    ]),
                    'filterModel'  => null,
                    'tableOptions' => [
                        'class' => 'table table-striped table-bordered table-hover',
                    ],
                    'summary'      => false,
                    'columns'      => [
                        [
                            'attribute' => 'personal_info',
                            'visible'   => Yii::$app->request->post("personal_info"),
                            'value'     => function ($data) {
                                return ReportsController::getPersonalInfo($data->user_id);
                            },
                        ],
                        [
                            'attribute' => 'email',
                            'visible'   => Yii::$app->request->post("personal_info"),
                            'value'     => function ($data) {
                                return ReportsController::getEmail($data->user_id);
                            },
                        ],
                        [
                            'attribute' => 'invoice_number',
                            'visible'   => Yii::$app->request->post("personal_info"),
                            'value'     => function ($data) {
                                return ReportsController::getInvoiceNumber($data->user_id);
                            },
                        ],
                        [
                            'attribute' => 'date_of_birth',
                            'visible'   => Yii::$app->request->post("personal_info"),
                            'value'     => function ($data) {
                                return ReportsController::getDOB($data->user_id);
                            },
                        ],
                        [
                            'attribute' => 'sex',
                            'visible'   => Yii::$app->request->post("personal_info"),
                            'value'     => function ($data) {
                                return ReportsController::getSex($data->user_id);
                            },
                        ],
                        [
                            'attribute' => 'restaurant_name',
                            'visible'   => Yii::$app->request->post("restaurant_name"),
                            'value'     => function ($data) {
                                return ReportsController::getRestaurantName($data->restaurant_id);
                            },
                        ],
                        [
                            'attribute' => 'restaurant_address',
                            'visible'   => Yii::$app->request->post("restaurant_address"),
                            'value'     => function ($data) {
                                return ReportsController::getRestaurantAddress($data->restaurant_id);
                            },
                        ],
                        [
                            'attribute' => 'order_qty',
                            'visible'   => Yii::$app->request->post("order_qty"),
                            'value'     => function ($data) {
                                return ReportsController::getOrderQty($data->id);
                            },
                        ],
                        [
                            'attribute' => 'order_date',
                            'visible'   => Yii::$app->request->post("order_date"),
                            'value'     => function ($data) {
                                return ReportsController::getOrderDate($data->date);
                            },
                        ],
                        [
                            'attribute' => 'order_number',
                            'visible'   => Yii::$app->request->post("order_number"),
                            'value'     => function ($data) {
                                return $data->id;
                            },
                        ],
                        [
                            'attribute' => 'order_amount',
                            'visible'   => Yii::$app->request->post("order_amount"),
                            'value'     => function ($data) {
                                return ReportsController::getOrderAmount($data->id);
                            },
                        ],
                        [
                            'attribute' => 'delivery_info',
                            'value'     => function ($data) {
                                return Orders::getTypes($data->type);
                            },
                        ],

                        [
                            'attribute' => 'products_info',
                            'visible'   => (Yii::$app->request->post("product_caption") || Yii::$app->request->post("product_qty") || Yii::$app->request->post("product_price") || Yii::$app->request->post("product_tax")),
                            'content'   => function ($data) {
                                return GridView::widget([
                                    'dataProvider' => new ActiveDataProvider([
                                        'query' => OrdersItems::find()->where(["order_id" => $data->id]),
                                        'pagination' => [
                                            'pageSize' => 50,
                                        ],
                                    ]),
                                    'filterModel'  => null,
                                    'tableOptions' => [
                                        'class' => 'table table-striped table-bordered table-hover',
                                    ],
                                    'summary'      => false,
                                    'columns'      => [
                                        [
                                            'attribute' => 'caption',
                                            'visible'   => Yii::$app->request->post("product_caption"),
                                            'value'     => function ($data) {
                                                return Menu::findOne(["id" => $data->menu_id])->name;
                                            },
                                        ],
                                        [
                                            'attribute'     => 'qty',
                                            'enableSorting' => false,
                                            'visible'       => Yii::$app->request->post("product_qty"),
                                            'value'         => function ($data) {
                                                return $data->count;
                                            },
                                        ],
                                        [
                                            'attribute'     => 'price',
                                            'enableSorting' => false,
                                            'visible'       => Yii::$app->request->post("product_price"),
                                            'value'         => function ($data) {
                                                return $data->price;
                                            },
                                        ],
                                        [
                                            'attribute'     => 'tax',
                                            'enableSorting' => false,
                                            'visible'       => Yii::$app->request->post("product_tax"),
                                            'value'         => function ($data) {
                                                return $data->tax;
                                            },
                                        ],
                                    ],
                                ]);

                            },
                        ],

                    ],
                ]);


            }
            ?>
        </div>
    </div>


    <?php
    ActiveForm::end();
    ?>

</div>