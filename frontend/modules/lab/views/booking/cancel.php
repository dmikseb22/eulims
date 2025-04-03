<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\finance\CancelledOr */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cancelled-or-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reason')->textInput() ?>

	<div class="form-group pull-right">
            <?= Html::submitButton('Confirm', ['class' => 'btn btn-success']) ?>
            <?php if(Yii::$app->request->isAjax){ ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <?php } ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>