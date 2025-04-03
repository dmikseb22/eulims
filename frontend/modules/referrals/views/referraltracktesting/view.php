<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Referraltracktesting */

$this->title = $model->referraltracktesting_id;
$this->params['breadcrumbs'][] = ['label' => 'Referraltracktestings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referraltracktesting-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->referraltracktesting_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->referraltracktesting_id], [
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
            'referraltracktesting_id',
            'referral_id',
            'testing_agency_id',
            'receiving_agency_id',
            'date_received_courier',
            'analysis_started',
            'analysis_completed',
            'cal_specimen_send_date',
            'courier_id',
            'date_created',
        ],
    ]) ?>

</div>
