<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\helpers\Json;
/* @var $this yii\web\View */
/* @var $model common\models\referral\Analysis */
/* @var $form yii\widgets\ActiveForm */

$options = [
        'language' => 'en-US',
        'width' => '100%',
        'theme' => Select2::THEME_KRAJEE,
        'placeholder' => 'Select Testname',
        'allowClear' => true,
        'id'=>'the-test'
    ];

$options2 = [
        'language' => 'en-US',
        'width' => '100%',
        'theme' => Select2::THEME_KRAJEE,
        'placeholder' => 'Select Methods',
        'allowClear' => true,
        'id'=>'the-method'
    ];
?>


<div class="analysis-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            
        <?= $form->field($model, 'sample_ids')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'sample_id')->widget(Select2::classname(), [
                'data' =>$data->samples,
                'language' => 'en',
                 'options' => [
                    'placeholder' => 'Select any samples',
                    'multiple' => true,
                    'id'=>'the-samples',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'pluginEvents' => [
                    "change" => "function() { 
                        $('#analysis-sample_ids').val($(this).val());

                        var key_ids =  $('#analysis-sample_ids').val();
                        var select = $('#the-test');
                        select.find('option').remove().end();
                        $.ajax({
                            url: '".Url::toRoute("/referrals/analysis/testnames?sample_ids='+key_ids+'")."',
                            success: function (data) {

                                var select2options = ".Json::encode($options).";
                                select2options.data = data;
                                select.select2(select2options);
                                select.val('').trigger('change');
                                $('.image-loader').removeClass(\"img-loader\");
                            },
                            beforeSend: function (xhr) {
                                //alert('Please wait...');
                                $('.image-loader').addClass(\"img-loader\");
                            }
                        });
                        
                    }
                    ",
                ]
            ])->label('Samples'); ?> 


        <?php
            echo $form->field($model,'testName_id')->widget(Select2::classname(),[
                'data' => [],
                'theme' => Select2::THEME_KRAJEE,
                //'theme' => Select2::THEME_BOOTSTRAP,
                'options' => $options,
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'pluginEvents' => [
                    "change" => "function() {

                        var test =  $(this).val();
                        var select = $('#the-method');
                        select.find('option').remove().end();
                        $.ajax({
                            url: '".Url::toRoute("/referrals/analysis/methods?test='+test+'")."',
                            success: function (data) {
                                $('#methodrefpart').html(data);
                                $('.image-loader').removeClass(\"img-loader\");
                            },
                            beforeSend: function (xhr) {
                                //alert('Please wait...');
                                $('.image-loader').addClass(\"img-loader\");
                            }
                        });
                    }",
                ],
            ])->label('Test Name');
        ?>
            <div class="row" id ="methodrefpart"></div>

        
    

            <div class="row" style="float: right;padding-right: 15px">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'btn-update']) ?>
                <?php if($model->isNewRecord){ ?>
                <?= Html::resetButton('Reset', ['class' => 'btn btn-danger']) ?>
                <?php } ?>
                <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
