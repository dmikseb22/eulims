<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\Products */

$this->title = 'Update Products: ' . ' ' . $model->product_id;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_id, 'url' => ['view', 'id' => $model->product_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="products-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
