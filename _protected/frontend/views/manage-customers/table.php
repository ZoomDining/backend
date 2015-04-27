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

	echo Html::submitButton('Export to CSV', [
		'id'	=> 'export_btn', 
		'name'	=> 'export', 
		'class' => 'btn btn-primary pull-right'
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
            'firstname',
            'lastname',
            'phone',
            'address',
            [
				'attribute' => 'created_at',
				'value' => function ($data) {
					return date ('Y-m-d H:i:s', $data->created_at);
				},
			],
        ],
    ]); ?>

</div>
