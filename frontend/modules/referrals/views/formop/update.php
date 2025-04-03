<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Formop */

$this->title = 'Update Formop: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Formops', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->formop_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="formop-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
