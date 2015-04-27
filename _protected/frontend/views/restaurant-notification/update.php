<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantNotification */

$this->title = Yii::$app->name." :: ".ucfirst(Yii::$app->controller->id);
?>
<div class="restaurant-notification-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
