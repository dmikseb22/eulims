<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Classification */

$this->title = 'Update Classification: ' . $model->classification_id;
$this->params['breadcrumbs'][] = ['label' => 'Classifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->classification_id, 'url' => ['view', 'id' => $model->classification_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="classification-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
