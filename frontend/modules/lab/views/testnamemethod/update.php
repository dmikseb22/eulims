<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Testnamemethod */

$this->title = 'Update Testnamemethod: ' . $model->testname_method_id;
$this->params['breadcrumbs'][] = ['label' => 'Testnamemethods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->testname_method_id, 'url' => ['view', 'id' => $model->testname_method_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="testnamemethod-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
