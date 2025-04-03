<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Packageoffer */

$this->title = 'Update Packageoffer: ' . $model->packageoffer_id;
$this->params['breadcrumbs'][] = ['label' => 'Packageoffers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->packageoffer_id, 'url' => ['view', 'id' => $model->packageoffer_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="packageoffer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
