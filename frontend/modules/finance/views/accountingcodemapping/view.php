<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\finance\Accountingcodemapping */

$this->title = $model->mapping_id;
$this->params['breadcrumbs'][] = ['label' => 'Accountingcodemappings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accountingcodemapping-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->mapping_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->mapping_id], [
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
            'mapping_id',
            'collectiontype_id',
            'accountingcode_id',
        ],
    ]) ?>

</div>
