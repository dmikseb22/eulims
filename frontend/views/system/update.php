<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\system\Rstl */

$this->title = 'Update Rstl: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Rstls', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->rstl_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rstl-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
