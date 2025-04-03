<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\grid\Module;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use arturoliveira\ExcelView;
use kartik\widgets\DatePicker;

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;

$pdfHeader="OneLab-Enhanced ULIMS";
$pdfFooter="{PAGENO}";
?>

<div class="accomplishment-report-default-index">
	<div class="box-body">
            <div class="form-group">
                <?php $form = ActiveForm::begin(); ?>
                <div class="col-md-3">
                    <?= $form->field($model, 'lab_id')->widget(Select2::classname(), [
                    'data' => $data->labs,
                    'language' => 'en',
                    'options' => ['placeholder' => 'All Laboratory'],
                    'pluginOptions'=>[
                       'placeholder'=>'All Laboratory',
                       'LoadingText'=>'Loading...',
                       'allowClear' => true
                    ],
                ])->label('Laboratory'); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'datefrom')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Date From'],
                'value'=>function($model){
                     return date("m/d/Y",$model->datefrom);
                },
                   //'setOnEmpty' => true, 
                    'value' => '',
                'pluginOptions' => [
                        'autoclose' => true,
                        // 'setOnEmpty' => true,
                        'removediv' => false,
                        'format' => 'yyyy-mm-dd'
                ],
                    'pluginEvents'=>[
                        "change" => "",
                    ]
                ])?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'dateto')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Report Due'],
                'value'=>function($model){
                     return date("m/d/Y",$model->dateto);
                },
                   //'setOnEmpty' => true, 
                    'value' => '',
                'pluginOptions' => [
                        'autoclose' => true,
                        // 'setOnEmpty' => true,
                        'removediv' => false,
                        'format' => 'yyyy-mm-dd'
                ],
                    'pluginEvents'=>[
                        "change" => "",
                    ]
                ])?>
                </div>
                <div class="col-md-3">
                    <br>
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
	<div class="panel panel-default">
		<?php
		    echo GridView::widget([
		        'id' => 'method-reference-grid',
		        'dataProvider'=> $dataprovider,
		        'showPageSummary'=>true,
			    'summary' => false,
		        'floatHeaderOptions' => ['scrollingTop' => true],
		        'responsive'=>true,
		        'striped'=>true,
		        'hover'=>true,
		        'bordered' => true,
		        'panel' => [
	                    'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Accomplishment Report</h3>',
	                    'type'=>'primary',
	                    'after'=>false,
	                    //'before'=>$exportMenu,
	                    //'headerOptions' => ['class' => 'text-center'],
	                ],
	             'exportConfig' => [
				    	GridView::PDF => [
			                'filename' => 'Accomplishment_Report('.date('Y-m-d').')',
			                'alertMsg'        => 'The PDF export file will be generated for download.',
			                'config' => [
			                    'methods' => [
			                        'SetHeader' => [$pdfHeader],
			                        'SetFooter' => [$pdfFooter]
			                    ],
			                    'options' => [
			                        'title' => 'Accomplishment Report',
			                        'subject' => 'Accomplishment_Report',
			                        'keywords' => 'pdf, preceptors, export, other, keywords, here'
			                    ],
			                ]
			            ],
			            GridView::EXCEL => [
			                'label'           => 'Excel',
			                //'icon'            => 'file-excel-o',
			                'methods' => [
			                    'SetHeader' => [$pdfHeader],
			                    'SetFooter' => [$pdfFooter]
			                ],
			                'iconOptions'     => ['class' => 'text-success'],
			                'showHeader'      => TRUE,
			                'showPageSummary' => TRUE,
			                'showFooter'      => TRUE,
			                'showCaption'     => TRUE,
			                'filename'        =>  'Accomplishment_Report('.date('y-m-d').')',
			                'alertMsg'        => 'The EXCEL export file will be generated for download.',
			                'options'         => ['title' => 'Department of Science OneLab'],
			                'mime'            => 'application/vnd.ms-excel',
			                'config'          => [
			                    'worksheet' => 'Accomplishment',
			                    'cssFile'   => ''
			                ]
			            ],
				    ],
		        'columns' => [
		            [
		                'class' => '\kartik\grid\SerialColumn',
		                'headerOptions' => ['class' => 'text-center'],
		                'contentOptions' => ['class' => 'text-center','style'=>'max-width:5px;'],
		            ],
		            [
		                'attribute'=>'myear',
		                'header'=> 'Year',
		                'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;white-space:pre-line;'],
		                'group' => true,  // enable grouping
		            ],
		            [
		                'attribute'=>'monthref',
		                'header'=> 'Month',
		                'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;white-space:pre-line;'],
		            ],
		            [
		                'attribute'=>'referrals',
		                'header'=> 'Referral Transactions',
		                'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;white-space:pre-line;background-color:#bac6ea!important'],
		            ],
		            [
		                'header'=> 'No. of referral request sent to TCL',
		                'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;white-space:pre-line;background-color:#94e69d!important'],		                'format'=>'raw',
		                'value'=>function($data)use($model){
		                	$urls = '/referrals/accomplishment/referralfigure?type=1&ids='.$data->g_id.'&rstl_id='.$model->rstl_id;
	                       		 return '<div class="toclick " name="'.$urls.'"><i class="fa fa-refresh fa-spin"></i>  Checking...</div>';

		                }
		            ],
		            [
		                'header'=> 'No. of samples referred to TCL',
		                'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;white-space:pre-line;background-color:#94e69d!important'],		                'format'=>'raw',
		                'value'=>function($data)use($model){
		                	$urls = '/referrals/accomplishment/referralfigure?type=2&ids='.$data->g_id.'&rstl_id='.$model->rstl_id;
	                       		 return '<div class="toclick " name="'.$urls.'"><i class="fa fa-refresh fa-spin"></i>  Checking...</div>';

		                }
		            ],
		            [
		                'header'=> 'No. of tests referred to TCL',
		                'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;white-space:pre-line;background-color:#94e69d!important'],		                'format'=>'raw',
		                'value'=>function($data)use($model){
		                	$urls = '/referrals/accomplishment/referralfigure?type=3&ids='.$data->g_id.'&rstl_id='.$model->rstl_id;
	                       		 return '<div class="toclick " name="'.$urls.'"><i class="fa fa-refresh fa-spin"></i>  Checking...</div>';

		                }
		            ],
		            [
		                'header'=> 'No. of referral request received from RL',
		                'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;white-space:pre-line;background-color:#eacdb1!important'],		                'format'=>'raw',
		                'value'=>function($data)use($model){
		                	$urls = '/referrals/accomplishment/referralfigure?type=4&ids='.$data->g_id.'&rstl_id='.$model->rstl_id;
	                       		 return '<div class="toclick " name="'.$urls.'"><i class="fa fa-refresh fa-spin"></i>  Checking...</div>';

		                }
		            ],
		            [
		                'header'=> 'No. of customers served from referral as TCL',
		                'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;white-space:pre-line;background-color:#eacdb1!important'],		                'format'=>'raw',
		                'value'=>function($data)use($model){
		                	$urls = '/referrals/accomplishment/referralfigure?type=4&ids='.$data->g_id.'&rstl_id='.$model->rstl_id;
	                       		 return '<div class="toclick " name="'.$urls.'"><i class="fa fa-refresh fa-spin"></i>  Checking...</div>';

		                }
		            ],
		            [
		                'header'=> 'No. of samples received from RL',
		                'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;white-space:pre-line;background-color:#eacdb1!important'],		                'format'=>'raw',
		                'value'=>function($data)use($model){
		                	$urls = '/referrals/accomplishment/referralfigure?type=5&ids='.$data->g_id.'&rstl_id='.$model->rstl_id;
                       		 return '<div class="toclick " name="'.$urls.'"><i class="fa fa-refresh fa-spin"></i>  Checking...</div>';

		                }
		            ],
		            [
		                'header'=> 'No. of tests conducted from referred sample',
		                'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;white-space:pre-line;background-color:#eacdb1!important'],		                'format'=>'raw',
		                'value'=>function($data)use($model){
							$urls = '/referrals/accomplishment/referralfigure?type=6&ids='.$data->g_id.'&rstl_id='.$model->rstl_id;
                       		return '<div class="toclick " name="'.$urls.'"><i class="fa fa-refresh fa-spin"></i>  Checking...</div>';

		                }
		            ],
		            [
		                'header'=> 'Actual Fees Collected',
		                'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;white-space:pre-line;background-color:#eacdb1!important'],		                'format'=>'raw',
		                'value'=>function($data)use($model){
		                	$urls = '/referrals/accomplishment/referralfigure?type=7&ids='.$data->g_id.'&rstl_id='.$model->rstl_id;
                       		return '<div class="toclick " name="'.$urls.'"><i class="fa fa-refresh fa-spin"></i>  Checking...</div>';

		                }
		            ],
		            [
		                'header'=> 'Value of Assistance (Gratis)',
		                'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;white-space:pre-line;background-color:#eacdb1!important'],		                'format'=>'raw',
		                'value'=>function($data)use($model){
		                	$urls = '/referrals/accomplishment/referralfigure?type=8&ids='.$data->g_id.'&rstl_id='.$model->rstl_id;
                       		return '<div class="toclick " name="'.$urls.'"><i class="fa fa-refresh fa-spin"></i>  Checking...</div>';

		                }
		            ],
		            [
		                'header'=> 'Value of Assistance (Discount)',
		                'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;white-space:pre-line;background-color:#eacdb1!important'],		                'format'=>'raw',
		                'value'=>function($data)use($model){
		                	$urls = '/referrals/accomplishment/referralfigure?type=9&ids='.$data->g_id.'&rstl_id='.$model->rstl_id;
                       		return '<div class="toclick " name="'.$urls.'"><i class="fa fa-refresh fa-spin"></i>  Checking...</div>';

		                }
		            ],
		            [
		                'header'=> 'Gross (Fees Collected)',
		                'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;white-space:pre-line;background-color:#eacdb1!important'],		                'format'=>'raw',
		                'value'=>function($data)use($model){
		                	$urls = '/referrals/accomplishment/referralfigure?type=10&ids='.$data->g_id.'&rstl_id='.$model->rstl_id;
                       		return '<div class="toclick " name="'.$urls.'"><i class="fa fa-refresh fa-spin"></i>  Checking...</div>';
		                }
		            ],
		            
		        ],
		         'toolbar' => [
		        	'{export}',
		                ],
                'export'=>[
                	'label' => 'Export',
			        'fontAwesome'=>true,
			        'showConfirmAlert'=>false,
			        'target'=>GridView::TARGET_SELF,
			    ],
		    ]);
		?>
				
		</div>
    </div>
</div>


<script type="text/javascript">

jQuery(document).ready(function ($) {

    setTimeout(function() {
        $('.toclick').each(function(i, obj) {
            $(this).load($(this).attr('name'));
        });

    }, 2000);
});
</script>