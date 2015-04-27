<?php
use \yii\helpers\Url;
use yii\helpers\Html;
$this->title = Yii::$app->name." :: ".ucfirst(Yii::$app->controller->id);
?>

<div class="row">
    <div class="col-lg-6">
        <div id="widget_table"><?php echo $table; ?></div>
    </div>
    <div class="col-lg-6">
        <?php if(!$disableCreateBtn){?>
            <p class="pull-right">
                <?= Html::a('Create', ['index'], ['class' => 'js-create-btn btn btn-warning']) ?>
            </p>
        <?php } ?>
        <div class="clearfix"></div>
        <div id="widget_form"><?php echo $form; ?></div>
    </div>
</div>


<script type="application/javascript">
    $(function(){
        // click on table item -> load edit form
        $(".grid-view table tbody tr").click(function(){
            var $id = $(this).attr("data-key");
            if($id>0) {
                $.post('<?php echo Url::toRoute("index") ?>?id=' + $id, function (data) {
                    $("#widget_form").html(data);
                });
            }
        });
    })
</script>
