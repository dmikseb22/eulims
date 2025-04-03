<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\SampleName */

$this->title = $model->sample_name_id;
$this->params['breadcrumbs'][] = ['label' => 'Sample Names', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-name-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->sample_name_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->sample_name_id], [
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
            'sample_name_id',
            'sample_name',
            'description',
        ],
    ]) ?>

</div>
