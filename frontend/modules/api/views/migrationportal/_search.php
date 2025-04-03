<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\api\MigrationportalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="migrationportal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'pm_id') ?>

    <?= $form->field($model, 'date_migrated') ?>

    <?= $form->field($model, 'record_id') ?>

    <?= $form->field($model, 'table_name') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
