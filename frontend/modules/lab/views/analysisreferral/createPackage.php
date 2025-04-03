<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysis */

$this->title = 'Create Analysis';
$this->params['breadcrumbs'][] = ['label' => 'Analyses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="analysis-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formPackage', [
        'model' => $model,
        'labId' => $labId,
        'sampleDataProvider' => $sampleDataProvider,
        'packageDataProvider' => $packageDataProvider,
    ]) ?>

</div>
