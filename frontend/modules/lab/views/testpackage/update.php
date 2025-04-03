<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\testpackage */

$this->title = 'Update Testpackage: ' . $model->testpackage_id;
$this->params['breadcrumbs'][] = ['label' => 'Testpackages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->testpackage_id, 'url' => ['view', 'id' => $model->testpackage_id]];
$this->params['breadcrumbs'][] = 'Update';

$sampletype = [];

?>
<div class="testpackage-update">

   
    <?= $this->render('_form', [
        'model' => $model,
        'package'=> $package,
    ]) ?>

</div>
