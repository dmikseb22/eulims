<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Agencydetails */

$this->title = 'Update Agencydetails: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Agencydetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->agencydetails_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="agencydetails-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
