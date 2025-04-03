<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\finance\Bankaccount */

$this->title = 'Create Bankaccount';
$this->params['breadcrumbs'][] = ['label' => 'Bankaccounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bankaccount-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
