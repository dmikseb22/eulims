<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\referral\Referraltracktesting */

$this->title = 'Create Referraltracktesting';
$this->params['breadcrumbs'][] = ['label' => 'Referraltracktestings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referraltracktesting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
