<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\inventory\Categorytype */

$this->title = $model->categorytype_id;
$this->params['breadcrumbs'][] = ['label' => 'Categorytypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorytype-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->categorytype_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->categorytype_id], [
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
            'categorytype_id',
            'categorytype',
            'description:ntext',
        ],
    ]) ?>

</div>
