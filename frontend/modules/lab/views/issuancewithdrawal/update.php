<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Issuancewithdrawal */

$this->title = 'Update Issuancewithdrawal: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Issuancewithdrawals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->issuancewithdrawal_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="issuancewithdrawal-update">

  

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
