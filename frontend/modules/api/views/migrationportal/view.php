<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\api\Migrationportal */

$this->title = $model->pm_id;
$this->params['breadcrumbs'][] = ['label' => 'Migrationportals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="migrationportal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->pm_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->pm_id], [
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
            'pm_id',
            'date_migrated',
            'record_id',
            'table_name',
        ],
    ]) ?>

</div>
