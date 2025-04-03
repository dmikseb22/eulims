<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Sampletype */

$this->title = 'Update Sampletype: ' . $model->sampletype_id;
$this->params['breadcrumbs'][] = ['label' => 'Sampletypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sampletype_id, 'url' => ['view', 'id' => $model->sampletype_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sampletype-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
