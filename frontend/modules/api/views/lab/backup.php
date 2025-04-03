


<?php
use yii\helpers\Html;
use yii\bootstrap\Progress;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Customer;
use common\models\lab\Restore_customer;
use common\models\lab\Services;
use common\models\lab\Request;
use common\models\lab\Sample;
use common\models\lab\Analysis;
use common\models\lab\Backuprestore;
use common\models\lab\Lab;
use common\models\lab\Testname;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use common\components\Functions;
use linslin\yii2\curl;
use yii\helpers\Json;



/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\ServicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$func=new Functions();


$this->title = 'Laboratory Module Backup';
$this->params['breadcrumbs'][] = ['label' => 'API', 'url' => ['/api']];
$this->params['breadcrumbs'][] = $this->title;
   



?>   

<fieldset>
    <legend>Legend/Status</legend>
    <div>
    <span class='badge btn-success legend-font' ><span class= 'glyphicon glyphicon-check'></span> DONE</span>
    <span class='badge btn-danger legend-font' ><span class= 'glyphicon glyphicon-check'></span> PENDING</span>

                
    </div>
</fieldset>
   
    <div class="row">
    <div class="image-loader" style="display: hidden;"></div>
   
    </div>
    
    <div class = "row" style="padding-left:15px;padding-right:15px" id="methodreference">
  
    <?= 
    GridView::widget([
        'dataProvider' => $restoredataprovider,
        'id'=>'restore-grid',
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'before'=> "<span class='btn btn-primary' onclick='restoreyear(2015)'>SYNC</span>",
               'after'=>false,
            ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],     
            [
                'header'=>'Table Name',
             //   'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {
                         return $model->table_name;
                },
                'enableSorting' => false,
              //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],           
            ],
            [
                'header'=>'Status',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {

                       
                        
                        
                       
                        if ($model->table_name=="tbl_customer"){
                            $customer = Customer::find()->count();
                            return "";
                        }else if ($model->table_name=="tbl_request"){
                            $request = Request::find()->count();
                            return "";
                        }else if ($model->table_name=="tbl_sample"){
                            $sample = Sample::find()->count();
                            return "";
                        }else if ($model->table_name=="tbl_analysis"){
                            $analysis = Analysis::find()->count();
                            
                            return "";
                        }
                         
                },
                'enableSorting' => false,
             //   'contentOptions' => ['style' => 'width:10%; white-space: normal;'],           
            ],
            [
                'header'=>'Backup',
                'hAlign'=>'center',
                'format'=>'raw',
                'value' => function($model) {
                    return "<span class='btn btn-primary' onclick='restoreyear()'>Sync Up</span>";      
                },
                'enableSorting' => false,
             //   'contentOptions' => ['style' => 'width:10%; white-space: normal;'],           
            ],

        ],
    ]);
    ?>
</div>



<style type="text/css">
/* Absolute Center Spinner */
.img-loader {
    position: fixed;
    z-index: 999;
    /*height: 2em;
    width: 2em;*/
    height: 64px;
    width: 64px;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-image: url('/images/img-loader64.gif');
    background-repeat: no-repeat;
}
/* Transparent Overlay */
.img-loader:before {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.3);
}
</style>

<script type="text/javascript">

    function restoreyear(year){

        
        $.ajax({
            url: "/api/lab/restoreyear",
            method: "POST",
            dataType: 'json',
            data: { year:year},
            beforeSend: function(xhr) {
                $('.image-loader').addClass("img-loader");
               }
            })
            .done(function( data ) {
                alert(data.message);
                $("#restore-grid").yiiGridView("applyFilter"); 

                $('.image-loader').removeClass("img-loader");
            });
        }

</script>
