<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\SampleName */

$this->title = 'Update Sample Name: ' . $model->sample_name_id;
$this->params['breadcrumbs'][] = ['label' => 'Sample Names', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sample_name_id, 'url' => ['view', 'id' => $model->sample_name_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sample-name-update">

    <!--<h1><?php //echo Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
