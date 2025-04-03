<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\testpackage */

$this->title = $model->testpackage_id;
$this->params['breadcrumbs'][] = ['label' => 'Testpackages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testpackage-view">

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'testpackage_id',
            'package_name',
            'lab_sampletype_id',
            'package_rate',
            'testname_methods',
            'added_by',
        ],
    ]) ?>

</div>
