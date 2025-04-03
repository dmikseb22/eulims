<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Sample */

$this->title = 'Create Sample';
$this->params['breadcrumbs'][] = ['label' => 'Samples', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'sampletype' => $sampletype,
        //'sampletypereferral' => $sampletypereferral,
        'labId' => $labId,
        'sampletemplate' => $sampletemplate,
    ]) ?>

</div>
