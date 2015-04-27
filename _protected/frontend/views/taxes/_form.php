<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Taxes */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="taxes-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="clearfix">
        <div class="col-lg-6 col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 256])->label('Name') ?>

            <?= $form->field($model, 'tax',  [
                    'inputTemplate' => '<div class="input-group input-tax-ag">{input}<span class="input-group-addon">%</span></div>',
                ])->textInput() ?>

            <?= $form->field($model, 'status')->checkbox() ?>

            <div class="form-group">
                <?php
                echo Html::submitButton('Save', ['name' => 'save', 'class' => 'btn btn-success pull-right']);
                echo Html::resetButton('Cancel', ['name' => 'cancel', 'class' => 'btn btn-primary pull-right']);
                ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
