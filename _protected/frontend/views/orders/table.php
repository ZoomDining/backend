<?php

use common\models\Orders;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="orders-index">

    <?php
    $form = ActiveForm::begin(['options' => ['class' => 'form-inline form-row-ag clearfix']]);
    ?>

    <div class="filter-box-ag clearfix">
        <?php

        echo Html::input("text", "username", Yii::$app->request->post("username"), [
            "class"       => "form-control size-input-3-ag",
            "placeholder" => "Search by Name",
        ]);

        echo Html::input("text", "order_id", Yii::$app->request->post("order_id"), [
            "class"       => "form-control size-input-3-ag",
            "placeholder" => "Search by Order Number",
        ]);

        echo Html::submitButton('Search', [
            'name'  => 'search_btn',
            'class' => 'btn btn-success pull-right'
        ]);
        ?>
    </div>
    <div class="clearfix">

        <?php
        echo Html::dropDownList("ordersStatus",
            Yii::$app->request->post("ordersStatus"),
            ArrayHelper::merge(["" => "All Orders"], Orders::getStatuses()), [
                "id"       => "ordersStatus",
                'class'    => 'form-control size-input-4-ag',
                'onchange' => '$(this).submit()',
            ]
        );
        ?>

        <div class="size-input-4-ag">
<!--            --><?//= Html::label("Start date:"); ?>
            <?= DatePicker::widget([
                "name"       => "date_start",
                'value'      => Yii::$app->request->post("date_start"),
                'dateFormat' => 'dd-MM-yyyy',
                'options'    => [
                    'class'         => 'form-control datepicker-ag',
                    'placeholder'   => 'Start date',
                ],
            ]);
            ?>
        </div>
        <div class="size-input-4-ag">
<!--            --><?//= Html::label("End date:"); ?>
            <?= DatePicker::widget([
                "name"       => "date_end",
                'value'      => Yii::$app->request->post("date_end"),
                'dateFormat' => 'dd-MM-yyyy',
                'options'    => [
                    'class'         => 'form-control datepicker-ag',
                    'placeholder'   => 'End date',
                ],
            ]);
            ?>
        </div>
    </div>


    <?php
    ActiveForm::end();
    ?>

    <div style="<?= in_array(Yii::$app->request->post("ordersStatus"), ["",0,1]) ? "" : "display: none" ?>">
        <?= Html::label("New and Preparing:") ?>
        <?= GridView::widget([
            'id' => "ordersNewPreparing",
            'dataProvider' => $dataProviderNewPreparing,
            'filterModel' => null,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered table-hover table-hover-ag',
            ],
            'summary' => false,
            'columns' => [
                [
                    'attribute' => 'username',
                    'value' => 'user.username'
                ],
                [
                    'attribute' => 'date',
                    'value' => function ($data) {
                        return date ('Y-m-d H:i:s', $data->date);
                    },
                ],
                [
                    'attribute' => 'guests',
                    'visible' => in_array($currentType, [1,2]) ? false : true,
                ],
                [
                    'attribute' => 'table',
                    'visible' => in_array($currentType, [1,2]) ? false : true,
                ],
                [
                    'attribute' => 'address',
                    'visible' => in_array($currentType, [2]) ? true : false,
                ],
				[
					'class' => 'yii\grid\ActionColumn',
					'template' => '{delete}',
				],

    //            [
    //                'attribute' => 'status',
    //                'value' => function ($data) {
    //                    return Orders::getStatuses($data->status);
    //                },
    //                'filter' => Orders::getStatuses(),
    //            ],
            ],
        ]); ?>
    </div>


    <div style="<?= in_array(Yii::$app->request->post("ordersStatus"), ["",2]) ? "" : "display: none" ?>">
        <?= Html::label("Completed:") ?>
        <?= GridView::widget([
            'id' => "ordersCompleted",
            'dataProvider' => $dataProviderCompleted,
            'filterModel' => null,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered table-hover table-hover-ag',
            ],
            'summary' => false,
            'columns' => [
                [
                    'attribute' => 'username',
                    'value' => 'user.username'
                ],
                [
                    'attribute' => 'address',
                    'visible' => in_array($currentType, [2]) ? true : false,
                ],
                [
                    'attribute' => 'date',
                    'value' => function ($data) {
                        return date ('Y-m-d H:i:s', $data->date);
                    },
                ],
                [
                    'attribute' => 'guests',
                    'visible' => in_array($currentType, [1,2]) ? false : true,
                ],
                [
                    'attribute' => 'table',
                    'visible' => in_array($currentType, [1,2]) ? false : true,
                ],
                [
                    'attribute' => 'address',
                    'visible' => in_array($currentType, [2]) ? true : false,
                ],
				[
					'class' => 'yii\grid\ActionColumn',
					'template' => '{delete}',
				],
            ],
        ]); ?>
    </div>


    <div style="<?= in_array(Yii::$app->request->post("ordersStatus"), ["",3]) ? "" : "display: none" ?>">
        <?= Html::label("Canceled:") ?>
        <?= GridView::widget([
            'id' => "ordersCanceled",
            'dataProvider' => $dataProviderCanceled,
            'filterModel' => null,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered table-hover table-hover-ag',
            ],
            'summary' => false,
            'columns' => [
                [
                    'attribute' => 'username',
                    'value' => 'user.username'
                ],
                [
                    'attribute' => 'date',
                    'value' => function ($data) {
                        return date ('Y-m-d H:i:s', $data->date);
                    },
                ],
                [
                    'attribute' => 'guests',
                    'visible' => in_array($currentType, [1,2]) ? false : true,
                ],
                [
                    'attribute' => 'table',
                    'visible' => in_array($currentType, [1,2]) ? false : true,
                ],
                [
                    'attribute' => 'address',
                    'visible' => in_array($currentType, [2]) ? true : false,
                ],
				[
					'class' => 'yii\grid\ActionColumn',
					'template' => '{delete}',
				],
            ],
        ]); ?>
    </div>


</div>


<script type="application/javascript">
    $(function(){
        $(".container-fluid").on('click', "#send_email", function(){

            var $order_id = $(this).attr("data-id");

            $(".js-loader").show();

            $.post('<?php echo Url::toRoute("/orders/send-email-status") ?>?&order_id=' + $order_id, function (data) {
                $(".js-loader").hide();
                if(data == "ok"){
                    alert("Email was sent successfully");
                }else{
                    alert("Error sending email");
                }
            });

            return false;
        });
    })
</script>