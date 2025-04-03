<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\system\BackupConfig */

$this->title = $model->backup_config_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('dbManager', 'Backup Configs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="backup-config-view">
    <div class="col-md-12">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'backup_config_id',
            'mysqldump_path',
            'Description:ntext',
        ],
    ]) ?>
    </div>
    <div class="row pull-right" style="padding-right: 15px">
        <button style='margin-left: 5px' type='button' class='btn btn-secondary pull-left-sm' data-dismiss='modal'>Cancel</button>
    </div> 
</div>
