<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\inventory\Categorytype */

$this->title = 'Create Categorytype';
$this->params['breadcrumbs'][] = ['label' => 'Category Type', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorytype-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
