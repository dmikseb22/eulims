<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Referraltrackreceiving */

$this->title = 'Update Referraltrackreceiving: ' . $model->referraltrackreceiving_id;
$this->params['breadcrumbs'][] = ['label' => 'Referraltrackreceivings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->referraltrackreceiving_id, 'url' => ['view', 'id' => $model->referraltrackreceiving_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="referraltrackreceiving-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
