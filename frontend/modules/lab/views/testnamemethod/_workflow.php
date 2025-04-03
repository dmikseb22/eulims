<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\lab\Sampletype;
use common\models\lab\Testname;
use common\models\lab\Methodreference;
use common\models\lab\Testnamemethod;
use common\models\lab\Lab;
use common\models\lab\Request;
use common\models\lab\Workflow;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\detail\DetailView;



$test = Testname::find()
->leftJoin('tbl_testname_method', 'tbl_testname.testname_id=tbl_testname_method.testname_id')
->leftJoin('tbl_workflow', 'tbl_testname_method.testname_method_id=tbl_workflow.testname_method_id')
//->where(['IN', 'tbl_testname_method.testname_method_id', '9']) 
->Where(['tbl_testname_method.workflow'=>1])  
->all();      

//TESTNAME METHOD PO ITO DAPAT
// $analysisQuery = Analysis::find()
// ->where(['IN', 'sample_id', $ids]);

$lablist = ArrayHelper::map($test,'testname_id','testName');
/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\ProcedureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js=<<<SCRIPT

function addworkflow(mid){  
    $.ajax({
        url: '/lab/testnamemethod/addworkflow',
        method: "post",
        data: { id: mid,  testname_id: $('#testname_id').val()},
        beforeSend: function(xhr) {
           $('.image-loader').addClass("img-loader");
           }
        })
        .done(function( response ) {  
            //render partial nalang 
            $("#workflow").html(response); 
            $("#testname-grid").yiiGridView("applyFilter");   
        });
}

function addprocedure(){  
    $.ajax({
        url: '/lab/testnamemethod/addprocedure',
        method: "post",
        data: {procedure_name: $('#procedure_name').val(), testname_id: $('#testname_id').val()},
        beforeSend: function(xhr) {
           $('.image-loader').addClass("img-loader");
           }
        })
        .done(function( response ) {  
            //render partial nalang 
            $("#workflow").html(response); 
            $("#testname-grid").yiiGridView("applyFilter");   
        });
}

function addtemplate(){  
    $.ajax({
        url: '/lab/testnamemethod/addtemplate',
        method: "post",
        data: {testnamemethod_id: $('#sample-testcategory_id').val(), testname_id: $('#testname_id').val()},
        beforeSend: function(xhr) {
           $('.image-loader').addClass("img-loader");
           }
        })
        .done(function( response ) {  
            //render partial nalang 
            $("#workflow").html(response); 
            $("#testname-grid").yiiGridView("applyFilter");   
        });
}

function deleteworkflow(mid){  
    $.ajax({
        url: '/lab/testnamemethod/deleteworkflow',
        method: "post",
        data: { id: mid,  testname_id: $('#testname_id').val()},
        beforeSend: function(xhr) {
           $('.image-loader').addClass("img-loader");
           }
        })
        .done(function( response ) {  
            //render partial nalang 
            $("#workflow").html(response); 
            $("#testname-grid").yiiGridView("applyFilter");  
        });
}

SCRIPT;
$this->registerJs($js);

//echo $testname_id;
?>


       
   


<div id="workflow">
<!-- <div class="alert alert-info" style="background: #d4f7e8 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d"><b>Instructions:</b><br>1.<br>2.<br>3.</p>  
    </div> -->
<?= Html::textInput('testname_id', $testname_id, ['class' => 'form-control', 'id'=>'testname_id', 'type'=>'hidden'], ['readonly' => true]) ?>
<div class="procedure-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $this->registerJsFile("/js/services/services.js"); ?>
   
<div class="row">
        <div class="col-sm-6">
        <div class="col-sm-6">
            <?= Html::textInput('procedure_name', '', ['class' => 'form-control', 'id'=>'procedure_name'], ['readonly' => true]) ?></div>
            <div class="col-sm-6">
        <span class='btn btn-success glyphicon glyphicon-plus' style='width:80px' id='offer' onclick=addprocedure()> Add</span>
        </div>
       <br>
       <br>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products', 'enablePushState' => false]],
        // 'containerOptions'=>[
        //     'style'=>'overflow:auto; height:320px',
        // ],
        'containerOptions'=>[
            'style'=>'overflow:auto; height:300px',
        ],
        'floatHeaderOptions' => ['scrollingTop' => true],
        'responsive'=>true,
        'striped'=>true,
        'hover'=>true,
        'bordered' => true,
        'panel' => [
           'heading'=>'<h3 class="panel-title">Procedures</h3>',
           'type'=>'primary',
           'before' => '',
           'after'=>false,
        ],
        'toolbar' => false,
        'columns' => [
            [
                'header'=>'',
                'format' => 'raw',
                'width' => '50px',
                'enableSorting' => false,
                'value' => function($model) {
                    return "<span class='btn btn-primary glyphicon glyphicon-plus' id='offer' onclick=addworkflow(".$model->procedure_id.")></span>";
                },
                'contentOptions' => ['style' => 'width:300px; white-space: normal;'],                      
            ],
            'procedure_name',
           
        ],
    ]); ?>
          
        </div>
        <div class="col-sm-6">

      
        <div class="col-sm-6">
                <?php $form = ActiveForm::begin(); ?>
        
                <?= $form->field($model,'testname_id')->widget(Select2::classname(),[
                            'data' => $lablist,
                            'theme' => Select2::THEME_KRAJEE,
                            'options' => ['id'=>'sample-testcategory_id'],
                            'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Template'],
                    ])->label(false);
                ?>

           
                <?php ActiveForm::end(); ?>
        </div>
        <div class="col-sm-6">
        <span class='btn btn-success glyphicon glyphicon-plus' style='width:80px' id='offer' onclick=addtemplate()> Add</span></div>
        <br>
        <br>
        <?= GridView::widget([
        'dataProvider' => $workflowdataprovider,
        'id'=>'workflow-grid',
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products', 'enablePushState' => false]],
        'pjax'=>true,
        'containerOptions'=>[
            'style'=>'overflow:auto; height:300px',
        ],
        'floatHeaderOptions' => ['scrollingTop' => true],
        'responsive'=>true,
        'striped'=>true,
        'hover'=>true,
        'bordered' => true,
        'panel' => [
           'heading'=>'<h3 class="panel-title">Workflow</h3>',
           'type'=>'primary',
           'before' => '',
           'after'=>false,
        ],
        'toolbar' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'header'=>'',
                'format' => 'raw',
                'width' => '50px',
                'enableSorting' => false,
                'value' => function($model) {
                    return "<span class='btn btn-danger glyphicon glyphicon-minus' id='offer' onclick=deleteworkflow(".$model->workflow_id.")></span>";
                },
                'contentOptions' => ['style' => 'width:300px; white-space: normal;'],                      
            ],
            [
                'header'=>'Workflow Steps',
                'format' => 'raw',
                'width' => '80%',
                'enableSorting' => false,
                'value' => function($model) {
                    return $model->procedure_name;
                },
                'contentOptions' => ['style' => 'width:300px; white-space: normal;'],                      
            ],
          
        ],
    ]); ?>         
        </div>
   



