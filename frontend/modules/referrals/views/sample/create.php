<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\referral\Sample */

$this->title = 'Create Sample';
$this->params['breadcrumbs'][] = ['label' => 'Samples', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-create">

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data
    ]) ?>

</div>
