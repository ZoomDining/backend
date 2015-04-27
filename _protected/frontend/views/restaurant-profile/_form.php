<?php

use common\models\Menu;
use common\models\Orders;
use common\models\OrdersItems;
use common\models\RestaurantProfile;


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantProfile */
/* @var $form yii\bootstrap\ActiveForm */
?>


<div class="restaurant-profile-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <div class="clearfix">
        <div class="col-lg-6 col-md-6">
            <?= Html::label("BASIC INFO") ?>

            <div class="row">
                <div class="col-lg-8 col-md-6 col-sm-8">

                    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                    <div class="row">
                        <div class="col-lg-6">
                            <?= $form->field($model, 'email')->textInput() ?>
                        </div>
                        <div class="col-lg-6">
                            <?= $form->field($model, 'phone')->textInput() ?>
                        </div>
                    </div>

					<?= $form->field($model, 'website')->textInput() ?>
					
                    <div class="row">
                        <div class="col-lg-6">
                            <?= Html::label("Location") ?>
                        </div>
                        <div class="col-lg-6">
                            <?= $form->field($model, 'show_location')->checkbox(); ?>
                        </div>
                    </div>

                    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

                    <div class="row">
                        <div class="col-lg-6">
                            <?= $form->field($model, 'city')->textInput() ?>
                        </div>
                        <div class="col-lg-6">
                            <?= $form->field($model, 'postcode')->textInput() ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <?= $form->field($model, 'lat')->textInput() ?>
                        </div>
                        <div class="col-lg-6">
                            <?= $form->field($model, 'lng')->textInput() ?>
                        </div>
                    </div>

                    <div class="form-inline check-box-ag">
                        <?= Html::label("Available") ?>
                        <?= $form->field($model, 'dine_in')->checkbox(); ?>
                        <?= $form->field($model, 'take_away')->checkbox(); ?>
                        <?= $form->field($model, 'delivery')->checkbox(); ?>
                    </div>

                    <div class="form-inline check-box-ag">
                        <?= Html::label("Type of food") ?>
                        <?= $form->field($model, 'halal')->checkbox(); ?>
                        <?= $form->field($model, 'non_halal')->checkbox(); ?>
                        <?= $form->field($model, 'vegetarian')->checkbox(); ?>
                        <?= $form->field($model, 'pork_free')->checkbox(); ?>
                        <?= $form->field($model, 'vegan')->checkbox(); ?>
                    </div>

                    <div class="form-inline">
                        <?= $form->field($model, 'cousine_type')->textInput() ?>
                    </div>

                </div>

                <div class="col-lg-4 col-md-6 col-sm-4">
                    <?php
                    $image_path = $model->getFileUrl("image");
                    ?>
                    <div class="img-box-ag">
                        <?php
                        if (empty($image_path)) {
                            $image_path = Yii::$app->homeUrl . Yii::$app->params["defaultImgUrl"];
                        }
                        echo Html::img($image_path . "?time=" . time(), ['class' => 'thumbnail']);
                        ?>
                    </div>

                    <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <?= Html::label("BUSINESS HOURS") ?>
            <?= $form->field($model, 'hours_mo', [
                'inputOptions' => [
                    'placeholder' => "09.00AM - 06.00PM",
                ]])->textInput() ?>
            <?= $form->field($model, 'hours_tu', [
                'inputOptions' => [
                    'placeholder' => "09.00AM - 06.00PM",
                ]])->textInput() ?>
            <?= $form->field($model, 'hours_we', [
                'inputOptions' => [
                    'placeholder' => "09.00AM - 06.00PM",
                ]])->textInput() ?>
            <?= $form->field($model, 'hours_th', [
                'inputOptions' => [
                    'placeholder' => "09.00AM - 06.00PM",
                ]])->textInput() ?>
            <?= $form->field($model, 'hours_fr', [
                'inputOptions' => [
                    'placeholder' => "09.00AM - 06.00PM",
                ]])->textInput() ?>
            <?= $form->field($model, 'hours_sa', [
                'inputOptions' => [
                    'placeholder' => "09.00AM - 06.00PM",
                ]])->textInput() ?>
            <?= $form->field($model, 'hours_su', [
                'inputOptions' => [
                    'placeholder' => "09.00AM - 06.00PM",
                ]])->textInput() ?>

            <?= $form->field($model, 'prefer_language')->textInput() ?>

            <?= $form->field($model, 'policy')->textarea(['rows' => 6]) ?>


        </div>
    </div>

    <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
