<?php
use yii\helpers\Html;
?>

<div class="form-group">
    <?php
    echo Html::submitButton('Save', ['name' => 'save', 'class' => 'btn btn-success pull-right']);
    echo Html::resetButton('Cancel', ['name' => 'cancel', 'class' => 'btn btn-primary pull-right']);

    if (!$isIndex) {
        echo Html::submitButton('Remove', ['name' => 'remove', 'class' => 'btn btn-danger pull-right'     /*  , 'data-confirm' => "Are you sure you want to delete this item?"*/]);
        echo Html::submitButton('Copy', ['name' => 'copy', 'class' => 'btn btn-warning pull-right']);
    }
    ?>
</div>