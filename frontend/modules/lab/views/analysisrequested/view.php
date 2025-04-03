<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysisrequested */

$this->title = $model->analysis_id;
$this->params['breadcrumbs'][] = ['label' => 'Analysisrequesteds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="analysisrequested-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->analysis_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->analysis_id], [
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
            'analysis_id',
            'sample_description',
            'control_no',
            'analysis',
            'price',
            'total',
            'joborder_id',
            'type',
            'status',
        ],
    ]) ?>

</div> 