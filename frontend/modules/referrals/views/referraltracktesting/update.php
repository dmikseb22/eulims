<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Referraltracktesting */

$this->title = 'Update Referraltracktesting: ' . $model->referraltracktesting_id;
$this->params['breadcrumbs'][] = ['label' => 'Referraltracktestings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->referraltracktesting_id, 'url' => ['view', 'id' => $model->referraltracktesting_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="referraltracktesting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
