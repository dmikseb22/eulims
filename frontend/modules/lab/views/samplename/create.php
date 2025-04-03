<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\SampleName */

$this->title = 'Create Sample Name';
$this->params['breadcrumbs'][] = ['label' => 'Sample Names', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-name-create">

    <!-- <h1><?php //echo Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
