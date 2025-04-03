<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\referral\Agencydetails */

$this->title = 'Create Agencydetails';
$this->params['breadcrumbs'][] = ['label' => 'Agencydetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agencydetails-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
