<?php

use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="categories-index">

    <?php
    $form = ActiveForm::begin(['options' => ['class' => 'form-inline form-row-ag clearfix']]);

    echo Html::input("text", "searchName", Yii::$app->request->post("searchName"),[
        "class"       => "form-control size-input-2-ag",
        "placeholder" => "Search by Name",
    ]);

    echo Html::submitButton('Search', [
        'name' => 'search_btn',
        'class' => 'btn btn-success pull-right'
    ]);

    ActiveForm::end();
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => null,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-hover table-hover-ag',
        ],
        'summary' => false,
        'columns'      => [
            'username',
            'email',
            [
                'class'     => 'yii\grid\DataColumn',
                'attribute' => 'permissions',
                'value'     => function ($data) {
                    $permissions = $data->permissions;
                    if(!empty($permissions)){
                        return str_replace("access_", "", implode(", ", $permissions));
                    }else{
                        return "";
                    }
                },
            ],


            ['class' => 'yii\grid\ActionColumn',
             'template' => '{delete}',
            ],
        ],
    ]); ?>

</div>
