<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\LabNotebook */

$this->title = 'Update Lab Notebook: ' . $model->notebook_id;
$this->params['breadcrumbs'][] = ['label' => 'Lab Notebooks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->notebook_id, 'url' => ['view', 'id' => $model->notebook_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lab-notebook-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
