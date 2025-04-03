<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use yii\helpers\Json;
use common\components\ReferralComponent;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysis */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    $refcomponent = new ReferralComponent();
    $rstlId = (int) Yii::$app->user->identity->profile->rstl_id;
    $img_url = "https://eulimsapi.onelab.ph/img_logo/icons/";
?>

<div class="methodreference-grid">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
            <?php
                /*$gridColumns = [
                    [
                        'class' => '\kartik\grid\SerialColumn',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;'],
                    ],
                    [
                        'class' => '\kartik\grid\CheckboxColumn',
                        //'class' => '\yii\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center','style'=>'max-width:10px;'],
                        'name' => 'methodref_ids',
                        //'checked' => $model['sample_id'] == 125,
                        //'multiple' => false,
                    ],
                    [
                        //'attribute'=>'samplename',
                        //'enableSorting' => false,
                        //'contentOptions' => ['style'=>'max-width:200px;'],
                        'header' => 'Offered',
                        'format' => 'raw',
                        'value' => 'YES/NO',
                    ],
                    [
                        'attribute'=>'description',
                        'format' => 'raw',
                        'enableSorting' => false,
                        'value' => function($data){
                            return ($data->request->lab_id == 2) ? "Sampling Date: <span style='color:#000077;'><b>".date("Y-m-d h:i A",strtotime($data->sampling_date))."</b></span>,&nbsp;".$data->description : $data->description;
                        },
                       'contentOptions' => [
                            'style'=>'max-width:200px; overflow: auto; white-space: normal; word-wrap: break-word;'
                        ],
                    ],
                ];

                echo GridView::widget([
                    'id' => 'sample-analysis-grid',
                    'dataProvider'=> $sampleDataProvider,
                    //'dataProvider' => ,
                    'pjax'=>true,                
                    'pjaxSettings' => [
                        'options' => [
                            'enablePushState' => false,
                        ]
                    ],
                    'containerOptions'=>[
                        'style'=>'overflow:auto; height:250px',
                    ],
                    'floatHeaderOptions' => ['scrollingTop' => true],
                    'responsive'=>true,
                    'striped'=>true,
                    'hover'=>true,
                    'bordered' => true,
                    'panel' => [
                       'heading'=>'<h3 class="panel-title">Samples</h3>',
                       'type'=>'primary',
                       'before' => '',
                       'after'=>false,
                       'footer'=>false,
                    ],
                    'columns' => $gridColumns,
                    'toolbar' => false,
                ]);*/
            ?>
            <?php
                $gridColumns = [
                    [
                        'class' => '\kartik\grid\SerialColumn',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center','style'=>'max-width:4%;'],
                    ],
                    /*[
                        'class' =>  '\kartik\grid\RadioColumn',
                        'radioOptions' => function ($model) use ($checkMethod) {
                            return [
                                'value' => $model['methodreference_id'],
                                'checked' => $model['methodreference_id'] == $checkMethod,
                            ];
                        },
                        'name' => 'methodref_id',
                        'showClear' => true,
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center','style'=>'max-width:20px;'],
                    ],*/
                    [
                        'class' => '\kartik\grid\CheckboxColumn',
                        //'class' => '\yii\grid\CheckboxColumn',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center','style'=>'max-width:4%;'],
                        'name' => 'methodref_ids',
                        'checkboxOptions'=> function($data) {
                            return [
                                'value' => $data['methodreference_id'],
                            ];
                        },
                    ],
                    [
                        'header' => 'Offered',
                        'format' => 'raw',
                        //'value' => 'YES/NO',
                        'value' => function($data) use ($refcomponent,$count_methods,$rstlId) {
                            //return $data['methodreference']['methodreference_id'];
                            if($count_methods > 0){
                                $check = $refcomponent->checkOffered($data['methodreference_id'],$rstlId);
                                //return $check == 1 ? 'YES' : 'NO';
                                return $check == 1 ? '<span style="font-size:14px;" class="label label-success">YES</span>' : '<span class="label label-danger" style="font-size:14px;">NO</span>';
                                //return $check;
                            } else {
                                return null;
                            }
                        },
                        'contentOptions' => [
                            'style'=>'max-width:5%; overflow: auto; white-space: normal; word-wrap: break-word;',
                            'class' => 'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        //'attribute'=>'testname_method_id',
                        'header' => 'Method',
                        'enableSorting' => false,
                        'value' => function($data){
                            return $data['method'];
                        },
                        'contentOptions' => [
                            'style'=>'max-width:20%; overflow: auto; white-space: normal; word-wrap: break-word;'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        //'attribute'=>'testname_method_id',
                        'header' => 'Reference',
                        'enableSorting' => false,
                        'value' => function($data){
                            return $data['reference'];
                        },
                        'contentOptions' => [
                            'style'=>'max-width:25%; overflow: auto; white-space: normal; word-wrap: break-word;'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        //'attribute'=>'testname_method_id',
                        'header' => 'Fee',
                        'enableSorting' => false,
                        'value' => function($data){
                            return number_format($data['fee'],2);
                        },
                        'contentOptions' => [
                            'style'=>'text-align:right;max-width:12%;'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'header' => 'Offered by',
                        'format' => 'raw',
                        //'value' => 'List of Agencies',
                        'value' => function($data) use ($refcomponent,$count_methods,$img_url) {
                            if($count_methods > 0){
                                $data = json_decode($refcomponent->offeredby($data['methodreference_id']),true);
                                $img = '';
                                $non_dost = [];
                                $non_dost_img = '';
                                if($data == 0){
                                    return '';
                                } else {
                                    foreach ($data as $agency) {
                                        if($agency['agency_id'] < 100){
                                            $img .= Html::img($img_url.$agency['agency_id'].".png", ['alt'=>$agency['agency']['name'],'title'=>$agency['agency']['name'], 'height'=>'26px', 'width'=>'26px']);
                                        } else {
                                            array_push($non_dost,$agency['agency']['code']); //..);
                                        }
                                    }
                                    $non_dost_img .= "<span style='font-size:9px;font-weight:bold;'>".implode(", ", $non_dost)."</span>";
                                    return $non_dost_img.$img;
                                }
                            } else {
                                return null;
                            }
                        },
                        'contentOptions' => [
                            'style'=>'max-width:27%; overflow: auto; white-space: normal; word-wrap: break-word;',
                            'class' => 'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                ];

                echo GridView::widget([
                    'id' => 'method-reference-grid',
                    'dataProvider'=> $methodrefDataProvider,
                    'pjax'=>true,
                    'pjaxSettings' => [
                        'options' => [
                            'enablePushState' => false,
                        ]
                    ],
                    'containerOptions'=>[
                        'style'=>'overflow:auto; height:250px',
                    ],
                    'floatHeaderOptions' => ['scrollingTop' => true],
                    'responsive'=>true,
                    'striped'=>true,
                    'hover'=>true,
                    'bordered' => true,
                    'panel' => [
                       'heading'=>'<h3 class="panel-title">Method Reference</h3>',
                       'type'=>'primary',
                       'before' => '<span style="color:#000000;">
                            <strong>Note : </strong> Offer / Unoffer test for your agency. If test/calibration is not found in the list, please contact the administrator to add your test/calibration.
                        </span>'.(($count_methods > 0) ? '<br><div style="position:relative;float:left;margin: 10px 0 0 0;">
                    <button type="button" id="btn-offer" onclick="offerService()" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok-sign"></span> Offer</button>&nbsp;&nbsp;<button type="button" id="btn-remove" onclick="removeService()" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove-sign"></span> Remove</button>
                </div>' : ''),
                       'after'=>false,
                    ],
                    'columns' => $gridColumns,
                    'toolbar' => false,
                ]);
            ?>
            </div>
        </div>
    </div>
</div>