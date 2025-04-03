<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Methodreference */

$this->title = $model->method_reference_id;
$this->params['breadcrumbs'][] = ['label' => 'Methodreferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="methodreference-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'method_reference_id',
            'method',
            'reference',
            [
                'label'=>'Fee',
                'format'=>'raw',
                'value' => function($model) {
                    return number_format($model->fee, 2);
                    },
                'valueColOptions'=>['style'=>'width:30%'], 
                'displayOnly'=>true
            ],
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
