<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Testname */

$this->title = 'Update Testname: ' . $model->testname_id;
$this->params['breadcrumbs'][] = ['label' => 'Testnames', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->testname_id, 'url' => ['view', 'id' => $model->testname_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="testname-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
