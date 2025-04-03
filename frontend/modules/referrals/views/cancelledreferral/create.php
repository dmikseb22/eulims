<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\referral\Cancelledreferral */

$this->title = 'Create Cancelledreferral';
$this->params['breadcrumbs'][] = ['label' => 'Cancelledreferrals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cancelledreferral-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
