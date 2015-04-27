<?php

use common\models\Categories;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Menu */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'id' => 'editForm',
        'options' => ['enctype' => 'multipart/form-data'],
    ]);
    ?>

    <div class="clearfix">
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
        <div class="col-lg-8 col-md-6 col-sm-8">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 512]) ?>

            <?= $form->field($model, 'category_id')->dropDownList(
                ArrayHelper::merge(
                    ['' => 'Please select'],
                    ArrayHelper::map(Categories::find()->all(), "id", "name")
                )) ?>

            <?= $form->field($model, 'price')->textInput(['maxlength' => 64]) ?>
        </div>
    </div>

    <?= $form->field($model, 'modifier')->radioList(["1" => "Rare", "2" => "Medium", "3" => "Well done"]) ?>

    <?= Html::label("Market settings")?>

    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-4">
            <?= $form->field($model, 'available_online')->checkbox(); ?>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-8">
            <?= $form->field($model, 'pick_up')->checkbox(); ?>
            <?= $form->field($model, 'take_away')->checkbox(); ?>
            <?= $form->field($model, 'dine_in')->checkbox(); ?>
        </div>
    </div>


    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6])->hint("(for search functions)") ?>

    <?= $this->render('//formBtns', [
        'isIndex' => $isIndex,
    ]);
    ?>


    <?php ActiveForm::end(); ?>

</div>
