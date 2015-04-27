<?php

use common\models\Orders;
use common\models\OrdersItems;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Orders */
/* @var $form yii\bootstrap\ActiveForm */

?>

<div class="orders-form">

    <?php if(!$isIndex){ ?>

        <?php
        $statuses = [
//            "0" => 'btn-info',
            "1" => 'btn-default',
            "2" => 'btn-success',
            "3" => 'btn-danger',
        ];
        unset($statuses[$model->status]);

        $form = ActiveForm::begin();

        foreach ((array)$statuses as $_status_id => $_btn_class) {
            echo Html::submitButton($model->getStatuses($_status_id), ['name' => 'status', 'value' => $_status_id, 'class' => 'btn '.$_btn_class.' pull-left']);
        }
        ?>
        <div class="pull-right">
            <i class="fa fa-refresh fa-spin loader-ag js-loader"></i>
        <?php
            echo Html::submitButton('Email', ['name' => 'email', 'value' => 'email', 'class' => 'btn btn-primary', 'id' => 'send_email', 'data-id' => $model->id]);
        ?>
        </div>

        <?php
        ActiveForm::end();
        ?>

        <div class="clearfix"></div>
        <div class="base-box-ag order-info-ag">
            <h4>
                <?= $model->getStatuses($model->status)." # ".$model->id ?>
            </h4>

            <p>
                <?= Html::label($model->getAttributeLabel("user_id")) ?>
                <?= $model->user_id ?>
            </p>

            <p>
                <?= Html::label($model->getAttributeLabel("table")) ?>
                <?= $model->table ?>
            </p>

            <p>
                <?= Html::label($model->getAttributeLabel("date")) ?>
                <?= date ('Y-m-d H:i:s', $model->date) ?>
            </p>

            <p>
                <?= Html::label($model->getAttributeLabel("guests")) ?>
                <?= $model->guests ?>
            </p>

            <p>
                <?= Html::label($model->getAttributeLabel("id")) ?>
                <?= $model->id ?>
            </p>

            <p>
                <?= Html::label($model->getAttributeLabel("type")) ?>
                <?= $model->getTypes($model->type) ?>
            </p>

            <p>
                <?= Html::label($model->getAttributeLabel("status")) ?>
                <?= $model->getStatuses($model->status) ?>
            </p>

            <p>
                <?= Html::label($model->getAttributeLabel("promo")) ?>
                <?= $model->promo ?>
            </p>
        </div>

        <?= Html::label('Items') ?>

        <?php

        echo GridView::widget([
            'dataProvider' => new ActiveDataProvider([
                'query' => OrdersItems::find()->where("order_id =".$model->id),
            ]),
            'filterModel' => null,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered table-hover',
            ],
            'summary' => false,
            'columns' => [
                [
                    'attribute' => 'count',
                    'value' => 'count',
                    'enableSorting' => false,
                    'label' => 'Quantity',
                ],
                [
                    'attribute' => 'item',
                    'value' => 'menu.name',
                ],
                'amount',

            ],
        ]);

        ?>

    <?php } ?>

</div>