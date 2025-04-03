<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\inventory\Suppliers */

$this->title = 'Create Suppliers';
$this->params['breadcrumbs'][] = ['label' => 'Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
