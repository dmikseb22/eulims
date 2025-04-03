<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\Categorytype */

$this->title = 'Update Categorytype: ' . $model->categorytype_id;
$this->params['breadcrumbs'][] = ['label' => 'Category Type', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->categorytype_id, 'url' => ['view', 'id' => $model->categorytype_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="categorytype-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
