<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\feedback\UserFeedback */

$this->params['breadcrumbs'][] = ['label' => 'User Feedbacks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->feedback_id, 'url' => ['view', 'id' => $model->feedback_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-feedback-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'dataPackageList'=>$dataPackageList
    ]) ?>

</div>
