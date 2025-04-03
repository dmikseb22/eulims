<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Customerwallet */

$this->title = 'Update Customerwallet: ' . $model->customerwallet_id;
$this->params['breadcrumbs'][] = ['label' => 'Customerwallets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->customerwallet_id, 'url' => ['view', 'id' => $model->customerwallet_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customerwallet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
