<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\grid\GridView;


?>

<div>
   

   
    
</div>

  <?php $form = ActiveForm::begin(); ?>

   <?php
    echo $form->field($modelAccountCode, 'accountcode')->widget(Select2::classname(), [
    'data' => $dataProviderAccountCode,
    'options' => ['placeholder' => 'Select Accounting Code'],
     'attribute'=> 'accountcode',
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
    
     echo $form->field($modelCollectionType, 'natureofcollection')->widget(Select2::classname(), [
    'data' => $dataProviderCollectionType,
    'options' => ['placeholder' => 'Select Accounting Code'],
     'attribute'=> 'accountcode',
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
    
    
    
    ?>



    <?php ActiveForm::end(); ?>
