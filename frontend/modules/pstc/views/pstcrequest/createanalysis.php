<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\referral\Pstcrequest */

$this->title = 'Create Pstcrequest';
$this->params['breadcrumbs'][] = ['label' => 'Pstcrequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pstcrequest-create">

    
    <?= $this->render('_formAnalysis',[
            'model' => $model,
            'base_sample' => $base_sample,
            'request_id' => $request_id,
            'pstc_id' => $pstc_id,
            'sampletypes'=> $sampletypes,
            'sampletype' => $sampletype
        ]) ?>

</div>
