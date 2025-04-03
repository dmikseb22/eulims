<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Bidnotification */

$this->title = 'Update Bidnotification: ' . $model->bid_notification_id;
$this->params['breadcrumbs'][] = ['label' => 'Bidnotifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bid_notification_id, 'url' => ['view', 'id' => $model->bid_notification_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bidnotification-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
