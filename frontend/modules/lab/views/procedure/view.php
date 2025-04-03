<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Procedure */

$this->title = $model->procedure_id;
$this->params['breadcrumbs'][] = ['label' => 'Procedures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procedure-view">

    

 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'procedure_id',
            'procedure_name',
            // 'procedure_code',
            // 'testname_id',
            // 'testname_method_id',
        ],
    ]) ?>

</div>
