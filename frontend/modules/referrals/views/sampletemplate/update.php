<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Sampletemplate */

$this->title = 'Update Sampletemplate: ' . $model->sampletemplate_id;
$this->params['breadcrumbs'][] = ['label' => 'Sampletemplates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sampletemplate_id, 'url' => ['view', 'id' => $model->sampletemplate_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sampletemplate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
