<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Sampletype */

$this->title = $model->sampletype_id;
$this->params['breadcrumbs'][] = ['label' => 'Sampletypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sampletype-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->sampletype_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->sampletype_id], [
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
            'sampletype_id',
            'sample_type',
            'test_category_id',
        ],
    ]) ?>

</div>
