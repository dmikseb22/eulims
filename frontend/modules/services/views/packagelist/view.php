<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Packagelist */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Packagelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="packagelist-view">

 

    <p>
      
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'package_id',
            'rstl_id',
            'testcategory_id',
            'sample_type_id',
            'name',
            'rate',
            'tests',
        ],
    ]) ?>

    <div style="position:absolute;right:18px;bottom:10px;">
        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
    </div>
</div>
