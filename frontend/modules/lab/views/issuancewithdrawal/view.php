<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Issuancewithdrawal */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Issuancewithdrawals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issuancewithdrawal-view">

   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'issuancewithdrawal_id',
            'document_code',
            'title',
            'rev_no',
            'copy_holder',
            'copy_no',
            'issuance',
            'withdrawal',
            'date',
            'name',
        ],
    ]) ?>

</div>
