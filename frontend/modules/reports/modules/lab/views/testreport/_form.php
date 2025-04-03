<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use common\components\Functions;
use kartik\widgets\DatePicker;
use kartik\widgets\SwitchInput;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Testreport */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
      .blink {
        animation: blinker 0.6s linear infinite;
        color: #1c87c9;
        font-size: 30px;
        font-weight: bold;
        font-family: sans-serif;
      }
      @keyframes blinker {
        50% {
          opacity: 0;
        }
      }
      .blink-one {
        animation: blinker-one 1s linear infinite;
      }
      @keyframes blinker-one {
        0% {
          opacity: 0;
        }
      }
      .blink-two {
        animation: blinker-two 1.4s linear infinite;
      }
      @keyframes blinker-two {
        100% {
          opacity: 0;
        }
      }
</style>

<div class="testreport-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 

    $func=new Functions();
    echo $func->GetRequestList($form,$model,false,"Request");
    ?>

    <!-- <?= $form->field($model, 'report_num')->textInput(['maxlength' => true]) ?> -->

    <?php
     echo $form->field($model, 'report_date')->widget(DatePicker::classname(), [
     'options' => ['placeholder' => 'Select Date ...',
         'autocomplete'=>'off'],
     'type' => DatePicker::TYPE_COMPONENT_APPEND,
         'pluginOptions' => [
             'format' => 'yyyy-mm-dd',
             'todayHighlight' => true,
             'autoclose'=>true,
         ]
     ]);
     ?>
	<div class="alert alert-info" style="background: #d4f7e8 !important;margin-top: 1px !important;">
       <a href="#" class="close" data-dismiss="alert" >×</a>
      <p class="note" style="color:#265e8d"><b>Slow down...</b><br/> Make sure to select <b>MULTIPLE</b> if you want to generate individual reports per sample.</p>
   
    </div>
    <div class="row-form">
        <?php echo $form->field($model, 'lab_id')->widget(SwitchInput::classname(), [
        //'disabled' => $disabled,
            'name'=>'chkmultiple',
			'pluginOptions' => [
				'size' => 'large',
				'handleWidth'=>'100',
				'onColor' => 'success',
				'offColor' => 'danger',
				'onText' => 'Yes',
				'offText' => 'No',
			]
    ])->label("Multiple Report?"); ?>
    </div>

    <!-- <?= $form->field($model, 'status_id')->textInput() ?> -->

    <!-- <?= $form->field($model, 'release_date')->textInput() ?> -->

    <!-- <?= $form->field($model, 'reissue')->textInput() ?> -->

    <!-- <?= $form->field($model, 'previous_id')->textInput() ?> -->

    <div class="row-form">
         <div id="prog" style="position:relative;display:none;">
            <img style="display:block; margin:0 auto;" src="<?php echo  $GLOBALS['frontend_base_uri']; ?>/images/ajax-loader.gif">
             </div>
        

        <div id="requests" style="padding:0px!important;">      
           <?php //echo $this->renderAjax('_request', ['dataProvider'=>$dataProvider]); ?>
        </div> 
    </div>

     <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success mybtn' : 'btn btn-primary mybtn',
            'id'=>'createTestReport',
            'data' => [
                'confirm' => knowthymulti(),
            ]]) ?>
        <?php if(Yii::$app->request->isAjax){ ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <?php } ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
     $('#testreport-request_id').on('change',function(e) {
       $(this).select2('close');
       e.preventDefault();
        $('#prog').show();
        $('#requests').hide();
        jQuery.ajax( {
            type: 'POST',
            //data: {
            //    customer_id:customer_id,
           // },
            url: '/reports/lab/testreport/getlistsamples?id='+$(this).val(),
            dataType: 'html',
            success: function ( response ) {

               setTimeout(function(){
               $('#prog').hide();
                 $('#requests').show();
               $('#requests').html(response);
                   }, 0);
            },
            error: function ( xhr, ajaxOptions, thrownError ) {
                alert( thrownError );
            }
        });
        
       //alert(paymentmode);
        $(this).select2('open');
      //  $(this).one('select-focus',select2Focus);
      $(this).attr('tabIndex',1);
       
    });

     $("#testreport-report_date").datepicker().datepicker("setDate", new Date());
</script>


<script type="text/javascript">
    
    $("#createTestReport").click(function(){
        var checked=$("#samplegrid").yiiGridView("getSelectedRows");
        var count=checked.length;
        if(count<1){alert("Please select sample(s).");return false;}
    });

</script>



<?php
function knowthymulti(){
	return "<div><h1 class='blink'><b>NOTICE!</b></h1></div><div class='alert alert-warning' style='background: #ffc0cb !important;margin-top: 1px !important;'><h2 style='color:#d73925'>Wait! You are about to generate report.</h2><h4 style='color:#d73925'>Please double check if you want to generate it with multiple or single report.</h4></div>";
}
?>

