<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Lab;
use common\models\lab\Sampletype;
use common\models\lab\Documentcontrolconfig;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\DocumentcontrolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Document Control';
$this->params['breadcrumbs'][] = $this->title;







?>
<?php $this->registerJsFile("/js/services/services.js"); ?>
<div class="documentcontrol-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                'before'=> Html::button("<span class='glyphicon glyphicon-plus'></span> Create Document Control Form", ["value"=>"/lab/documentcontrol/create", "class" => "btn btn-success modal_services","title" => Yii::t("app", "Create New Document Control Form")]),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'documentcontrol_id',
            'originator',
            'date_requested',
            'division',
            'code_num',
            'title',
            //'previous_rev_num',
            //'new_revision_no',
            //'pages_revised',
            //'effective_date',
            //'reason',
            //'description',
            //'reviewed_by',
            //'approved_by',
            'dcf_no',
            //'custodian',

            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
            'template' => '{view}{update}{delete}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to(['/lab/documentcontrol/view','id'=>$model->documentcontrol_id]), 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Document Control Form")]);
                },
                'update'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to(['/lab/documentcontrol/update','id'=>$model->documentcontrol_id]),'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Document Control")]);
                },
                'delete'=>function ($url, $model) {
                    $urls = '/lab/documentcontrol/delete?id='.$model->documentcontrol_id;
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $urls,['data-confirm'=>"Are you sure you want to delete this record?<b></b>", 'data-method'=>'post', 'class'=>'btn btn-danger','title'=>'Delete Lab Sample Type','data-pjax'=>'0']);
                },
            ],
        ],
        ],
    ]); ?>
</div>
