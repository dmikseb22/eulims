<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Referral */

$this->title = 'Update Referral: ' . $model->referral_id;
$this->params['breadcrumbs'][] = ['label' => 'Referrals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->referral_id, 'url' => ['view', 'id' => $model->referral_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="referral-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
