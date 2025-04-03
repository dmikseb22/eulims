<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Labsampletype */

$this->title = 'Update Labsampletype: ' . $model->lab_sampletype_id;
$this->params['breadcrumbs'][] = ['label' => 'Labsampletypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->lab_sampletype_id, 'url' => ['view', 'id' => $model->lab_sampletype_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="labsampletype-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
