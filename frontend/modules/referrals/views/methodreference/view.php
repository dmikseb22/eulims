<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Methodreference */

$this->title = $model->methodreference_id;
$this->params['breadcrumbs'][] = ['label' => 'Methodreferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="methodreference-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->methodreference_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->methodreference_id], [
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
            'methodreference_id',
            'method',
            'reference',
            'fee',
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
