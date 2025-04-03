<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Testreport */

$this->title = 'Update Testreport: ' . $model->testreport_id;
$this->params['breadcrumbs'][] = ['label' => 'Testreports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->testreport_id, 'url' => ['view', 'id' => $model->testreport_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="testreport-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
