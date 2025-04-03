<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\grid\ActionColumn;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\lab\Lab;
use common\models\lab\Request;
/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\TestreportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testreport-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>

        <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create New Test Report', ['value'=>'/reports/lab/testreport/create', 'class' => 'btn btn-success btn-modal','title' => Yii::t('app', "Create New Test Report"),'name'=>'Create New Test Report']); ?>
    </p>

    <div class="table-responsive">
        
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel'=>[
                'type'=>Gridview::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
            ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'testreport_id',
            // 'request_id',
            // 'lab_id',
            // 'lab.labname',
         
            'report_num',
            'report_date',
            [
               
                'header'=>'Request Reference Number',
                'value'=>function($model){

                    $request = Request::find()->where(['request_id' => $model->request_id])->one();

                    if ($request){
                        return $request->request_ref_num;
                    }else{
                        "";
                    }
                   
                },
               
                // 'filter'=>Select2::widget([
                //     'model' => $searchModel,
                //     'attribute' => 'lab_id',
                //     'data' => ArrayHelper::map(Lab::find()->all(), 'lab_id', 'labname'),
                //     'theme' => Select2::THEME_BOOTSTRAP,
                //     'hideSearch' => false,
                //     'options' => [
                //         'placeholder' => 'Select a Laboratory',
                //     ],
                //     'pluginOptions' => [
                //         'allowClear' => true,
                //     ],
                // ]),
            ],

            ['class' => 'kartik\grid\ActionColumn',
                'template'=> '{view}',
            ],
        ],
    ]); ?>
    </div>
</div>
