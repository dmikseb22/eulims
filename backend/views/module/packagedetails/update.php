<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\system\PackageDetails */

$this->title = 'Update Package Details: ' . $model->Package_DetailID;
$this->params['breadcrumbs'][] = ['label' => 'Package', 'url' => ['/package']];
$this->params['breadcrumbs'][] = ['label' => 'Details', 'url' => ['/package/details']];
$this->params['breadcrumbs'][] = ['label' => $model->Package_Detail, 'url' => ['details?action=view&id='.$model->Package_DetailID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="package-details-update">
    <?= $this->render('_form', [
        'model' => $model,
        'ArrayIcons'=>$ArrayIcons
    ]) ?>

</div>
