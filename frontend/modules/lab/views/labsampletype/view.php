<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Labsampletype */

$this->title = $model->lab_sampletype_id;
$this->params['breadcrumbs'][] = ['label' => 'Labsampletypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="labsampletype-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'lab_sampletype_id',
            'lab.labname',
            'sampletype.type', 'sampletype.type',
            'effective_date',
            'added_by',
        ],
    ]) ?>

</div>
