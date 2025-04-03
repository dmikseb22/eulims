<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Formrequest */

$this->title = 'Update Formrequest: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Formrequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->formrequest_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="formrequest-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
