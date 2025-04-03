<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Check */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Check',
]) . $model->check_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Checks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->check_id, 'url' => ['view', 'id' => $model->check_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="check-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
