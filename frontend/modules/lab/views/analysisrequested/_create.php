<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysisrequested */

$this->title = 'Create Analysisrequested';
$this->params['breadcrumbs'][] = ['label' => 'Analysisrequesteds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="analysisrequested-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div> 