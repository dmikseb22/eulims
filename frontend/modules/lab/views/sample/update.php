<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Sample */

$this->title = 'Update Sample: ' . $model->sample_id;
$this->params['breadcrumbs'][] = ['label' => 'Samples', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sample_id, 'url' => ['view', 'id' => $model->sample_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sample-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'sampletype' => $sampletype,
        'labId' => $labId,
        'sampletemplate' => $sampletemplate,
    ]) ?>

</div>
