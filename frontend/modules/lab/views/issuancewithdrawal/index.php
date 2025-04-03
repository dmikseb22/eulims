<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Lab;
use common\models\lab\Sampletype;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\IssuancewithdrawalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Issuance/ Withdrawal of Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issuancewithdrawal-index">
<?php $this->registerJsFile("/js/services/services.js"); ?>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'before'=> Html::button("<span class='glyphicon glyphicon-plus'></span> Create Issuance/ Withdrawal of Documents", ["value"=>"/lab/issuancewithdrawal/create", "class" => "btn btn-success modal_services","title" => Yii::t("app", "Create Issuance/ Withdrawal of Documents")]),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'issuancewithdrawal_id',
            'document_code',
            'title',
            'rev_no',
            'copy_holder',
            //'copy_no',
            //'issuance',
            //'withdrawal',
            'date',
            //'name',

            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
            'template' => '{view}{update}{delete}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to(['/lab/issuancewithdrawal/view','id'=>$model->issuancewithdrawal_id]), 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Issuance/ Withdrawal Form")]);
                },
                'update'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to(['/lab/issuancewithdrawal/update','id'=>$model->issuancewithdrawal_id]),'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Issuance/ Withdrawal Form")]);
                },
                'delete'=>function ($url, $model) {
                    $urls = '/lab/issuancewithdrawal/delete?id='.$model->issuancewithdrawal_id;
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $urls,['data-confirm'=>"Are you sure you want to delete this record?<b></b>", 'data-method'=>'post', 'class'=>'btn btn-danger','title'=>'Delete Lab Sample Type','data-pjax'=>'0']);
                },
            ],
        ],
        ],
    ]); ?>
</div>
