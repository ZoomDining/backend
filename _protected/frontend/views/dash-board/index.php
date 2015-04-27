<?php
/* @var $this yii\web\View */


use common\models\Orders;
use common\models\OrdersItems;
use common\models\Tables;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::$app->name." :: ".ucfirst(Yii::$app->controller->id);

$this->registerCssFile(Yii::$app->view->theme->baseUrl.'/js/fullcalendar/fullcalendar.css');
$this->registerJsFile(Yii::$app->view->theme->baseUrl.'/js/fullcalendar/lib/moment.min.js');
$this->registerJsFile(Yii::$app->view->theme->baseUrl.'/js/fullcalendar/fullcalendar.min.js');
$this->registerJsFile(Yii::$app->view->theme->baseUrl.'/js/jquery-ui/jquery-ui.min.js');
$this->registerJsFile(Yii::$app->view->theme->baseUrl.'/js/jquery.ui.touch-punch.min.js');

$tables = Tables::find()->all();
$tables_arr = [];
foreach ((array)$tables as $table_info) {
    $tables_arr[$table_info->pax][] = $table_info;
}
?>
<section class="page-dash-board-ag">
    <div class="row">
        <div class="col-lg-8 col-md-6 col-sm-6">
            <?= Html::label("Tables") ?>
            <div class="base-box-ag order-info-ag">
                <?php
                if(empty($tables_arr)){
                    echo "No results found.";
                }else{
                    foreach ((array)$tables_arr as $guests => $_info_arr) {
                ?>
                   <?= $guests ?> guests <br>
                <?php
                        foreach ((array)$_info_arr as $__info) {
                ?>
                   <div class="table-ag js-table" data-id="<?= $__info->id ?>"><?= $__info->name ?></div>
                <?php
                        }
                ?>
                        <br>
                <?php
                    }
                }
                ?>
            </div>

            <?= Html::label("Live update") ?> <i class="fa fa-refresh fa-spin loader-ag js-loader"></i>
            <div class="base-box-ag js-live-box">

            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div id='js-calendar'></div>
        </div>
    </div>
</section>

<script type="application/javascript">
    $(document).ready(function() {

        $('#js-calendar').fullCalendar({
            header: false,
//            defaultDate: '2014-06-12',
            defaultView: 'agendaDay',
            allDaySlot: false,
            editable: false,
            slotDuration: '00:60:00',
            columnFormat: 'dddd, DD MMMM',
            timeFormat: 'H:mm',
			timezone: 'UTC',
            height: 554,
            events: [
//                {
//                    id: 999,
//                    title: 'Repeating Event',
//                    url: 'http://google.com/',
//                    start: '2014-06-12T10:30:00',
//                    end: '2014-06-12T12:30:00'
//                }
            ],
            eventRender: function(event, element) {
                element.find('.fc-title').append("<br/>" + event.description);
            }
        });


        //load orders for Schedule
        function load_orders($table_id) {
            if($table_id > 0) {
                $.post('<?php echo Url::toRoute("/orders/get-table-orders") ?>?id=' + $table_id, function (data) {
                    $('#js-calendar').fullCalendar('removeEvents');
                    try {
                        data = eval("(" + data + ")");
                    } catch (e) {
                        data = {"type": "error", "message": "Error"};
                    }

                    if (data["type"] != "error") {
                        data.forEach(function (entry) {
                            $('#js-calendar').fullCalendar('renderEvent', {
                                id: entry["id"],
                                start: new Date(entry["start"]),
                                description: entry["description"],
                                title: entry["title"]
                            }, true);
                        })
                    }
                });
            }
        }

        $(".js-table").click(function(){
            var $table_id = $(this).attr("data-id");
            load_orders($table_id);
        });


        $(".js-live-box").on('click', ".js-item-head", function(){
            $(this).next(".js-sub-item").slideToggle();
        });

        $(".js-live-box").on('click', ".js-btn-cancelled", function(){
            var $order_id = $(this).parent(".js-item-box").attr("data-id");
            var $box = $(this).parent(".js-item-box");

            $.post('<?php echo Url::toRoute("/orders/set-status-order") ?>?status=3&order_id=' + $order_id, function (data) {
                $($box).remove();
                if($(".js-item-box").length == 0) {
                    $(".js-live-box").html("No results found.");
                }
            });

        });


        $(".js-table").draggable({
            revert:true
        });


        //load orders for live
        function load_orders_live() {
            $(".js-loader").show();
            $.post('<?php echo Url::toRoute("/orders/get-live-orders") ?>', function (data) {
                $(".js-loader").hide();

                $(".js-live-box").html(data);

                $('.js-item-box').droppable({
                    drop: function(event, ui) {
                        var $table_id = ui.helper.attr("data-id");
                        var $order_id = $(this).attr("data-id");
                        var $box = this;

                        if ($table_id > 0 && $order_id > 0) {
                            $(".js-loader").show();
                            $.post('<?php echo Url::toRoute("/orders/set-table-order") ?>?table_id=' + $table_id + '&order_id=' + $order_id, function (data) {
                                $($box).remove();
                                if($(".js-item-box").length == 0) {
                                    $(".js-live-box").html("No results found.");
                                }

                                load_orders($table_id);
                                $(".js-loader").hide();
                            });
                        }
                    },
                    over: function(event, ui) {
                        $(this).css("background-color", "#f5f5f5");
                    },
                    out: function(event, ui) {
                        $(this).css("background-color", "white");
                    }
                });

            });
        }

        load_orders_live();
        setInterval(load_orders_live, 30000);


    });
</script>
