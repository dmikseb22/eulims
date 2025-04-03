<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Bid */

$this->title = $model->bid_id;
$this->params['breadcrumbs'][] = ['label' => 'Bids', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bid-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->bid_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->bid_id], [
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
            'bid_id',
            'referral_id',
            'bidder_agency_id',
            'sample_requirements:ntext',
            'bid_amount',
            'remarks',
            'estimated_due',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
