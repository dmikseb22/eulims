<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\web\JsExpression;

?>
<div class="lab-testschedule-view">
	<div class="row">
		<div class="alert alert-warning">
	         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	         <h2><i class="icon fa fa-warning"></i>Workboard</h2>
	         Analyses and their Recommended Maximum Storage
	    </div>
	</div>
	<fieldset>
        <legend>Status Legends</legend>
        <div style='padding: 0 10px'>
            <span class='badge legend-font btn-primary' ><span class="glyphicon glyphicon-star"> </span>  Done</span>
            
            <span class='badge legend-font btn-success' ><span class="glyphicon glyphicon-pencil"> </span>  Ongoing</span>

            <span class='badge legend-font btn-warning' ><span class="glyphicon glyphicon-flash"> </span>  Critical</span>

            <span class='badge legend-font btn-danger' ><span class="glyphicon glyphicon-comment"> </span>  Untouched</span>

            <span class='badge legend-font' ><span class="glyphicon glyphicon-pushpin"> </span>  Pending</span>

            <span class='badge legend-font' style="background-color: #333" ><span class="glyphicon glyphicon-stop"> </span>  Cancelled</span>
            
        </div>
        <div>
            <i style="font-size: 8pt"><b style="color:#3c8dbc">Done</b> - The test is completed.
            </i>
            <br>
            <i style="font-size: 8pt"><b style="color:#00a65a">Ongoing</b> - The test is currently running and up.</i>
            <br>
            <i style="font-size: 8pt"><b style="color:#f39c12">Critical</b> - The test needs to be started.</i>
            <br>
            <i style="font-size: 8pt"><b style="color:#ac2925">Untoched</b> - The test is forgotten.</i>
            <br>
            <i style="font-size: 8pt"><b style="color:#777">Pending</b> - The test will be started soon.</i>
            <i style="font-size: 8pt"><b style="color:#333">Cancelled</b> - The test is cancelled.</i>
        </div>
    </fieldset>
	<div class="row">
	<?= \yii2fullcalendar\yii2fullcalendar::widget(array(
	      'events'=> Url::to(['/lab/testschedule/schedules']),
	      'clientOptions' => [
	      				'weekends'=>true,
	                    'selectable' => false,
	                    'selectHelper' => false,
	                    'droppable' => false,
	                    'editable' => false,
	                    'contentHeight'=>800,
	                    // 'select' => new JsExpression($JSCode),
	                    // 'drop' => new JsExpression($JSDropEvent),
	                    // 'eventClick' => new JsExpression($JSEventClick),
	                    // 'dayClick'=>new \yii\web\JsExpression($JSDayClick),
	                    'defaultDate' => date('Y-m-d')
	              ],
	  ));
	?>
	</div>
</div>


<?php


$this->registerCss("table div div {
		overflow: inherit !important;
		white-space: normal !important;
	}");
?>

