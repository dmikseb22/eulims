<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Billing */

$this->title = 'Update Billing: ' . $model->billing_id;
$this->params['breadcrumbs'][] = ['label' => 'Billings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->billing_id, 'url' => ['view', 'id' => $model->billing_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="billing-update">
    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
