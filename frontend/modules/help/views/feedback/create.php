<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\feedback\UserFeedback */

$this->title = 'Create User Feedback';
$this->params['breadcrumbs'][] = ['label' => 'User Feedbacks', 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-feedback-create">

    <h2><?= Html::encode($this->title) ?></h2>
    <p style="color: red">
            (Please upload the screenshot first before creating a feedback)
            
        </p>
    <?= $this->render('_form', [
        'model' => $model,'dataPackageList'=>$dataPackageList
    ]) ?>

</div>
