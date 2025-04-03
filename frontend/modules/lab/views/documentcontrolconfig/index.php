<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Lab;
use common\models\lab\Sampletype;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\DocumentcontrolconfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Document Control Config';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documentcontrolconfig-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
               // 'before'=> Html::button("<span class='glyphicon glyphicon-plus'></span> Create Document Control Form", ["value"=>"/lab/documentcontrol/create", "class" => "btn btn-success modal_services","title" => Yii::t("app", "Create New Document Control Form")]),
            ],
        'columns' => [
         //   ['class' => 'yii\grid\SerialColumn'],

          //  'documentcontrolconfig_id',
            'dcf',
            'year',
            'custodian',
            'approved',

            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
            'template' => '{update}',
            'buttons'=>[
                'update'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to(['/lab/documentcontrolconfig/update','id'=>$model->documentcontrolconfig_id]),'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Document Control Config")]);
                },
            ],
        ],
        ],
    ]); ?>
</div>
