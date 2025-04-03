<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\api\YiiMigration */

$this->title = 'Update Yii Migration: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Yii Migrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="yii-migration-update">
 <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
