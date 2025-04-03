<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\discount */

$this->title = 'Update Discount: ' . $model->discount_id;
$this->params['breadcrumbs'][] = ['label' => 'Discounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->discount_id, 'url' => ['view', 'id' => $model->discount_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="discount-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
