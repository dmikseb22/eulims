<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\referral\Sampletemplate */

$this->title = $model->sampletemplate_id;
$this->params['breadcrumbs'][] = ['label' => 'Sampletemplates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sampletemplate-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->sampletemplate_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->sampletemplate_id], [
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
            'sampletemplate_id',
            'samplename',
            'description:ntext',
        ],
    ]) ?>

</div>
