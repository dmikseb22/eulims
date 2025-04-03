 <?php 
use kartik\grid\GridView;
use yii\helpers\Html;
use common\models\lab\TestreportSample;


    $gridColumn = [
        [
          // 'attribute'=>'sample_id',
          'class' => '\kartik\grid\CheckboxColumn',
             'checkboxOptions' => function($model) {
                $testreportsample = TestreportSample::find()->where(['sample_id' => $model->sample_id])->one();
                
                 if ($testreportsample){
                        return ['disabled' =>true];
                 }
                    
                
             },
                     
        ],
        [
          'class' => '\kartik\grid\SerialColumn',    
        ],
        [
          'attribute'=>'sample_code',
          'enableSorting' => false,
        ],
        [
          'attribute'=>'samplename',
          'enableSorting' => false,
        ],
        [
          'attribute'=>'description',
          'enableSorting' => false,
        ],
        
//        [
//               
//                'header'=>'Test Report ID',
//                'value'=>function($model){
//
//                    $testreportsample = TestreportSample::find()->where(['sample_id' => $model->sample_id])->one();
//
//                    if ($testreportsample){
//                        return $testreportsample->testreport_sample_id;
//                    }else{
//                        "";
//                    }
//                   
//                },
//               
//                
//            ],
        // [
        //   'attribute'=>'remarks',
        //   'enableSorting' => false,
        // ],
         /*[
            'attribute'=>'selected_request',
            'pageSummary' => '<span style="float:right;">Total</span>',
        ],*/
      
        
    ];
?>    

	   
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax'=>true,
        'id'=>'samplegrid',
        'containerOptions'=> ["style"  => 'overflow:auto;height:300px'],
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
            ]
        ],
        
        'responsive'=>false,
        'striped'=>true,
        'hover'=>true,
      
        'floatHeaderOptions' => ['scrollingTop' => true],
        'panel' => [
            'heading'=>'<h3 class="panel-title">Request</h3>',
            'type'=>'primary',
         ],
       
         'columns' =>$gridColumn,
         'showPageSummary' => true,
         /*'afterFooter'=>[
             'columns'=>[
                 'content'=>'Total Selected'
             ],
             
         ],*/
    ]); ?>

    