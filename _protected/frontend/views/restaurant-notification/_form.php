<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantNotification */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="restaurant-notification-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="clearfix">
        <div class="col-lg-6 col-md-6">
            <?= Html::label("Account email") ?>

            <?= $form->field($model, 'daily_summary')->checkbox() ?>

            <?= $form->field($model, 'events_info')->checkbox() ?>

            <?= Html::label("Feature email") ?>

            <?= $form->field($model, 'customer_feedback')->checkbox() ?>

            <?= $form->field($model, 'transaction_email')->checkbox() ?>

            <div class="form-inline">
                <?= $form->field($model, 'email')->textInput(['maxlength' => 256]) ?>
            </div>

            <div class="form-group pull-right">
                <?php
                    echo Html::submitButton('Save', ['name' => 'save', 'class' => 'btn btn-success pull-right']);
                    echo Html::resetButton('Cancel', ['name' => 'cancel', 'class' => 'btn btn-primary pull-right']);
                ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
