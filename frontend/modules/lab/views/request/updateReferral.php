<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Request */

$this->title = 'Update Referral Request: ' . $model->request_id;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->request_id, 'url' => ['view', 'id' => $model->request_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="request-update">
    <?= $this->render('_formReferral', [
        'model' => $model,
        'labreferral' => $labreferral,
        'discountreferral' => $discountreferral,
        'purposereferral' => $purposereferral,
        'modereleasereferral' => $modereleasereferral,
        'notified'=>$notified,
        'api_url'=>$api_url
    ]) ?>

</div>
