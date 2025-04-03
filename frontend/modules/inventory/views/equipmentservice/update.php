<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\Equipmentservice */

$this->title = 'Update Equipmentservice: #' . $model->equipmentservice_id;
$this->params['breadcrumbs'][] = ['label' => 'Equipmentservices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->equipmentservice_id, 'url' => ['view', 'id' => $model->equipmentservice_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="equipmentservice-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
