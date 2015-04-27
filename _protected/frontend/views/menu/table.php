<?php

use common\models\Categories;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="menu-index">

    <?php
    $form = ActiveForm::begin(['options' => ['class' => 'form-inline form-row-ag clearfix']]);

    echo Html::dropDownList("searchCategory",
        Yii::$app->request->post("searchCategory"),
        ArrayHelper::merge([""=>"All Categories"], ArrayHelper::map(Categories::find()->all(), "id", "name")),
        [
            'class' => 'form-control size-input-3-ag',
            'onchange' => '$(this).submit()',
        ]
    );

    echo Html::input("text", "searchName", Yii::$app->request->post("searchName"),[
        "class"       => "form-control size-input-3-ag",
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
        'filterModel' => null,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-hover table-hover-ag',
        ],
        'summary' => false,
        'columns' => [
            'name',
            [
                'attribute' => 'category_id',
                'value' => 'category.name'
            ],
            'price',
//            'description:text',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]); ?>

</div>

