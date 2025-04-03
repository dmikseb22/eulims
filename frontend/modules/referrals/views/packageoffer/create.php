<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\referral\Packageoffer */

$this->title = 'Create Packageoffer';
$this->params['breadcrumbs'][] = ['label' => 'Packageoffers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="packageoffer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
