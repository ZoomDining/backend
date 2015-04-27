<?php
/* @var $this yii\web\View */

use common\models\Orders;
use common\models\OrdersItems;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;



?>

<?php
if(empty($orders)){
    echo "No results found.";
}else{
    ?>

    <?php foreach ((array)$orders as $_order) { ?>

        <?php
        $orderPrice = Orders::getOrderPrice($_order->id);
        ?>


        <div class="base-box-ag js-item-box" data-id="<?= $_order->id ?>">
            <?php
            echo Html::submitButton('&times;', ['name' => 'cancelled', 'class' => 'btn pull-right btn-danger js-btn-cancelled btn-cancelled-ag']);
            ?>

            <div class="js-item-head">
                <div>
                    <?= User::findIdentity($_order->user_id)->username . ": " . $_order->id ?>
                </div>
                <div>
                    <?= $_order->guests . " guests: " . $orderPrice ?>
                </div>
                <div>
                    <?= date("h.iA", $_order->date) . ": " . Orders::getTypes($_order->type) ?>
                </div>
            </div>


            <div class="js-sub-item">
                <div>
                    <?php
                    echo GridView::widget([
                        'dataProvider' => new ActiveDataProvider([
                            'query' => OrdersItems::find()->where("order_id =" . $_order->id),
                        ]),
                        'filterModel'  => null,
                        'tableOptions' => [
                            'class' => 'table table-striped table-bordered table-hover',
                        ],
                        'summary'      => false,
                        'columns'      => [
                            [
                                'options' => ['class'=>'col-lg-4'],
                                'attribute'     => 'count',
                                'value'         => 'count',
                                'enableSorting' => false,
                            ],
                            [
                                'options' => ['class'=>'col-lg-4'],
                                'attribute' => 'item',
                                'value'     => 'menu.name',
                            ],
                            'amount',

                        ],
                    ]);
                    ?>
                </div>

                <div class="clearfix">
                    <div class="col-lg-4 col-md-offset-8">
                        <div>
                            SUB TOTAL: <?= $orderPrice ?>
                        </div>
                        <div>
                            GOV. TAX: 0
                        </div>
                        <div>
                            SERVICE CHARGE: 0
                        </div>
                        <div>
                            ROUNDING ADJ: 0
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-offset-8">
                        <?= Html::label("NET TOTAL:") . " " . $orderPrice ?>
                    </div>
                </div>
            </div>

        </div>


    <?php } ?>
<?php } ?>
