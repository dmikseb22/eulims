<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Testname */

$this->title = $model->testname_id;
$this->params['breadcrumbs'][] = ['label' => 'Testnames', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testname-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'testname_id',
            'testName',
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
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
