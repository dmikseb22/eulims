<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Documentcontrol */

$this->title = 'Update Documentcontrol: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Documentcontrols', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->documentcontrol_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="documentcontrol-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
