<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Methodreference;
use common\models\lab\Testname;
use common\models\lab\Workflow;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\TestnamemethodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$methodlist= ArrayHelper::map(Methodreference::find()->all(),'method_reference_id','method');
$testnamelist= ArrayHelper::map(Testname::find()->all(),'testname_id','testName');

$this->title = 'Workflow Management';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->registerJsFile("/js/services/services.js"); ?>

<div class="alert alert-info" style="background: #d4f7e8 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d"><b>Note:</b> To manage workflow click the orange button in actions column</p>
     
    </div>
<div class="testnamemethod-index">

<?php $this->registerJsFile("/js/services/services.js"); ?>


<?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'width' => '50px',
                    'value' => function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detail' => function ($model, $key, $index, $column) {

                                $workflow = Workflow::find()->where(['testname_method_id' => $model->testname_method_id]);
                                $workflowdataprovider = new ActiveDataProvider([
                                        'query' => $workflow,
                                        'pagination' => [
                                            'pageSize' => 10,
                                        ],
                                     
                                ]);

                                 return $this->render('_viewworkflow.php', [
                                     'workflowdataprovider'=>$workflowdataprovider,
                                 ]);
                    },
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'expandOneOnly' => true
                ],
                [
                    'attribute' => 'testname_id',
                    'label' => 'Test Name',
                    'value' => function($model) {
                        if ($model->testname){
                            return $model->testname->testName;
                        }else{
                            return "";
                        }
                        
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $testnamelist,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                   ],
                   'filterInputOptions' => ['placeholder' => 'Test Name', 'testcategory_id' => 'grid-products-search-category_type_id']
                ],
                [
                    'attribute' => 'method_id',
                    'label' => 'Method',
                    'value' => function($model) {
                         if($model->method){
                          return $model->method->method;
                        }else{
                            return "";
                     }    
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $methodlist,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                   ],
                   'filterInputOptions' => ['placeholder' => 'Method', 'testcategory_id' => 'grid-products-search-category_type_id']
                ],
                [
                    'header'=>'Actions',
                    'hAlign'=>'center',
                    'format'=>'raw',
                    'value'=>function($data){     
                        $workflow = Workflow::find()->where(['testname_method_id' => $data->testname_method_id])->one();
                        if ($workflow){
                           return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value'=>Url::to(['/lab/testnamemethod/createworkflow?test_id='.$data->testname_method_id]),'onclick'=>'LoadModal(this.title, this.value, true, 950);', 'class' => 'btn btn-warning','title' => Yii::t('app', "Create Workflow")]);
                        }else{
                            return Html::button('<span class="glyphicon glyphicon-plus"></span>', ['value'=>Url::to(['/lab/testnamemethod/createworkflow?test_id='.$data->testname_method_id]),'onclick'=>'LoadModal(this.title, this.value, true, 950);', 'class' => 'btn btn-success','title' => Yii::t('app', "Create Workflow")]);
                        }

                        ///return $data->testname_method_id;
                    },
                        'enableSorting' => false,
                        'contentOptions' => ['style' => 'width:20px; white-space: normal;'],
                    ], 
            ];   
            echo GridView::widget([
                'id'=>'testname-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'pjax'=>true,
                'pjaxSettings' => [
                    'options' => [
                        'enablePushState' => false,
                    ]
                ],
                'responsive'=>true,
                'striped'=>true,
                'hover'=>true,
                'panel' => [
                    'heading'=>'<h3 class="panel-title"> <i class="glyphicon glyphicon-file"></i> Workflow Management</h3>',
                    'type'=>'primary',
                ],
                'columns' => $gridColumns,
            
            ]);
        ?>

</div>

