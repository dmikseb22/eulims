<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Sampletype */

$this->title = $model->sampletype_id;
$this->params['breadcrumbs'][] = ['label' => 'Sampletypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sampletype-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sampletype_id',
            'type',
            [
                'label'=>'Status',
                'format'=>'raw',
                'value'=>function($model){
                    if ($model->status_id==1)
                    {   
                        return "<span class='badge badge-success' style='width:80px!important;height:20px!important;'>Active</span>";
                    }else{
                        return "<span class='badge badge-default' style='width:80px!important;height:20px!important;'>Inactive</span>";
                    }
                },
                'valueColOptions'=>['style'=>'width:30%'], 
                'displayOnly'=>true
            ],
        ],
    ]) ?>

</div>
