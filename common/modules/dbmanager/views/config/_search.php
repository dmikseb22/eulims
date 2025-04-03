<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\system\BackupConfigSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="backup-config-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'backup_config_id') ?>

    <?= $form->field($model, 'mysqldump_path') ?>

    <?= $form->field($model, 'Description') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('dbManager', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('dbManager', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
