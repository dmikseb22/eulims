<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Documentcontrol */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Documentcontrols', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documentcontrol-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           
            'originator',
            'date_requested',
            'division',
            'code_num',
            'title',
            'previous_rev_num',
            'new_revision_no',
            'pages_revised',
            'effective_date',
            'reason',
            'description',
            'reviewed_by',
            'approved_by',
            'dcf_no',
            'custodian',
        ],
    ]) ?>

</div>
