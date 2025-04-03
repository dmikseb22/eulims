<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Request */

$this->title = 'Update Request: ' . $model->request_id;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->request_id, 'url' => ['view', 'id' => $model->request_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="request-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
