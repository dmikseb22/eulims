<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysis */
$this->title = 'Update Analysis: ' . $model->analysis_id;
$this->params['breadcrumbs'][] = ['label' => 'Analyses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->analysis_id, 'url' => ['view', 'id' => $model->analysis_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="analysis-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
