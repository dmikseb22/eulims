<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\api\Migrationportal */

$this->title = 'Update Migrationportal: ' . $model->pm_id;
$this->params['breadcrumbs'][] = ['label' => 'Migrationportals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pm_id, 'url' => ['view', 'id' => $model->pm_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="migrationportal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
