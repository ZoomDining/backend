<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="categories-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-hover',
        ],
        'columns'      => [
            'username',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{delete}',
            ],
        ],
    ]); ?>

</div>
