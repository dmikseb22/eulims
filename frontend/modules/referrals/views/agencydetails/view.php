<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Agencydetails */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Agencydetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agencydetails-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->agencydetails_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->agencydetails_id], [
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
            'agencydetails_id',
            'agency_id',
            'name',
            'address',
            'contacts:ntext',
            'short_name',
            'lab_name',
            'labtype_short',
            'description:ntext',
        ],
    ]) ?>

</div>
