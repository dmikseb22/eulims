<?php

//PHYTO CHEMICAL

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Joborder */

$this->title = $model->joborder_id;
$this->params['breadcrumbs'][] = ['label' => 'Joborders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joborder-view">
phyto chem
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->joborder_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->joborder_id], [
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
            'joborder_id',
            'customer_id',
            'joborder_date',
            'sampling_date',
            'lsono',
            'sample_received',
        ],
    ]) ?>

<?php
    echo Html::button('<i class="glyphicon glyphicon-print"></i> Print Label', [ 'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['/reports/preview?url=/lab/request/printlabel','request_id'=>$model->joborder_id]) . "';" ,'title'=>'Print Label',  'class' => 'btn btn-success']);
?>
</div> 