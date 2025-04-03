<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Package */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Packages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
           'sampletype.type',
            'name',
            [
                'label'=>'Rate',
                'format'=>'raw',
                'value' => function($model) {
                    return number_format($model->rate, 2);
                    },
                'valueColOptions'=>['style'=>'width:30%'], 
                'displayOnly'=>true
            ],
            [
                'label'=>'Tests',
                'format'=>'raw',
                'value' => function($model) use ($tests) {
                        return $tests;
                    },
                'valueColOptions'=>['style'=>'width:30%'], 
                'displayOnly'=>true
            ],
        ],
    ]) ?>

</div>
