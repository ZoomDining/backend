<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Taxes */

$this->title = Yii::$app->name." :: ".ucfirst(Yii::$app->controller->id);

?>
<div class="taxes-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
