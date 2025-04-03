<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Documentcontrolconfig */

$this->title = $model->documentcontrolconfig_id;
$this->params['breadcrumbs'][] = ['label' => 'Documentcontrolconfigs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documentcontrolconfig-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->documentcontrolconfig_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->documentcontrolconfig_id], [
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
            'documentcontrolconfig_id',
            'dcf',
            'year',
            'custodian',
            'approved',
        ],
    ]) ?>

</div>
