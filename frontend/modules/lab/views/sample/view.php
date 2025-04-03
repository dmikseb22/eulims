<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Sample */

$this->title = $model->sample_id;
$this->params['breadcrumbs'][] = ['label' => 'Samples', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->sample_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->sample_id], [
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
            'sample_id',
            'rstl_id',
            'pstcsample_id',
            'package_id',
            //'test_category_id',
            'sample_type_id',
            'sample_code',
            'samplename',
            'description:ntext',
            'sampling_date',
            'remarks',
            'request_id',
            'sample_month',
            'sample_year',
            'active',
        ],
    ]) ?>

</div>
