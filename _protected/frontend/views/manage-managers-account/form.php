<?php

use common\models\Menu;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Categories */
/* @var $form yii\bootstrap\ActiveForm */

?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'permissions')->checkboxList([
        "access_home" => "Home",
        "access_orders" => "Orders",
        "access_schedule" => "Schedule",
        "access_items" => "Items"
    ]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 512]) ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'firstname')->textInput() ?>
    <?= $form->field($model, 'lastname')->textInput() ?>
    <?= $form->field($model, 'id_number')->textInput() ?>

    <?= $this->render('//formBtns', [
        'isIndex' => $isIndex,
    ]);
    ?>

    <?php ActiveForm::end(); ?>

</div>
