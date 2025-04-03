<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Collectiontype */

$this->title = 'Update Collectiontype: ' . $model->collectiontype_id;
$this->params['breadcrumbs'][] = ['label' => 'Collectiontypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->collectiontype_id, 'url' => ['view', 'id' => $model->collectiontype_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="collectiontype-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
