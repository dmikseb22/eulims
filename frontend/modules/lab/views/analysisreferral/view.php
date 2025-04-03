<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Analysis */

?>
<div class="analysis-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'sample_id',
                'label' => 'Sample Name',
                'format' => 'raw',
                'value' => function($data) {
                    return !empty($data->sample->samplename) ?  $data->sample->samplename : '<span class="not-set">No related record</span>';
                },
            ],
            //'sample_code',
            [
                'label' => 'Sample Code',
                'format' => 'raw',
                'value' => function($data) {
                    return !empty($data->sample->sample_code) ?  $data->sample->sample_code : '<span class="not-set">No related record</span>';
                },
            ],
            'testname',
            'method',
            'references',
            'fee',
            [
                'attribute' => 'date_analysis',
                'label' => 'Date added',
                'value' => function($data){
                    return (!empty($data->date_analysis) ||  $data->date_analysis > 0) ? Yii::$app->formatter->asDate($data->date_analysis, 'php:F j, Y') : "";
                },
            ]
        ],
    ]) ?>

</div>
