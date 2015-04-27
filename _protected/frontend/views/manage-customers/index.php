<?php
use \yii\helpers\Url;
use yii\helpers\Html;
$this->title = Yii::$app->name." :: ".ucfirst(Yii::$app->controller->id);
?>

<div class="row">
    <div class="col-lg-12">
        <div id="widget_table"><?php echo $table; ?></div>
    </div>
</div>
