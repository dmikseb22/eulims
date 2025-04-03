<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Packagelist */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Packagelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="packagelist-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->package_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->package_id], [
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
            'package_id',
            'lab_id',
            'sampletype_id',
            'name',
            'rate',
            'test_method',
        ],
    ]) ?>

</div>
