
<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Procedure;
use common\models\lab\Testname;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>
        <?= GridView::widget([
        'dataProvider' => $workflowdataprovider,
        'pjax' => true,
        'id'=>'workflow-grid',
        'containerOptions'=>[
            'style'=>'overflow:auto; height:320px',
        ],
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'header'=>'Workflow Steps',
                'format' => 'raw',
                'width' => '20%',
                'enableSorting' => false,
                'value' => function($model) {
                    return $model->procedure_name;
                },
                
                'contentOptions' => ['style' => 'width:300px; white-space: normal;'],                      
            ],
            [
                'attribute' => 'procedure_code',
                'label' => 'Description',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width:70%; white-space: normal;'],
                'value' => function($model) {   
                    //find in workflow
                    $procedure= Procedure::find()->where(['procedure_id'=> $model->method_id])->one();
                    if ($procedure){
                        return $procedure->procedure_code;
                    }else{
                        return "";
                    }
                   
                        //return $model->procedure_code;
                            },
            ],
        ],
    ]); ?>    