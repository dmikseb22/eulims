<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\discount */

$this->title = $model->discount_id;
$this->params['breadcrumbs'][] = ['label' => 'Discounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'discount_id',
            'type',
            'rate',
            'status:boolean',
        ],
    ]) ?>
    <div class="form-group pull-right">
        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
    </div>
</div>
