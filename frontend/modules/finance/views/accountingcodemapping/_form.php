<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Accountingcodemapping */
/* @var $form yii\widgets\ActiveForm */

//var_dump($mar);
?>
<script type="text/javascript">
    $.fn.modalmanager.defaults.spinner = '<div class="animationload"><div class="osahanloading"></div></div>';
$.fn.modal.defaults.spinner = '<div class="animationload"><div class="osahanloading"></div></div>';

    $('#accountingcodemapping-accountingcode_id').on("select2:select", function (e) {
        //Do stuff
        alert('test');
    });
</script>
<div class="accountingcodemapping-form">


    <?php
    Pjax::begin(['id' => 'pjax',
        'timeout' => 2000,
        'enablePushState' => false]);
    ?>
    <?php
    $form = ActiveForm::begin(
                    [
                        'id' => 'accountingcodemapping-form'
    ]);
    ?>



    <div class="row">
        <div class="col-md-6">
            <?php
            echo $form->field($model, 'accountingcode_id')->dropDownList($dataProviderAccountCode, [
                // 'id' => 'accountnolist',
                'prompt' => 'Select Account Code'
            ]);
            ?>


        </div>
        <div class="col-md-6">
            <?php
            echo $form->field($model, 'collectiontype_id')->widget(DepDrop::classname(), [
                'pluginOptions' => [
                    'depends' => [Html::getInputId($model, 'accountingcode_id')],
                    // 'depends'=>['accountingcodemapping-accountingcode_id'],
                    'placeholder' => 'Select Collection Type',
                    'url' => Url::to(['/finance/accountingcodemapping/collectionfilter']),
                    'idParam' => 'collectiontype_id',
                    'nameParam' => 'natureofcollection',
                ]
            ]);
            ?>

        </div>
    </div>


 

    <div class="form-group">
<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>


    </div>

       



    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>



</div>
