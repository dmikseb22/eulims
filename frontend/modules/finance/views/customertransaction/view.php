<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Customertransaction */

$this->title = $model->customertransaction_id;
$this->params['breadcrumbs'][] = ['label' => 'Customertransactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customertransaction-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->customertransaction_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->customertransaction_id], [
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
            'customertransaction_id',
            'date',
            'transactiontype',
            'amount',
            'customerwallet_id',
        ],
    ]) ?>

</div>
