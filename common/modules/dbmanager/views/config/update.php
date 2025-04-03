<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\system\BackupConfig */

$this->title = Yii::t('dbManager', 'Update {modelClass}: ', [
    'modelClass' => 'Backup Config',
]) . $model->backup_config_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('dbManager', 'Backup Configs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->backup_config_id, 'url' => ['view', 'id' => $model->backup_config_id]];
$this->params['breadcrumbs'][] = Yii::t('dbManager', 'Update');
?>
<div class="backup-config-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
