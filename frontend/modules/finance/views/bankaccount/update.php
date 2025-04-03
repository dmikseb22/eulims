<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Bankaccount */

$this->title = 'Update Bankaccount: ' . $model->bankaccount_id;
$this->params['breadcrumbs'][] = ['label' => 'Bankaccounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bankaccount_id, 'url' => ['view', 'id' => $model->bankaccount_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bankaccount-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
