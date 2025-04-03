
<?php

use common\models\lab\Sample;
use common\models\lab\Testreport;
use common\models\lab\Analysis;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

use common\models\lab\Tagging;
use common\models\lab\Tagginganalysis;
use common\models\lab\Workflow;
use common\models\lab\Testnamemethod;
use common\models\lab\Methodreference;
use common\models\lab\Request;
use common\models\lab\Procedure;
use common\models\TaggingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use common\models\system\Profile;


?>

<span style="display:inline-block;">



<br>
</span>
<?= GridView::widget([
    'dataProvider' => $testreportdataprovider,
    'summary' => '',
    'panel' => [
        'heading'=>'<h3 class="panel-title"> <i class="glyphicon glyphicon-file"></i>'. $request->request_ref_num.'</h3>',
        'type'=>'primary',
        'items'=>false,
    ],
    'toolbar' => false,
    'columns' => [
        [
            // 'header'=>'Report #',
            // 'hAlign'=>'center',
            // 'format' => 'raw',
            // 'enableSorting' => false,
            'attribute'=>'report_num',
            // 'contentOptions' => ['style' => 'width:30%; white-space: normal;'],                   
        ],
        [
            'attribute'=>'report_date',
            // 'contentOptions' => ['style' => 'width:30%; white-space: normal;'],                   
        ],
        // [
        //     'header'=>'Date Released',
        //     'hAlign'=>'center',
        //     'format' => 'raw',
        //     'enableSorting' => false,
        //     'value'=> function ($model){
        //        return "";
        //     },
        //     'contentOptions' => ['style' => 'width:30%; white-space: normal;'],                   
        // ],

],
]); 


?>
<?php 
$testreport = Testreport::find()->where(['request_id' => $request->request_id])->one();
                
if ($testreport){
	echo Html::button('<span class="glyphicon glyphicon-send"> SMS and Email</span>', ['value' => '/lab/request/notifysms?id=' . $request->customer_id.'&reqid='.$request->request_id.'&refnum='.$request->request_ref_num,'onclick'=>'location.href=this.value', 'class' => 'btn btn-primary', 'title' => Yii::t('app', "SMS")]);
}

	

?>