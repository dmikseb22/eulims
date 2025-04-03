<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\lab\Methodreference;
use common\models\lab\Sampletype;
use common\models\lab\Labsampletype;
use common\models\lab\Testname;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel common\models\lab\TestpackageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Packages';
$this->params['breadcrumbs'][] = $this->title;
$sampetypelist= ArrayHelper::map(Sampletype::find()->all(),'sampletype_id','type');
?>


<?php $this->registerJsFile("/js/services/services.js"); ?>

<div class="testpackage-index">


    <p>
    <?= Html::button('<span class="glyphicon glyphicon-plus"></span> Create Test Package', ['value'=>'/lab/testpackage/create', 'class' => 'btn btn-success modal_services','title' => Yii::t('app', "Create New Test Package")]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-products']],
        'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<span class="glyphicon glyphicon-book"></span>  ',
            ],
        'columns' => [
            [
                'attribute' => 'lab_sampletype_id',
                'label' => 'Sample Type',
                'value' => function($model) {

                   // $labsampletype = Labsampletype::find()->where(['lab_id' => 2]);
                 //   $sampletype = Sampletype::find()->where(['sampletype_id' => $labsampletype->sampletype_id])->one();
                   
               //  $labsampletype = "";

               return "boom";
                    // $labsampletype = Labsampletype::find()->where(['lab_sampletype_id'=> 2]);
                    // return  $labsampletype->lab_sampletype_id;
                 //  return var_dump($sampletype);

                    // if ($sampletype->type){
                    //     return $sampletype->type;
                    // }else{
                    //     return "";
                    // }           
                },
            //    'filterType' => GridView::FILTER_SELECT2,
            //    'filter' => $sampetypelist,
            //     'filterWidgetOptions' => [
            //         'pluginOptions' => ['allowClear' => true],
            //    ],
            //    'filterInputOptions' => ['placeholder' => 'Sample Type', 'testcategory_id' => 'grid-products-search-category_type_id']
            ],
            'package_name',
            'package_rate',
            'testname_methods',
            'added_by',

            ['class' => 'kartik\grid\ActionColumn',
            'contentOptions' => ['style' => 'width: 8.7%'],
           'template' => '{view}{update}{delete}',
            'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value'=>Url::to(['/lab/testpackage/view','id'=>$model->testpackage_id]), 'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-primary','title' => Yii::t('app', "View Test Package")]);
                },
                'update'=>function ($url, $model) {
                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'=>Url::to(['/lab/testpackage/update','id'=>$model->testpackage_id]),'onclick'=>'LoadModal(this.title, this.value);', 'class' => 'btn btn-success','title' => Yii::t('app', "Update Test Package")]);
                },
                'delete'=>function ($url, $model) {
                    $urls = '/lab/testpackage/delete?id='.$model->testpackage_id;
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $urls,['data-confirm'=>"Are you sure you want to delete this record?<b></b>", 'data-method'=>'post', 'class'=>'btn btn-danger','title'=>'Delete Test Package','data-pjax'=>'0']);
                },
                ],
            ],
        ],
    ]); ?>

    
<?php
// echo GridView::widget([
//         'dataProvider'=>$dataProvider,
//         'filterModel'=>$searchModel,
//         'showPageSummary'=>true,
//         'pjax'=>true,
//         'striped'=>false,
//         'hover'=>true,
//         'panel'=>['type'=>'primary', 'heading'=>'Grid Grouping Example'],
//         'columns'=>[
//             ['class'=>'kartik\grid\SerialColumn'],
//             [
//                 'attribute'=>'supplier_id', 
//                 'width'=>'310px',
//                 'value'=>function ($model, $key, $index, $widget) { 
//                     return $model->testpackage_id;
//                 },
//                 'filterType'=>GridView::FILTER_SELECT2,
//                 'filter'=>ArrayHelper::map(Suppliers::find()->orderBy('company_name')->asArray()->all(), 'id', 'company_name'), 
//                 'filterWidgetOptions'=>[
//                     'pluginOptions'=>['allowClear'=>true],
//                 ],
//                 'filterInputOptions'=>['placeholder'=>'Any supplier'],
//                 'group'=>true,  // enable grouping
//                 'groupHeader'=>function ($model, $key, $index, $widget) { // Closure method
//                     return [
//                         'mergeColumns'=>[[1,3]], // columns to merge in summary
//                         'content'=>[             // content to show in each summary cell
//                             1=>'Summary (' . $model->testpackage_id . ')',
//                             4=>GridView::F_AVG,
//                             5=>GridView::F_SUM,
//                             6=>GridView::F_SUM,
//                         ],
//                         'contentFormats'=>[      // content reformatting for each summary cell
//                             4=>['format'=>'number', 'decimals'=>2],
//                             5=>['format'=>'number', 'decimals'=>0],
//                             6=>['format'=>'number', 'decimals'=>2],
//                         ],
//                         'contentOptions'=>[      // content html attributes for each summary cell
//                             1=>['style'=>'font-variant:small-caps'],
//                             4=>['style'=>'text-align:right'],
//                             5=>['style'=>'text-align:right'],
//                             6=>['style'=>'text-align:right'],
//                         ],
//                         'options'=>['class'=>'danger','style'=>'font-weight:bold;']
//                     ];
//                 }
//             ],
//             [
//                 'attribute'=>'category_id', 
//                 'width'=>'250px',
//                 'value'=>function ($model, $key, $index, $widget) { 
//                     return $model->testpackage_id;
//                 },
//                 'filterType'=>GridView::FILTER_SELECT2,
//                 'filterWidgetOptions'=>[
//                     'pluginOptions'=>['allowClear'=>true],
//                 ],
//                 'filterInputOptions'=>['placeholder'=>'Any category'],
//                 'group'=>true,  // enable grouping
//                 'subGroupOf'=>1, // supplier column index is the parent group,
//                 'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
//                     return [
//                         'mergeColumns'=>[[2, 3]], // columns to merge in summary
//                         'content'=>[              // content to show in each summary cell
//                             2=>'Summary (' . $model->testpackage_id . ')',
//                             4=>GridView::F_AVG,
//                             5=>GridView::F_SUM,
//                             6=>GridView::F_SUM,
//                         ],
//                         'contentFormats'=>[      // content reformatting for each summary cell
//                             4=>['format'=>'number', 'decimals'=>2],
//                             5=>['format'=>'number', 'decimals'=>0],
//                             6=>['format'=>'number', 'decimals'=>2],
//                         ],
//                         'contentOptions'=>[      // content html attributes for each summary cell
//                             4=>['style'=>'text-align:right'],
//                             5=>['style'=>'text-align:right'],
//                             6=>['style'=>'text-align:right'],
//                         ],
//                         // html attributes for group summary row
//                         'options'=>['class'=>'success','style'=>'font-weight:bold;']
//                     ];
//                 },
//             ],
//             [
//                 'attribute'=>'product_name',
//                 'pageSummary'=>'Page Summary',
//                 'pageSummaryOptions'=>['class'=>'text-right text-warning'],
//             ],
//             [
//                 'attribute'=>'unit_price',
//                 'width'=>'150px',
//                 'hAlign'=>'right',
//                 'format'=>['decimal', 2],
//                 'pageSummary'=>true,
//                 'pageSummaryFunc'=>GridView::F_AVG
//             ],
//             [
//                 'attribute'=>'units_in_stock',
//                 'width'=>'150px',
//                 'hAlign'=>'right',
//                 'format'=>['decimal', 0],
//                 'pageSummary'=>true
//             ],
//             [
//                 'class'=>'kartik\grid\FormulaColumn',
//                 'header'=>'Amount In Stock',
//                 'value'=>function ($model, $key, $index, $widget) { 
//                     $p = compact('model', 'key', 'index');
//                     return $widget->col(4, $p) * $widget->col(5, $p);
//                 },
//                 'mergeHeader'=>true,
//                 'width'=>'150px',
//                 'hAlign'=>'right',
//                 'format'=>['decimal', 2],
//                 'pageSummary'=>true
//             ],
//         ],
//     ]);

?>
</div>
