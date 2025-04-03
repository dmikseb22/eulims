<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\system\BackupConfig */

$this->title = Yii::t('dbManager', 'Create Backup Config');
$this->params['breadcrumbs'][] = ['label' => Yii::t('dbManager', 'Backup Configs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="backup-config-create">
    <div class="col-md-12">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
