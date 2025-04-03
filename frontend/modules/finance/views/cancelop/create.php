<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\lab\Cancelledrequest */

$this->title = 'Create Cancel OP';
$this->params['breadcrumbs'][] = ['label' => 'Cancel OP', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cancelledrequest-create">
    <?= $this->render('_form', [
        'model' => $model,
        'op_id'=> $op_id
    ]) ?>

</div>
