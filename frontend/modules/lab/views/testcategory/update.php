<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Testcategory */

$this->title = 'Update Testcategory: ' . $model->testcategory_id;
$this->params['breadcrumbs'][] = ['label' => 'Testcategories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->testcategory_id, 'url' => ['view', 'id' => $model->testcategory_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="testcategory-update">

   
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div> 