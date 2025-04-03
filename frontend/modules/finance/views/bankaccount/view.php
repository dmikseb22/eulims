<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Bankaccount */

$this->title = $model->bankaccount_id;
$this->params['breadcrumbs'][] = ['label' => 'Bankaccounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bankaccount-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->bankaccount_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->bankaccount_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'bankaccount_id',
            'bank_name',
            'account_number',
            'rstl_id',
        ],
    ]) ?>

</div>
