<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\lab\Documentcontrolindex */

$this->title = 'Update Documentcontrolindex: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Documentcontrolindices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->documentcontrolindex_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="documentcontrolindex-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
