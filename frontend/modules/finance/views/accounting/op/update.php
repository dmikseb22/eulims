<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Orderofpayment */

$this->title = 'Update Orderofpayment: ' . $model->orderofpayment_id;
$this->params['breadcrumbs'][] = ['label' => 'Orderofpayments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->orderofpayment_id, 'url' => ['view', 'id' => $model->orderofpayment_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="orderofpayment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
