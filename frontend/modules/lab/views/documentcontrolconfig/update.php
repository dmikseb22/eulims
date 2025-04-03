<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Documentcontrolconfig */

$this->title = 'Update Documentcontrolconfig: ' . $model->documentcontrolconfig_id;
$this->params['breadcrumbs'][] = ['label' => 'Documentcontrolconfigs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->documentcontrolconfig_id, 'url' => ['view', 'id' => $model->documentcontrolconfig_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="documentcontrolconfig-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
