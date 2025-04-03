<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Cancelledrequest */

$this->title = 'Create Cancelledrequest';
$this->params['breadcrumbs'][] = ['label' => 'Cancelledrequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cancelledrequest-create">
    <?= $this->render('_form', [
        'model' => $model,
        'Req_id'=> $Req_id,
        'HasOP'=>$HasOP,
        'request'=>$request,
        'UserCancel'=>$UserCancel
    ]) ?>

</div>
