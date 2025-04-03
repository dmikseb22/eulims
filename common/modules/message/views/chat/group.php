<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\Functions;
use yii\helpers\Url;
use kartik\grid\GridView;

$js=<<<SCRIPT
   $(".kv-row-checkbox").click(function(){
        setids();
   });    
   $(".select-on-check-all").change(function(){
        setids();
   });
  
SCRIPT;
$this->registerJs($js);
?>
<div class="form" style="margin:0important;padding:0px!important;padding-bottom: 10px!important;">

    <?php $form = ActiveForm::begin(); ?>
    <div class="alert alert-info" style="background: #d9edf7 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d">Fields with <i class="fa fa-asterisk text-danger"></i> are required.</p>
     </div>
   
    <div style="padding:0px!important;">
         <div class="row">
            <div class="col-lg-12"> 
                <?= $form->field($model, 'group_name')->textarea(['maxlength' => true]); ?>
            </div>
        </div>
        
		
		<div>
		<?php 
		$gridColumn = [
			['class' => 'kartik\grid\SerialColumn'
			],
			[
				 'class' => '\kartik\grid\CheckboxColumn',
			],
			[
				'attribute'=>'username',
				'enableSorting' => false,
				'contentOptions' => [
					'style'=>'overflow: auto; white-space: normal; word-wrap: break-word;'
				],
			],     
		];
		?>    

		   
		<?= GridView::widget([
			'dataProvider' => $possible_recipients,
			'id'=>'grid',
			'pjax'=>true,
			'containerOptions'=> ["style"  => 'overflow:auto;height:300px'],
			'pjaxSettings' => [
				'options' => [
					'enablePushState' => false,
				]
			],
			
			'responsive'=>false,
			'striped'=>true,
			'hover'=>true,
		  
			'floatHeaderOptions' => ['scrollingTop' => true],
			'panel' => [
				'heading'=>'<h3 class="panel-title">Users</h3>',
				'type'=>'primary',

			 ],
		   
			 'columns' =>$gridColumn,
	   
		   
		]); ?>

		</div>
		
        <div class="row">
            <div class="col-lg-12"> 
                <?= $form->field($model, 'userids')->textarea(['maxlength' => true]); ?>
            </div>
        </div>
		
        <div class="form-group pull-right">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'createOP']) ?>
            <?php if(Yii::$app->request->isAjax){ ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <?php } ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

 <script type="text/javascript">
    function setids(){
       var dkeys=$("#grid").yiiGridView("getSelectedRows");
       $("#chatgroup-userids").val(dkeys); 
    }
    
   
</script>
