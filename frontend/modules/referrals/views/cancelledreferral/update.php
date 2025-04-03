<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Cancelledreferral */

$this->title = 'Update Cancelledreferral: ' . $model->cancelledreferral_id;
$this->params['breadcrumbs'][] = ['label' => 'Cancelledreferrals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cancelledreferral_id, 'url' => ['view', 'id' => $model->cancelledreferral_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cancelledreferral-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
