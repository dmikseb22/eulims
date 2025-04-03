<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Cancelledrequest */
/* @var $form yii\widgets\ActiveForm */

?>

<?php
    if($HasOP){
        ?>
          <div class="alert alert-danger" style="background: #ffc0cb !important;margin-top: 1px !important;">
           <a href="#" class="close" data-dismiss="alert" >×</a>
          <p class="note" style="color:#d73925"><b>Cannot Cancel!</b><br/>This Request with Reference # '<?= $model->request_ref_num ?> already have an Order of Payment</p>
          </div>
          <?= Html::Button('Close', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
        <?php
    }else{
        if($request->payment_status_id > 1){
            ?>
            <div class="alert alert-danger" style="background: #ffc0cb !important;margin-top: 1px !important;">
               <a href="#" class="close" data-dismiss="alert" >×</a>
              <p class="note" style="color:#d73925"><b>Cannot Cancel!</b><br/>This Request with Reference # '<?= $model->request_ref_num ?> is already PAID</p>
              </div>
              <?= Html::Button('Close', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
            <?php
        }elseif($request->status_id==0){
            ?>
            <div class="alert alert-danger" style="background: #ffc0cb !important;margin-top: 1px !important;">
               <a href="#" class="close" data-dismiss="alert" >×</a>
              <p class="note" style="color:#d73925"><b>Cannot Cancel!</b><br/>This Request with Reference # '<?= $model->request_ref_num ?> is already CANCELLED.</p>
              </div>
              <?= Html::Button('Close', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
            <?php
        }else{
            ?>
            <div class="cancelledrequest-form">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'request_id')->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'cancelledby')->hiddenInput()->label(false) ?>
                
                <?= $form->field($model, 'request_ref_num')->textInput(['maxlength' => true,'readonly'=>true])->label("Request Reference #") ?>

                <?= $form->field($model, 'cancel_date')->textInput(['readonly'=>true])->label('Date') ?>
                
                <?= $form->field($model, 'reason')->textarea(['style'=>'overflow-y: scroll']) ?>
                <label class="control-label" for="Cancelled By">Cancelled By:</label>                     
                <?= Html::tag('text',$UserCancel,['class'=>'form-control','readonly'=>true]) ?>
                <div class="row" style="float: right;padding-right: 15px;padding-top: 10px;margin-bottom: 10px">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    <?php if($model->isNewRecord){ ?>
                    <?= Html::resetButton('Reset', ['class' => 'btn btn-danger']) ?>
                    <?php } ?>
                    <?= Html::Button('Close', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
                </div>
                <br>
                <?php ActiveForm::end(); ?>
            </div>
            <?php
        }

    }
?>