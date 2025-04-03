<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Packageoffer */

$this->title = $model->packageoffer_id;
$this->params['breadcrumbs'][] = ['label' => 'Packageoffers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="packageoffer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->packageoffer_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->packageoffer_id], [
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
            'packageoffer_id',
            'agency_id',
            'packagelist_id',
            'offered_date',
        ],
    ]) ?>

</div>
