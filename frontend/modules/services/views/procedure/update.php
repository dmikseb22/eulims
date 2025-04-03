<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Procedure */

$this->title = 'Update Procedure: ' . $model->procedure_id;
$this->params['breadcrumbs'][] = ['label' => 'Procedures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->procedure_id, 'url' => ['view', 'id' => $model->procedure_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="procedure-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
