<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\finance\Collectiontype;
use common\models\finance\Paymentmode;
use common\models\lab\Customer;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use common\components\Functions;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\finance\Op */
/* @var $form yii\widgets\ActiveForm */
$paymentlist='';
?>

<div class="orderofpayment-form" style="margin:0important;padding:0px!important;padding-bottom: 10px!important;">

    <?php $form = ActiveForm::begin(); ?>
    <div class="alert alert-info" style="background: #d9edf7 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d">Fields with <i class="fa fa-asterisk text-danger"></i> are required.</p>
     
    </div>
   
    <div style="padding:0px!important;">
        <div class="row">
            <div class="col-sm-6">
           <?php 

                echo $form->field($model, 'collectiontype_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Collectiontype::find()->all(), 'collectiontype_id', 'natureofcollection'),
                'theme' => Select2::THEME_BOOTSTRAP,
                'options' => ['placeholder' => 'Select Collection Type ...'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
                ]);
            ?>
            </div>   
            <div class="col-sm-6">
             <?php
             echo $form->field($model, 'order_date')->widget(DatePicker::classname(), [
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
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
              
             <?php
            $disabled=false;
            $func=new Functions();
            echo $func->GetCustomerList($form,$model,$disabled,"Customer");
            ?>    
           
            </div>
             <div class="col-sm-6">
                <?= $form->field($model, 'payment_mode_id')->widget(DepDrop::classname(), [
                    'type'=>DepDrop::TYPE_SELECT2,
                    'options' => ['placeholder' => 'Select Payment Mode ...'],
                    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                    'pluginOptions'=>[
                        'depends'=>['op-customer_id'],
                        'url'=>Url::to(['/finance/accounting/listpaymentmode?customerid='.$model->customer_id]),
                        
                    ]
                ])
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">  
                 <div id="prog" style="position:relative;display:none;">
                    <img style="display:block; margin:0 auto;" src="<?php echo  $GLOBALS['frontend_base_uri']; ?>/images/ajax-loader.gif">
                     </div>
                

                <div id="requests" style="padding:0px!important;">    	
                   <?php //echo $this->renderAjax('_request', ['dataProvider'=>$dataProvider]); ?>
                </div> 

            </div>
        </div> 
		 <?php echo $form->field($model, 'RequestIds')->hiddenInput()->label(false) ?>
        <div class="row">
            <div class="col-lg-12"> 
                <?= $form->field($model, 'purpose')->textarea(['maxlength' => true,'disabled' =>true]); ?>
            </div>
        </div>

        <input type="text" id="wallet" name="wallet" hidden>
        
        <div class="form-group pull-right">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                'id'=>'createOP','disabled'=>true]) ?>
            <?php if(Yii::$app->request->isAjax){ ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <?php } ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<style>
    .modal-body{
        padding-top: 0px!important;
    }
</style>

<script type="text/javascript">
    $('#op-customer_id').on('change',function(e) {
       $(this).select2('close');
       e.preventDefault();
        $('#prog').show();
        $('#requests').hide();
         jQuery.ajax( {
            type: 'POST',
            url: '/finance/op/check-customer-wallet?customerid='+$(this).val(),
            dataType: 'html',
            success: function ( response ) {
               $('#wallet').val(response);
            },
            error: function ( xhr, ajaxOptions, thrownError ) {
                alert( thrownError );
            }
        });
        jQuery.ajax( {
            type: 'POST',
            //data: {
            //    customer_id:customer_id,
           // },
            url: '/finance/op/getlistrequest?id='+$(this).val(),
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
       checkpayment_mode();
    });
    
    $('#op-payment_mode_id').on('change',function(e) {
        e.preventDefault();
        checkpayment_mode();
    });
    function checkpayment_mode(){
        var payment_mode=$('#op-payment_mode_id').val();
        if(payment_mode == 4){
            $('#op-purpose').prop('disabled', true);
            $('#createOP').prop('disabled', true);
        }
        else{
            $('#op-purpose').prop('disabled', false);
            $('#createOP').prop('disabled', false);
        }    
    }
</script>
