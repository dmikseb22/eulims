<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Testnamemethod */

$this->title = $model->testname_method_id;
$this->params['breadcrumbs'][] = ['label' => 'Testnamemethods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testnamemethod-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->testname_method_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->testname_method_id], [
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
            'testname_method_id',
            'testname_id',
            'methodreference_id',
            'added_by',
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
