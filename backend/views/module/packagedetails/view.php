<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\system\PackageDetails */

$this->title = $model->Package_Detail;
$this->params['breadcrumbs'][] = ['label' => 'Module', 'url' => ['/module']];
$this->params['breadcrumbs'][] = ['label' => 'Details', 'url' => ['details?action=view', 'id'=> $model->Package_DetailID]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="package-details-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Package_DetailID',
            'package.PackageName',
            'Package_Detail',
            [
                'attribute' => 'icon',
                'label' => 'Icon',
                'format' => 'raw',
                'value' => function($model) {
                    return "<span class='" . $model->icon . "'><span>";
                }
            ],
            'url',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
    <div class="row" style="float: right;padding-right: 15px">
        <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
    </div>
</div>
