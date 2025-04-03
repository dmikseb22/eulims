<?php
use kartik\detail\DetailView;
use common\models\lab\Testnamemethod;
use common\models\lab\Testname;
use common\models\lab\Methodreference;

use common\models\system\Rstl;
use common\models\system\RstlDetails;

use common\models\system\Profile;
use common\models\system\User;


use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = 'SETUP';

?>

<!-- <div class="alert alert-info" style="background: #d4f7e8 !important;margin-top: 1px !important;">
     <a href="#" class="close" data-dismiss="alert" >×</a>
    <p class="note" style="color:#265e8d"><b>Note:</b> Please scan barcode in the dropdown list below. .</p>
     
    </div> -->
    
    <!-- tbl request code -->
<?php $this->registerJsFile("/js/services/services.js"); ?>

<?php
// echo Html::button('<span class=""></span> Laboratory Details', ['value'=>'/lab/setup/labdetails', 'class' => 'btn btn-primary modal_services','title' => Yii::t('app', "Laboratory Details")])."&nbsp;&nbsp;&nbsp;";
// echo Html::button('<span class=""></span> User Accounts', ['value'=>'/lab/setup/useraccounts', 'class' => 'btn btn-primary modal_services','title' => Yii::t('app', "User Accounts")])."&nbsp;&nbsp;&nbsp;";
// echo Html::button('<span class=""></span> Laboratories', ['value'=>'/lab/setup/lab', 'class' => 'btn btn-primary modal_services','title' => Yii::t('app', "Laboratory Details")])."&nbsp;&nbsp;&nbsp;";
// echo Html::button('<span class=""></span> Request Code Template', ['value'=>'/lab/setup/requestcodetemplate', 'class' => 'btn btn-primary modal_services','title' => Yii::t('app', "Request Code Template")])."&nbsp;&nbsp;&nbsp;";
// echo Html::button('<span class=""></span> Config Lab', ['value'=>'/lab/setup/configlab', 'class' => 'btn btn-primary modal_services','title' => Yii::t('app', "Config Lab")])."&nbsp;&nbsp;&nbsp;";
// echo Html::button('<span class=""></span> RSTL Lab', ['value'=>'/lab/setup/rstllab', 'class' => 'btn btn-primary modal_services','title' => Yii::t('app', "RSTL Lab")])."&nbsp;&nbsp;&nbsp;";
// echo Html::button('<span class=""></span> Request Code', ['value'=>'/lab/setup/requestcode', 'class' => 'btn btn-primary modal_services','title' => Yii::t('app', "Request Code")])."<br> &nbsp;";
?>
<?php
$rstl=Yii::$app->user->identity->profile->rstl_id;
//$rstl =  Rstl::findOne(['rstl_id'=>11]);

$rstldetail =  RstlDetails::findOne(['rstl_id'=>$rstl]);

   echo DetailView::widget([
   'model'=>$rstldetail,
   'responsive'=>true,
   'hover'=>true,
   'mode'=>DetailView::MODE_VIEW,
   'panel'=>[
       'heading'=>'<i class="glyphicon glyphicon-book"></i> Laboratory Details',
       'type'=>DetailView::TYPE_PRIMARY,
   ],
   'attributes'=>[
       [     
           'columns' => [
               [
                   'label'=>'RSTL ID',
                   'format'=>'raw',
                   'value'=>$rstldetail->rstl_id,
                   'displayOnly'=>true
               ],
           ],
       ],
       [
           'columns' => [
               [
                   'label'=>'Region',
                   'value'=> '',
                   'displayOnly'=>true,
               ],
           ],
       ],
       [
           'columns' => [
               [
                   'label'=>'Laboratory Name',
                   'format'=>'raw',
                   'value'=>$rstldetail->shortName,
                   'displayOnly'=>true
               ],
           ],
       ],
       [
        'columns' => [
                [
                    'label'=>'Code',
                    'format'=>'raw',
                    'value'=>'',
                    'displayOnly'=>true
                ],
            ],
        ],
        [
            'columns' => [
                    [
                        'label'=>'Address',
                        'format'=>'raw',
                        'value'=>$rstldetail->address,
                        'displayOnly'=>true
                    ],
                ],
        ],
        [
            'columns' => [
                    [
                        'label'=>'Contact Number',
                        'format'=>'raw',
                        'value'=>$rstldetail->contacts,
                        'displayOnly'=>true
                    ],
                ],
        ],
        [
            'columns' => [
                    [
                        'label'=>'Short Name',
                        'format'=>'raw',
                        'value'=>$rstldetail->shortName,
                        'displayOnly'=>true
                    ],
                ],
        ],
        [
            'columns' => [
                    [
                        'label'=>'Lab Type Short',
                        'format'=>'raw',
                        'value'=>$rstldetail->labtypeShort,
                        'displayOnly'=>true
                    ],
                ],
        ],
        [
            'columns' => [
                    [
                        'label'=>'Description',
                        'format'=>'raw',
                        'value'=>$rstldetail->description,
                        'displayOnly'=>true
                    ],
                ],
        ],
        [
            'columns' => [
                    [
                        'label'=>'Website',
                        'format'=>'raw',
                        'value'=>$rstldetail->website,
                        'displayOnly'=>true
                    ],
                ],
        ],
   ],
]);

?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"> </span> User Accounts ',
             //   'before'=> Html::button('<span class="glyphicon glyphicon-plus"></span> Create Test Name', ['value'=>'/lab/testname/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Test Name")]),
            ],
        'columns' => [
            'username',
            'email',
            [
                'header'=>'Actions',
                'hAlign'=>'center',
                'format'=>'raw',
                'value'=>function($data){     
                    // $workflow = Workflow::find()->where(['testname_method_id' => $data->testname_method_id])->one();
                    // if ($workflow){
                       return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value'=>Url::to(['/lab/testnamemethod/createworkflow?test_id='.$data->user_id]),'onclick'=>'LoadModal(this.title, this.value, true, 950);', 'class' => 'btn btn-warning','title' => Yii::t('app', "Update User Account")]);
                    // }else{
                    //     return Html::button('<span class="glyphicon glyphicon-plus"></span>', ['value'=>Url::to(['/lab/testnamemethod/createworkflow?test_id='.$data->testname_method_id]),'onclick'=>'LoadModal(this.title, this.value, true, 950);', 'class' => 'btn btn-success','title' => Yii::t('app', "Create Workflow")]);
                    // }     
                },
                    'enableSorting' => false,
                    'contentOptions' => ['style' => 'width:20px; white-space: normal;'],
            ], 
        ],
    ]); ?>

    



<?= GridView::widget([
        'dataProvider' => $labdataProvider,
        //'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"> </span> Laboratories',
             //   'before'=> Html::button('<span class="glyphicon glyphicon-plus"></span> Create Test Name', ['value'=>'/lab/testname/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Test Name")]),
            ],
        'columns' => [
           'labname',
           'labcode',
           [
            'header'=>'Status',
            'hAlign'=>'center',
            'format'=>'raw',
            'value'=>function($data){     
                if ($data->active==0){
                    return "<span class='badge btn-default' style='width:90px;height:20px'><b>INACTIVE</span>";
                }else{
                    return "<span class='badge btn-success' style='width:90px;height:20px'><b>ACTIVE</span>";
                }
              
            },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:20px; white-space: normal;'],
        ], 
           [
            'header'=>'Actions',
            'hAlign'=>'center',
            'format'=>'raw',
            'value'=>function($data){     
                // $workflow = Workflow::find()->where(['testname_method_id' => $data->testname_method_id])->one();
                // if ($workflow){
                   return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value'=>Url::to(['/lab/testnamemethod/createworkflow?test_id='.$data->lab_id]),'onclick'=>'LoadModal(this.title, this.value, true, 950);', 'class' => 'btn btn-warning','title' => Yii::t('app', "Update Laboratory")]);
                // }else{
                //     return Html::button('<span class="glyphicon glyphicon-plus"></span>', ['value'=>Url::to(['/lab/testnamemethod/createworkflow?test_id='.$data->testname_method_id]),'onclick'=>'LoadModal(this.title, this.value, true, 950);', 'class' => 'btn btn-success','title' => Yii::t('app', "Create Workflow")]);
                // }     
            },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:20px; white-space: normal;'],
        ], 
        ],
    ]); ?>



<?= GridView::widget([
      'id' => 'sample-grid',
      'dataProvider'=> $codetemplatedataprovider,
      'pjax'=>true,
      'pjaxSettings' => [
          'options' => [
              'enablePushState' => false,
          ]
      ],
      'containerOptions'=>[
          'style'=>'overflow:auto; height:150px',
      ],
      'floatHeaderOptions' => ['scrollingTop' => true],
      'responsive'=>true,
      'striped'=>true,
      'hover'=>true,
      'bordered' => true,
      'panel' => [
         'heading'=>'<h3 class="panel-title">Request Code Template</h3>',
         'type'=>'primary',
         'before' => '',
         'after'=>false,
      ],
      'toolbar' => false,
        'columns' => [
         'request_code_template',
         'sample_code_template',
         'generate_mode',
         [
            'header'=>'Actions',
            'hAlign'=>'center',
            'format'=>'raw',
            'value'=>function($data){     
                // $workflow = Workflow::find()->where(['testname_method_id' => $data->testname_method_id])->one();
                // if ($workflow){
                   return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value'=>Url::to(['/lab/testnamemethod/createworkflow?test_id='.$data->code_template_id]),'onclick'=>'LoadModal(this.title, this.value, true, 950);', 'class' => 'btn btn-warning','title' => Yii::t('app', "Update Request Code Template")]);
                // }else{
                //     return Html::button('<span class="glyphicon glyphicon-plus"></span>', ['value'=>Url::to(['/lab/testnamemethod/createworkflow?test_id='.$data->testname_method_id]),'onclick'=>'LoadModal(this.title, this.value, true, 950);', 'class' => 'btn btn-success','title' => Yii::t('app', "Create Workflow")]);
                // }     
            },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:20px; white-space: normal;'],
        ], 
        ],
    ]); ?>

<?= GridView::widget([
      'id' => 'sample-grid',
      'dataProvider'=> $configlabdataprovider,
      'pjax'=>true,
      'pjaxSettings' => [
          'options' => [
              'enablePushState' => false,
          ]
      ],
      'containerOptions'=>[
          'style'=>'overflow:auto; height:150px',
      ],
      'floatHeaderOptions' => ['scrollingTop' => true],
      'responsive'=>true,
      'striped'=>true,
      'hover'=>true,
      'bordered' => true,
      'panel' => [
         'heading'=>'<h3 class="panel-title">Config Lab</h3>',
         'type'=>'primary',
         'before' => '',
         'after'=>false,
      ],
      'toolbar' => false,
        'columns' => [
       //  'configlab_id',
            [     
                'label' => 'RSTL ID',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 50%;word-wrap: break-word;white-space:pre-line;'],  
                'value' => function($data) {
                    $rstl = Rstl::find()->where(['rstl_id'=>$data->rstl_id])->one();
                    // $method_query = Methodreference::find()->where(['method_reference_id'=>$data->method_id])->one();

                    // if ($method_query){
                    //     return $method_query->method;
                    // }else{
                    //     return "";
                    // }

                    return $rstl->name;
                }                        
            ],
         'lab',
         [
            'header'=>'Actions',
            'hAlign'=>'center',
            'format'=>'raw',
            'value'=>function($data){     
                // $workflow = Workflow::find()->where(['testname_method_id' => $data->testname_method_id])->one();
                // if ($workflow){
                   return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value'=>Url::to(['/lab/testnamemethod/createworkflow?test_id='.$data->configlab_id]),'onclick'=>'LoadModal(this.title, this.value, true, 950);', 'class' => 'btn btn-warning','title' => Yii::t('app', "Update Config Lab")]);
                // }else{
                //     return Html::button('<span class="glyphicon glyphicon-plus"></span>', ['value'=>Url::to(['/lab/testnamemethod/createworkflow?test_id='.$data->testname_method_id]),'onclick'=>'LoadModal(this.title, this.value, true, 950);', 'class' => 'btn btn-success','title' => Yii::t('app', "Create Workflow")]);
                // }     
            },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:20px; white-space: normal;'],
        ], 
        ],
    ]); ?>

<?= GridView::widget([
      'id' => 'sample-grid',
      'dataProvider'=> $rstllabdataprovider,
      'pjax'=>true,
      'pjaxSettings' => [
          'options' => [
              'enablePushState' => false,
          ]
      ],
      'containerOptions'=>[
          'style'=>'overflow:auto; height:150px',
      ],
      'floatHeaderOptions' => ['scrollingTop' => true],
      'responsive'=>true,
      'striped'=>true,
      'hover'=>true,
      'bordered' => true,
      'panel' => [
         'heading'=>'<h3 class="panel-title">RSTL Lab</h3>',
         'type'=>'primary',
         'before' => '',
         'after'=>false,
      ],
      'toolbar' => false,
        'columns' => [
         'lab_id',
         [
            'header'=>'Actions',
            'hAlign'=>'center',
            'format'=>'raw',
            'value'=>function($data){     
                // $workflow = Workflow::find()->where(['testname_method_id' => $data->testname_method_id])->one();
                // if ($workflow){
                   return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value'=>Url::to(['/lab/testnamemethod/createworkflow?test_id='.$data->rstl_lab_id]),'onclick'=>'LoadModal(this.title, this.value, true, 950);', 'class' => 'btn btn-warning','title' => Yii::t('app', "Update RSTL Lab")]);
                // }else{
                //     return Html::button('<span class="glyphicon glyphicon-plus"></span>', ['value'=>Url::to(['/lab/testnamemethod/createworkflow?test_id='.$data->testname_method_id]),'onclick'=>'LoadModal(this.title, this.value, true, 950);', 'class' => 'btn btn-success','title' => Yii::t('app', "Create Workflow")]);
                // }     
            },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:20px; white-space: normal;'],
        ], 
        ],
    ]); ?>

<?= GridView::widget([
      'id' => 'sample-grid',
      'dataProvider'=> $requestcodedataprovider,
      'pjax'=>true,
      'pjaxSettings' => [
          'options' => [
              'enablePushState' => false,
          ]
      ],
      'containerOptions'=>[
          'style'=>'overflow:auto; height:150px',
      ],
      'floatHeaderOptions' => ['scrollingTop' => true],
      'responsive'=>true,
      'striped'=>true,
      'hover'=>true,
      'bordered' => true,
      'panel' => [
         'heading'=>'<h3 class="panel-title">Request Code</h3>',
         'type'=>'primary',
         'before' => '',
         'after'=>false,
      ],
      'toolbar' => false,
        'columns' => [
         'request_ref_num',
         'rstl_id',
         'lab_id',
         'number',
         'year',
         [
            'header'=>'Actions',
            'hAlign'=>'center',
            'format'=>'raw',
            'value'=>function($data){     
                // $workflow = Workflow::find()->where(['testname_method_id' => $data->testname_method_id])->one();
                // if ($workflow){
                   return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value'=>Url::to(['/lab/testnamemethod/createworkflow?test_id='.$data->requestcode_id]),'onclick'=>'LoadModal(this.title, this.value, true, 950);', 'class' => 'btn btn-warning','title' => Yii::t('app', "Update Request Code")]);
                // }else{
                //     return Html::button('<span class="glyphicon glyphicon-plus"></span>', ['value'=>Url::to(['/lab/testnamemethod/createworkflow?test_id='.$data->testname_method_id]),'onclick'=>'LoadModal(this.title, this.value, true, 950);', 'class' => 'btn btn-success','title' => Yii::t('app', "Create Workflow")]);
                // }     
            },
                'enableSorting' => false,
                'contentOptions' => ['style' => 'width:20px; white-space: normal;'],
        ], 
        ],
    ]); ?>