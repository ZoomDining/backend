<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Categories */
/* @var $form yii\bootstrap\ActiveForm */

?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 512]) ?>

<!--    --><?//= $form->field($model, 'available_online')->checkbox() ?>
    <div class="checkbox">
        <label for="available_online">
            <?= Html::checkbox('available_online', true, ['id' => 'available_online', 'disabled' => 'disabled']) ?>
            Available Online
        </label>
    </div>


    <!--    --><?//= $form->field($model, 'item_numbers')->textInput() ?>
    <p>
    <?= Html::label("Total number of items:", 'item_numbers') ?>
    <?= count($model->items) ?>

    </p>



    <?= $form->field($model, 'items')->checkboxList(ArrayHelper::map($model->menus, "id", "name"),
        ['item' =>
             function($index, $label, $name, $checked, $value) {
                 $item = '<div class="checkbox">';
                 $item .= '<label>';
                 $item .= Html::checkbox($name, $checked, [
                     'disabled' => 'disabled'
                 ]);
                 $item .= $label;
                 $item .= '</label></div>';

                 return $item;
             }
        ]) ?>

    <?= $this->render('//formBtns', [
        'isIndex' => $isIndex,
    ]);
    ?>

    <?php ActiveForm::end(); ?>

</div>
