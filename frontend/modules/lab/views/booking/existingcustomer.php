<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\Functions;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model common\models\finance\CancelledOr */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="existing-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
    <div class="col-md-12">
	<?php
		 echo $form->field($model,'customer_id')->widget(Select2::classname(),[
                'data' => $customers,
                'theme' => Select2::THEME_KRAJEE,
                'options' => [
                    'placeholder' => 'Select Customer',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Customer');
	?>
    </div>
	</div>
    <div class="form-group">
	    <div class="form-group pull-right">
			<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
		</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>