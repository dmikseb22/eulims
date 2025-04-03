<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Orseries */

$this->title = $model->or_series_id;
$this->params['breadcrumbs'][] = ['label' => 'Orseries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orseries-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->or_series_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->or_series_id], [
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
            'or_series_id',
            'or_category_id',
            'terminal_id',
            'rstl_id',
            'or_series_name',
            'startor',
            'nextor',
            'endor',
        ],
    ]) ?>

</div>
