<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Cancelledreferral */

$this->title = $model->cancelledreferral_id;
$this->params['breadcrumbs'][] = ['label' => 'Cancelledreferrals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cancelledreferral-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->cancelledreferral_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->cancelledreferral_id], [
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
            'cancelledreferral_id',
            'referral_id',
            'reason',
            'cancel_date',
            'agency_id',
            'cancelled_by',
        ],
    ]) ?>

</div>
