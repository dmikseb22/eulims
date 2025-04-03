<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Sampletype;
use common\models\lab\Services;
use common\models\lab\Lab;
use common\models\lab\Testname;
use common\models\lab\Methodreference;
use common\models\lab\Sampletypetestname;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;

$sampletypelist= ArrayHelper::map(Sampletype::find()->all(),'sampletype_id','type');
$lablist= ArrayHelper::map(Lab::find()->all(),'lab_id','labname');
$methodlist= ArrayHelper::map(Methodreference::find()->all(),'method_reference_id','method');
$testnamelist= ArrayHelper::map(Testname::find()->all(),'testname_id','testName');

$this->title = 'Add/ Remove Services';

$js=<<<SCRIPT

function offerservices(mid){
  
    $.ajax({
        url: '/lab/services/offer',
        method: "post",
        data: { id: mid,
        labid: $('#labid').val(),
        sampletypeid: $('#sampletypeid').val(),
        methodreferenceid: $('#methodreferenceid').val(),
        labsampletypeid: $('#labsampletypeid').val(),
        sampletypetestname: $('#sampletypetestname').val(),
        testnamemethod: $('#testnamemethod').val(),
        testcategory: $('#testcategory').val(),
        testname: $('#testname').val()},
        beforeSend: function(xhr) {
           $('.image-loader').addClass("img-loader");
           }
        })
        .done(function( response ) {   
             $("#testname-grid").yiiGridView("applyFilter");   
            $('.image-loader').removeClass("img-loader");  
        });
}

function unofferservices(mid){
    
      $.ajax({
         url: '/lab/services/unoffer',
         method: "post",
          data: { id: mid,
          labid: $('#labid').val(),
          sampletypeid: $('#sampletypeid').val(),
          methodreferenceid: $('#methodreferenceid').val(),
          labsampletypeid: $('#labsampletypeid').val(),
          sampletypetestname: $('#sampletypetestname').val(),
          testnamemethod: $('#testnamemethod').val(),
          testcategory: $('#testcategory').val(),
          testname: $('#testname').val()},
          beforeSend: function(xhr) {
             $('.image-loader').addClass("img-loader");
             }
          })
          .done(function( response ) {   
               $("#testname-grid").yiiGridView("applyFilter");   
              $('.image-loader').removeClass("img-loader");  
          });
  }
SCRIPT;
$this->registerJs($js);

?>

<?= Html::textInput('methodreferenceid', $methodreferenceid, ['class' => 'form-control', 'id'=>'methodreferenceid', 'type'=>'hidden'], ['readonly' => true]) ?>
<?= Html::textInput('labid', $labid, ['class' => 'form-control', 'id'=>'labid', 'type'=>'hidden'], ['readonly' => true]) ?>
<?= Html::textInput('sampletypeid', $sampletypeid, ['class' => 'form-control', 'id'=>'sampletypeid', 'type'=>'hidden' ], ['readonly' => true]) ?>
<?= Html::textInput('labsampletypeid', $labsampletypeid, ['class' => 'form-control', 'id'=>'labsampletypeid',  'type'=>'hidden' ], ['readonly' => true]) ?> 
<?= Html::textInput('sampletypetestname', $sampletypetestname, ['class' => 'form-control', 'id'=>'sampletypetestname' , 'type'=>'hidden'], ['readonly' => true]) ?>
<?= Html::textInput('testcategory', $testcategory, ['class' => 'form-control', 'id'=>'testcategory', 'type'=>'hidden' ], ['readonly' => true]) ?>



<?php
 $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
 $servicesquery= Services::find()->Where(['rstl_id'=>$GLOBALS['rstl_id']])->all();
 $servicecount = count($servicesquery);
?>

    <?= GridView::widget([
        'dataProvider' => $testnameDataProvider,
        'pjax' => true,    
        'id'=>'testname-grid',
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'hover' => true,
        'containerOptions'=>[
            'style'=>'overflow:auto; height:400px',
        ],
        'rowOptions' => function($data)use ($methodreferenceid, $sampletypeid){

            $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
            $typetestname = Sampletypetestname::find()->where(['sampletype_id' =>  $sampletypeid, 'testname_id'=>$methodreferenceid])->one();
            
            if ($typetestname){
                //sampletypetestname exist
                $servicesquery = Services::find()->where(['method_reference_id' => $data['method_reference_id']])->andWhere(['rstl_id'=>  $GLOBALS['rstl_id']])->andWhere(['testname_method_id'=>  $typetestname->sampletype_testname_id])->one();        
                if ($servicesquery){
                    return ['class'=>'success'];
                }else{
                    
                    return ['class'=>'danger'];
                }         
            }else{
                      //sampletypetestname not exist
                      return ['class'=>'danger'];
            } 

            //updates
       },
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'after'=>false,
                'before'=>'Tests:'.$testnamemethodcount
            ],
        'columns' => [
            [
                'header'=>'Offered',
                'hAlign'=>'center',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 5%;word-wrap: break-word;white-space:pre-line;'],
                'value'=>function($data) use ($methodreferenceid, $sampletypeid) {
                    $GLOBALS['rstl_id']=Yii::$app->user->identity->profile->rstl_id;
                    $typetestname = Sampletypetestname::find()->where(['sampletype_id' =>  $sampletypeid, 'testname_id'=>$methodreferenceid])->one();         
                    if ($typetestname){
                        $servicesquery = Services::find()->where(['method_reference_id' => $data['method_reference_id']])->andWhere(['rstl_id'=>  $GLOBALS['rstl_id']])->andWhere(['testname_method_id'=>  $typetestname->sampletype_testname_id])->one();        
                        if ($servicesquery){
                            return "<span class='btn btn-success' id='offer' onclick='unofferservices(".$data['method_reference_id'].")'>YES</span>";                                 
                        }else{
                            return "<span class='btn btn-danger' id='offer'  onclick='offerservices(".$data['method_reference_id'].")'>NO</span>"; 
                            
                        }                         
                    }else{
                        return "<span class='btn btn-danger' id='offer'  onclick='offerservices(".$data['method_reference_id'].")'>NO</span>";             
                    } 
                },
                'enableSorting' => false,
            ],
            [
                'attribute' => 'method',
                'label' => 'Method',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 30%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($data) {
                     if($data['method']){
                      return $data['method'];
                    }else{
                        return "";
                 }    
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $methodlist,
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 30%;word-wrap: break-word;white-space:pre-line;'], 
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
               ],
            ],
            [
                'attribute' => 'reference',
              
                'format' => 'raw',
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 80%;word-wrap: break-word;white-space:pre-line;'],     
            ],
            [
                'attribute' => 'fee',
                'format' => 'raw',
                'hAlign'=>'right',
                'value' => function($data) {   
                     return number_format($data['fee'],2);
                },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width: 10%;word-wrap: break-word;white-space:pre-line;'],     
            ],
       ],
    ]); ?>


  