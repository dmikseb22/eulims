<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Labsampletype */

$this->title = 'Update Labsampletype: ' . $model->labsampletype_id;
$this->params['breadcrumbs'][] = ['label' => 'Labsampletypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->labsampletype_id, 'url' => ['view', 'id' => $model->labsampletype_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="labsampletype-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
