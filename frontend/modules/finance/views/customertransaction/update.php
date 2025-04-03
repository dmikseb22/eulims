<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Customertransaction */

$this->title = 'Update Customertransaction: ' . $model->customertransaction_id;
$this->params['breadcrumbs'][] = ['label' => 'Customertransactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->customertransaction_id, 'url' => ['view', 'id' => $model->customertransaction_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customertransaction-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
