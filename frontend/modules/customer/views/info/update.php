<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Customer */

$this->title = 'Update Customer: ' . $model->customer_name;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->customer_id, 'url' => ['view', 'id' => $model->customer_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customer-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
