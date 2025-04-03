<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Cancelledrequest */

$this->title = 'Update Cancelledrequest: ' . $model->canceledrequest_id;
$this->params['breadcrumbs'][] = ['label' => 'Cancelledrequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->canceledrequest_id, 'url' => ['view', 'id' => $model->canceledrequest_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cancelledrequest-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
