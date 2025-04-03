<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Package */

$this->title = ucwords($model->PackageName);
$this->params['breadcrumbs'][] = ['label' => 'Packages', 'url' => ['/package']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="package-view">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'PackageID',
            'PackageName',
            [
                'attribute' => 'icon',
                'label' => 'Icon Name',
            ],
            [
                'attribute' => 'icon',
                'label' => 'Icon',
                'format' => 'raw',
                'value' => function($model) {
                    return "<span class='" . $model->icon . "'><span>";
                }
            ],
            'created_at:date',
            'updated_at:date',
        ],
    ])
    ?>
    <div class="row" style="float: right;padding-right: 15px">
        <?= Html::Button('Cancel', ['class' => 'btn btn-default', 'id' => 'modalCancel', 'data-dismiss' => 'modal']) ?>
    </div>
</div>
