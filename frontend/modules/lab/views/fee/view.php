<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Fee */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Fees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fee-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->fee_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->fee_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fee_id',
            'name',
            'code',
            'unit_cost',
        ],
    ]) ?>

</div>
