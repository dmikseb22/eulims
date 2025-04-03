<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\BookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Create Booking';
$this->params['breadcrumbs'][] = ['label' => 'Manage Booking', 'url' => ['/lab/booking/manage']];
$this->params['breadcrumbs'][] = $this->title;

$DragJS = <<<EOF
/* initialize the external events
-----------------------------------------------------------------*/
$('#external-events .fc-event').each(function() {
    // store data so the calendar knows to render an event upon drop
    $(this).data('event', {
        title: $.trim($(this).text()), // use the element's text as the event title
        stick: true // maintain when user navigates (see docs on the renderEvent method)
    });
    // make the event draggable using jQuery UI
    $(this).draggable({
        zIndex: 999,
        revert: true,      // will cause the event to go back to its
        revertDuration: 0  //  original position after the drag
    });
});
EOF;
$this->registerJs($DragJS);

$JSDayClick = <<<EOF
function (date, allDay, jsEvent, view) { 
    alert('haha');
}
EOF;

$JSCode = <<<EOF
function(start, end) {
    var title = prompt('Event Title:');
    var eventData;
    if (title) {
        eventData = {
            title: title,
            start: start,
            end: end
        };
        $('#w0').fullCalendar('renderEvent', eventData, true);
    }
    $('#w0').fullCalendar('unselect');
}
EOF;
$JSDropEvent = <<<EOF
function(date) {
    alert("Dropped on " + date.format());
    if ($('#drop-remove').is(':checked')) {
        // if so, remove the element from the "Draggable Events" list
        $(this).remove();
    }
}
EOF;
$JSEventClick = <<<EOF
function(calEvent, jsEvent, view) {


    window.open( "/lab/booking/view?id=" + calEvent.id, "_blank", "" );
}
EOF;

?>
<div class="booking-index">

    <div class="alert alert-success" style="background: #d4f7e8 !important;margin-top: 1px !important;">
        <a href="#" class="close" data-dismiss="alert" >×</a>
        <i style="font-size: 20pt"><b style="color:#00a65a">3 Easy steps to book online</b></i>

        <br>
        <br>
        <i style="font-size: 15pt;color:#00a65a;"><b>1. </b> Click "Book Now!"</i>
        <br>
        <br>
        <i style="font-size: 15pt;color:#00a65a;"><b>2. </b> Fill up the form and Submit.</i>
        <br>
        <br>
        <i style="font-size: 15pt;color:#00a65a;"><b>3. </b> Track your request using the reference number.</i>



        <p class="note" style="color:#d73925;font-size: 12pt;"><b>Always secure a copy of your reference number </b><br/> You may also reach us through (062) 991-1024</p>
   
    </div>
    <div class="alert alert-warning" style="background: #F4D6B6 !important;margin-top: 1px !important;">
        <a href="#" class="close" data-dismiss="alert" >×</a>
         <i style="font-size: 20pt;color:#E17400"><b>Note:Our Customer Relation Officer may contact you to verify your booking details.</b></i>

         <p class="note" style="color:#d73925;font-size: 12pt;"><b>Make sure that the provided contact number is updated</b><br/> Thank you!</p>
    </div>
    <div>
        <?= Html::button('<span class="glyphicon glyphicon-plus"></span>  Book Now!', ['value'=>'/lab/booking/create', 'class' => 'btn btn-lg btn-success ','title' => Yii::t('app', "Booking"),'id'=>'btnBooking', 'style'=>'style="left: 50%;margin-right: -50%;"','onclick'=>'addBooking(this.value,this.title)'])?>
        - or -
        <?= Html::button('<span class="glyphicon glyphicon-eye-open"></span>  Track your request!', ['value'=>'/lab/booking/viewbyreference', 'class' => 'btn btn-success btn-lg','title' => Yii::t('app', "View Booking"),'id'=>'btnBooking','onclick'=>'viewBooking(this.value,this.title)'])?>
    </div>
    <br>
    
</div>
<script type="text/javascript">
    function addBooking(url,title){
        LoadModal(title,url,'true','700px');
    }

    function viewBooking(url,title){
        LoadModal(title,url,'true','700px');
    }
    $('#btnBooking').click(function(){
        $('.modal-title').html($(this).attr('title'));
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
</script>


