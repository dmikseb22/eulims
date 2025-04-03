<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Testname */

$this->title = 'Update Testname: ' . $model->testname_id;
$this->params['breadcrumbs'][] = ['label' => 'Testnames', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->testname_id, 'url' => ['view', 'id' => $model->testname_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="testname-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
