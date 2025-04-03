<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\LabNotebook */

$this->title = $model->notebook_id;
$this->params['breadcrumbs'][] = ['label' => 'Lab Notebooks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lab-notebook-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->notebook_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->notebook_id], [
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
            'notebook_id',
            'notebook_name',
            'description:ntext',
            'date_created',
            'file',
            'created_by',
        ],
    ]) ?>

</div>
