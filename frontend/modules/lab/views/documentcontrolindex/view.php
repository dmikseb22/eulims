<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Documentcontrolindex */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Documentcontrolindices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documentcontrolindex-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'documentcontrolindex_id',
            'dcf_no',
            'document_code',
            'title',
            'rev_no',
            'effectivity_date',
            'dc',
        ],
    ]) ?>

</div>
