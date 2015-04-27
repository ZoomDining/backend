<?php

use common\models\Categories;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Sets */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="sets-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'pax')->textInput() ?>

    <?= $this->render('//formBtns', [
        'isIndex' => $isIndex,
    ]);
    ?>


    <?php ActiveForm::end(); ?>

</div>
