<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Orseries */

$this->title = 'Update Orseries: ' . $model->or_series_id;
$this->params['breadcrumbs'][] = ['label' => 'Orseries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->or_series_id, 'url' => ['view', 'id' => $model->or_series_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="orseries-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
