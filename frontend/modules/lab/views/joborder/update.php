<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Joborder */

$this->title = 'Update Joborder: ' . $model->joborder_id;
$this->params['breadcrumbs'][] = ['label' => 'Joborders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->joborder_id, 'url' => ['view', 'id' => $model->joborder_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="joborder-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div> 