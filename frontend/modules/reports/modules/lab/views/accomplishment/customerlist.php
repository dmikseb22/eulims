<?php

use yii\helpers\Html;
//use yii\grid\GridView;
//use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use common\models\lab\Lab;
use kartik\grid\Module;
use kartik\daterange\DateRangePicker;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\export\ExportMenu;
use kartik\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Firms/Customers - Accomplishment Report';
$this->params['breadcrumbs'][] = $this->title;

?>

<h3>Full List of customer under <?php echo $monthyear ?></h3>
<div class="accomplishment-index">
<div class="panel panel-default col-xs-12">
        
	    <div class="row">
        	<?php
			    $gridColumns= [
			    	'request_ref_num',
			    	'customer.customer_name'
			    ];

			    echo GridView::widget([
			    	// 'id' => 'accomplishment-report',
			        'dataProvider'=>$dataProvider,
			        'columns'=> $gridColumns,
			       
           
			    ]);
        	?>
    	</div>
     
</div>
</div>