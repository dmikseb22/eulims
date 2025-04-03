<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Issuancewithdrawal */

$this->title = 'Create Issuancewithdrawal';
$this->params['breadcrumbs'][] = ['label' => 'Issuancewithdrawals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issuancewithdrawal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
