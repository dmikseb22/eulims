<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Packagelist */

$this->title = 'Update Packagelist: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Packagelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->package_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="packagelist-update">



    <?= $this->render('_form', [
        'model' => $model,
        'testcategory'=>$testcategory,
    ]) ?>

</div>
