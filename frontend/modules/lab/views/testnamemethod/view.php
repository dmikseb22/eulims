<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Testnamemethod */

$this->title = $model->testname_method_id;
$this->params['breadcrumbs'][] = ['label' => 'Testnamemethods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testnamemethod-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'testname_method_id',
            'testname.testName',
            'method.method',
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
