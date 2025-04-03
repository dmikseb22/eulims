<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Labsampletype;
use common\models\lab\Services;
use common\models\lab\Lab;
use common\models\lab\Testname;
use common\models\lab\Methodreference;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;
use common\components\Functions;
use linslin\yii2\curl;
use yii\helpers\Json;
$func=new Functions();


$apiUrl="https://eulimsapi.onelab.ph/api/web/v1/labs/search?labcount=0";
$curl = new curl\Curl();
$list = $curl->get($apiUrl);
$data =  json_decode($list);

$sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sampletype_id','type');
$lablist= ArrayHelper::map($data,'lab_id','labname');
$this->title = 'Add/ Remove Services';
$this->params['breadcrumbs'][] = $this->title;
$services =  Services::find()->all(); 

//$testcategory = Labsampletype::find()->where(['lab_sampletype_id'=>$labsampletypeid])->one();
// $apiUrl_testcategory="https://eulimsapi.onelab.ph/api/web/v1/testcategories/search?testcategory_id=3";
// $curl = new curl\Curl();
// $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
// $response_testcategory = $curl->get($apiUrl_testcategory);
// $decode_testcategory=Json::decode($response_testcategory,TRUE);

// echo "<pre>";
// var_dump($decode_testcategory);
// echo "</pre>";

?>

<div class="alert alert-info" style="background: #d4f7e8 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d"><b>Note:</b> Please contact administrator if you want to add new test that is not available in the dropdown list below.</p>
     
    </div>
    <div class="image-loader" style="display: hidden;"></div>
<div class="services-index" >

<!-- <fieldset>
    <legend>Legend/Status</legend> -->
    <!-- <div>
        <span class='badge btn-success legend-font' ><span class= 'glyphicon glyphicon-check'></span> UNOFFER</span>
        <span class='badge btn-danger legend-font' ><span class= 'glyphicon glyphicon-check'></span> OFFER</span>               
    </div> -->
<!-- </fieldset>  -->
    <div class="row">
     <?php $form = ActiveForm::begin(); ?> 
        <div>
            <?php 
                echo$sampletype = "<div class='col-md-3'>".$form->field($model,'lab_id')->widget(Select2::classname(),[
                            'data' => $lablist,
                            'theme' => Select2::THEME_KRAJEE,
                            'options' => ['id'=>'lab_id'],
                            'pluginOptions' => ['allowClear' => true,'placeholder' => 'Select Lab'],
                    ])->label("Laboratory")."</div>"."<div class='col-md-3'>".$form->field($model, 'method_reference_id')->widget(DepDrop::classname(), [
                        'type'=>DepDrop::TYPE_SELECT2,
                        'data'=>$testcategory,
                        'options'=>['id'=>'sample-testcategory_id'],
                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                        'pluginOptions'=>[
                            'depends'=>['lab_id'],
                            'placeholder'=>'Select Test Category',
                            'url'=>Url::to(['/lab/services/listtestcategory']),
                            'loadingText' => 'Loading Test Category...',
                        ]
                    ])->label("Test Category")."</div>"."<div class='col-md-3'>".$form->field($model, 'sampletype_id')->widget(DepDrop::classname(), [
                        'type'=>DepDrop::TYPE_SELECT2,
                        'data'=>$sampletype,
                        'options'=>['id'=>'sample-sample_type_id'],
                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                        'pluginOptions'=>[
                            'depends'=>['sample-testcategory_id'],
                            'placeholder'=>'Select Sample Type',
                            'url'=>Url::to(['/lab/services/listsampletype']),
                            'loadingText' => 'Loading Sample Types...',
                        ]
                    ])."</div>"."<div class='col-md-3'>".$form->field($model, 'testname_method_id')->widget(DepDrop::classname(), [
                        'type'=>DepDrop::TYPE_SELECT2,
                        'data'=>$test,
                        'options'=>['id'=>'sample-test_id'],
                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                        'pluginOptions'=>[
                            'depends'=>['sample-sample_type_id'],
                            'placeholder'=>'Select Test',
                            'url'=>Url::to(['/lab/services/listtest']),
                            'loadingText' => 'Loading Tests...',
                        ]
                    ])."</div>";
            ?>       
        </div>
        <?php ActiveForm::end(); ?>
    </div>
      
    <div class="row" id="methodreference"  style="padding-left:15px;padding-right:15px">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'pjax' => true,
            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
            'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'after'=>false,
                ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'header'=>'Offer',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],           
                ],
                [
                    'header'=>'Method',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'contentOptions' => ['style' => 'width: 60%;word-wrap: break-word;white-space:pre-line;'],  
                ],
                [
                    'header'=>'Reference',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'contentOptions' => ['style' => 'width: 60%;word-wrap: break-word;white-space:pre-line;'],      
                ],
                [
                    'header'=>'Fee',
                    'format' => 'raw',
                    'enableSorting' => false,
                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],             
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
 </div>
</div>

<script type="text/javascript">
    $('#sample-test_id').on('change',function(e) {
        $.ajax({
            url: '/lab/services/getmethod?id='+$(this).val(),
            method: "GET",
            dataType: 'html',
            data: { lab_id: $('#lab_id').val(),
            sample_type_id: $('#sample-sample_type_id').val(),
            testcategory: $('#sample-testcategory_id').val()},
            beforeSend: function(xhr) {
               $('.image-loader').addClass("img-loader");
               }
            })
            .done(function( response ) {
                $("#methodreference").html(response); 
                $('.image-loader').removeClass("img-loader");  
            });

    });
</script>

<style type="text/css">
/* Absolute Center Spinner */
.img-loader {
    position: fixed;
    z-index: 999;
    /*height: 2em;
    width: 2em;*/
    height: 64px;
    width: 64px;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-image: url('/images/img-loader64.gif');
    background-repeat: no-repeat;
}
/* Transparent Overlay */
.img-loader:before {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.3);
}
</style>
