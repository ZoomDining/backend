<?php

use common\models\Menu;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Categories */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 512]) ?>
    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $this->render('//formBtns', [
        'isIndex' => $isIndex,
    ]);
    ?>

    <?php ActiveForm::end(); ?>

</div>
