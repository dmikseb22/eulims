<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Methodreference */

$this->title = 'Update Methodreference: ' . $model->method_reference_id;
$this->params['breadcrumbs'][] = ['label' => 'Methodreferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->method_reference_id, 'url' => ['view', 'id' => $model->method_reference_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="methodreference-update">

  

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
