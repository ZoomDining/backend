<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\modules\user\models\LoginForm */

$this->title = Yii::t('frontend', 'Sign in');
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-page">
    <div class="logo-img">
        <img src="<?= Yii::$app->homeUrl . "img/logo.png" ?>" alt="<?= Yii::$app->name ?>"/>
    </div>


    <div class="site-login">
        <div>
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal']
            ); ?>
            <?= $form->field($model, 'identity') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('frontend', 'Sign in'), ['class' => 'btn btn-primary pull-right', 'name' => 'login-button']) ?>
            </div>

<?/*
                    <div style="color:#999;margin:1em 0">
                        <?php echo Yii::t('frontend', 'If you forgot your password you can reset it <a href="{link}">here</a>', [
                            'link'=>yii\helpers\Url::to(['sign-in/request-password-reset'])
                        ]) ?>
                    </div>


                    <div class="form-group">
                        <?php echo Html::a(Yii::t('frontend', 'Need an account? Sign up.'), ['signup']) ?>
                    </div>
                    <h2><?php echo Yii::t('frontend', 'Log in with')  ?>:</h2>
                    <div class="form-group">
                        <?= yii\authclient\widgets\AuthChoice::widget([
                            'baseAuthUrl' => ['/user/sign-in/oauth']
                        ]) ?>
                    </div>
*/?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
