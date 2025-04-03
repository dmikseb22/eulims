<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\referral\Analysis */

$this->title = 'Create Analysis';
$this->params['breadcrumbs'][] = ['label' => 'Analyses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="analysis-create">

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
        'referral_id'=>$referral_id,
    ]) ?>

</div>
