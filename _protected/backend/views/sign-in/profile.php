<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = Yii::t('backend', 'Edit profile')
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php $image_path = $model->getFileUrl("picture") ?>
    <?php echo !empty($image_path)?Html::img($image_path):""; ?>

    <?= $form->field($model, 'picture')->fileInput(['accept' => 'image/*']) ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'middlename')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'locale')->dropDownlist(Yii::$app->params['availableLocales']) ?>

    <?= $form->field($model, 'gender')->dropDownlist([
        \common\models\UserProfile::GENDER_FEMALE=>Yii::t('frontend', 'Female'),
        \common\models\UserProfile::GENDER_MALE=>Yii::t('frontend', 'Male'),
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('frontend', 'Create') : Yii::t('frontend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
