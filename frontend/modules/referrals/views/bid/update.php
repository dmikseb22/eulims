<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Bid */

$this->title = 'Update Bid: ' . $model->bid_id;
$this->params['breadcrumbs'][] = ['label' => 'Bids', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bid_id, 'url' => ['view', 'id' => $model->bid_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bid-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
