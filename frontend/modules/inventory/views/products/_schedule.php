<?php 
use common\models\inventory\Equipmentservice;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\helpers\Html; 
use yii\widgets\ActiveForm; 
use yii\helpers\ArrayHelper;
use common\models\inventory\Servicetype;
use kartik\date\DatePicker;

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


    // $.ajax({
    //     url: Url::to(['/inventory/products/dayClickCalendarEvent']),
    //     dataType: 'json',
    //     data: { 
    //           title: calEvent.title,
             
    //     },
        
    // });

    // alert('Event: id is  ' + calEvent.id);
    // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
    // alert('View: ' + view.name);

    // change the border color just for fun
    // $(this).css('border-color', 'red');

    window.open( "/inventory/equipmentservice/update?id=" + calEvent.id, "_blank", "" );
}
EOF;

?>
<div class="products-index">
    <div class="col-md-6" class="row">
        <div id="external-events" >
        <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
          'events'=> Url::to(['/inventory/products/jsoncalendar?id='.$id]),
          'clientOptions' => [
                        'selectable' => true,
                        'selectHelper' => true,
                        'droppable' => true,
                        'editable' => true,
                        // 'select' => new JsExpression($JSCode),
                        // 'drop' => new JsExpression($JSDropEvent),
                        'eventClick' => new JsExpression($JSEventClick),
                        // 'dayClick'=>new \yii\web\JsExpression($JSDayClick),
                        'defaultDate' => date('Y-m-d')
                  ],
      ));
    ?>


    </div>
     
    </div>
    <div class="col-md-6">
        
        <div class="equipmentservice-form"> 
            <h2>Set new Schedule</h2>
            <br><br>
            <?php $form = ActiveForm::begin(); ?> 
             <?= $form->errorSummary($model); ?>

            <?=
            $form->field($model, 'servicetype_id')->widget(\kartik\widgets\Select2::classname(), [
                'data' => ArrayHelper::map(Servicetype::find()->orderBy('servicetype')->asArray()->all(), 'servicetype_id', 'servicetype'),
                'options' => ['placeholder' => 'Choose Service Type'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Service Type');
            ?>
            <?php
                 echo "<b>Start Date</b>";
                echo DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'startdate',
                    'readonly' => true,
                    'options' => ['placeholder' => 'Enter Date'],
                    'value' => function($model) {
                        return date("Y-m-d", $model->startdate);
                    },
                    'pluginOptions' => [
                        'autoclose' => true,
                        'removeButton' => false,
                        'format' => 'yyyy-mm-dd'
                    ],
                    'pluginEvents' => [
                        "change" => "function() {  }",
                    ]
                ]);
                ?>

                <br>

            <?php
                 echo "<b>End Date</b>";
                echo DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'enddate',
                    'readonly' => true,
                    'options' => ['placeholder' => 'Enter Date'],
                    'value' => function($model) {
                        return date("Y-m-d", $model->enddate);
                    },
                    'pluginOptions' => [
                        'autoclose' => true,
                        'removeButton' => false,
                        'format' => 'yyyy-mm-dd'
                    ],
                    'pluginEvents' => [
                        "change" => "function() {  }",
                    ]
                ]);
                ?>

                <br>
            <div class="form-group"> 
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?> 
            </div> 

            <?php ActiveForm::end(); ?> 

        </div> 
    </div>
</div>