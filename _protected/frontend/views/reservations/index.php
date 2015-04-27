<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name." :: ".ucfirst(Yii::$app->controller->id);
?>
<div class="orders-index">


    <div class="row">
        <div class="col-lg-6">
            <?php
                $form = ActiveForm::begin(['options' => ['class' => 'form-inline form-row-ag clearfix']]);

                echo Html::submitButton('Search', [
                    'name' => 'search_btn',
                    'class' => 'btn btn-success btn-ag'
                ]);
            ?>

            <div class="wrapper">
                <div class="input-box-ag">
                    <?php
                        echo Html::input("text", "searchName", Yii::$app->request->post("searchName"),[
                            "class"       => "form-control size-input-1-ag",
                            "placeholder" => "Search by Name",
                        ]);
                    ?>
                </div>
            </div>

            <?php
                ActiveForm::end();
            ?>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'summary' => false,
        'columns' => [
            [
                'attribute' => 'username',
                'value' => 'user.username'
            ],
            'date',
            'guests',
            'table',
            // 'restaurant_id',
            // 'type',
            // 'status',
            // 'id',
        ],
    ]); ?>

</div>
