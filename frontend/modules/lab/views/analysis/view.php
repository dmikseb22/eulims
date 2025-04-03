<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysis */

$this->title = $model->analysis_id;
$this->params['breadcrumbs'][] = ['label' => 'Analyses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="analysis-view">

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
            'date_analysis',
            'rstl_id',
            'pstcanalysis_id',
            'request_id',
            'sample_id',
            'sample_code',
            'testname',
            'method',
            'references',
            'quantity',
            'fee',
            'test_id',
            'cancelled',
            'user_id',
            'is_package',
        ],
    ]) ?>

</div>
