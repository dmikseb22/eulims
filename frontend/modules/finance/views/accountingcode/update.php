<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Accountingcode */

$this->title = 'Accountingcode: ' . $model->accountcode;
$this->params['breadcrumbs'][] = ['label' => 'Accountingcodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->accountingcode_id, 'url' => ['view', 'id' => $model->accountingcode_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="accountingcode-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
