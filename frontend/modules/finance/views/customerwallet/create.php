<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\finance\Customerwallet */

$this->title = 'Create Customer Wallet';
$this->params['breadcrumbs'][] = ['label' => 'Customerwallets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customerwallet-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
