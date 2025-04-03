<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\referral\Formrequest */

$this->title = 'Create Formrequest';
$this->params['breadcrumbs'][] = ['label' => 'Formrequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="formrequest-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
