<?php
use common\models\Orders;
use common\models\User;

$this->title = Yii::$app->name." :: ".ucfirst(Yii::$app->controller->id);

$this->registerCssFile(Yii::$app->view->theme->baseUrl.'/js/fullcalendar/fullcalendar.css');
$this->registerJsFile(Yii::$app->view->theme->baseUrl.'/js/fullcalendar/lib/moment.min.js');
$this->registerJsFile(Yii::$app->view->theme->baseUrl.'/js/fullcalendar/fullcalendar.min.js');



//find orders for schedule
$orders = Orders::find()->all();
$orders_js = '';
foreach ((array)$orders as $_info) {
    $title = User::findIdentity($_info->user_id)->username;
    $description = "Table: ".$_info->table;
    $start = date('c', $_info->date);
    $orders_js .= '
        {
            id: '.$_info->id.',
            title: "'.$title.'",
            description: "'.$description.'",
            start: "'.$start.'"
        },
    ';
}
if(!empty($orders_js)){
    $orders_js = rtrim($orders_js, ',');
}

?>


<div class="site-index">
    <div id='js-calendar'></div>
</div>


<script type="application/javascript">
    $(document).ready(function() {

        $('#js-calendar').fullCalendar({
//            header: {
//                left: '',
//                right: 'prev,next today',
//                center: 'title'
//            },
//            defaultDate: '2014-06-12',
            defaultView: 'agendaWeek',
            allDaySlot: false,
            editable: false,
            slotDuration: '00:30:00',
            axisFormat: 'h A',
            defaultTimedEventDuration: '01:00:00',
            timeFormat: 'H:mm',
//            height: 601,
            height: 1129,
			timezone: 'UTC',
            titleFormat: 'DD MMMM',
            columnFormat: 'ddd, DD MMM',
            events: [<?= $orders_js ?>
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
    });
</script>