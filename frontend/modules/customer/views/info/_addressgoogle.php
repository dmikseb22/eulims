<?php
use yii\helpers\Html; 
?>
<?= Html::button('<span class="glyphicon glyphicon-search"></span> Locate on map', ['value'=>'/customer/info/create', 'class' => 'btn btn-small btn-primary','title' => Yii::t('app', "Locate Customer"),'onclick'=>"ShowGModal('Locate Customer',true,'900px')"]); ?>

<?= $form->field($model, 'address')->textarea(['maxlength' => true]) ?>
<div class="row">
<div class="col-md-6">
 <?= $form->field($model, 'latitude')->textInput(['readonly'=>'true']) ?>
</div>
<div class="col-md-6">
 <?= $form->field($model, 'longitude')->textInput(['readonly'=>'true']) ?>
</div>
</div>