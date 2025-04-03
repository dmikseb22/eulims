<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use yii\helpers\Url;
        
?>

<div class="products-form">

    <?php $form = ActiveForm::begin( [ 'options' => [ 'enctype' => 'multipart/form-data' ] ] ); ?>

    <?= $form->errorSummary($model); ?>
     <?= $form->field($model, 'request_id')->hiddenInput()->label(false) ?>
    <div class="row">
        <div class="col-md-6">
        <?php // your fileinput widget for single file upload
            echo "<b>Proof</b>";

            echo $form->field($model, 'proof')->widget(FileInput::classname(), [
                'options'=>['proof_upload',
                    'accept'=>'*'
                ],
                'pluginOptions'=>[
                    'allowedFileExtensions'=>['pdf',],
                    'overwriteInitial'=>true,
                    'resizeImages'=>true,
                    'initialPreviewConfig'=>[
                        'width'=>'120px',
                    ],
                    'initialPreview' =>true,
                    'showUpload'=>true,
                    'showRemove'=>false,
                    'showBrowse'=>true,
                   // 'showText'=>false
                ],
            ])->label(false);
        ?>    
        </div>
     </div>
    
    <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Upload', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
