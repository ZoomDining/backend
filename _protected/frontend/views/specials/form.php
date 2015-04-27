<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Menu;



/* @var $this yii\web\View */
/* @var $model common\models\Specials */
/* @var $form yii\bootstrap\ActiveForm */



?>

<div class="specials-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $menuModel = Menu::findOne($model->menu_id);
    if($menuModel !== null){
        $image_path = $menuModel->getFileUrl("image");
    }
    ?>
    <div class="img-box-ag">
        <?php
        if (empty($image_path)) {
            $image_path = Yii::$app->homeUrl . Yii::$app->params["defaultImgUrl"];
        }
        echo Html::img($image_path . "?time=" . time(), ['class' => 'thumbnail']);
        ?>
    </div>

    <?= $form->field($model, 'menu_id')->dropDownList(
        ArrayHelper::merge(['' => "Please select"], ArrayHelper::map(Menu::find()->all(), 'id', 'name'))
    ); ?>

    <?= $form->field($model, 'discount')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'price_after')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'available_online')->checkbox(); ?>

    <?= $this->render('//formBtns', [
        'isIndex' => $isIndex,
    ]);
    ?>

    <?php ActiveForm::end(); ?>

</div>
