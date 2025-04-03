<?php
// _list_item.php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use yii\widgets\ActiveForm;
?>
<div class="confirm-referral-form">
	<?= Html::beginForm(); ?>
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group required">
			<?php
				echo '<label>Please indicate estimated due date </label>';
				echo DatePicker::widget([
					'name' => 'estimated_due_date',
					'type' => DatePicker::TYPE_INPUT,
					'value' => '',
					'pluginOptions' => [
						'autoclose'=>true,
						'format' => 'dd-MM-yyyy',
					],
					'options' => [
						'placeholder' => 'Enter Estimated Due Date',
						'autocomplete'=>'off',
						'style' => 'width:50%;',
						'required' => true
					],
				]);
			?>
			</div>
		</div>
	</div>
	<div class="form-group" style="padding-bottom: 3px;margin-top:20px;">
		<div style="float:left;">
			<?= Html::submitButton('Send', ['class' => 'btn btn-primary']); ?>
			<?= Html::button('Close', ['class' => 'btn', 'data-dismiss' => 'modal']) ?>
			<br>
		</div>
	</div>
	<?= Html::endForm(); ?>
</div>

<style type="text/css">
input:required:focus {
  border: 1px solid red;
  outline: none;
}

input:required:hover {
  opacity: 1;
}
</style>