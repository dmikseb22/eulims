<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Joborder */

$this->title = 'Create Joborder';
$this->params['breadcrumbs'][] = ['label' => 'Joborders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="joborder-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div> 